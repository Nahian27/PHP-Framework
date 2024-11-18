<html lang="en">
<title>test</title>
<?php
foreach ($data as $item) {
    echo '<ol>' . $item['id'];
    echo '<li>' . $item['title'] . '</li>';
    echo '<li>' . $item['description'] . '</li>';
    echo '</ol>';
}
?>
</html>