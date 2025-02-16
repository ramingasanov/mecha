Mecha CMS
=========

> Mecha is a flat-file content management system for minimalists.

[<img src="https://user-images.githubusercontent.com/1669261/119496162-69eb5180-bd8d-11eb-830c-897168f58416.png" width="127" height="46">](https://mecha-cms.com) [<img src="https://user-images.githubusercontent.com/1669261/119496168-6b1c7e80-bd8d-11eb-8ee1-33e8eb5b90ed.png" width="87" height="46">](https://mecha-cms.com/reference) [<img src="https://user-images.githubusercontent.com/1669261/119496170-6bb51500-bd8d-11eb-9d6d-9d95c0510b67.png" width="102" height="46">](https://github.com/mecha-cms/mecha/discussions)

![Code Size](https://img.shields.io/github/languages/code-size/mecha-cms/mecha?color=%23444&style=for-the-badge) ![License](https://img.shields.io/github/license/mecha-cms/mecha?color=%23444&style=for-the-badge)

Front-End
---------

The default layout uses only Serif and Mono fonts. Different operating systems might display somewhat different results. This preview was taken through a computer with Linux operating system. Serif font that’s displayed in the preview below should be [DejaVu Serif](https://commons.wikimedia.org/wiki/File:DejaVuSerifSpecimen.svg "DejaVu Serif · Wikimedia Commons"):

![Front-End](https://user-images.githubusercontent.com/1669261/141647070-e994e220-8061-4cd6-bdf7-45ef9ad8ea56.png)

Back-End ([Optional](https://github.com/mecha-cms/x.panel "Panel Extension"))
-----------------------------------------------------------------------------

To be able to activate the back-end feature requires you to install our [panel](https://github.com/mecha-cms/x.panel "Panel Extension") and [user](https://github.com/mecha-cms/x.user "User Extension") extensions. This feature is forever optional. You can use this feature on the local version only, and remove it on the public version to secure your website (only if you don&rsquo;t trust this extension).

![Back-End](https://user-images.githubusercontent.com/1669261/141484343-0568ef0d-f7c5-4991-a8ee-7773379415b2.png)

Colors and font types in the control panel preview above are generated from the default layout files. Without them, the display will look like the preview below:

![Back-End](https://user-images.githubusercontent.com/1669261/141484323-d97a403f-5706-4e84-b5ab-78ebd9eb6bd9.png)

Mecha survives on the principle that a database-less site should be personal, portable, light and easy to be exported and backed up. That’s why most of the projects associated with Mecha are created with personal natures and are dedicated to be used for personal purposes such as blog, journal and diary. Mecha’s market shares are people with high creativity and individuals who want to dedicate themselves to the freedom of speech, that probably don’t have much time to learn web programming languages. By introducing Mecha as files and folders that used to be seen by people everyday in their working desktop, we hope you will soon be familiar with the way Mecha CMS works.

Mecha is as simple as files and folders. Yet, that doesn’t mean that Mecha is weak. Mecha has fairly flexible set of API that you can use without having to make it bloated, keeping you happy focused on developing your own site, according to your personality.

If you want to make something that is super huge with Mecha, that would be possible, but remember that Mecha wasn’t created to replace databases. Mecha was previously created simply to help people getting rid of various resources that are not needed from the start (such as databases). There will be a time when you need a database, and when that time comes, just use a database. Mecha is fairly open to be extended with other database-based applications.

Features
--------

 - Writing pages with ease using Markdown.
 - Unlimited page children.
 - Unlimited page fields.
 - Extensible as hell.
 - Create unique design for each blog post by adding special CSS and JavaScript files using the art extension.
 - Built-in commenting system using the comment extension.
 - RSS and Sitemap using the feed and sitemap extension.
 - Easy to use and well documented API.
 - Almost everything are optional.
 - Control panel extension.

Environments
------------

 - PHP 7.3.0 and above, with enabled [`mbstring`](http://php.net/manual/en/book.mbstring.php "PHP Extension `mbstring`") and [`dom`](http://php.net/manual/en/book.dom.php "PHP Extension `dom`") extension.
 - Apache 2.4 and above, with enabled [`mod_rewrite`](http://httpd.apache.org/docs/current/mod/mod_rewrite.html "Apache Module `mod_rewrite`") module.

Preparations
------------

 1. Make sure that you already have the required components.
 2. Download the available package from the [home page](https://mecha-cms.com).
 3. Upload Mecha through your FTP/SFTP to the public folder/directory on your site, then extract it!
 4. Take a look on the available extensions and layouts that you might be interested.
 5. Upload your extension files to `.\lot\x` and your layout files to `.\lot\y`. They’re auto-loaded.
 6. Read on how to add pages and tags. Learn on how to create pages from the author by looking at the [source code](https://github.com/mecha-cms/lot "GitHub").
 7. Install the panel extension if you are stuck by doing everything manually. You always have the full control to remove this extension without having to worry that your site will stop running after doing so.

Alternatives
------------

### Command Line

This assumes that your site’s public directory is in `/srv/http`. Make sure the folder is empty, or move the existing files to another place first. Don’t forget with that `.` at the end of the command as written in the example below, to clone the repository into the current root folder.

#### Using Git

~~~ .sh
$ cd /srv/http
$ git clone https://github.com/mecha-cms/mecha.git --depth 1 .
$ git submodule update --init --recursive
$ rm .gitmodules composer.json LICENSE README.md
$ rm -r .git
~~~

You may want to install [user](https://github.com/mecha-cms/x.user) and [panel](https://github.com/mecha-cms/x.panel) extension as well:

~~~ .sh
$ cd lot/x
$ git clone https://github.com/mecha-cms/x.user.git --depth 1 user
$ rm user/LICENSE user/README.md
$ rm -r user/.git
$ git clone https://github.com/mecha-cms/x.panel.git --depth 1 panel
$ rm panel/LICENSE panel/README.md
$ rm -r panel/.git
~~~

### Web Browser

Download the installer file from <https://mecha-cms.com/start> and then follow the instructions.

---

Contributors
------------

This project exists and survives because of you. I would like to thank all those who have taken the time to contribute to this project.

[![Contributors](https://opencollective.com/mecha-cms/contributors.svg?avatarHeight=24&button=false&width=890)](https://github.com/mecha-cms/mecha/graphs/contributors)

Contribute financially to keep the project domain and website accessible to everyone. The website provides complete documentation and latest information regarding the software and future development plans. Some parts of the website also serve to provide a clean and efficient project file download feature which is obtained by managing responses from the [GitHub API](https://docs.github.com/en/rest/reference/repos).

### Backers

[![Contribute](https://opencollective.com/mecha-cms/individuals.svg?width=890)](https://opencollective.com/mecha-cms)

### Sponsors

[![0](https://opencollective.com/mecha-cms/organization/0/avatar.svg)](https://opencollective.com/mecha-cms/organization/0/website)
[![1](https://opencollective.com/mecha-cms/organization/1/avatar.svg)](https://opencollective.com/mecha-cms/organization/1/website)
[![2](https://opencollective.com/mecha-cms/organization/2/avatar.svg)](https://opencollective.com/mecha-cms/organization/2/website)
[![3](https://opencollective.com/mecha-cms/organization/3/avatar.svg)](https://opencollective.com/mecha-cms/organization/3/website)
[![4](https://opencollective.com/mecha-cms/organization/4/avatar.svg)](https://opencollective.com/mecha-cms/organization/4/website)
[![5](https://opencollective.com/mecha-cms/organization/5/avatar.svg)](https://opencollective.com/mecha-cms/organization/5/website)
[![6](https://opencollective.com/mecha-cms/organization/6/avatar.svg)](https://opencollective.com/mecha-cms/organization/6/website)
[![7](https://opencollective.com/mecha-cms/organization/7/avatar.svg)](https://opencollective.com/mecha-cms/organization/7/website)
[![8](https://opencollective.com/mecha-cms/organization/8/avatar.svg)](https://opencollective.com/mecha-cms/organization/8/website)
[![9](https://opencollective.com/mecha-cms/organization/9/avatar.svg)](https://opencollective.com/mecha-cms/organization/9/website)

---

Release Notes
-------------

### 3.0.0

 - [x] Added class `XML`.
 - [x] Added functions `abort`, `check`, `choke`, `cookie`, `delete`, `ip`, `kick`, `long`, `move`, `save`, `seal`, `short`, `size`, `status`, `store`, `token`, `type`, `ua`, `zone`.
 - [x] Changed `path` state property to `route`.
 - [x] Implemented [WAI-ARIA](https://www.w3.org/TR/wai-aria) to allow class-less styling of HTML markup.
 - [x] Improved `Genome` and `Page` class to make it possible to inherit (fake) methods and (fake) properties from the parent class automatically.
 - [x] Layout is now behaves like extension. If it does not contain any `index.php` file, then its entire layout system will be discarded (#157).
 - [x] Moved [`art`](https://github.com/mecha-cms/x.art) and [`form`](https://github.com/mecha-cms/x.form) feature to a separate extension.
 - [x] Moved `To::{description,sentence,title}` methods to `page` extension.
 - [x] Moved core extensions and layouts out of the repository and convert them to git sub-modules.
 - [x] Optimized hook sorting mechanism (#156)
 - [x] Re-enabled the layout switcher feature (#205)
 - [x] Refactored function `has` to make it more useful along with `get`, `let`, and `set` functions.
 - [x] Removed `$html` option in `To::description` (previously was `To::excerpt`). People who want to make page excerpt without HTML should be able to easily remove all the HTML markup from the input first, before using this function.
 - [x] Removed `$parent` variable (#165)
 - [x] Removed `404.php` file requirement for layout.
 - [x] Removed `clean`, `d`, `i`, `port` property from `URL` class.
 - [x] Removed `get`, `has`, `let` and `set` methods from non-static classes (#166)
 - [x] Removed `parent` method from `File`, `Folder`, and `Page` class.
 - [x] Removed classes `Cache`, `Client`, `Cookie`, `Files`, `Folders`, `Get`, `Guard`, `Path`, `Post`, `Request`, `Route`, `Server`, `Session`, `SGML`.
 - [x] Removed constant `GROUND`, `PS`.
 - [x] Removed separator options from URL functions and methods (#164)
 - [x] Renamed `To::excerpt` to `To::description`.
 - [x] Renamed class `Anemon` to `Anemone`.
 - [x] Renamed constant `DEBUG` to `TEST` (#159)
 - [x] Renamed constant `DS` to `D`.
 - [x] Renamed constant `ROOT` to `PATH`.
 - [x] Renamed function `anemon` to `anemone`.
 - [x] The `e` function will no longer evaluate string in the form of JSON pattern (#167)
 - [x] Upgraded PHP version requirement to 7.3.0.

### 2.6.4

 - Added `Path::long()` and `Path::short()` method.
 - Added `content-length` header to facilitate AJAX-based applications with progress bars.
 - Added `link` to the core extensions.
 - Added second parameter to the `content` function to allow user to use this function to create a file.
 - Fixed bug of `SGML` class when parsing attributes contain Base64 image URL.
 - Fixed bug of default date format not applied to the output (#117)
 - Improved alert message session. Now you can print the `$alert` variable multiple times and all `<alert>` elements will appear at each location.
 - Improved class auto-loader. `\` now will be converted into `/`, and `__` will be converted into `.` (#96)
 - Improved internal JSON validator.
 - Improved path and URL resolver.
 - Removed function `mecha`.
 - Renamed `$link->active` to `$link->current` in layout navigation.
 - Updated function and method parameter names. Make them to be more semantic for better support with the new named parameter feature in PHP 8.x.
 - Updated the default layout.

### 2.5.3

 - Bug fixes.

### 2.5.2

 - Added `path` helper function.
 - Removed cache optimization stuff from `.htaccess`. The main `.htaccess` file should focus only to the rewrite module.
 - Removed all image asset methods.

### 2.5.1

 - Added `YAML\SOH`, `YAML\ETB`, and `YAML\EOT` constant in the YAML extension (#94)

### 2.5.0

 - Added `$status` parameter to `Guard::kick()` with default value set to `301`.
 - Added `?` symbol for `Route` as alias of `:key` pattern. So, `foo/bar/:baz` will be equal to `foo/bar/?`.
 - Added ability to set response status automatically based on the first numeric layout path.
 - Renamed `$route->view()` method to `$route->layout()` for consistency.

### 2.4.0

This update focuses on improving the pagination feature of page extension. `$pager->next`, `$pager->parent` and `$pager->prev` will now return a `Page` instance or `null`. This allows us to get richer data easily from the previous and next page property such as to retrieve title, description and image thumbnail to be displayed in the previous and next page navigation HTML.

 - Improved HTML output generated by `To::excerpt()` method.
 - `$pager->next`, `$pager->parent` and `$pager->prev` are now return a `Page` instance or `null`.

### 2.3.2

 - Added `drop` helper function.
 - Improved `Path` methods to allow `null` values.
 - Updated [Parsedown Extra](https://github.com/erusev/parsedown-extra) to version 0.8.0.

### 2.3.1

 - Bug fixes and improvements for the YAML extension.
 - Prefers HTTP/2 header style for both request and response (#89)

### 2.3.0

This update focuses on improving the token feature so that it is not too strict. We need to give other extension opportunities to load the current page for certain purposes without having to change the current token.

 - Added `$deep` option for `From::HTML()` with default value set to `false` to prevent double encode HTML special characters.
 - Added `X-Requested-With` header field to `fetch()` with default value set to `CURL` to let the client to know that the request is not came from a normal web browser (#86)
 - Fixed double encode on HTML attribute’s value caused by the `HTML` class (#85)
 - Fixed form extension bug that caused the comment duplicate checker to fails to work.
 - Fixed layout extension bug that does not capture the custom attributes added to the asset path that is relative to the layout folder.
 - Improved alert counter and serializer. Counting alert messages or converting them into a JSON string will not clear the alert session.
 - Improved hook remover. It is now possible to remove a hook function from closures as long as you store the function closure into a variable. You can then remove the hook function using the variable as a reference.
 - Improved HTTP response headers API. They are now case-insensitive.
 - Improved markdown extension. It is now possible to generate HTML `<figure>` element automatically from every image that appears alone in a paragraph.
 - Improved token mechanism. Added `$for` parameter for `Guard::token()` to set delay time for the token to refresh. The default value is one minute. Previously, every token will be refreshed on every page visits. This causes [several obstacles](https://github.com/mecha-cms/mecha/issues/82) if some extensions require to reload the page to build the cache (even if it is only to load pages in the background) or to prepare it to load the next page via the HTML5 prefetch feature.
 - Removed `State::over()` method.
 - Removed automatic paragraph tags in page description data for consistency with other page data such as the title data. If I had to be consistent, when the description data is required to be wrapped in paragraph tags, then the title data should also be wrapped in heading tags. But it doesn’t (#87)
 - Renamed `Cache::expire()` to `Cache::stale()` for more semantic method naming (#84)
 - Renamed `Route::over()` to `Route::hit()` to make it in-line with `Cache::hit()` (#83)

### 2.2.2

This update focuses on stabilizing the `URL` class. In this version, you can use the class to parse all types of URLs, not only internal URLs but also external URLs. Mecha has its own specifications regarding URLs, and is a bit different from the native PHP `parse_url` function. One of them is the presence of `d` and `i` properties. You can learn more about this on the [URL reference page](https://mecha-cms.com/reference/class/u-r-l).

 - Added optional `$d` and `$i` parameter to the `URL` class constructor.
 - Fixed `$lot` parameter applied to `Route::fire()` does not give any effect.

### 2.2.1

 - Added `$as` parameter to `copy` and `move` methods of `File` and `Folder` class.
 - Fixed `send` function not sending HTML email.
 - Small bug fixes for the `let` hook.

### 2.2.0

Compatible with PHP 7.3.0 and above. Mecha uses `Closure::fromCallable()` method (which is only available in PHP version 7.1.0 and above) to convert named function into closures, so that we can pass `$this` reference from another class instance to the function body even if it’s a named function. The `??` operator becomes a must-have feature in this version as we no longer use extra `$fail` parameter on certain class methods to set default values.

 - Added ability to read special file named `task.php`.
 - Added classes: `Client`, `Files`, `Folders`, `Layout`, `Pager\Page`, `Pager\Pages`, `Pages`, `Post`, `Server`, `SGML`.
 - Added more static functions: `abort`, `alert`, `anemon`, `any`, `c2f`, `cache`, `check`, `concat`, `content`, `cookie`, `eq`, `exist`, `extend`, `f2c`, `f2p`, `fetch`, `find`, `fire`, `ge`, `get`, `gt`, `has`, `hook`, `is`, `kick`, `le`, `let`, `lt`, `map`, `mecha`, `ne`, `not`, `open`, `p2f`, `page`, `pages`, `pluck`, `route`, `send`, `session`, `set`, `shake`, `state`, `step`, `stream`, `test`, `token`.
 - Added page conditional statement features.
 - Moved YAML parser feature to a separate _YAML_ extension.
 - Moved class `Page` and `Pager` to a separate _Page_ extension.
 - Moved configuration file from `.\lot\extend\:extension\state\config.php` to `.\lot\x\:extension\state.php`.
 - Moved configuration file from `.\lot\shield\:layout\state\config.php` to `.\lot\layout\state.php`.
 - Moved configuration file from `.\lot\state\config.php` to `.\state.php`.
 - Moved search functionality to a separate _Search_ extension.
 - Now you can call page properties via `$this` property inside the hook function, either as a named function or as an anonymous function.
 - Removed ability to read special file named `__index.php` and `index__.php`. Only `index.php` file that will be read automatically.
 - Removed automatic constant creation for every folder name in the `.\lot` directory.
 - Removed classes: `Extend` `Elevator`, `Form`, `Mecha`, `Plugin`, `Shield`, `Union`.
 - Removed language and layout switcher features. Now we no longer have the ability to change themes through configuration files, and therefore there will only be one theme on every website built with Mecha.
 - Removed plugin feature. There are no such thing called “plugin” in this version. They are now simply called “extension”.
 - Renamed `.\lot\extend` directory address to `.\lot\x`.
 - Renamed class `Config` to `State`.
 - Renamed class `Date` to `Time`.
 - Renamed class `Guardian` to `Guard`.
 - Renamed class `Message` to `Alert`.
 - Renamed the `X` constant to `P`. “P” stands for “Placeholder”.
 - The “Set, Get and Reset” method naming standard has now been changed to “Set, Get and Let”.
 - Use `null` value everywhere as the default value for all inaccessible data. From now on, use the `??` operator to determine alternative value.
 - `$pages` variable is now a generator. Every page data in it will be loaded only if you iterate over the generator.

### 2.0.0

Compatible with PHP 5.3.6 and above.

 - Refactor.