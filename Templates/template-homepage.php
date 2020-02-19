<?php /* Template Name: Homepage */  ?>

<?php
    get_header();
    get_template_part('/Template-Parts/nav');
?>
<main>

    <?php include( locate_template( '/Template-Parts/hero-home.php', false, false ) ); ?>
    <section class="uk-padding-remove-bottom bg-grey-gradient">
    <div id="home-content" class="uk-container uk-overflow-hidden">
        <div uk-grid>
            <div class="uk-width-1-3@s uk-position-relative home-content-image">
                <div class="uk-position-relative uk-animation-slide-bottom-small">
                    <?php 
                        $filter_image = get_field("home_image");
                        $img["url"] = ($filter_image) ? $filter_image["url"] : get_template_directory_uri() . "/assets/img/3m-filter.png";
                        $img["alt"] = ($filter_image["alt"]) ? $filter_image["alt"] : "3M Filter";
                    ?>
                    <img src="<?php echo $img["url"] ?>" alt="<?php echo $img["alt"] ?>">
                </div>
            </div>
            
            <div class="uk-width-2-3@s">
                <section class="uk-padding-remove-bottom">
                    <?php 
                        $section_1_copy = get_field( 'section_1_copy' );
                        $show_about_button = get_field( 'show_section_1_button' );
                        if ($section_1_copy){ // Display first section if copy is provided ?>
                            <section id="home-about-us">
                                <div class="uk-container">
                                    <div class="<?php echo $grid_style ?>" uk-grid>
                                        <div>
                                            <?php echo $section_1_copy ?>
                                            <?php if ($show_about_button){
                                                $url = (get_field( 'section_1_button' )) ? get_field( 'section_1_button' )["url"] : site_url() . "/about";
                                                $title = (get_field( 'section_1_button' )) ? get_field( 'section_1_button' )["title"] : "More About Us";
                                                $target = get_field( 'section_1_button' )["target"];
                                                ?>

                                                <a href="<?php echo $url; ?>" class="btn bg-primary" target="<?php echo $target; ?>"><?php echo $title; ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        <?php } ?>
                </section>



                <section class="uk-padding-remove-top">
                    <?php
                    $products_copy = get_field( 'products_copy' );
                    echo ($products_copy) ? $products_copy : "";

                    if( have_rows('products_links') ): // Display if product links section has rows
                        echo "<div class='uk-child-width-1-2@s uk-margin-medium-top' uk-grid>";
                        while ( have_rows('products_links') ) : the_row();
                            $image = get_sub_field("image");
                            $category = get_sub_field("category");
                            ?>

                            <div>
                                <a href="<?php echo site_url(); ?>/products/?id=<?php echo $category->term_id; ?>&category=<?php echo $category->name; ?>">
                                    <div class="uk-cover-container uk-width-1-1 home-products-container">
                                        <img src="<?php echo $image["url"]; ?>" alt="<?php echo $image["alt"]; ?>" uk-cover>
                                    </div>
                                </a>
                            </div>
                            <?php
                        endwhile;
                        echo "</div>";
                    endif;
                ?>
                </section>
            </div> <!-- right column -->

        </div> <!-- .uk-grid -->
    </div> <!-- .uk-container -->
    </section>
</main>
<?php get_footer(); ?>
