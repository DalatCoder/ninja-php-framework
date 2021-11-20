<?php class_exists('Ninja\TemplateBak') or exit; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <title><?php echo $title ?></title>
    <meta charset="utf-8">
</head>
<body>

<h1>Home</h1>
<p>Welcome to the home page, list of colors:</p>
<ul>
    <?php foreach($colors as $color): ?>
    <li><?php echo $color ?></li>
    <?php endforeach; ?>
</ul>

</body>
</html>





