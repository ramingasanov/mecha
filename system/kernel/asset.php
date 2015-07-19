<?php

/**
 * ================================================================================
 *  ASSET STUFF
 * ================================================================================
 *
 * -- CODE: -----------------------------------------------------------------------
 *
 *    echo Asset:stylesheet('foo.css');
 *
 * --------------------------------------------------------------------------------
 *
 *    echo Asset:stylesheet('foo.css', ' type="text/css"');
 *
 * --------------------------------------------------------------------------------
 *
 *    echo Asset::stylesheet(array(
 *        'foo.css', 'bar.css', 'baz.css', 'qux.css'
 *    ));
 *
 * --------------------------------------------------------------------------------
 *
 */

class Asset extends Base {

    protected static $loaded = array();
    protected static $ignored = array();

    // Get full version of private asset path
    public static function path($path) {
        $path = File::path($path);
        if($_path = File::exist(SHIELD . DS . Config::get('shield') . DS . ltrim($path, DS))) {
            return $_path;
        } else if($_path = File::exist(ROOT . DS . ltrim($path, DS))) {
            return $_path;
        }
        return $path;
    }

    // Get public asset URL
    public static function url($path_origin) {
        $config = Config::get();
        $path = self::path($path_origin);
        $url = File::url($path);
        if(strpos($path, ROOT) === false) {
            return strpos($url, '://') !== false ? Filter::apply('asset:url', $url . ($config->resource_versioning && strpos($url, $config->url) === 0 ? '?' . sprintf(ASSET_VERSION_FORMAT, filemtime($path)) : ""), $path_origin) : false;
        }
        return file_exists($path) ? Filter::apply('asset:url', $url . ($config->resource_versioning ? '?' . sprintf(ASSET_VERSION_FORMAT, filemtime($path)) : ""), $path_origin) : false;
    }

    // Return the HTML stylesheet of asset
    public static function stylesheet($path, $addon = "", $merge = false) {
        if($merge) return self::merge($path, $merge, $addon, 'stylesheet');
        $path = is_string($path) && strpos($path, '.css;') !== false ? explode(';', $path) : (array) $path;
        $html = "";
        for($i = 0, $count = count($path); $i < $count; ++$i) {
            if(self::url($path[$i]) !== false) {
                self::$loaded[$path[$i]] = 1;
                $html .= ! self::ignored($path[$i]) ? Filter::apply('asset:stylesheet', str_repeat(TAB, 2) . '<link href="' . self::url($path[$i]) . '" rel="stylesheet"' . (is_array($addon) ? $addon[$i] : $addon) . ES . NL, $path[$i]) : "";
            } else {
                // File does not exist
                $html .= str_repeat(TAB, 2) . '<!-- ' . $path[$i] . ' -->' . NL;
            }
        }
        return O_BEGIN . rtrim(substr($html, strlen(TAB . TAB)), NL) . O_END;
    }

    // Return the HTML javascript of asset
    public static function javascript($path, $addon = "", $merge = false) {
        if($merge) return self::merge($path, $merge, $addon, 'javascript');
        $path = is_string($path) && strpos($path, '.js;') !== false ? explode(';', $path) : (array) $path;
        $html = "";
        for($i = 0, $count = count($path); $i < $count; ++$i) {
            if(self::url($path[$i]) !== false) {
                self::$loaded[$path[$i]] = 1;
                $html .= ! self::ignored($path[$i]) ? Filter::apply('asset:javascript', str_repeat(TAB, 2) . '<script src="' . self::url($path[$i]) . '"' . (is_array($addon) ? $addon[$i] : $addon) . '></script>' . NL, $path[$i]) : "";
            } else {
                // File does not exist
                $html .= str_repeat(TAB, 2) . '<!-- ' . $path[$i] . ' -->' . NL;
            }
        }
        return O_BEGIN . rtrim(substr($html, strlen(TAB . TAB)), NL) . O_END;
    }

