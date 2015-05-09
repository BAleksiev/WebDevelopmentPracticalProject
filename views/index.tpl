
<div class="content-box">

    <div class="title">
        <h2>Categories</h2>
        <div class="clear"></div>
    </div>

    <ul class="album-list">
        {foreach $categories as $category}
            <li>
                <a href="{url(['category', $category.name])}">
                    <img src="{url(['public', 'images', 'category_icon.png'])}" width="100" />

                    <div>{$category.name}</div>
                </a>
            </li>
        {/foreach}
    </ul>

</div>

<div class="content-box">

    <div class="title">
        <h2>Most popular albums</h2>
        <div class="clear"></div>
    </div>

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

</div>