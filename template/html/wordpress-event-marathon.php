<?php
/**
* @package WPEVENTMARATHON
*/
/*
	Plugin Name: Management des Compétition 
	Plugin URI: https://www.ars-agency.com
	Description: Competion Marathon
	Version: 1.0
	Author: ARS GROUP
	Author URI: http://www.ars-agency.com
*/
header("Access-Control-Allow-Origin: *");

// ini_set('display_errors', 1);

// ini_set('display_startup_errors', 1);

// error_reporting(E_ALL);

define('WPEVENTMARATHON_PLUGIN_FILE',__FILE__);

define('WPEVENTMARATHON_DIR', plugin_dir_path(__FILE__));
	 
define('WPEVENTMARATHON_URL', plugin_dir_url(__FILE__));

define('WPEVENTMARATHON_API_URL_SITE', get_site_url() . "/");

class WpEventMarathon {

	public $meta_event = array(
			array(
				'key'=>"link_on_live",
				'label' => "Url de la competion",
				'admin_col'=>false, 
				'stape'=>'global'
			),
			array(
				'key'=>"date_end_",
				'label' => "Date de debut",
				'admin_col'=>false, 
				'stape'=>'global'
			),
			array(
				'key'=>"time_end_",
				'label' => "Heure de fin ",
				'admin_col'=>false, 
				'stape'=>'global'
			),
			array(
				'key'=>"date_start",
				'label' => "Date de debut",
				'admin_col'=>false, 
				'stape'=>'global'
			),
			array(
				'key'=>"time_start",
				'label' => "Heure de debut",
				'admin_col'=>false, 
				'stape'=>'global'
			),
			array(
				'key'=>"date_end_subscribe",
				'label' => "Date de fin d'inscription",
				'admin_col'=>false, 
				'stape'=>'global'
			),
			array(
				'key'=>"time_end_subscribe",
				'label' => "Heure de fin d'inscription",
				'admin_col'=>false, 
				'stape'=>'global'
			),
			array(
				'key'=>"distance",
				'label' => "Distance",
				'admin_col'=>false, 
				'stape'=>'global'
			),
			array(
				'key'=>"report_pdf",
				'label' => "PDF Rapport",
				'admin_col'=>false, 
				'stape'=>'global'
			)
		);
	public $post_type_event = array(
		'post_type' => 'marathon',
		'label'=> 'Compétition', 
		'plural'=>'Compétitions'
	);
	public $post_type_event_itineraire = array(
		'post_type' => 'marathon_itineraire',
		'label'=> 'Distance', 
		'plural'=>'Distances'
	);
	public $pages = array(
    		'course-subsribe-to-event' => array(
    			'slug'=>'course-subsribe-to-event' ,
    			'name' => 'Souscrire a une Course', 
    			'label'=> 'Souscrire a la course', 
    			'id' => '' ,
    			'link' => '',
    			'shortcode' => "[woocommerce_checkout]"
    		),
    		'toutes-courses' => array(
    			'slug'=>'toutes-courses' ,
    			'name' => 'Compétitions', 
    			'label'=> 'Compétitions', 
    			'id' => '' ,
    			'link' => '',
    			'shortcode' => "[Event-All-Event]"
    		)
    	);
	public $headers = array('From: Marrathon <contact@ars-global.com>');
	public $plugin_slug = "wp_event_marrathon_digital";

