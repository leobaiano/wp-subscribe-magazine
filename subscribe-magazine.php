<?php
	/**
	 * Plugin Name: Subscribe Magazine
	 * Plugin URI:
	 * Description: Subscribe Magazine.
	 * Author: leobaiano
	 * Author URI: http://lbideias.com.br
	 * Version: 1.0.0
	 * License: GPLv2 or later
	 * Text Domain: lb_subscribe_magazine
 	 * Domain Path: /languages/
	 */

	if ( ! defined( 'ABSPATH' ) )
		exit; // Exit if accessed directly.

	require_once 'class-cpt.php';

	/**
	 * Subscribe_Magazine
	 *
	 * @author   Leo Baiano <leobaiano@lbideias.com.br>
	 */
	class Subscribe_Magazine {
		/**
		 * Instance of this class.
		 *
		 * @var object
		 */
		protected static $instance = null;

		/**
		 * Prefix plugin
		 *
		 * @var string
		 */
		public static $prefix = 'snct';


		/**
		 * Initialize the plugin
		 */
		private function __construct() {

			// Load plugin text domain
			add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
			// Create Custom post types
			add_action( 'init', array( $this, 'create_cpts' ), 1 );
			add_action( 'init', array( $this, 'create_taxonomys' ), 1 );
			add_action( 'init', array( $this, 'create_custom_fields' ), 1 );
		}
		/**
		 * Return an instance of this class.
		 *
		 * @return object A single instance of this class.
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
		/**
		 * Load the plugin text domain for translation.
		 *
		 * @return void
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( self::$prefix, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Creates the post pin type that is used to add posts
		 *
		 */
		public function create_cpts(){
			new Create_CPT( 'assine', 'Assine', array( 'title' ), self::$prefix );
			// new Create_CPT( 'location', 'Locations', array( 'title', 'editor', 'excerpt', 'thumbnail' ), self::$prefix );
		}

		/**
		 * Create Taxonomys
		 */
		public function create_taxonomys() {
			// register_taxonomy('state', array( 'schedule', 'location' ), array( 'hierarchical' => true, 'label' => _x( 'State/ City', self::$prefix ), 'query_var' => true, 'rewrite' => true));
			// register_taxonomy('city', array( 'schedule', 'location' ), array( 'hierarchical' => true, 'label' => _x( 'City', self::$prefix ), 'query_var' => true, 'rewrite' => true));
		}

		/**
		 * Create Custom fields
		 */
		public function create_custom_fields() {
			if(function_exists("register_field_group"))	{
				register_field_group(array (
					'id' => 'acf_assine',
					'title' => 'Assine',
					'fields' => array (
						array (
							'key' => 'field_56cd9e6e8a2a5',
							'label' => 'Imagem',
							'name' => 'assine_imagem',
							'type' => 'image',
							'save_format' => 'id',
							'preview_size' => 'thumbnail',
							'library' => 'all',
						),
						array (
							'key' => 'field_56cd9ea98a2a6',
							'label' => 'Valor',
							'name' => 'assine_valor',
							'type' => 'text',
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'formatting' => 'html',
							'maxlength' => '',
						),
						array (
							'key' => 'field_56cd9ea98a2a7',
							'label' => 'Link',
							'name' => 'assine_link',
							'type' => 'text',
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'formatting' => 'html',
							'maxlength' => '',
						),
					),
					'location' => array (
						array (
							array (
								'param' => 'post_type',
								'operator' => '==',
								'value' => 'assine',
								'order_no' => 0,
								'group_no' => 0,
							),
						),
					),
					'options' => array (
						'position' => 'normal',
						'layout' => 'default',
						'hide_on_screen' => array (
						),
					),
					'menu_order' => 0,
				));
			}

		}
	}
	add_action( 'plugins_loaded', array( 'Subscribe_Magazine', 'get_instance' ), 0 );
