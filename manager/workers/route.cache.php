<?php


/**
 * Cache Manager
 * -------------
 */

Route::accept(array($config->manager->slug . '/cache', $config->manager->slug . '/cache/(:num)'), function($offset = 1) use($config, $speak) {
    if(Guardian::get('status') !== 'pilot') {
        Shield::abort();
    }
    $offset = (int) $offset;
    $filter = Request::get('q', false);
    $filter = $filter ? Text::parse($filter, '->safe_file_name') : "";
    $takes = Get::files(CACHE, '*', 'DESC', 'update', $filter);
    if($_files = Mecha::eat($takes)->chunk($offset, $config->per_page * 2)->vomit()) {
        $files = array();
        foreach($_files as $_file) {
            $files[] = $_file;
        }
        unset($_files);
    } else {
        $files = false;
    }
    Config::set(array(
        'page_title' => $speak->caches . $config->title_separator . $config->manager->title,
        'offset' => $offset,
        'files' => $files,
        'pagination' => Navigator::extract($takes, $offset, $config->per_page * 2, $config->manager->slug . '/cache'),
        'cargo' => DECK . DS . 'workers' . DS . 'cache.php'
    ));
    Shield::attach('manager', false);
});


/**
 * Cache Repair
 * ------------
 */

Route::accept($config->manager->slug . '/cache/repair/(file|files):(:all)', function($prefix = "", $path = "") use($config, $speak) {
    if(Guardian::get('status') !== 'pilot') {
        Shield::abort();
    }
    $path = File::path($path);
    if( ! $file = File::exist(CACHE . DS . $path)) {
        Shield::abort(); // File not found!
    }
    $G = array('data' => array('path' => $file, 'content' => File::open($file)->read()));
    Config::set(array(
        'page_title' => $speak->editing . ': ' . File::B($path) . $config->title_separator . $config->manager->title,
        'cargo' => DECK . DS . 'workers' . DS . 'repair.cache.php'
    ));
    if($request = Request::post()) {
        Guardian::checkToken($request['token']);
        $P = array('data' => $request);
        File::open($file)->write($request['content'])->save(0600);
        Notify::success(Config::speak('notify_file_updated', '<code>' . $path . '</code>'));
        Session::set('recent_file_update', File::B($path));
        $name = File::path($request['name']);
        if($name !== $path) {
            File::open($file)->moveTo(CACHE . DS . $name);
            Guardian::kick($config->manager->slug . '/cache/1');
        }
        Weapon::fire('on_cache_update', array($G, $P));
        Weapon::fire('on_cache_repair', array($G, $P));
        Guardian::kick($config->manager->slug . '/cache/repair/file:' . File::url($request['name']));
    }
    Shield::lot(array(
        'the_name' => $path,
        'the_content' => File::open($file)->read()
    ))->attach('manager', false);
});


/**
 * Cache Killer
 * ------------
 */

Route::accept($config->manager->slug . '/cache/kill/(file|files):(:all)', function($prefix = "", $path = "") use($config, $speak) {
    if(Guardian::get('status') !== 'pilot') {
        Shield::abort();
    }
    $path = File::path($path);
    if(strpos($path, ';') !== false) {
        $deletes = explode(';', $path);
    } else {
        if( ! File::exist(CACHE . DS . $path)) {
            Shield::abort(); // File not found!
        } else {
            $deletes = array($path);
        }
    }
    Config::set(array(
        'page_title' => $speak->deleting . ': ' . (count($deletes) === 1 ? File::B($path) : $speak->caches) . $config->title_separator . $config->manager->title,
        'files' => $deletes,
        'cargo' => DECK . DS . 'workers' . DS . 'kill.cache.php'
    ));
    if($request = Request::post()) {
        Guardian::checkToken($request['token']);
        $info_path = array();
        foreach($deletes as $file_to_delete) {
            $_path = CACHE . DS . $file_to_delete;
            $info_path[] = $_path;
            File::open($_path)->delete();
        }
        $P = array('data' => array('files' => $info_path));
        Notify::success(Config::speak('notify_file_deleted', '<code>' . implode('</code>, <code>', $deletes) . '</code>'));
        Weapon::fire('on_cache_update', array($P, $P));
        Weapon::fire('on_cache_destruct', array($P, $P));
        Guardian::kick($config->manager->slug . '/cache/1');
    } else {
        Notify::warning(count($deletes) === 1 ? Config::speak('notify_confirm_delete_', '<code>' . $path . '</code>') : $speak->notify_confirm_delete);
    }
    Shield::attach('manager', false);
});


/**
 * Multiple Cache Killer
 * ---------------------
 */

Route::accept($config->manager->slug . '/cache/kill', function() use($config, $speak) {
    if($request = Request::post()) {
        Guardian::checkToken($request['token']);
        if( ! isset($request['selected'])) {
            Notify::error($speak->notify_error_no_files_selected);
            Guardian::kick($config->manager->slug . '/cache/1');
        }
        $files = array();
        foreach($request['selected'] as $file) {
            $files[] = str_replace('%2F', '/', Text::parse($file, '->encoded_url'));
        }
        Guardian::kick($config->manager->slug . '/cache/kill/files:' . implode(';', $files));
    }
});