    function __construct() {    	

        add_filter( 'wp_mail_content_type', array(&$this,'wpcs_set_email_content_type') );
    	add_action( 'init', array(&$this,'init_plugin_pages'), 0 );
        add_action('save_post', array(&$this,'wporg_save_postdata'));
        add_action( 'init', array(&$this,'register_post_types'), 0 );
        $this->init_shortcode();
        $this->init_callback_meta_box();
        $this->init_templates_pages();
        $this->init_ajax_api();
    }
        /**
    **  if page do not exist create it
    **  finaly return the permalink
    **  @return permalink
    **/
    function check_exist_page_create($name,$slug,$shortcode){
    	$page = get_page_by_path( $slug ); 
    	$post_id = 0;
    	if(!$page){

			$post_information = array(
		        'post_title' =>  wp_strip_all_tags( $name ),
		        'post_content' => $shortcode,
		        'post_type' => 'page',
		        'post_status' => 'publish',
		       	'post_name' => $slug
		    );
		    $post_id = wp_insert_post( $post_information );
    	}else{
    		$post_id = $page->ID;
    	}
    	return get_the_permalink($post_id );
    }
    function init_urls(){
		foreach ($this->pages as $key => $page) {
    		$this->pages[$key]['link'] = get_the_permalink( get_page_by_path( $page['slug'] )->ID );
    	}
    }
    /**
    ** Init all pages of plugin
    **/
    function init_plugin_pages(){
		foreach ($this->pages as $key => $page) {
    		$page['link'] = $this->check_exist_page_create($page['label'],$page['slug'],$page['shortcode']);
    	}
    }

	function array_sort($array, $on, $order=SORT_ASC)
	{
	    $new_array = array();
	    $sortable_array = array();

	    if (count($array) > 0) {
	        foreach ($array as $k => $v) {
	            if (is_array($v)) {
	                foreach ($v as $k2 => $v2) {
	                    if ($k2 == $on) {
	                        $sortable_array[$k] = $v2;
	                    }
	                }
	            } else {
	                $sortable_array[$k] = $v;
	            }
	        }

	        switch ($order) {
	            case SORT_ASC:
	                asort($sortable_array);
	            break;
	            case SORT_DESC:
	                arsort($sortable_array);
	            break;
	        }

	        foreach ($sortable_array as $k => $v) {
	            array_push($new_array, $array[$k]);
	        }
	    }

	    return $new_array;
	}

