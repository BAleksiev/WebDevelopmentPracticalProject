<div class="form">
    <form action="{url(['album', 'create'])}" method="POST">
        <input type="text" name="name" placeholder="Name" required />
        <textarea name="description" placeholder="Description"></textarea>
        <select name="category" required>
            <option>Category</option>
            {foreach $categories as $category}
                <option value="{$category.id}">{$category.name}</option>
            {/foreach}
        </select>
        <input type="submit" value="Create" />
    </form>
    <div class="clear"></div>
</div>