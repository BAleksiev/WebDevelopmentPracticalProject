<div class="form">
    <form action="{url(['album', $album.id, 'uploadSubmit'])}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="4194304" /> 
        <input type="file" name="photo" required />
        <textarea name="description"></textarea>
        <input type="submit" value="Upload" />
    </form>
    <div class="clear"></div>
</div>