<?php

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup() {

	load_child_theme_textdomain( 'uo-custom', get_stylesheet_directory() . '/languages' );

}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

// Defines the child theme (do not remove).
define( 'CHILD_THEME_NAME', 'uo-custom' );
define( 'CHILD_THEME_URL', 'https://unlikelyobjects.com/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function genesis_sample_enqueue_scripts_styles() {

// 	wp_enqueue_style(
// 		'uo-custom-fonts',
// 		'//fonts.googleapis.com/css?family=Source+Serif+Pro',
// 		array(),
// 		CHILD_THEME_VERSION
// 	);

	
	wp_enqueue_style(
		'uo-custom-fonts',
		'//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css',
		array(),
		CHILD_THEME_VERSION
	);	
	
	
	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script(
		'uo-custom-responsive-menu',
		get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js",
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);
	wp_localize_script(
		'uo-custom-responsive-menu',
		'genesis_responsive_menu',
		genesis_sample_responsive_menu_settings()
	);

	wp_enqueue_script(
		'uo-custom',
		get_stylesheet_directory_uri() . '/js/uo-custom.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

}

/**
 * Defines responsive menu settings.
 *
 * @since 2.3.0
 */
function genesis_sample_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( 'Menu', 'uo-custom' ),
		'menuIconClass'    => 'dashicons-before dashicons-menu',
		'subMenu'          => __( 'Submenu', 'uo-custom' ),
		'subMenuIconClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Sets the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 702; // Pixels.
}

// Adds support for HTML5 markup structure.
add_theme_support(
	'html5', array(
		'caption',
		'comment-form',
		'comment-list',
		'gallery',
		'search-form',
	)
);

// Adds support for accessibility.
add_theme_support(
	'genesis-accessibility', array(
		'404-page',
		'drop-down-menu',
		'headings',
		'rems',
		'search-form',
		'skip-links',
	)
);

// Adds viewport meta tag for mobile browsers.
add_theme_support(
	'genesis-responsive-viewport'
);

// Adds custom logo in Customizer > Site Identity.
add_theme_support(
	'custom-logo', array(
		'height'      => 120,
		'width'       => 700,
		'flex-height' => true,
		'flex-width'  => true,
	)
);

// Renames primary and secondary navigation menus.
add_theme_support(
	'genesis-menus', array(
		'primary'   => __( 'Header Menu', 'uo-custom' ),
		'secondary' => __( 'Footer Menu', 'uo-custom' ),
	)
);

// Adds support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Adds support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Removes output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

add_action( 'genesis_theme_settings_metaboxes', 'genesis_sample_remove_metaboxes' );
/**
 * Removes output of unused admin settings metaboxes.
 *
 * @since 2.6.0
 *
 * @param string $_genesis_admin_settings The admin screen to remove meta boxes from.
 */
function genesis_sample_remove_metaboxes( $_genesis_admin_settings ) {

	remove_meta_box( 'genesis-theme-settings-header', $_genesis_admin_settings, 'main' );
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_admin_settings, 'main' );

}

add_filter( 'genesis_customizer_theme_settings_config', 'genesis_sample_remove_customizer_settings' );
/**
 * Removes output of header settings in the Customizer.
 *
 * @since 2.6.0
 *
 * @param array $config Original Customizer items.
 * @return array Filtered Customizer items.
 */
function genesis_sample_remove_customizer_settings( $config ) {

	unset( $config['genesis']['sections']['genesis_header'] );
	return $config;

}

// Displays custom logo.
add_action( 'genesis_site_title', 'the_custom_logo', 0 );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 10 );

add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' !== $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;
	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function genesis_sample_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}




/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
// Customisation below 
/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */


//* Customize Entry Meta Filed Under and Tagged Under - http://www.basicwp.com/?p=268
add_filter( 'genesis_post_meta', 'ig_entry_meta_footer' );
function ig_entry_meta_footer( $post_meta ) {
	$post_meta = '[post_categories before="Categories: "] [post_tags before="Tags: "]';
	return $post_meta;
}


