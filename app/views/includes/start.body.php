<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= \Helpers\URLHelper::appendToBaseURL('public/assets/css/output.css') ?>?v=<?php echo time(); ?>" rel="stylesheet">
    <link href="<?= \Helpers\URLHelper::appendToBaseURL('public/assets/css/style.css') ?>?v=<?php echo time(); ?>" rel="stylesheet">
    <link href="<?= \Helpers\URLHelper::appendToBaseURL('public/assets/css/all.min.css') ?>?v=<?php echo time(); ?>" rel="stylesheet">
    <script src="<?= \Helpers\URLHelper::appendToBaseURL('public/assets/js/functions.js') ?>?v=<?php echo time(); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title><?= $data['title'] ?? null; ?></title>
</head>

<body class="relative overflow-x-hidden">