    function rank_users_of_itineraire($itineraire){
		$users_models = get_post_meta(get_the_ID(),'account_member_participation',true) ;
	    $users = array();
	    $dossard_min = intval(get_post_meta($itineraire,'dossard_min',true));
	    if(!$users_models)
	    	$users_models = [];
		foreach ($users_models as $key => $value) {
			$age = intval(date('Y')) - intval(explode('-',$value['datenaissance'])[0] ) ;
	    	$users[] = array(
               			'id'=>$key+1,
               			'rank'=>$key+1,
               			'name'=> $value['name'],
               			'date_update'=>$value['updated_date'],
               			'time'=>$value['time'],
               			'link'=> $value['link'],
               			'sexe'=> $value['sexe'],
               			'pays'=> $value['pays'],
               			'club'=> $value['club'],
               			'email'=> $value['email'],
               			'categorie'=> $value['categorie'],
               			'age' => $age,			   			
               			"dossard" => $dossard_min + $value['dossard'],
               			'surname'=> $value['surname'],
               			'datenaissance'=> $value['datenaissance']
               		);
		}
    	return $users;
    }
    function result_rank_users_of_itineraire($itineraire){
	    $users = array();
	    $rtr=$this->rank_users_of_itineraire($itineraire);
	    foreach ($rtr as $key => $value) {
	    	if($value['time']){

	    		$value['time'] = $key*$key;//trim($value['time']);
	    		$users[] = $value;
	    	}
	    }
    	return $this->array_sort($users, 'time' );
    }
    function get_itineraire_of_course($course){
    	$courses = array();
    	if($course){
	    	$args = array(
		            'post_type' => $this->post_type_event_itineraire['post_type'],
		            'post_parent' => $course,
		            'posts_per_page' => -1
		        );
			$query = new WP_Query( $args );
			$user_id = get_current_user_id();
		    if ( $query->have_posts() ) : 
               	while ( $query->have_posts() ) : $query->the_post(); 
               		$post_id = get_the_ID();
               		$participants = $this->rank_users_of_itineraire($post_id);
               		$subscribe = false;
               		$exists = array_search($user_id, array_column($participants, 'id'));
               		if( $exists  === 0 || $exists > 0 ){
               			$subscribe = true;
               		}
               		$courses[] = array(
			    		"id" => get_the_ID(), 
			    		'url'=>get_the_permalink($post_id),
			    		"subscribe" => $subscribe,
			    		"admin"=>get_edit_post_link($post_id),
			    		"distance" => get_post_meta($post_id, 'distance',true),
			    		"dossard_max" => get_post_meta($post_id, 'dossard_max',true),
			    		"dossard_min" => get_post_meta($post_id, 'dossard_min',true),
			    		"participant" => count($participants),
			    		"participants" => array(),
			   			"debut" => get_post_meta($post_id, 'date_start',true),
			   			"fin" => get_post_meta($post_id, 'date_end',true),
			   			"debut_hr" => get_post_meta($post_id, 'time_start',true),
			   			"fin_hr" => get_post_meta($post_id, 'time_end',true),
		    			"inscription" => get_post_meta($post_id, 'date_end_subscribe',true),
		    			"inscription_hr" => get_post_meta($post_id, 'time_end_subscribe',true),
		    		);
               	endwhile;
            endif;
    	}
    	return $courses;
    	
    }
     function get_itineraire_of_course_basique($course){
    	$courses = array();
    	if($course){
	    	$args = array(
		            'post_type' => $this->post_type_event_itineraire['post_type'],
		            'post_parent' => $course,
		            'posts_per_page' => -1
		        );
			$query = new WP_Query( $args );
		    if ( $query->have_posts() ) : 
               	while ( $query->have_posts() ) : $query->the_post(); 
               		$post_id = get_the_ID();
               		$courses[] = array(
			    		"id" => get_the_ID(), 
			    		"distance" => get_post_meta($post_id, 'distance',true)
		    		);
               	endwhile;
            endif;
    	}
    	return $courses;
    	
    }
    function ajax_callback(){
    	$module = $this->get_var('function');
    	//http://leopronos.ars-agency.com/wp-admin/admin-ajax.php?action=Events&function=get_email_participation&Events=139
		$user_id = get_current_user_id();
		if($module == 'get_itineraire'){
			$course= $this->get_var('course');
	    	if($course ){
	    		$courses = $this->get_itineraire_of_course($course);
		    	echo json_encode(array("response"=>200,"message"=>"Liste reccuperer",'itineraires'=> $courses) );
	    	}else{
		    	echo json_encode(array("response"=>200,"message"=>"user not connected" ) );
	    	}
		}else if($module == 'update_itineraire'){

			$course= $this->get_var('course');
			$itineraire= $this->get_var('itineraire');
			

	    	if($user_id && $course ){
	    		$post_id = $itineraire['id'];
			    update_post_meta($post_id, 'dossard_min', $itineraire['dossard_min']);
			    update_post_meta($post_id, 'dossard_max', $itineraire['dossard_max']);
			    update_post_meta($post_id, 'distance', $itineraire['distance']);
			    update_post_meta($post_id, 'date_start', $itineraire['debut']);
			    update_post_meta($post_id, 'time_start', $itineraire['debut_hr']);
			    update_post_meta($post_id, 'date_end', $itineraire['fin']);
			    update_post_meta($post_id, 'time_end', $itineraire['fin_hr']);
			    update_post_meta($post_id, 'date_end_subscribe', $itineraire['inscription']);
			    update_post_meta($post_id, 'time_end_subscribe', $itineraire['inscription_hr']);
			    $title = $itineraire['distance'] . ' - ' . get_the_title(get_post_field( 'post_parent', $post_id , true ));
				$post = array(
				        'ID' => intval($post_id),
				        'post_title' => $title
				        // 'post_name' =>sanitize_title($title)
		        );
				wp_update_post($post, true);

		    	echo json_encode(array("response"=>200,"message"=>"Liste reccuperer",'itineraires'=> $itineraire) );
	    	}else{
		    	echo json_encode(array("response"=>200,"message"=>"user not connected" ) );
	    	}
		}else if($module == 'delete_itineraire'){

			$course= $this->get_var('course');
			$itineraire= $this->get_var('itineraire');
			

	    	if($user_id && $course ){
	    		$post_id = $itineraire['id'];

	    		wp_delete_post($post_id);

		    	echo json_encode(array("response"=>200,"message"=>"Le post a ete supprime",'itineraires'=> $post_id) );
	    	}else{
		    	echo json_encode(array("response"=>200,"message"=>"les donnees n ont pas ete fournies" ) );
	    	}
		}else if($module == 'add_empty_itineraire'){
			$course= $this->get_var('course');
	    	if($user_id && $course ){
	    		$post_information = array(
			        'post_title' =>  "Distance - ".get_the_title($course),
			        'post_content' => get_the_content($course),
			        'post_type' => $this->post_type_event_itineraire['post_type'],
			        'post_status' => 'publish',
			        'post_parent' => $course,
			        'author' => $user_id,
			    );
			    $post_id = wp_insert_post( $post_information );

			    update_post_meta($post_id, 'distance', '0 km');
			    update_post_meta($post_id, 'date_start', date("Y-m-d"));
			    update_post_meta($post_id, 'time_start', date("h:i"));
			    update_post_meta($post_id, 'date_end', date("Y-m-d"));
			    update_post_meta($post_id, 'time_end', date("h:i"));
			    update_post_meta($post_id, 'date_end_subscribe', date("Y-m-d"));
			    update_post_meta($post_id, 'time_end_subscribe', date("h:i"));

		    	echo json_encode(array("response"=>200,"message"=>"itineraire cree",'itineraire'=> $post_id) );
	    	}else{
		    	echo json_encode(array("response"=>200,"message"=>"user not connected" ) );
	    	}
			
		}
	    die();
    }
    /**
    ** Call back ajax api
    **/
    function get_var($name){
    	$module = "";
		if(isset($_POST[$name])){
	    	$module	= $_POST[$name];
	    }
	    if(isset($_GET[$name])){
	    	$module	= $_GET[$name];
	    }
	    return $module;
    }

