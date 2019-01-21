<?php
/**
 * Home template
 */

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

?>

<!-- Add custom acf loop -->
<?php add_action( 'genesis_entry_footer', 'acf_loop' ); ?>

<?php function acf_loop() { ?>

<!-- Hero text area -->
	<div class="hero">
		<h3><?php the_field( 'hero_heading' ); ?></h3>
		<?php the_field( 'hero_text' ); ?>
	</div>

<!-- Project cards -->
<section class="projects">

<h4>Projects</h4>

<ul class="cards">
<?php if ( have_rows( 'project_cards' ) ) : ?>
	<?php while ( have_rows( 'project_cards' ) ) : the_row(); ?>
 		 <li class="cards__item" style="position:relative;">

			<?php if ( get_sub_field( 'coming_soon' ) == 0 ): // Show the project page ?>
				<a class="card-link" href='<?php the_sub_field( 'project_page_link' ); ?>' title='<?php the_sub_field( 'title' ); ?> project page'>
   			<?php endif; ?>

			<?php if ( get_sub_field( 'coming_soon' ) == 1 ) { // No project page yet
			 echo '<div class="card">';
			} else {
			 echo '<div class="card live-card">';
			} ?>

    		  <div class="card__image">
      				<?php if ( get_sub_field( 'image' ) ) { ?>
					<img src="<?php the_sub_field( 'image' ); ?>" alt="<?php the_sub_field( 'image_alt' ); ?>" />
				<?php } ?>
			  </div>

    		  <div class="card__content">
        		<h5 class="card__title"><?php the_sub_field( 'title' ); ?></h5>
        		<p class="card__text"><?php the_sub_field( 'text' ); ?></p>
    		  </div>

			</div> <!-- /.card -->

			<?php if ( get_sub_field( 'coming_soon' ) == 0 ): // Close the project page link ?>
				</a>
   			<?php endif; ?>

  		</li>
	<?php endwhile; ?>
<?php else : ?>
	<?php // no rows found ?>
<?php endif; ?>
</ul>

</section>

<?php } ?>

<?php

//* Run the Genesis loop
genesis();
