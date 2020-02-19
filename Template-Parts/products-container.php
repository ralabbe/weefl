
<h2 id="products-category"><?php echo $category ? $category : "All Products"; ?></h2>
<div id="response" data-products="<?php echo ($id) ? $id : "all" ?>" data-limit="<?php echo $product_limit ?>">
    <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-margin-medium-top uk-margin-medium-bottom"  uk-grid uk-scrollspy="cls: uk-animation-slide-right-small; target: > div; delay: 50; repeat: false">
    <?php 
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $args =  array( // Arguements for post query
        'post_type' => 'products',
        'posts_per_page' => $product_limit,
        'paged' => $paged,
        'cat' => $_GET["id"], // Grab posts from specific category (if page is accessed with a query)
    );
    
    $query = new WP_Query( $args ); // Query posts with arguments

    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post(); ?>
            <div class="opacity0 products-single">
                <a href="<?php echo the_permalink(); ?>">
                    <figure class="uk-text-center">
                        <div class="uk-padding-small">
                            <?php the_post_thumbnail("thumb"); ?>
                        </div>
                    </figure>
                </a>
                
                <a href="<?php echo the_permalink(); ?>">
                    <h3 class="uk-text-bold uk-margin-remove"><?php the_title(); ?></h3>
                </a>
            </div>
        <?php
        endwhile;
        echo "</div><div id='pagination' class='pagination uk-text-center' data-action='" . site_url() .  "/wp-admin/admin-ajax.php'>";

        echo paginate_links( array(
            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'total'        => $query->max_num_pages,
            'current'      => max( $paged, get_query_var( 'paged' ) ),
            'format'       => '?paged=%#%',
            'show_all'     => false,
            'type'         => 'plain',
            'end_size'     => 2,
            'mid_size'     => 1,
            'prev_next'    => false,
            'add_args'     => false,
            'add_fragment' => '',
        ) );
        echo "</div>";
        wp_reset_postdata();
    endif;
    ?>
</div>