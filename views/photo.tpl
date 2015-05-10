
<div class="photo">
    <div class="photo-nav">
        {if $prev_photo}<a href="{url(["photo/{$prev_photo.id}"])}" class="button left">Previous</a>{/if}
        {if $next_photo}<a href="{url(["photo/{$next_photo.id}"])}" class="button right">Next</a>{/if}
        <div class="clear"></div>
    </div>

    <div class="photo-container">
        <img src="{url(["storage/{$photo.id}.{$photo.format}"])}" />
    </div>

    <p class="photo-desc">{$photo.description}</p>

    <div class="content-box">

        <div class="title">
            <h2>Comments</h2>
            <div class="clear"></div>
        </div>

        {if Auth::check()}
        <div class="comment-form">
            <form action="{url(["photo/{$photo['id']}/submitComment"])}" method="POST">
                <textarea name="comment" placeholder="Share your thoughts"></textarea>
                <br/>
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
</div>

<div class="photo-sidebar">
    <div class="item">
        <span>Owner:</span> <a href="{url(["user/{$owner.id}"])}">{$owner.username}</a>
    </div>
    <div class="item">
        <span>Album:</span> <a href="{url(["album/{$album.id}"])}">{$album.name}</a>
    </div>
    <div class="item center">
        <a href="{url(["storage/{$photo.id}.{$photo.format}"])}" class="button" target="_blank">Download</a>
    </div>
</div>

<div class="clear"></div>