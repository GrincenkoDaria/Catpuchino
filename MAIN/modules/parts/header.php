<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
<button type="button" class="lang-toggle-btn" id="lang-toggle-btn" aria-label="Toggle language">EN</button>
<header class="site-header">
    <div class="logo">
        <span class="logo-icon" aria-hidden="true"></span>
        <span class="logo-text">Catppuccino</span>
    </div>

    <nav class="main-nav" id="main-nav">
        <ul>
            <li><a href="index.php" class="<?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">Home</a></li>
            <li><a href="adopt.php" class="<?php echo $currentPage === 'adopt.php' ? 'active' : ''; ?>">Adopt</a></li>
            <li><a href="menu.php" class="<?php echo $currentPage === 'menu.php' ? 'active' : ''; ?>">Menu</a></li>
            <li><a href="events.php" class="<?php echo $currentPage === 'events.php' ? 'active' : ''; ?>">Events</a></li>
            <li><a href="merch.php" class="<?php echo $currentPage === 'merch.php' ? 'active' : ''; ?>">Merch</a></li>
            <li><a href="aboutus.php" class="<?php echo $currentPage === 'aboutus.php' ? 'active' : ''; ?>">About us</a></li>
        </ul>
    </nav>

    <button class="menu-toggle" id="menu-toggle" aria-label="Toggle navigation">
        <span class="hamburger"></span>
    </button>
</header>

<nav class="mobile-fab-nav" aria-label="Mobile quick navigation">
    <button class="mobile-nav-orb" id="mobile-nav-orb" aria-expanded="false" aria-controls="mobile-fab-panel" aria-label="Open navigation">
        <span class="mobile-nav-orb-label">Menu</span>
    </button>
    <div class="mobile-fab-panel" id="mobile-fab-panel" aria-hidden="true">
        <ul>
            <li><a href="index.php" class="<?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">Home</a></li>
            <li><a href="adopt.php" class="<?php echo $currentPage === 'adopt.php' ? 'active' : ''; ?>">Adopt</a></li>
            <li><a href="menu.php" class="<?php echo $currentPage === 'menu.php' ? 'active' : ''; ?>">Menu</a></li>
            <li><a href="events.php" class="<?php echo $currentPage === 'events.php' ? 'active' : ''; ?>">Events</a></li>
            <li><a href="merch.php" class="<?php echo $currentPage === 'merch.php' ? 'active' : ''; ?>">Merch</a></li>
            <li><a href="aboutus.php" class="<?php echo $currentPage === 'aboutus.php' ? 'active' : ''; ?>">About us</a></li>
        </ul>
    </div>
</nav>

