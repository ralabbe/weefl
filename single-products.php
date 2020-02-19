<?php
    get_header(); // Header
    get_template_part('/Template-Parts/nav'); // Navbar
    if (have_posts()):
	    while ( have_posts() ) :
            the_post(); ?>
            
            <?php include( locate_template( '/Template-Parts/hero-product.php', false, false ) ); ?>
            <main id="product-single" class="uk-padding-large uk-padding-remove-left uk-padding-remove-top uk-padding-remove-right">
                <section class="uk-padding-remove-top uk-margin-top">
                    <div class="uk-container">
                        <div uk-grid>
                            <div class="uk-width-1-3@m uk-text-center product-single-thumbnail">
                                <figure class="uk-padding uk-position-relative">
                                    <?php
                                        the_post_thumbnail("large"); // Display product image
                                    ?>
                                </figure>
                                <a href="<?php echo site_url(); ?>/contact/?product=<?php the_title(); ?>" class="btn bg-primary">Buy Product</a>
                            </div>
                            <div class="uk-width-2-3@m">
                                
                                <small class="uk-text-meta"><a href="<?php echo site_url(); ?>/products">Products</a> / <a href="<?php echo site_url(); ?>/products/?id=<?php echo get_the_category()[0]->term_id; ?>&category=<?php echo get_the_category()[0]->name; ?>"><?php echo get_the_category()[0]->name; ?></a></small>
                                
                                <div class="uk-flex uk-flex-around uk-flex-middle">
                                        <h1 class="uk-margin-remove"><?php the_title(); ?></h1>
                                        <?php 
                                    
                                        $term_id = get_the_category()[0]->term_id; // Category id
                                        $taxonomy = "category"; // Taxonomy name
                                        
                                        $company_logo = get_field('image', $taxonomy . "_" . $term_id); // Grab logo
                                        
                                        echo "<div class='products-single-company-logo uk-margin-auto'><figure class='uk-padding-small uk-margin-remove'>" . wp_get_attachment_image($company_logo,"medium") . "</figure></div>" ; // Display thumbnail logo
                                        ?>
                                </div>
                                <?php the_content(); ?>



                                
                                <?php
                                $spec = get_field("spec_sheet");
                                $manual = get_field("install_manual");

                                $allinfo = []; // Create info array

                                $model = (get_field("model_number")) ? get_field("model_number") : "";
                                if ($model) { $allinfo["Model Number"] = $model; } // Add model number to info array

                                $part = (get_field("part_number")) ? get_field("part_number") : "";
                                if ($part) { $allinfo["Part Number"] = $part; } // Add part number to info array

                                $part_id = (get_field("id")) ? get_field("id") : "";
                                if ($part_id) { $allinfo["ID"] = $part; } // Add ID to info array

                                while ( have_rows('more_information') ) : the_row(); // Get custom info
                                    $title = get_sub_field("info_title"); // Title
                                    $description = get_sub_field("info_description"); // Info

                                    $allinfo[$title] = $description; // Add to info array
                                
                                endwhile;


                                if (count($allinfo) > 0){ // If the info array has content, create a table.
                                    ?>

                                    <table class="uk-table uk-table-striped products-single-info">
                                        <tbody>
                                            <?php 
                                                foreach ($allinfo as $title => $info){ // Create a row for each item in the info array
                                                    echo "<tr><td>" . $title . "</td><td>" . $info . "</td></tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>

                                    <?php
                                }
                                

                                if ($spec){
                                    echo "<a href='" . $spec . "' target='_blank' class='btn btn-small bg-primary'>View Spec Sheet</a>";
                                }
                                if ($manual){
                                    echo " <a href='" . $manual . "' target='_blank' class='btn btn-small bg-primary'>View Installation Manual</a>";
                                }
                                ?>
                            </div> <!-- info section -->
                        </div> <!-- .uk-grid -->
                    </div> <!-- .uk-container -->
                </section>
                
            <?php include( locate_template( '/Template-Parts/related-cartridge.php', false, false ) ); // Related products section ?>
            </main>
        <?php endwhile;
    endif; ?>
<?php
	get_footer();
?>