<?php /* Template Name: About */  ?>

<?php
    get_header();
    get_template_part('/Template-Parts/nav');
?>
<main>

    <?php include( locate_template( '/Template-Parts/hero-sub-alt.php', false, false ) ); ?>
    <section class="uk-padding-remove-bottom bg-grey-gradient">
    <div id="home-content" class="uk-container uk-overflow-hidden">
        <div uk-grid>
            <div class="uk-width-1-3@s uk-position-relative home-content-image">
                <div class="uk-position-relative uk-animation-slide-bottom-small">
                    <?php 
                        $filter_image = get_field("page_image");
                        $img["url"] = ($filter_image) ? $filter_image["url"] : get_template_directory_uri() . "/assets/img/3m-filter.png";
                        $img["alt"] = ($filter_image["alt"]) ? $filter_image["alt"] : "3M Filter";
                    ?>
                    <img src="<?php echo $img["url"] ?>" alt="<?php echo $img["alt"] ?>">
                </div>
            </div>
            
            <div class="uk-width-2-3@s">
                <section>
                    <section class="uk-padding-remove-bottom">
                    <?php the_content(); ?>
                    </section>
                </section>
            </div> <!-- right column -->

        </div> <!-- .uk-grid -->
    </div> <!-- .uk-container -->
    </section>
</main>
<?php get_footer(); ?>