/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
// Page nav function 
/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */

function getPrevNext(){
	$pagelist = get_pages('sort_column=menu_order&sort_order=asc&exclude=1367,1341,3,1488');
	$pages = array();
	foreach ($pagelist as $page) {
	   $pages[] += $page->ID;
	}

	$current = array_search(get_the_ID(), $pages);
	$prevID = $pages[$current-1];
	$nextID = $pages[$current+1];
	
	echo '<div class="navigation">';
	
	if (!empty($prevID)) {
		echo '<div class="alignleft prev-link prev-next-link">';
		echo '<a class="sans" href="';
		echo get_permalink($prevID);
		echo '"';
		echo 'title="';
		echo get_the_title($prevID); 
		echo'">Previous project</a>';
		echo "</div>";
	}
	if (!empty($nextID)) {
		echo '<div class="alignright next-link prev-next-link">';
		echo '<a class="sans" href="';
		echo get_permalink($nextID);
		echo '"';
		echo 'title="';
		echo get_the_title($nextID); 
		echo'">Next project</a>';
		echo "</div>";		
	}
}
/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
// Remove the title from the home page 
/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
add_action('get_header', 'remove_page_titles');
function remove_page_titles() {
if (is_front_page()) {
remove_action('genesis_entry_header', 'genesis_do_post_title');
}
}

/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
// Remove WP emoji
/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
// Clear CSS Cache 
/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
add_filter( 'stylesheet_uri', 'child_stylesheet_uri' );
/**
 * Cache bust the style.css reference.
 *
 */
function child_stylesheet_uri( $stylesheet_uri ) {
    return add_query_arg( 'v', filemtime( get_stylesheet_directory() . '/style.css' ), $stylesheet_uri );
}

/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
// Remove site footer
/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
// Customize site footer
add_action( 'genesis_footer', 'leaguewp_custom_footer' );
function leaguewp_custom_footer() { ?>

	<div class="site-footer">
		<div class="wrap">

			
			<?php
			/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
			// Begin MailChimp Signup Form 
			/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
			?>
			<div id="mc_embed_signup">
				<form action="https://unlikelyobjects.us16.list-manage.com/subscribe/post?u=dc4d7ba822c544e5f61e97268&amp;id=e1ab031cad" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					<div id="mc_embed_signup_scroll">
						<label for="mce-EMAIL">Subscribe to our mailing list. We have something good to tell you.</label>
						<input type="email" value="" name="EMAIL" class="email sans" id="mce-EMAIL" placeholder="Your email address" required>
						<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
						<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_dc4d7ba822c544e5f61e97268_e1ab031cad" tabindex="-1" value=""></div>
						<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button sans"></div>
					</div>
				</form>
			</div>
			<?php
			/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
			// End MailChimp Signup Form 
			/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
			?>

			
			<div class="footer-social-icons">
			    <ul class="social-icons">
					<li><a href="https://twitter.com/unlikelyobjects" class="social-icon"> <i class="fa fa-twitter"></i></a></li>
 			  		<li><a href="https://www.facebook.com/unlikelyobjects/" class="social-icon"> <i class="fa fa-facebook"></i></a></li>
					<li><a href="https://www.instagram.com/unlikely_objects/" class="social-icon"> <i class="fa fa-instagram"></i></a></li>
        		</ul>
        	</div>

			<p class="copyright sans">&copy; <?php echo date("Y"); ?> Unlikely Objects</p>
			<!--  &middot; <a href='<?php echo esc_html( antispambot( 'mailto:hello@unlikelyobjects.com' ) ); ?>'><?php echo esc_html( antispambot( 'hello@unlikelyobjects.com' ) ); ?></a></p> -->

			
		</div>
	</div>

<?php
}