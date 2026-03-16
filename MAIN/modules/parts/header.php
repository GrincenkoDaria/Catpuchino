<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
<header class="site-header">
    <div class="logo">
        <!-- simple cat icon, replace with actual graphic if available -->
        <span class="logo-icon" aria-hidden="true">🐱</span>
        <span class="logo-text">Catppuccino</span>
    </div>

    <nav class="main-nav" id="main-nav">
        <ul>
            <li><a href="index.php" class="<?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">Home</a></li>
            <li><a href="adopt.php" class="<?php echo $currentPage === 'adopt.php' ? 'active' : ''; ?>">Adopt</a></li>
            <li><a href="menu.php" class="<?php echo $currentPage === 'menu.php' ? 'active' : ''; ?>">Menu</a></li>
            <li><a href="events.php" class="<?php echo $currentPage === 'events.php' ? 'active' : ''; ?>">Events</a></li>
            <li><a href="merch.php" class="<?php echo $currentPage === 'merch.php' ? 'active' : ''; ?>">Merch</a></li>
            <li><a href="#">About us</a></li>
        </ul>
    </nav>

    <button class="menu-toggle" id="menu-toggle" aria-label="Toggle navigation">
        <span class="hamburger"></span>
    </button>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var toggle = document.getElementById('menu-toggle');
        var nav = document.getElementById('main-nav');
        if (toggle && nav) {
            toggle.addEventListener('click', function () {
                nav.classList.toggle('open');
            });
        }
    });
</script>