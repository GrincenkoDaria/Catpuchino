<!-- MAIN SET HTML -->
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<!-- META DATA -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Catppuccino Café</title>

<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

<!-- color and variable definitions -->
<link rel="stylesheet" href="assets/css/root/variables.css">
<link rel="stylesheet" href="assets/css/root/colors.css">

<!-- font definitions -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

<!-- shared and page-specific stylesheets -->
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
<?php endif; ?>
