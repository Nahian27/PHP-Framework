<html lang="en">
<title>home</title>
<h1>Hello {$name ? $name : "world"}</h1>
{foreach $data as $item}
    <h1><a href="/{$item.id}">ID: {$item.id}</a>></h1>
    <ol>
        <li>{$item.title}</li>
        <li>{$item.description}</li>
        <li>{$item.created_at}</li>
    </ol>
{/foreach}
</html>