
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Catppuccino Café</title>

<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<link rel="icon" type="image/png" href="assets/img/logo/image.png">
<script src="assets/js/app.min.js" defer></script>
<script src="assets/js/i18n.min.js?v=4" defer></script>

<link rel="preload" as="style" href="assets/css/shared.css">
<link rel="stylesheet" type="text/css" href="assets/css/shared.css">
<?php if ($currentPage === 'index.php'): ?>
<link rel="stylesheet" type="text/css" href="assets/css/pages/home.css">
<?php elseif ($currentPage === 'adopt.php'): ?>
<link rel="stylesheet" type="text/css" href="assets/css/pages/adopt.css">
<?php elseif ($currentPage === 'menu.php'): ?>
<link rel="stylesheet" type="text/css" href="assets/css/pages/menu.css">
<?php elseif ($currentPage === 'events.php'): ?>
<link rel="stylesheet" type="text/css" href="assets/css/pages/events.css">
<?php elseif ($currentPage === 'merch.php'): ?>
<link rel="stylesheet" type="text/css" href="assets/css/pages/merch.css">
<?php elseif ($currentPage === 'aboutus.php'): ?>
<link rel="stylesheet" type="text/css" href="assets/css/pages/aboutus.css">
<?php elseif ($currentPage === 'donate.php'): ?>
<link rel="stylesheet" type="text/css" href="assets/css/pages/donate.css">
<?php elseif ($currentPage === 'todo.php'): ?>
<link rel="stylesheet" type="text/css" href="assets/css/pages/todo.css">
<?php endif; ?>