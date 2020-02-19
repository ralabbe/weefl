<?php
    get_header();
    get_template_part('/Template-Parts/nav');
    $form = get_field("contact_form_shortcode");
?>


<?php include( locate_template( '/Template-Parts/hero-sub.php', false, false ) ); ?>
<main>

    <?php     
        while ( have_posts() ) :
            the_post(); 
    ?>

        <section class="projects-container">
            <div class="uk-container">
                <?php the_content(); ?>
            </div>
        </section>

    <?php endwhile; ?>

</main>
<?php get_footer(); ?>
