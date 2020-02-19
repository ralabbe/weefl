<?php /* Template Name: Contact */  ?>

<?php
    get_header();
    get_template_part('/Template-Parts/nav');
    $form = get_field("contact_form_shortcode");
?>

<?php include( locate_template( '/Template-Parts/hero-sub.php', false, false ) ); ?>
<?php     
    while ( have_posts() ) :
        the_post(); 
?>
<main>

    <section class="projects-container">
        <div class="uk-container">
            <div class="uk-child-width-1-2@m" uk-grid>
                <div class="text-center-mobile uk-flex uk-flex-middle">
                    <div class="bg-grey uk-padding">
                        <?php the_content(); ?>
                        <hr>
                        <p>
                            <?php echo get_bloginfo("name"); ?>
                            <br />
                            <a href="<?php echo get_option('google_maps'); ?>" target="_blank" class="text-inherit hover-underline"><?php echo get_option('address'); ?></a>
                            <br /><br />
                            <i class="fas fa-phone fa-fw uk-margin-small-right"></i><a href="tel:<?php echo get_option('phone'); ?>" class="text-inherit hover-underline"><?php echo get_option('phone'); ?></a> <span class="uk-padding-small uk-padding-remove-top uk-padding-remove-bottom">|</span> <i class="fas fa-fax fa-fw uk-margin-small-right"></i><?php echo get_option('fax'); ?>
                        </p>
                    </div>
                </div>
                <div class="uk-flex uk-flex-middle"><?php echo do_shortcode($form); ?></div>
            </div>
        </div>
    </section>


</main>

<?php endwhile; ?>
<?php get_footer(); ?>
