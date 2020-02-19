<?php
    get_header();
    get_template_part('nav');

	while ( have_posts() ) :
		the_post(); ?>
		<div class="uk-position-relative height-40">
			<div class="uk-position-absolute height-70 uk-width-1-1 blog-hero" style="background:url(<?php echo get_the_post_thumbnail_url(); ?>); background-size:cover; background-position:center;" role="img" aria-label="<?php echo get_the_post_thumbnail_caption(); ?>">
			</div>
		</div>
			
			<article id="blog-container" class="uk-container bg-white" uk-scrollspy="cls: uk-animation-slide-bottom-medium;">
				<div class="uk-text-center">
					<h1 class="blog-heading"><?php the_title(); ?></h1>
					<br>
					<time><?php echo get_the_date( 'F j, Y' );?></time>
				</div>
				<section id="blog-post">
					<div class="blog-post-container">
						<?php the_content(); ?>
					</div>
				</section>
			</article>

	<?php endwhile;
	wp_reset_postdata(); //Reset post query
	the_post();
?>

<hr>

<!-- Let's Go Section -->
<div class="uk-margin-large-top">
	<?php get_template_part('lets-go'); ?>
</div>
 
<?php
	get_footer();
?>