    /**
    ** init Ajax Api
    **/
    function init_ajax_api(){
		add_action( 'wp_ajax_'.$this->plugin_slug, array(&$this,'ajax_callback') );
  		add_action( 'wp_ajax_nopriv_'.$this->plugin_slug, array(&$this,'ajax_callback') );

    }
	/**
	** Register all post types 
	**/
	function create_post_type($post_type , $single, $plural,$icon = "dashicons-universal-access"){

		$labels = array(
				'name'                  => _x( $single, 'wp_menu_digital', 'wp_custom_visit_card_manage' ),
				'singular_name'         => _x( $single, 'wp_menu_digital', 'wp_custom_visit_card_manage' ),
				'menu_name'             => __( $single, 'wp_menu_digital' ),
				'name_admin_bar'        => __( $single, 'wp_custom_visit_card_manage' ),
				'archives'              => __( 'Archive des '.$plural, 'wp_menu_digital' ),
				'attributes'            => __( 'Attributs d\'un '.$single, 'wp_menu_digital' ),
				'parent_item_colon'     => __( 'Parent du '.$single, 'wp_menu_digital' ),
				'all_items'             => __( 'Tous les '.$plural, 'wp_menu_digital' ),
				'add_new_item'          => __( 'Ajouter une '.$single, 'wp_menu_digital' ),
				'add_new'               => __( 'Ajouter une Nouvelle '.$single, 'wp_menu_digital' ),
				'new_item'              => __( 'Nouveau '.$single, 'wp_menu_digital' ),
				'edit_item'             => __( 'Editer le '.$single, 'wp_menu_digital' ),
				'update_item'           => __( 'Mettre a jour la '.$single, 'wp_menu_digital' ),
				'view_item'             => __( 'Voir la '.$single, 'wp_menu_digital' ),
				'view_items'            => __( 'Voir les '.$plural, 'wp_menu_digital' ),
				'search_items'          => __( 'Rechercher un '.$single, 'wp_menu_digital' ),
				'not_found'             => __( $single.' non trouvee', 'wp_menu_digital' ),
				'not_found_in_trash'    => __( 'Pas trouve dans la corbeille', 'wp_menu_digital' ),
				'featured_image'        => __( 'Multiples Images', 'wp_menu_digital' ),
				'set_featured_image'    => __( 'Modifer l\'image', 'wp_menu_digital' ),
				'remove_featured_image' => __( 'Retirer l\'image', 'wp_menu_digital' ),
				'use_featured_image'    => __( 'Utiliser comme image', 'wp_menu_digital' ),
				'insert_into_item'      => __( 'inserer dans la '.$single, 'wp_menu_digital' ),
				'uploaded_to_this_item' => __( 'Charger dans la Carte Visite', 'wp_menu_digital' ),
				'items_list'            => __( 'Liste des '.$plural, 'wp_menu_digital' ),
				'items_list_navigation' => __( 'Les '.$plural, 'wp_menu_digital' ),
				'filter_items_list'     => __( 'Filtrer les '.$plural, 'wp_menu_digital' ),
			);
		$args = array(
				'label'                 => __( $single, 'wp_menu_digital' ),
				'description'           => __( 'Les differentes '.$plural, 'wp_menu_digital' ),
				'labels'                => $labels,
				'supports'              => array( 'title', 'editor', 'thumbnail','excerpt','author' ),
				'taxonomies'            => array( 'category' ),
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 10,
				'menu_icon'             => $icon,
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => 'visit_card',
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'capability_type'       => 'post',
				'show_in_rest'          => true,
			);
		register_post_type( $post_type, $args );
	}
	function register_post_types() {
		$this->create_post_type( $this->post_type_event['post_type'] , $this->post_type_event['label'], $this->post_type_event['plural'],'dashicons-universal-access');

		$this->create_post_type( $this->post_type_event_itineraire['post_type'] , $this->post_type_event_itineraire['label'], $this->post_type_event_itineraire['plural'],"dashicons-location-alt");
	}

