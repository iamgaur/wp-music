<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.techwithnavi.com/
 * @since      1.0.0
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/admin
 * @author     Naveen Gaur <navigaur99@gmail.com>
 */
class Wp_Music_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Music_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Music_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-music-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Music_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Music_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-music-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function registerWpMusicPostType()
	{
		$labels = array(
			'name'                => _x( 'Music', 'Post Type General Name', 'wp-music' ),
			'singular_name'       => _x( 'Music', 'Post Type Singular Name', 'wp-music' ),
			'menu_name'           => __( 'Music', 'wp-music' ),
			'parent_item_colon'   => __( 'Parent Music', 'wp-music' ),
			'all_items'           => __( 'All Music', 'wp-music' ),
			'view_item'           => __( 'View Music', 'wp-music' ),
			'add_new_item'        => __( 'Add New Music', 'wp-music' ),
			'add_new'             => __( 'Add New', 'wp-music' ),
			'edit_item'           => __( 'Edit Music', 'wp-music' ),
			'update_item'         => __( 'Update Music', 'wp-music' ),
			'search_items'        => __( 'Search Music', 'wp-music' ),
			'not_found'           => __( 'Not Found', 'wp-music' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'wp-music' ),
		);
		 
	// Set other options for Custom Post Type
		 
		$args = array(
			'label'               => __( 'Music', 'wp-music' ),
			'description'         => __( 'Music', 'wp-music' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
			// You can associate this CPT with a taxonomy or custom taxonomy. 
			'taxonomies'          => array( 'category', 'post_tag' ),
			/* A hierarchical CPT is like Pages and can have
			* Parent and child items. A non-hierarchical CPT
			* is like Posts.
			*/ 
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest' => true,
	 
		);

		return register_post_type( 'Music', $args );
	}

	/*
		* Add a settings page for the plugin under Settings menu
		* Administration Menus: http://codex.wordpress.org/Administration_Menus
		*
	*/

	public function add_admin_menu() {
		add_submenu_page( 'edit.php?post_type=music', 'Music Settings', 'Music Settings',
    'manage_options', $this->plugin_name, array($this, 'display_setup_page'));
	}

	/**
		 * Load the settings page content
		 *
		 * @since    1.0.0
	 */
  
	public function display_setup_page() {
		include_once( 'partials/wp-music-admin-display.php' );
	}

	/**
	 *
	 * Save/update options settings
	 *
	 * @since 1.0.0
	 */
  
		public function options_update() {
			
			register_setting($this->plugin_name, $this->plugin_name,  array($this, 'validate'));
	}

	/**
		 *
		* Validate input fieldset
		*
		* @since 1.0.0
		*/

		public function validate( $input ) {

			$validated = array();

			
			/**
			 * Validate currency
			 */

			$validated['music_currency'] = sanitize_key( $input[ 'music_currency' ] );

			/**
			 * Validate post per page
			 */

			$validated['music_post_per_page'] = intval( $input['music_post_per_page'] );

	
			return $validated;

	}


	/**
	 *
	 * Meta data added
	 *
	 * @since 1.0.0
	 */

	function add_music_meta_box()
	{
		add_meta_box("music-meta-info", "Music Meta Box", array( $this, 'music_meta_info_markup' ), "music", "normal", "high", null);
	}

	/**
	 *
	 * Meta data form
	 *
	 * @since 1.0.0
	 */

	function music_meta_info_markup($object)
	{
		wp_nonce_field(basename(__FILE__), "meta-box-nonce");
		$html = '<div class="music-custom-box">
			<div class="row">
				<label for="composer-name">Composer Name</label>
				<input name="composer-name" type="text" value="'.get_post_meta($object->ID, "composer-name", true).'">
			</div>
			<div class="row">
				<label for="publisher">Publisher</label>
				<input name="publisher" type="text" value="'.get_post_meta($object->ID, "publisher", true).'">
			</div>	

			<div class="row">
			
				<label for="year">Year of recording</label>
				<input name="year" type="text" value="'.get_post_meta($object->ID, "year", true).'">
			</div>
			<div class="row">
				<label for="additional-contributors">Additional Contributors</label>
				<input name="additional-contributors" type="text" value="'.get_post_meta($object->ID, "additional-contributors", true).'">
			</div>
			<div class="row">
				<label for="url">URL</label>
				<input name="url" type="text" value="'.get_post_meta($object->ID, "url", true).'">
			</div>

			<div class="row">
				<label for="price">Price</label>
				<input name="price" type="text" value="'.get_post_meta($object->ID, "price", true).'">
			</div>
        	</div>';
		echo $html;
	}

	/**
	 *
	 * Save and update meta data value
	 *
	 * @since 1.0.0
	 */
	public function save_custom_meta_box($post_id, $post, $update)
	{

		
		if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

		if(!current_user_can("edit_post", $post_id))
			return $post_id;

		if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
			return $post_id;

		$slug = "music";
		if($slug != $post->post_type)
			return $post_id;



		if(isset($_POST["composer-name"]))
		{
			$composer = sanitize_text_field($_POST["composer-name"]);
			update_post_meta($post_id, "composer-name", $composer);
		}
		
		if(isset($_POST["publisher"]))
		{
			$publisher = sanitize_text_field($_POST["publisher"]);
			update_post_meta($post_id, "publisher", $publisher);
		}

		if(isset($_POST["year"]))
		{
			$years = sanitize_text_field($_POST["year"]);
			update_post_meta($post_id, "year", $years);
		}

		if(isset($_POST["additional-contributors"]))
		{
			$additionalContributors = sanitize_text_field($_POST["additional-contributors"]);
			update_post_meta($post_id, "additional-contributors", $additionalContributors);
		}

		if(isset($_POST["url"]))
		{
			$additionalContributors = sanitize_text_field($_POST["url"]);
			update_post_meta($post_id, "url", $additionalContributors);
		}

		if(isset($_POST["price"]))
		{
			$additionalContributors = sanitize_text_field($_POST["price"]);
			update_post_meta($post_id, "price", $additionalContributors);
		}

	} 
}
