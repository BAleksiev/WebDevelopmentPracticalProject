
<div class="content-box">

    <div class="title">
        <h2>Album: {$album[0].name}</h2>
        <div class="nav">
            {if $album[0].user_id == Auth::$user['id']}
                <a href="{url(['album', {$album[0].id}, 'upload'])}" class="button">Upload photo</a>
            {/if}
        </div>
        <div class="clear"></div>
    </div>

    {if $photos}
        <ul class="album-list photo-list">
            {foreach $photos as $photo}
                <li>
                    <a href="{url(['photo', $photo['id']])}">
                        <img src="{url(["storage/{$photo.id}.{$photo.format}"])}" />
                    </a>
                </li>
            {/foreach}
        </ul>
        <div class="clear"></div>
    {else}
        <p>This album is empty.</p>
    {/if}

</div>

<div class="content-box">
    <div class="title">
        <div class="nav">
            {if $like == true}
                <a href="{url(['album', {$album[0].id}, 'dislike'])}" class="button">Dislike</a>
            {else}
                <a href="{url(['album', {$album[0].id}, 'like'])}" class="button">Like</a>
            {/if}
        </div>
        <div class="clear"></div>
    </div>
</div>

<div class="content-box">

    <div class="title">
        <h2>Comments</h2>
        <div class="clear"></div>
    </div>

    {if Auth::check()}
        <div class="comment-form">
            <form action="{url(["album/{$album[0]['id']}/submitComment"])}" method="POST">
                <textarea name="comment" placeholder="Share your thoughts"></textarea>
                <input type="submit" value="Post" class="right"/>
            </form>
            <div class="clear"></div>
        </div>
    {/if}

    <div class="comments">
        {if $comments}
            {foreach $comments as $comment}
                <div class="comment">
                    <div class="comment-title">
                        <a href="">{$comment.username}</a> <span>{date('H:i:s d.m.Y', strtotime($comment.date_created))}</span>
                    </div>
                    <p>{$comment.comment}</p>
                </div>
            {/foreach}
        {/if}
    </div>

</div>