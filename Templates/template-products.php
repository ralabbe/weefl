<?php /* Template Name: Products */  ?>

<?php
    get_header();
    get_template_part('/Template-Parts/nav');

    $id = 0;

    if ($_GET["category"] && $_GET["id"]){
        $category = $_GET["category"];
        $id = $_GET["id"];
    }
    
    $product_limit = (get_field("products_per_page")) ? get_field("products_per_page") : 6;
?>
<main>

    <?php include( locate_template( '/Template-Parts/hero-sub.php', false, false ) ); ?>

    <section class="products-container">
        <div class="uk-container">
            <div uk-grid>
                <div class="products-filter uk-width-1-4@m">
                    <span  class="uk-text-bold">Select a Brand</span>
                    <?php
                        // Crerate Filter buttons for each category taxonomy
                        // categoryfilter is the id of the category that will be filtered in. This is pulled in custom.js and fetched in functions.php
                        // categoryName is the name of the category to be used as a display above the products
                        
                        if( $terms = get_terms( array( 'taxonomy' => 'category', 'orderby' => 'name' ) ) ) : 

                            foreach ( $terms as $term ) :
                            ?>
                                <form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" class="filter">
                                    <input type="hidden" name="categoryfilter" value="<?php echo $term->term_id; ?>" />
                                    <input type="hidden" name="categoryName" value="<?php echo $term->name; ?>" />
                                    <input type="hidden" name="categoryDescription" value="<?php echo $term->description; ?>" />
                                    <button class="uk-text-left"><?php echo $term->name ?></button>
                                    <input type="hidden" name="action" value="myfilter">
                                </form>
                            <?php
                            endforeach;
                        endif;
                        // Default View All button. (no input with categoryfilter)
                    ?>
                    <form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" class="filter uk-inline-block">
                        <input type="hidden" name="categoryName" value="All Products" />
                        <button>View All</button>
                        <input type="hidden" name="action" value="myfilter">
                    </form>
                    <?php the_content(); ?>
                    <?php
                        $image = get_field("image");
                        if ($image){
                            echo wp_get_attachment_image($image, "medium", "", array( "class" => "uk-margin-auto uk-display-block uk-margin-top uk-visible@m" ));
                        }
                    ?>
                </div>
                <div class="uk-width-3-4@m">
                    
                    <?php include( locate_template( '/Template-Parts/products-container.php', false, false ) ); ?>

                </div> <!-- .products container -->
            </div> <!-- .uk-grid -->
        </div> <!-- .uk-container -->
    </section>

</main>


<?php get_footer(); ?>

<script>
    $(document).ready(function(){
        var uri = window.location.toString();
        if (uri.indexOf("?") > 0) {
            var clean_uri = uri.substring(0, uri.indexOf("?"));
            window.history.replaceState({}, document.title, clean_uri);
        }
    });
</script>