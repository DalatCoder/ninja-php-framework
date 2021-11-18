<?php
    $title = $title ?? 'Ninja Framework Screen';
    $error_message = $error_message ?? '';
    $error_stack_trace = $error_stack_trace ?? '';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ninja Error Screen: <?= $title ?></title>

    <style>
        *,
        *::before,
        *::after {
            padding: 0;
            margin: 0;
            box-sizing: inherit;
        }

        body {
            box-sizing: border-box;
        }
    </style>
</head>
<body>

<h1>Đã có lỗi xảy ra: <?= $title ?></h1>

<div>Tin nhắn lỗi: <?= $error_message ?></div>
<div><?= $error_stack_trace ?></div>

</body>
</html>
