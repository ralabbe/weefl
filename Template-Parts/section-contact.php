<?php 
    // Get image from contact setting. If no image, default to water droplet mail icon from the assets folder
    $contact_img = get_option('contact_image') ? get_option('contact_image') : get_template_directory_uri() . "/assets/img/mail-icon-droplets.png";
?>

<section class="bg-primary">
    <div class="uk-container">
        <div uk-grid class="uk-flex uk-flex-middle">
            <div class="uk-width-1-3@m uk-text-center">
                <img src="<?php echo $contact_img; ?>" alt="Mail icon with water droplets" class="uk-width-2-3" style="max-width:200px">
            </div>
            <div class="uk-width-2-3@m">
                <?php echo get_option('contact_section'); ?>
                <p><a href="<?php echo site_url(); ?>/contact" class="btn bg-primary btn-alt">Contact Us</a></p>
            <div>
        </div>
    </div>
</section>