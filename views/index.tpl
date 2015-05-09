<ul>
    {foreach $categories as $category}
        <li><a href="{$category.name}">{$category.name}</a></li> 
    {/foreach}
</ul>