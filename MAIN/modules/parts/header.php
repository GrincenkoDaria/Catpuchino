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
            <li><a href="aboutus.php" class="<?php echo $currentPage === 'aboutus.php' ? 'active' : ''; ?>">About us</a></li>
        </ul>
    </nav>

    <button class="menu-toggle" id="menu-toggle" aria-label="Toggle navigation">
        <span class="hamburger"></span>
    </button>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var transitionStorageKey = 'pageTransitionMeta';
        var isNavigating = false;

        try {
            var rawMeta = window.sessionStorage.getItem(transitionStorageKey);
            if (rawMeta) {
                var meta = JSON.parse(rawMeta);
                var age = Date.now() - Number(meta.ts || 0);
                var expectedPath = String(meta.path || '');
                var currentPath = window.location.pathname;
                var isFresh = age >= 0 && age < 2500;
                var isTargetPage = expectedPath !== '' && expectedPath === currentPath;

                window.sessionStorage.removeItem(transitionStorageKey);

                if (isFresh && isTargetPage) {
                    document.body.classList.add('page-reveal');
                    window.setTimeout(function () {
                        document.body.classList.remove('page-reveal');
                    }, 780);
                }
            }
        } catch (error) {
        }

        var toggle = document.getElementById('menu-toggle');
        var nav = document.getElementById('main-nav');
        if (toggle && nav) {
            toggle.addEventListener('click', function () {
                nav.classList.toggle('open');
            });
        }

        if (nav) {
            var navLinks = nav.querySelectorAll('a[href]');
            navLinks.forEach(function (link) {
                link.addEventListener('click', function (event) {
                    if (isNavigating) {
                        event.preventDefault();
                        return;
                    }

                    var href = link.getAttribute('href');
                    if (!href || href === '#' || href.indexOf('javascript:') === 0) {
                        return;
                    }

                    if (link.target && link.target !== '_self') {
                        return;
                    }

                    if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || event.button !== 0) {
                        return;
                    }

                    var targetUrl = new URL(link.href, window.location.href);
                    var samePath = targetUrl.pathname === window.location.pathname;
                    var sameSearch = targetUrl.search === window.location.search;
                    var sameHash = targetUrl.hash === window.location.hash;
                    if (samePath && sameSearch && sameHash) {
                        return;
                    }

                    event.preventDefault();
                    isNavigating = true;
                    document.body.classList.add('page-transitioning');
                    try {
                        window.sessionStorage.setItem(transitionStorageKey, JSON.stringify({
                            path: targetUrl.pathname,
                            ts: Date.now()
                        }));
                    } catch (error) {
                    }

                    window.setTimeout(function () {
                        window.location.href = link.href;
                    }, 270);
                });
            });
        }
    });
</script>