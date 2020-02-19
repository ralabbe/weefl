<?php 
    $thumbnail = get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : get_template_directory_uri() . "/assets/img/water-hero-blue.jpg";
    $hero_heading = get_field('hero_heading');
    $hero_copy = get_field('hero_copy');
    $hide_hero_heading = get_field('hide_hero_heading');

    if ( $thumbnail ) { ?>
        
        <section id="hero" class="sub-hero sub-hero-alt text-white uk-cover-container uk-width-1-1 uk-flex uk-flex-center uk-flex-middle uk-text-center uk-margin-remove">
            <img src="<?php echo $thumbnail; ?>" alt="<?php echo $file['alt']; ?>" class="z-index--1" uk-cover>
                <?php
                echo "<div class='dis-table uk-width-1-1'><div class='dis-table-cell'><div class='uk-container '>";
                if (!$hide_hero_heading){
                    echo ($hero_heading) ? "<h1>" . $hero_heading . "</h1>" : "<h1>" . get_the_title() . "</h1>";
                }
                if ($hero_copy){
                    echo ($hero_copy) ? $hero_copy : "";
                }
                echo "</div></div>";
                ?>
        </section>

    <?php } else { // If no file exists, add a spacer ?>
        <div id='nav-spacer'></div>
    <?php } 
?>