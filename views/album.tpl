
<div class="content-box">

    <div class="title">
        <h2>Album: {$album[0].name}</h2>
        <div class="nav">
            <a href="{url(['album', {$album[0].id}, 'upload'])}" class="button">Upload photo</a>
        </div>
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
        <p>This album is empty.</p>
    {/if}

</div>