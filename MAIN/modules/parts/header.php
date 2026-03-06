<header class="site-header">
    <div class="logo">
        <!-- simple cat icon, replace with actual graphic if available -->
        <span class="logo-icon" aria-hidden="true">🐱</span>
        <span class="logo-text">Catppuccino</span>
    </div>

    <nav class="main-nav" id="main-nav">
        <ul>
            <li><a href="#" class="active">Home</a></li>
            <li><a href="#">Adopt</a></li>
            <li><a href="#">Menu</a></li>
            <li><a href="#">Events</a></li>
            <li><a href="#">Merch</a></li>
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
        toggle.addEventListener('click', function () {
            nav.classList.toggle('open');
        });
    });
</script>