    function wporg_save_postdata($post_id){
    	if (array_key_exists('update_course', $_POST)) {
    		
		    $metas = array("date_start","date_end_","time_start","time_end_","link_on_live","date_end_subscribe","time_end_subscribe","distance","course");
		  
		   	foreach ($_POST as $key => $value) {
		   		if (in_array($key, $metas)) {
				   update_post_meta($post_id,$key,$value);
				}
			}
		}else if(array_key_exists('update_itineraire', $_POST)){
			 $metas = array("date_start","date_end_","time_start","time_end_","link_on_live","date_end_subscribe","time_end_subscribe","distance","course","dossard_min","dossard_max");
		  
		   	foreach ($_POST as $key => $value) {
		   		if (in_array($key, $metas)) {
				   update_post_meta($post_id,$key,$value);
				}
			}
		}
    }

 	/**
    ** Init all Meta Box
    **/  
    function init_callback_meta_box(){
    	add_action('add_meta_boxes', array(&$this,'wporg_add_custom_box'));
    	add_action('add_meta_boxes', array(&$this,'wporg_add_custom_box_itineraire'));
    }

	function add_File_to_Gallery($name,$post_id){

	    // WordPress environment
		require( WPEVENTMARATHON_DIR . '/../../../wp-load.php' );
		if(isset($_FILES[$name]) && $post_id && $_FILES[$name]['size']){
					     
			$wordpress_upload_dir = wp_upload_dir();

			$profilepicture = $_FILES[$name];
			$new_file_path = $wordpress_upload_dir['path'] . '/' . $profilepicture['name'];
			$new_file_mime = mime_content_type( $profilepicture['tmp_name'] );
					     
			if( empty( $profilepicture ) )
					        die( 'File is not selected.' );
					     
					    if( $profilepicture['error'] )
					        die( $profilepicture['error'] );
					     
					    if( $profilepicture['size'] > wp_max_upload_size() )
					        die( 'It is too large than expected.' );
					     
					    if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
					        die( 'WordPress doesn\'t allow this type of uploads.' );
					     
					    while( file_exists( $new_file_path ) ) {
					        $i++;
					        $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $profilepicture['name'];
					    }
					     
					    // looks like everything is OK
					    if( move_uploaded_file( $profilepicture['tmp_name'], $new_file_path ) ) {
					     
					        $upload_id = wp_insert_attachment( array(
					            'guid'           => $new_file_path, 
					            'post_mime_type' => $new_file_mime,
					            'post_title'     => preg_replace( '/\.[^.]+$/', '', $profilepicture['name'] ),
					            'post_content'   => '',
					            'post_status'    => 'gallery',
					            'post_parent' => $post_id
					        ), $new_file_path );
					     
					        // wp_generate_attachment_metadata() won't work if you do not include this file
					        require_once( ABSPATH . 'wp-admin/includes/image.php' );
					     
					        // Generate and save the attachment metas into the database
					        wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
					     
					        update_post_meta(  $post_id, $name.'-id',  $upload_id );
					        update_post_meta(  $post_id, $name, wp_get_attachment_url( $upload_id ));
					        // Show the uploaded file in browser
					     	var_dump(wp_get_attachment_url( $upload_id ));
					     	die();
					    }
					}
    }
	/**
	** Callback of meta box
	**/
	function wporg_add_custom_box()
	{
	    $screens = [$this->post_type_event['post_type'], $this->plugin_slug];
	    foreach ($screens as $screen) {
	        add_meta_box(
		        'post_event_informations',//Unique ID
		        'A propos de la course',  //Box title
	            array(&$this,'event_custom_box_html'),//Content callback, must be of type callable
		            $screen// Post type
	        );
	    }
	    $screens = [$this->post_type_event['post_type'], $this->plugin_slug];

	}

