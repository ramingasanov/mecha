<?php


/**
 * Comments Manager
 * ----------------
 */

Route::accept(array($config->manager->slug . '/comment', $config->manager->slug . '/comment/(:num)'), function($offset = 1) use($config, $speak) {
    if(Guardian::get('status') != 'pilot') {
        Shield::abort();
    }
    File::write($config->total_comments_backend)->saveTo(SYSTEM . DS . 'log' . DS . 'comments.total.txt', 0600);
    if($files = Mecha::eat(Get::commentsExtract(null, 'DESC', 'id', 'txt,hold'))->chunk($offset, $config->per_page)->vomit()) {
        $comments = array();
        foreach($files as $comment) {
            $comments[] = Get::comment($comment['path']);
        }
    } else {
        $comments = false;
    }
    Config::set(array(
        'page_title' => $speak->comments . $config->title_separator . $config->manager->title,
        'offset' => $offset,
        'responses' => $comments,
        'pagination' => Navigator::extract(Get::comments(null, 'DESC', 'txt,hold'), $offset, $config->per_page, $config->manager->slug . '/comment'),
        'cargo' => DECK . DS . 'workers' . DS . 'comment.php'
    ));
    Shield::attach('manager', false);
});


/**
 * Comment Killer
 * --------------
 */

Route::accept($config->manager->slug . '/comment/kill/id:(:num)', function($id = "") use($config, $speak) {
    if(Guardian::get('status') != 'pilot') {
        Shield::abort();
    }
    if( ! $comment = Get::comment($id)) {
        Shield::abort(); // File not found!
    }
    File::write($config->total_comments_backend)->saveTo(SYSTEM . DS . 'log' . DS . 'comments.total.txt', 0600);
    Config::set(array(
        'page_title' => $speak->deleting . ': ' . $speak->comment . $config->title_separator . $config->manager->title,
        'response' => $comment,
        'cargo' => DECK . DS . 'workers' . DS . 'kill.comment.php'
    ));
    if($request = Request::post()) {
        $P = array('data' => Mecha::A($comment));
        Guardian::checkToken($request['token']);
        File::open($comment->path)->delete();
        File::write($config->total_comments_backend)->saveTo(SYSTEM . DS . 'log' . DS . 'comments.total.txt', 0600); 
        Notify::success(Config::speak('notify_success_deleted', array($speak->comment)));
        Weapon::fire('on_comment_update', array($P, $P));
        Weapon::fire('on_comment_destruct', array($P, $P));
        Guardian::kick($config->manager->slug . '/comment');
    } else {
        Notify::warning($speak->notify_confirm_delete);
    }
    Shield::attach('manager', false);
});


/**
 * Comment Repair
 * --------------
 */

Route::accept($config->manager->slug . '/comment/repair/id:(:num)', function($id = "") use($config, $speak) {
    if(Guardian::get('status') != 'pilot' || ! $comment = Get::comment($id)) {
        Shield::abort();
    }
    File::write($config->total_comments_backend)->saveTo(SYSTEM . DS . 'log' . DS . 'comments.total.txt', 0600);
    $G = array('data' => Mecha::A($comment));
    Config::set(array(
        'page_title' => $speak->editing . ': ' . $speak->comment . $config->title_separator . $config->manager->title,
        'response' => $comment,
        'cargo' => DECK . DS . 'workers' . DS . 'repair.comment.php'
    ));
    Weapon::add('SHIPMENT_REGION_BOTTOM', function() {
        echo '<script>
(function($) {
    if (typeof MTE == "undefined") return;
    var $area = $(\'.MTE[name="message"]\'),
        languages = $area.data(\'mteLanguages\');
    new MTE($area[0], {
        tabSize: \'    \',
        shortcut: true,
        buttons: languages.buttons,
        prompt: languages.prompt,
        placeholder: languages.placeholder
    });
})(Zepto);
</script>';
    });
    if($request = Request::post()) {
        $request['id'] = $id;
        $request['ua'] = isset($comment->ua) ? $comment->ua : 'N/A';
        $request['ip'] = isset($comment->ip) ? $comment->ip : 'N/A';
        $request['message_raw'] = $request['message'];
        $extension = $request['action'] == 'publish' ? '.txt' : '.hold';
        Guardian::checkToken($request['token']);
        // Empty name field
        if(trim($request['name']) === "") {
            Notify::error(Config::speak('notify_error_empty_field', array($speak->comment_name)));
            Guardian::memorize($request);
        }
        // Invalid email address
        if(trim($request['email']) !== "" && ! Guardian::check($request['email'])->this_is_email) {
            Notify::error($speak->notify_invalid_email);
            Guardian::memorize($request);
        }
        $P = array('data' => $request, 'action' => $request['action']);
        if( ! Notify::errors()) {
            $data  = 'Name: ' . $request['name'] . "\n";
            $data .= 'Email: ' . Text::parse($request['email'])->to_ascii . "\n";
            $data .= 'URL: ' . $P['data']['url'] . "\n";
            $data .= 'Status: ' . $request['status'] . "\n";
            $data .= 'UA: ' . $request['ua'] . "\n";
            $data .= 'IP: ' . $request['ip'] . "\n";
            $data .= "\n" . SEPARATOR . "\n\n" . $request['message'];
            File::open($comment->path)->write($data)->save(0600)->renameTo(basename($comment->path, '.' . pathinfo($comment->path, PATHINFO_EXTENSION)) . $extension);
            Notify::success(Config::speak('notify_success_updated', array($speak->comment)));
            Weapon::fire('on_comment_update', array($G, $P));
            Weapon::fire('on_comment_repair', array($G, $P));
            Guardian::kick($config->manager->slug . '/comment/repair/id:' . $id);
        }
    }
    Shield::define('default', $comment)->attach('manager', false);
});