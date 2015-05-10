<div class="center">
    {if Config::get('app.debug') == true}
        <p style="text-align: left">{$error}</p>
    {else}
        <a href="{url(['index'])}"><img src="{url(['public/images/404.jpg'])}" /></a>
    {/if}
</div>