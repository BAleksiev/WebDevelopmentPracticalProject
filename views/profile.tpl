
<div class="content-box">

    <div class="title">
        <h2>{$user.username}'s albums</h2>
        <div class="nav">
            {if $user.id == Auth::$user['id']}
            <a href="{url(['album', 'create'])}" class="button">Create new album</a>
            {/if}
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
        <p>No albums found.</p>
    {/if}

</div>