<?php
$related = get_field( 'replacement_cartridge' ); // Grab replacement cartridge product
if ( $related ): // If replacement cartridge product is selected, show this section
    foreach ( $related as $post ):
        setup_postdata ($post);
        $title = get_the_title();
        ?>
        <section class="uk-padding-remove-top">
            <div class="uk-container">
                <hr>
                <div class="uk-margin-large-top" uk-grid>
                    <div class="products-container uk-width-1-3@m uk-visible@m">
                        <div class="products-single">
                            <a href="<?php echo the_permalink(); ?>">
                                <figure class="uk-text-center">
                                    <div class="uk-padding-small">
                                        <?php the_post_thumbnail("thumb"); ?>
                                    </div>
                                </figure>
                                <h3><?php echo $title; ?> </h3>
                            </a>
                        </div>
                    </div>
                    
                    <div class="uk-width-2-3@m uk-margin-medium-top">
                        <?php echo get_option('single_product'); ?>
                        <br>
                        <a href="<?php echo site_url(); ?>/contact/?cartridge=<?php the_title(); ?>" class="btn bg-primary">Get a Replacement</a>
                    </div>

                    
                    <div class="products-container uk-width-1-1 uk-width-2-3@s uk-margin-auto uk-hidden@m">
                        <div class="products-single">
                            <a href="<?php echo the_permalink(); ?>">
                                <figure class="uk-text-center">
                                    <div class="uk-padding-small">
                                        <?php the_post_thumbnail("thumb"); ?>
                                    </div>
                                </figure>
                                <h3><?php echo $title; ?> </h3>
                            </a>
                        </div>
                    </div>
                </div>
            
            </div>
        </section>
    <?php endforeach;
    wp_reset_query();
    wp_reset_postdata(); //Reset post query
endif;
                    
?>