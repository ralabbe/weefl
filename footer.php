

<?php
// If the current page is not the Contact page, display the Contact Us section
if (get_the_title() != "Contact" && get_the_title() != "Contact Us"  ){ include( locate_template( '/Template-Parts/section-contact.php', false, false ) ); }
?>

<footer>
    <div class="uk-container uk-text-center">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/wilson_icon_sm.png" alt="<?php echo get_bloginfo("name"); ?> logo" class="uk-margin-bottom">
        <p>
            <strong><?php echo get_bloginfo("name"); ?></strong>
            <br />
            <?php if (get_option('google_maps')){ ?>
                <a href="<?php echo get_option('google_maps'); ?>" target="_blank"><?php echo get_option('address'); ?></a>
            <?php } else {
                echo get_option('address');
            } ?>
            <br />
            <i class="fas fa-phone fa-fw uk-margin-small-right text-primary"></i><a href="tel:<?php echo get_option('phone'); ?>"><?php echo get_option('phone'); ?></a>
            <br />
            <i class="fas fa-fax fa-fw uk-margin-small-right text-primary"></i></span><?php echo get_option('fax'); ?>
        </p>
        <ul class="social-icons uk-margin-medium-top uk-margin-medium-bottom">
            <?php if (get_option('facebook')){ ?><li><a href="<?php echo get_option('facebook'); ?>" target="_blank"><i class="fab fa-facebook-f fa-2x uk-margin-small-right text-tertiary" alt="facebook icon"></i></a></li><?php } ?>
            <?php if (get_option('instagram')){ ?><li><a href="<?php echo get_option('instagram'); ?>" target="_blank"><i class="fab fa-instagram fa-2x uk-margin-small-right text-tertiary" alt="instagram icon"></i></a></li><?php } ?>
            <?php if (get_option('twitter')){ ?><li><a href="<?php echo get_option('twitter'); ?>" target="_blank"><i class="fab fa-twitter fa-2x uk-margin-small-right text-tertiary" alt="twiiter icon"></i></a></li><?php } ?>
            <?php if (get_option('youtube')){ ?><li><a href="<?php echo get_option('youtube'); ?>" target="_blank"><i class="fab fa-youtube fa-2x uk-margin-small-right text-tertiary" alt="youtube icon"></i></a></li><?php } ?>
            <?php if (get_option('linkedin')){ ?><li><a href="<?php echo get_option('linkedin'); ?>" target="_blank"><i class="fab fa-linkedin fa-2x uk-margin-small-right text-tertiary" alt="linkedin icon"></i></a></li><?php } ?>
        </ul>
        <div class="footer-affiliations uk-margin-bottom">
            <?php dynamic_sidebar("affiliations"); ?>
        </div>
        <?php wp_nav_menu( array('menu' => 'Footer Menu', 'menu_id' => 'footer-nav', 'menu_class' => 'uk-nav-parent-icon','depth'=> 2, 'container'=> false, 'walker'=> new Navbar_Menu_Walker)); ?>
        <p class="copyright">
            &copy; <?php echo get_bloginfo("name"); ?> <?php echo date("Y"); ?> | Orlando Florida <a href="tel:<?php echo get_option('phone'); ?>"><?php echo get_option('phone'); ?></a>
        </p>
</footer>

<div id="mobile-menu" uk-offcanvas="overlay: true; flip: true" class="uk-hidden@m hide">
    <div class="uk-offcanvas-bar bg-secondary" uk-scrollspy="cls: uk-animation-slide-right-medium; target: li a; delay: 50; repeat: true">
        <a class="uk-offcanvas-close" uk-close></a>
        <?php wp_nav_menu( array('menu' => 'Main-Top', 'menu_class' => 'uk-navbar-nav','depth'=> 2, 'container'=> false, 'walker'=> new Navbar_Menu_Walker)); ?>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
