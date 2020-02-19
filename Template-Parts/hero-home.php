<?php 
  $file = get_field( 'hero_file' );
  $hero_heading = get_field('hero_heading'); // Copy to be placed in hero
  $hero_copy = get_field('hero_copy');
  $hero_button = get_field('hero_button');

  if ( $file ) {
        $filetype = wp_check_filetype($file['url'])['ext'];
        if ( $filetype == "mp4" ||  $filetype == "mov" || $filetype == "avi" || $filetype == "wmv"){  // If file is a video, display a video element
            $vid_thumb = "";
            if (get_field("hero_thumbnail")){
                $vid_thumb = "poster='" . get_field("hero_thumbnail") . "'";
            }?>

            <section id="hero" class="hero-home uk-cover-container uk-width-1-1 uk-margin-remove">
                <video autoplay loop muted playsinline uk-cover oncontextmenu="return false;"  <?php echo $vid_thumb; ?>>
                    <source src="<?php echo $file['url']; ?>" type="video/<?php echo $filetype; ?>" data-vidsrc="<?php echo $file['url']; ?>">
                </video>

                <?php if ($hero_heading || $hero_copy || $hero_button) { ?>
                    <div class='dis-table uk-text-center uk-width-1-1'>
                        <div class="dis-table-cell uk-padding-small">
                            <?php echo ($hero_heading) ? "<h1 class='hero-heading' style='color:" . get_field("hero_text_color") . "'>" . $hero_heading . "</h1>" : ""; ?>

                            <div class="hero-copy" style='color:<?php echo get_field("hero_text_color");?>;'>
                                <?php if ($hero_copy){ ?>
                                    <?php echo $hero_copy ?> 
                                <?php } ?>
                            </div>
                            <?php echo ($hero_button) ? "<a href='" . $hero_button["url"] . "' class='btn bg-white'>" . $hero_button["title"] . "</a>" : ""; ?>
                            
                        </div>
                    </div>
                <?php } ?>

            </section>
        <?php } else { // If file isn't a video, display as an image ?>
            <section id="hero" class="hero-home uk-cover-container uk-width-1-1 uk-margin-remove">
                <img src="<?php echo $file['url']; ?>" alt="<?php echo $file['alt']; ?>" class="z-index--1" uk-cover>
    
                <?php if ($hero_heading || $hero_copy || $hero_button) { ?>
                    <div class='dis-table uk-text-center uk-width-1-1'>
                        <div class="dis-table-cell uk-padding-small">
                            <?php echo ($hero_heading) ? "<h1 class='hero-heading' style='color:" . get_field("hero_text_color") . "'>" . $hero_heading . "</h1>" : ""; ?>

                            <?php if ($hero_copy){ ?>
                                <div class='hero-copy' style='color:<?php echo get_field("hero_text_color");?>;' class="uk-margin-medium-top">
                                    <?php echo $hero_copy ?> 
                                </div>
                            <?php } ?>

                            <?php echo ($hero_button) ? "<a href='" . $hero_button["url"] . "' class='btn bg-white'>" . $hero_button["title"] . "</a>" : ""; ?>
                        </div>
                    </div>
                <?php } ?>
            </section>
      <?php }  ?>

  <?php } else { // If no file exists add a placeholder image ?>
        <section id="hero" class="hero-home uk-cover-container uk-width-1-1 height-100uk-flex uk-flex-center uk-flex-middle uk-table uk-margin-remove">
            <img src="<?php get_template_directory_uri(); ?>/assets/img/water-hero-blue.jpg" alt="An image of a wave of water" class="z-index--1" uk-cover>
        </section>
   <?php } 
?>