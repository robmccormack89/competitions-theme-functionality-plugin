<?php
namespace Rmcc;
use Timber\Timber;

class CompetitionsThemeFunctionality extends Timber {

  public function __construct() {
    parent::__construct();
    add_filter('timber/twig', array($this, 'add_to_twig'));
    add_filter('timber/context', array($this, 'add_to_context'));
    
    add_action('plugins_loaded', array($this, 'plugin_timber_locations'));
    add_action('plugins_loaded', array($this, 'plugin_text_domain_init')); 

    add_action('init', array($this, 'register_post_types'));
    add_action('pre_get_posts', array($this, 'cpt_posts_per_page'));

    add_action('plugins_loaded' , array($this, 'add_acf_options_page'));
    add_action('plugins_loaded' , array($this, 'add_cpt_custom_fields'));
  }
  
  public function add_acf_options_page() {
    // add options page in backend via acf
    if( function_exists('acf_add_options_page') ) {
      // the options page options
    	acf_add_options_page(array(
    		'page_title' 	=> 'Theme Settings',
    		'menu_title'	=> 'Theme Settings',
    		'menu_slug' 	=> 'theme-settings',
    		'capability'	=> 'edit_posts',
    		'redirect'		=> false
    	));
      // options page acf fields
      if( function_exists('acf_add_local_field_group') ):
        acf_add_local_field_group(array(
        	'key' => 'group_5fc3ebf0d7bb9',
        	'title' => 'Site Settings',
        	'fields' => array(
        		array(
        			'key' => 'field_60c62769bb70f',
        			'label' => 'Site Featured Image',
        			'name' => 'site_featured_image',
        			'type' => 'image',
        			'instructions' => '',
        			'required' => 0,
        			'conditional_logic' => 0,
        			'wrapper' => array(
        				'width' => '',
        				'class' => '',
        				'id' => '',
        			),
        			'return_format' => 'array',
        			'preview_size' => 'medium',
        			'library' => 'all',
        			'min_width' => '',
        			'min_height' => '',
        			'min_size' => '',
        			'max_width' => '',
        			'max_height' => '',
        			'max_size' => '',
        			'mime_types' => '',
        		),
        	),
        	'location' => array(
        		array(
        			array(
        				'param' => 'options_page',
        				'operator' => '==',
        				'value' => 'theme-settings',
        			),
        		),
        	),
        	'menu_order' => 0,
        	'position' => 'normal',
        	'style' => 'default',
        	'label_placement' => 'top',
        	'instruction_placement' => 'label',
        	'hide_on_screen' => '',
        	'active' => true,
        	'description' => '',
        ));
      endif;
    };
  }
  public function add_cpt_custom_fields() {
    // check if acf is present first
    if ( class_exists( 'ACF' ) ) {
      if( function_exists('acf_add_local_field_group') ):
      
      acf_add_local_field_group(array(
      	'key' => 'group_5e8de4fdbcea9',
      	'title' => 'Entry List Group',
      	'fields' => array(
      		array(
      			'key' => 'field_5e8de529c1f06',
      			'label' => 'PDF Upload',
      			'name' => 'pdf_upload',
      			'type' => 'file',
      			'instructions' => 'Upload your Entry List PDF',
      			'required' => 1,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'return_format' => 'array',
      			'library' => 'all',
      			'min_size' => '',
      			'max_size' => '',
      			'mime_types' => '',
      		),
      		array(
      			'key' => 'field_5e8de56e8657d',
      			'label' => 'Draw Date',
      			'name' => 'draw_date',
      			'type' => 'text',
      			'instructions' => 'Enter the date the competition was drawn on',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'default_value' => '',
      			'placeholder' => '',
      			'prepend' => '',
      			'append' => '',
      			'maxlength' => '',
      		),
      	),
      	'location' => array(
      		array(
      			array(
      				'param' => 'post_type',
      				'operator' => '==',
      				'value' => 'entry_lists',
      			),
      		),
      	),
      	'menu_order' => 0,
      	'position' => 'normal',
      	'style' => 'default',
      	'label_placement' => 'top',
      	'instruction_placement' => 'label',
      	'hide_on_screen' => '',
      	'active' => true,
      	'description' => '',
      ));
      
      endif;
    };
  }
  
