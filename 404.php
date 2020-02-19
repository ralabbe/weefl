<?php
    get_header();
?>

<main class="uk-text-center dis-table" uk-height-viewport>
    <section class="dis-table-cell" style="width: 100vw">
        <div class="uk-container">
            <div class="wave-fill uk-margin-auto">
                <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/img/404.svg" alt="404"> -->
                <div class="water-container">
                    <span class="wave"></span>
                    <span class="deep-water"></span>
                </div>
                <div class="water-container water-container-2">
                    <span class="wave"></span>
                    <span class="deep-water"></span>
                </div>
            </div>
            <h1 aria-label="404 Page not found" class="text-tertiary">Page Not Found</h1>
			<p>It looks like this page doesn't exist. Please check your link and try again or return to the home page. If this issue keeps occuring, please contact <a href="mailto:team@alariedesign.com">team@alariedesign.com</a></p>
			<p><a href="<?php echo site_url();?>" class="btn bg-primary">Return to home</a>
        </div>
    </section>
</main>
<?php wp_footer(); ?>
