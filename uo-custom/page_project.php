<?php
/*
Template Name: Project page
*/

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Next: add the custom Advanced Custom Fields loop

?>

<?php add_action( 'genesis_entry_footer', 'acf_loop' ); ?>

<?php function acf_loop() {

// ---------------------------------------------------------------------------------------
// Main content
// ---------------------------------------------------------------------------------------
?>

<div class="text-content">
	<section class="intro">
		<?php the_field( 'intro_text' ); ?>
	</section>

	<section class="main">
		<?php the_field( 'text' ); ?>
	</section>

<?php if ( is_page( 1497 ) ) : // The Invisible D CTA ?>
	<div class="cta-wrapper">
		<a class="cta sans" href="https://mailchi.mp/56671c8aa23c/the-invisible-d">Get the book <i class="fa fa-arrow-right"></i></a>
		<p class="cta-text">We have ebook and print versions planned as well as a <strong>free&nbsp;PDF&nbsp;version</strong> and teaching materials.</p>
	</div>
<?php endif; ?>

</div>


<?php
// ---------------------------------------------------------------------------------------
// Sidebar: Project Links
// ---------------------------------------------------------------------------------------

$project_links = get_field( 'project_links' ); ?>
<?php if ( $project_links ) :  ?>
<div class="project-links">
	<h3>Project links</h3>
	<?php the_field( 'project_links' ); ?>
</div>
<?php endif; ?>


<?php
// ---------------------------------------------------------------------------------------
// Sidebar: Chapter Reviews
// ---------------------------------------------------------------------------------------

if ( is_page( 1495 ) ) : ?>

<div class="writing-links">
	<h3>Chapter reviews</h3>
		<ul>

<?php
// Get titles and links for the latest posts

	global $post;
	$args = array( 'category' => 22, 'posts_per_page' => 30 );
	$myposts = get_posts( $args );
	foreach( $myposts as $post ) :  setup_postdata($post); ?>
			<li><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
	<?php endforeach; ?>
		</ul>

</div> <!-- /.writing-links -->
<?php endif; ?>


<?php
// ---------------------------------------------------------------------------------------
// Sidebar: Project Notes
// ---------------------------------------------------------------------------------------

$category_ids = get_field( 'category' ); ?>


<?php
// Check to see if there's 1 post in the category, if yes then write the wrapper HTML
	global $post;
	$args = array( 'category' => $category_ids, 'posts_per_page' => 1 );
	$myposts = get_posts( $args );
	foreach( $myposts as $post ) :  setup_postdata($post); ?>

<div class="writing-links">
	<h3>Project notes</h3>
             <ul>
<?php endforeach; ?>

<?php
// Get titles and links for the latest 10 posts
// reference https://stackoverflow.com/questions/11909304/wp-get-posts-by-category

	global $post;
	$args = array( 'category' => $category_ids, 'posts_per_page' => 10, 'category__not_in' => array(22) );
	$myposts = get_posts( $args );
	foreach( $myposts as $post ) :  setup_postdata($post); ?>
				<li><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
	<?php endforeach; ?>
           		 </ul>

<?php
// Check to see if there's 1 post in the category, if yes then close the wrapper
	global $post;
	$args = array( 'category' => $category_ids, 'posts_per_page' => 1 );
	$myposts = get_posts( $args );
	foreach( $myposts as $post ) :  setup_postdata($post); ?>

</div> <!-- /.writing-links -->
<?php endforeach; ?>


<?
// ---------------------------------------------------------------------------------------
// Gallery of project images
// ---------------------------------------------------------------------------------------
?>

<?php wp_reset_postdata(); ?>

<div id="project-gallery-wrapper">
<?php $gallery_images = get_field( 'gallery' ); ?>
<?php if ( $gallery_images ) :  ?>
	<?php foreach ( $gallery_images as $gallery_image ): ?>
		<div class="panel"><img src="<?php echo $gallery_image['sizes']['large']; ?>" alt="<?php echo $gallery_image['alt']; ?>" /></div>
	<?php endforeach; ?>
<?php endif; ?>
</div>

<footer>

<?php getPrevNext(); // Prev & next page nav for projects, excludes home, about, etc. Function in functions.php ?>

<?php } ?>

<?php

//* Run the Genesis loop
genesis();