  public function register_post_types() {
    $labels_winners = array(
      'name'                  => _x( 'Competition Winners', 'Competition Winners label: Plural', 'competitions-theme-functionality' ),
      'singular_name'         => _x( 'Competition Winner', 'Competition Winners label: Singular', 'competitions-theme-functionality' ),
      'menu_name'             => _x( 'Competition Winners', 'Competition Winners label: Plural', 'competitions-theme-functionality' ),
      'name_admin_bar'        => _x( 'Competition Winner', 'Competition Winners label: Singular', 'competitions-theme-functionality' ),
      'archives'              => _x( 'Competition Winners', 'Competition Winners label: Archive', 'competitions-theme-functionality' ),
      'attributes'            => 'Item Attributes',
      'parent_item_colon'     => 'Parent Item:',
      'all_items'             => 'All Items',
      'add_new_item'          => 'Add New Item',
      'add_new'               => 'Add New',
      'new_item'              => 'New Item',
      'edit_item'             => 'Edit Item',
      'update_item'           => 'Update Item',
      'view_item'             => 'View Item',
      'view_items'            => 'View Items',
      'search_items'          => 'Search Item',
      'not_found'             => 'Not found',
      'not_found_in_trash'    => 'Not found in Trash',
      'featured_image'        => 'Featured Image',
      'set_featured_image'    => 'Set featured image',
      'remove_featured_image' => 'Remove featured image',
      'use_featured_image'    => 'Use as featured image',
      'insert_into_item'      => 'Insert into item',
      'uploaded_to_this_item' => 'Uploaded to this item',
      'items_list'            => 'Items list',
      'items_list_navigation' => 'Items list navigation',
      'filter_items_list'     => 'Filter items list',
    );
    $args_winners = array(
      'label'                 => _x( 'Competition Winner', 'Competition Winners label: Singular', 'competitions-theme-functionality' ),
      'description'           => _x( 'Lucky Competition Winners...', 'Competition Winners description', 'competitions-theme-functionality' ),
      'labels'                => $labels_winners,
      'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes' ),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 3,
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => 'competition-winners',
      'exclude_from_search'   => true,
      'publicly_queryable'    => true,
      'query_var'             => false,
      'capability_type'       => 'page',
      'show_in_rest'          => false,
    );
    register_post_type( 'winners', $args_winners );

    $labels_lists = array(
      'name'                  => _x( 'Entry Lists', 'Entry Lists label: Plural', 'competitions-theme-functionality' ),
      'singular_name'         => _x( 'Entry List', 'Entry Lists label: Singular', 'competitions-theme-functionality' ),
      'menu_name'             => _x( 'Entry Lists', 'Entry Lists label: Plural', 'competitions-theme-functionality' ),
      'name_admin_bar'        => _x( 'Entry List', 'Entry Lists label: Singular', 'competitions-theme-functionality' ),
      'archives'              => _x( 'Entry Lists', 'Entry Lists label: Archive', 'competitions-theme-functionality' ),
      'attributes'            => 'Item Attributes',
      'parent_item_colon'     => 'Parent Item:',
      'all_items'             => 'All Items',
      'add_new_item'          => 'Add New Item',
      'add_new'               => 'Add New',
      'new_item'              => 'New Item',
      'edit_item'             => 'Edit Item',
      'update_item'           => 'Update Item',
      'view_item'             => 'View Item',
      'view_items'            => 'View Items',
      'search_items'          => 'Search Item',
      'not_found'             => 'Not found',
      'not_found_in_trash'    => 'Not found in Trash',
      'featured_image'        => 'Featured Image',
      'set_featured_image'    => 'Set featured image',
      'remove_featured_image' => 'Remove featured image',
      'use_featured_image'    => 'Use as featured image',
      'insert_into_item'      => 'Insert into item',
      'uploaded_to_this_item' => 'Uploaded to this item',
      'items_list'            => 'Items list',
      'items_list_navigation' => 'Items list navigation',
      'filter_items_list'     => 'Filter items list',
    );
    $args_lists = array(
      'label'                 => _x( 'Entry List', 'Entry Lists label: Singular', 'competitions-theme-functionality' ),
      'description'           => _x( 'Competition Entry List...', 'Entry Lists description', 'competitions-theme-functionality' ),
      'labels'                => $labels_lists,
      'supports'              => array( 'title', 'editor', 'revisions', 'custom-fields', 'page-attributes' ),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 4,
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => 'entry-lists',
      'exclude_from_search'   => true,
      'publicly_queryable'    => true,
      'query_var'             => false,
      'capability_type'       => 'page',
    );
    register_post_type( 'entry_lists', $args_lists );
  }
  public function cpt_posts_per_page( $query ) {
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('entry_lists')) $query->set( 'posts_per_page', '6' );
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('winners')) $query->set( 'posts_per_page', '8' );
  }

  public function plugin_timber_locations() {
    // if timber::locations is empty (another plugin hasn't already added to it), make it an array
    if(!Timber::$locations) Timber::$locations = array();
    // add a new views path to the locations array
    array_push(
      Timber::$locations, 
      COMPETITIONS_THEME_FUNCTIONALITY_PATH . 'views',
      COMPETITIONS_THEME_FUNCTIONALITY_PATH . 'views/list',
      COMPETITIONS_THEME_FUNCTIONALITY_PATH . 'views/winner'
    );
  }
  public function plugin_text_domain_init() {
    load_plugin_textdomain('competitions-theme-functionality', false, COMPETITIONS_THEME_FUNCTIONALITY_BASE. '/languages');
  }

  public function add_to_twig($twig) { 
    if(!class_exists('Twig_Extension_StringLoader')){
      $twig->addExtension(new Twig_Extension_StringLoader());
    }
    return $twig;
  }
  public function add_to_context($context) {
    
    // cpts
    $context['is_winners'] = is_post_type_archive( 'winners' );
    $context['is_entry_lists'] = is_post_type_archive( 'entry_lists' );
    
    // acf options
    $context['options'] = get_fields('option');

    // return context
    return $context;    
  }
}