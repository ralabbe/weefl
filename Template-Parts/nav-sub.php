<header>
    <nav id="navbar" class="uk-navbar-container uk-padding-small uk-position-fixed uk-width-1-1 nav-sub" uk-navbar="mode: click">
        <div class="uk-container uk-margin-auto" style="width:100%; display: inherit">
        <div class="uk-navbar-left">
            <?php echo the_custom_logo() ?>
        </div>
        <div class="uk-navbar-right">
            <!-- Mobile Nav -->
            <nav class="uk-navbar-container uk-hidden@m">
                <ul class="uk-navbar-nav">
                    <li>
                        <a href="#mobile-menu" uk-navbar-toggle-icon uk-toggle></a>
                    </li>
                </ul>
            </nav>
            <div class="dual-nav">
                <?php wp_nav_menu( array('menu' => 'Main Top', 'menu_class' => 'uk-navbar-nav uk-visible@m','depth'=> 2, 'container'=> false, 'walker'=> new Navbar_Menu_Walker)); ?>
            </div>
        </div>
        </div>
    </nav>
</header>