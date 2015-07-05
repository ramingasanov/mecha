<?php

// The `__launch.php` file will be included only in the backend

Route::accept($config->manager->slug . '/plugin/' . File::B(__DIR__) . '/update', function() use($config, $speak) {
    if( ! Guardian::happy()) {
        Shield::abort(); // [1]
    }
    if($request = Request::post()) {
        Guardian::checkToken($request['token']); // [2]
        File::write('test!')->saveTo(PLUGIN . DS . File::B(__DIR__) . DS . 'states' . DS . 'config.txt', 0600);
        Notify::success(Config::speak('notify_success_updated', array($speak->plugin))); // [3]
        Guardian::kick(File::D($config->url_current)); // [4]
    }
});