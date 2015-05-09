
<div class="content-box">

    <div class="title">
        <h2>Category: {$category[0].name}</h2>
        <div class="clear"></div>
    </div>

    {if $albums}
        <ul class="album-list">
            {foreach $albums as $album}
                <li>
                    <a href="{url(['album', $album['id']])}">
                        <img src="{url(['public', 'images', 'album_icon.png'])}" width="100" />

                        <div>{$album.name}</div>
                    </a>
                </li>
            {/foreach}
        </ul>
    {else}
        <p>No albums found.</p>
    {/if}

</div>