	function wporg_add_custom_box_itineraire()
	{
	    $screens = [$this->post_type_event_itineraire['post_type'], $this->plugin_slug];
	    foreach ($screens as $screen) {
	        add_meta_box(
		        'post_event_informations',//Unique ID
		        'A propos de l\'itineraire',  //Box title
	            array(&$this,'event_custom_box_html_itineraire'),//Content callback, must be of type callable
		            $screen// Post type
	        );
	    }
	    $screens = [$this->post_type_event['post_type'], $this->plugin_slug];

	}
	/**
	** Front - view of callback Restaurant
	**/
	function event_custom_box_html(){
		
		if ( file_exists( WPEVENTMARATHON_DIR.'template/html/admin-event-detail.php' ) ) {
			include( WPEVENTMARATHON_DIR.'template/html/admin-event-detail.php' );
		}
	}

	function event_custom_box_html_itineraire(){
		
		if ( file_exists( WPEVENTMARATHON_DIR.'template/html/admin-event-itineraire-detail.php' ) ) {
			include( WPEVENTMARATHON_DIR.'template/html/admin-event-itineraire-detail.php' );
		}
	}
	/**
	** Callback shortcodes
	**/
	function last_event(){
		
		$args = array(
		    'post_type' => $this->post_type_event['post_type']
		);
		$query = new WP_Query( $args );

		$posts =   array( );


		if ( $query->have_posts() ) : 
			while ( $query->have_posts() ) : $query->the_post(); 
				$posts[] = get_the_ID();
	 		endwhile; 
	 	endif; 
		wp_reset_postdata();

		if(count($posts) == 0 ){
			if ( file_exists( WPEVENTMARATHON_DIR.'template/html/no-event.php' ) ) {
				include(WPEVENTMARATHON_DIR.'template/html/no-event.php');
			}
		}else{
			if ( file_exists( WPEVENTMARATHON_DIR.'template/html/last-events.php' ) ) {
				include(WPEVENTMARATHON_DIR.'template/html/last-events.php');
			}
		}
		
	}
	  /**
    ** init Global PHP fonction
    **/
    function shapeSpace_add_var($url, $key, $value) {
	
		$url = preg_replace('/(.*)(?|&)'. $key .'=[^&]+?(&)(.*)/i', '$1$2$4', $url .'&');
		$url = substr($url, 0, -1);
		
		if (strpos($url, '?') === false) {
			return ($url .'?'. $key .'='. $value);
		} else {
			return ($url .'&'. $key .'='. $value);
		}
		return $url;
	}
	 /**
    ** Init override of default wordpress pages
    **/
    function init_templates_pages(){
    	add_filter('single_template',  array(&$this,'custom_event_template') );
    	add_filter( 'page_template',  array(&$this,'custom_page_template') , 10, 1 );

    }
    function custom_page_template($single) {
		global $post;
		$this->init_urls();

		if( $post->post_name == $this->pages['course-subsribe-to-event']['slug']){
			
			if ( file_exists( WPEVENTMARATHON_DIR.'template/html/subscribe.php' ) ) {
				$single =  WPEVENTMARATHON_DIR.'template/html/subscribe.php' ;
		    }
		}
		return $single;
	}
    function custom_event_template($single){
    	global $post;
 
   
 
    	$current_user = get_current_user_id();

    	if ( $this->post_type_event['post_type'] === $post->post_type ) {

	    	if ( file_exists( WPEVENTMARATHON_DIR.'template/html/single-event.php' ) ) {
				$single =  WPEVENTMARATHON_DIR.'template/html/single-event.php' ;
			}

	    }else if($this->post_type_event_itineraire['post_type'] === $post->post_type ){
	    	if(isset($_GET['dossard'])){
	    		if( file_exists( WPEVENTMARATHON_DIR.'template/html/single-event-itineraire-dossard.php' ) ) {
					$single =  WPEVENTMARATHON_DIR.'template/html/single-event-itineraire-dossard.php' ;
				}
	    	}else if(isset($_GET['subscribe'])){
	    		if($current_user && isset($_GET['admin-subscribe']) && $_GET['admin-subscribe'] == hash('md5', get_current_user_id())){
	    			if( file_exists( WPEVENTMARATHON_DIR.'template/html/admin-subscribe.php' ) ) {
						$single =  WPEVENTMARATHON_DIR.'template/html/admin-subscribe.php' ;
					}
	    		}else if( $current_user && isset($_GET['secret']) && $_GET['secret'] == hash('md5', get_current_user_id()) ){

	    			if( file_exists( WPEVENTMARATHON_DIR.'template/html/admin-edit-participant.php' ) ) {
						$single =  WPEVENTMARATHON_DIR.'template/html/admin-edit-participant.php' ;
					}
	    		}else {
	    			if( file_exists( WPEVENTMARATHON_DIR.'template/html/subscribe.php' ) ) {
						$single =  WPEVENTMARATHON_DIR.'template/html/subscribe.php' ;
					}
				}
				
	    	}else if(isset($_GET['membres'])){
				if ( file_exists( WPEVENTMARATHON_DIR.'template/html/single-event-itineraire-members.php' ) ) {
					$single =  WPEVENTMARATHON_DIR.'template/html/single-event-itineraire-members.php' ;
				}else{
					echo 'file not found';
				}
	    	}else if(isset($_GET['member'])){
				if ( file_exists( WPEVENTMARATHON_DIR.'template/html/single-event-itineraire-add-chrono.php' ) ) {
					$single =  WPEVENTMARATHON_DIR.'template/html/single-event-itineraire-add-chrono.php' ;

				}else{
					echo 'file not found';
				}
	    	}else if(isset($_GET['result'])){
				if ( file_exists( WPEVENTMARATHON_DIR.'template/html/single-event-itineraire-result.php' ) ) {
					$single =  WPEVENTMARATHON_DIR.'template/html/single-event-itineraire-result.php' ;

				}else{
					echo 'file not found';
				}
	    	}else{
	    		if ( file_exists( WPEVENTMARATHON_DIR.'template/html/single-event-itineraire.php' ) ) {
					$single =  WPEVENTMARATHON_DIR.'template/html/single-event-itineraire.php' ;
				}
	    	}
	    	
	    }
		return $single;
    }
	/**
	** Callback shortcodes
	**/
	function all_event(){
		
		// echo '0';

		// if(count($posts) == 0 ){
		// 	if ( file_exists( WPEVENTMARATHON_DIR.'template/html/no-event.php' ) ) {
		// 		include(WPEVENTMARATHON_DIR.'template/html/no-event.php');
		// 	}
		// }else{
			if ( file_exists( WPEVENTMARATHON_DIR.'template/html/all-event.php' ) ) {
				 include(WPEVENTMARATHON_DIR.'template/html/all-event.php');
			}else{
				echo 'not found';
			}
		// }
		
	}
	/**
	** Init all short codes 
	**/
    function init_shortcode(){
		add_shortcode( 'Event-Last-Event', array(&$this,'last_event') );
		add_shortcode( 'Event-All-Event', array(&$this,'all_event') );

    }
    function wpcs_set_email_content_type() {
        return 'text/html';
    }
}

$wpEventMarathon = new WpEventMarathon();