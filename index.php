<?php
    get_header();
    get_template_part('/Template-Parts/nav-sub');
?>

<div id='nav-spacer'></div>
<main>
    <section class="projects-container">
        <div class="uk-container">
			<h1>404 Page Not Found</h1>
			<p>It looks like this page doesn't exist. Please check your link and try again or return to the home page. If this issue keeps occuring, please contact <a href="mailto:team@alariedesign.com">team@alariedesign.com</a></p>
			<p><a href="<?php echo site_url();?>" class="btn bg-primary">Return to home</a>
        </div>
    </section>
</main>
<?php get_footer(); ?>
