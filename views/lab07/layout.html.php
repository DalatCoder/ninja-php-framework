<?php
$title = $title ?? 'Ninja Framework';
$custom_styles = $custom_styles ?? [];
$custom_scripts = $custom_scripts ?? [];
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title><?= $title ?></title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">

    <!-- Feather icon -->
    <script src="/static/js/feather.min.js"></script>

    <?php foreach ($custom_styles as $style) : ?>
        <link rel="stylesheet" href="<?= $style ?>">
    <?php endforeach; ?>
</head>

<body>

<div class="container">
    {% yield content %}
</div>

<script src="/static/js/bootstrap.bundle.min.js"></script>

<script>
    window.feather.replace();
</script>

<?php foreach ($custom_scripts as $script) : ?>
    <script src="<?= $script ?>"></script>
<?php endforeach; ?>

</body>

</html>
