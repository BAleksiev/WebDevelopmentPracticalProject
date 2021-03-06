<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Photo Gallery</title>

        <link href="{url(['public', 'css', 'style.css'])}" rel="stylesheet" type="text/css"/>

        <script src="{url(['public', 'js', 'jquery-2.1.4.min.js'])}" type="text/javascript"></script>
        <script src="{url(['public', 'js', 'jquery.noty.packaged.js'])}" type="text/javascript"></script>
    </head>
    <body>
        <header>
            <div class="wrapper">
                <ul class="navigation">
                    <li class="{if Route::$method == 'index'}active{/if}"><a href="{url(['index'])}">Home</a></li>
                        {if !Auth::check()}
                        <li class="{if Route::$method == 'login'}active{/if}"><a href="{url(['login'])}">Login</a></li>
                        <li class="{if Route::$method == 'register'}active{/if}"><a href="{url(['register'])}">Register</a></li>
                        {else}
                        <li class="{if Route::$method == 'profile'}active{/if}"><a href="{url(['profile'])}">Profile</a></li>
                            {*                    {if Auth::checkAdmin()}<li class="{if Route::$method == 'admin'}active{/if}"><a href="{url(['admin'])}">Admin Panel</a></li>{/if}*}
                            {*                    <li class="{if Route::$method == 'settings'}active{/if}"><a href="{url(['profile/settings'])}">Settings</a></li>*}
                        <li><a href="{url(['logout'])}">Logout</a></li>
                        {/if}
                </ul>
            </div>
        </header>

        <script>

            function generateNoty(text, type, layout) {
                if (layout == null) {
                    layout = 'topCenter';
                }

                var n = noty({
                    text: text,
                    type: type,
                    timeout: 10000,
                    closeWith: ['click'],
                    layout: layout,
                    theme: 'defaultTheme'
                });
            }

            {if Session::messages()}
                {foreach Session::messages() as $type => $messages}
                    {foreach $messages as $msg}
            generateNoty('{$msg}', '{$type}');
                    {/foreach}
                {/foreach}
            {/if}

        </script>

        <div class="content wrapper">
            {include file="views/$layout.tpl"}
        </div>

        <footer>
            <div class="wrapper">
                Boris Aleksiev's project for Software University
            </div>
        </footer>
    </body>
</html>