    // Return the HTML image of asset
    public static function image($path, $addon = "", $merge = false) {
        if($merge) return self::merge($path, $merge, $addon, 'image');
        $path = is_string($path) && strpos($path, ';') !== false ? explode(';', $path) : (array) $path;
        $html = "";
        for($i = 0, $count = count($path); $i < $count; ++$i) {
            if(self::url($path[$i]) !== false) {
                self::$loaded[$path[$i]] = 1;
                $html .= ! self::ignored($path[$i]) ? Filter::apply('asset:image', '<img src="' . self::url($path[$i]) . '"' . (is_array($addon) ? $addon[$i] : $addon) . ES . NL, $path[$i]) : "";
            } else {
                // File does not exist
                $html .= '<!-- ' . $path[$i] . ' -->' . NL;
            }
        }
        return O_BEGIN . rtrim($html, NL) . O_END;
    }

    // Merge multiple asset file(s) into a single file
    public static function merge($path, $name = null, $addon = "", $call = null) {
        $path = is_string($path) && strpos($path, ';') !== false ? explode(';', $path) : (array) $path;
        $the_path = ASSET . DS . File::path($name);
        $the_path_log = SYSTEM . DS . 'log' . DS . 'asset.' . str_replace(array(ASSET . DS, DS), array("", '__'), $the_path) . '.log';
        $is_valid = true;
        if( ! file_exists($the_path_log)) {
            $is_valid = false;
        } else {
            $the_path_time = explode("\n", file_get_contents($the_path_log));
            if(count($the_path_time) !== count($path)) {
                $is_valid = false;
            } else {
                foreach($the_path_time as $i => $time) {
                    $p = self::path($path[$i]);
                    if( ! file_exists($p) || (int) filemtime($p) !== (int) $time) {
                        $is_valid = false;
                        break;
                    }
                }
            }
        }
        $time = "";
        $content = "";
        $e = File::E($name);
        if( ! file_exists($the_path) || ! $is_valid) {
            if(Text::check($e)->inArray(array('gif', 'jpeg', 'jpg', 'png'))) {
                foreach($path as $p) {
                    if( ! self::ignored($p)) {
                        $p = self::path($p);
                        if(file_exists($p)) {
                            $time .=  filemtime($p) . "\n";
                        }
                    }
                }
                File::write(trim($time))->saveTo($the_path_log);
                Image::take($path)->merge()->saveTo($the_path);
            } else {
                foreach($path as $p) {
                    if( ! self::ignored($p)) {
                        $p = self::path($p);
                        if(file_exists($p)) {
                            $time .= filemtime($p) . "\n";
                            $c = file_get_contents($p);
                            if(strpos(File::B($p), '.min.') === false) {
                                if(strpos(File::B($the_path), '.min.css') !== false) {
                                    $content .= Converter::detractShell($c) . "\n";
                                } else if(strpos(File::B($the_path), '.min.js') !== false) {
                                    $content .= Converter::detractSword($c) . "\n";
                                } else {
                                    $content .= $c . "\n\n";
                                }
                            } else {
                                $content .= $c . "\n\n";
                            }
                        }
                    }
                }
                File::write(trim($time))->saveTo($the_path_log);
                File::write(trim($content))->saveTo($the_path);
            }
        }
        if(is_null($call)) {
            $call = Mecha::alter($e, array(
                'css' => 'stylesheet',
                'js' => 'javascript',
                'gif' => 'image',
                'jpeg' => 'image',
                'jpg' => 'image',
                'png' => 'image'
            ));
        }
        return call_user_func_array('self::' . $call, array($the_path, $addon));
    }

    // Check for loaded asset(s)
    public static function loaded($path = null) {
        if(is_null($path)) return self::$loaded;
        return isset(self::$loaded[$path]) ? $path : false;
    }

    // Do not let the `Asset` loads these file(s) ...
    public static function ignore($path) {
        if(is_array($path)) {
            foreach($path as $p) {
                self::$ignored[$p] = 1;
            }
        } else {
            self::$ignored[$path] = 1;
        }
    }

    // Check for ignored asset(s)
    public static function ignored($path = null) {
        if(is_null($path)) return self::$ignored;
        return isset(self::$ignored[$path]) ? $path : false;
    }

}