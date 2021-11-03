<?php
/**
* @package WPMD
*/
/*
	Plugin Name: Manager participation du Marrathon 
	Description: Permettre aux utilisateur de s enregistrer a une course
	Plugin URI: https://www.ars-agency.com
	Version: 1.0
	Author: ARS GROUP
	Author URI: http://www.ars-agency.com
*/


define('WPCP_PLUGIN_FILE',__FILE__);

define('WPCP_DIR', plugin_dir_path(__FILE__));
	 
define('WPCP_URL', plugin_dir_url(__FILE__));

define('WPCP_API_URL_SITE', get_site_url() . "/");

class WpEventParticipation {
	public $post_type_Events = array(
		'post_type' => 'marathon_itineraire',
		'label'=> 'Parcours', 
		'plural'=>'Parcours'
	);
	public $post_type_Events_participant = array(
		'post_type' => 'marathon_participant',
		'label'=> 'Coureur', 
		'plural'=>'Coureur'
	);
	public $plugin_slug = 'event_marrathon';

	public $headers = array('From:Marrathon <contact@marrathon.ars-global.com>');

    function __construct() {

        add_filter( 'wp_mail_content_type', array($this,'wpcs_set_email_content_type') );
       	

        add_action('save_post', array($this, 'save_postdata' ));

       	$this->init_config_column();
    	$this->init_callback_meta_box();
    	$this->init_ajax_api();
    }


	function set_html_content_type() {
		return 'text/html';
	}


    function save_postdata( $post_id ) {
    	// var_dump($_POST);
    	// die();
        if ( ! isset( $_POST['manage_Events'] ) )
            return;
        if( ! current_user_can( 'edit_post', $post_id ) )
            return;
        $my_data = sanitize_text_field( $_POST['active'] );
        update_post_meta( $post_id, 'active', $my_data );
        $my_data = sanitize_text_field( $_POST['start_date'] );
        update_post_meta( $post_id, 'start_date', $my_data );
        $my_data = sanitize_text_field( $_POST['end_date'] );
        update_post_meta( $post_id, 'end_date', $my_data );
    }
    /**
    ** Call back ajax api
    **/
    function get_var($name){
    	$module = "";
		if(isset($_POST[$name])){
	    	$module	= trim($_POST[$name]);
	    }
	    if(isset($_GET[$name])){
	    	$module	= trim($_GET[$name]);
	    }
	    return $module;
    }
    function get_current_Events(){
    	$args = array( 'post_type' => $this->post_type_Events['post_type'],'order' => 'ASC','posts_per_page' => -1);
		wp_reset_query();
        $query = new WP_Query( $args );
        $events = array();
        if( $query->have_posts() ) :
            while( $query->have_posts() ) : $query->the_post();
               	$active = get_post_meta(get_the_ID(),'active',true);
               	if($active){
               		$events[] = array(
               			'id'	=>	get_the_ID(),
               			'name'	=>	get_the_title(),
               			'image'	=>	get_the_post_thumbnail_url(),
               			'end'	=>	get_post_meta(get_the_ID(),'end_date',true),
               			'start'	=>	get_post_meta(get_the_ID(),'start_date',true)
               		);
               	}
           	endwhile;
        endif;
        return $events;
    }

    function connexion($email,$password){

		$credentials['user_login'] = $email;
		$credentials['user_password'] = $password;
		$credentials['remember'] = true;
		$t = wp_signon( $credentials);
		if(get_class($t) === 'WP_Error')
			return false;
		return true;
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
    function ajax_callback(){
    	$module = $this->get_var('function');
    	//http://leopronos.ars-agency.com/wp-admin/admin-ajax.php?action=Events&function=get_email_participation&Events=139
		$user_id = get_current_user_id();
		if($module == 'delete_email'){
			$events= $this->get_var('event');
			$email= $this->get_var('email');
	    	if($email && $events ){
	    		$list_email = get_post_meta($events, 'account_member_participation',true );
	    		if(!$list_email)
	    			$list_email = [];
	    		$new_list = [];
	    		$find = 0;
	    		foreach ($list_email as $key => $value) {
	    			if(trim($value['email']) != trim($email)){
	   					$new_list[] = $value;
	    			}else{
	    				$find++;
	    			}
	    		}
	   			
	    		if($find){
					update_post_meta($events, 'account_member_participation' , $new_list );
	    			echo json_encode(array("response"=>200,"message"=>"this email has been deleted in list of participations - ".$find ) );
	    		}else{
					echo json_encode(array("response"=>400,"message"=>"this email is not in  participation's list" ) );
	    		}
	    	}else{
		    	echo json_encode(array("response"=>200,"message"=>"Les donnees non transmises" ) );
	    	}
		}else if($module == 'updat_chrono_event'){

			$event = $this->get_var('event');
			$url = $this->get_var('url');
			$time = $this->get_var('time');
			$token = $this->get_var('token');
			if($event && $url && $time && $token){
				$participants =  get_post_meta(  $event, 'account_member_participation',true );

				if(is_null($participants))
					$participants = [];

				$participant = null;
				$index = null;
				foreach ($participants as $key => $value) {
				   if($token == hash('md5',$value['email']) ){
				        $participant = $value;
				        $index = $key;
				        break;
				   }
				}
		    	if(!is_null($participant)){
		    		$participants[$key]['time'] = $time;
		    		$participants[$key]['link'] = $url;
		    		$participants[$key]['updated_date'] = date("Y-m-d h:i:s");
		    		update_post_meta(  $event, 'account_member_participation' , $participants);
		    		$link = $this->shapeSpace_add_var( get_the_permalink( $event ) ,'result',1 );
		    		
					$variables = array( 
									array(
										'value' => $participants[$key]['name'],
										'key' => '{Prenom}'
									),
									array(
										'value' => get_the_title( $event ),
										'key' => '{Nom_de_la_Competition}'
									),
									array(
										'value' => get_post_meta(  $event, 'distance',true ),
										'key' => '{distancekm}'
									),
									array(
										'value' => $time,
										'key' => '{time}'
									),
									array(
										'value' => $link,
										'key' => '{URL_Resultats}'
									),
									array(
										'value' => get_home_url() ,
										'key' => '{URL_HOME_SITE}'
									)
								);
					$mail = file_get_contents(WPCP_DIR.'template/html/mail_remerciements.php');
					foreach ($variables as $cle => $value) {
						$mail = str_replace($value['key'], $value['value'], $mail);
					}

					wp_mail($participants[$key]['email'] , 'Confirmation de score ' . get_the_title( $event ) . ' !', $mail );
					echo json_encode(array("response"=>200,"message"=>"Vos informations ont ete sauvegardee avec succes, vous serrez redirige vers la page des resultats" ) );

		    	}else{
			    	echo json_encode(array("response"=>300,"message"=>"Ce jour n est pas reconnu par le systeme" ) );
		    	}
			}else{
				echo json_encode(array("response"=>400,"message"=>"Les donnees transmises sont incompletes"));
			}
		}else if($module == 'updat_registration_event_admin'){
			// echo 'Bonjour';{URL_Dossard}URL_Chronos
			

			global $current_user;

			$event = $this->get_var('event');
			$name = $this->get_var('name');
			$datenaissance = $this->get_var('datenaissance');
			$surname = $this->get_var('surname');
			$sexe = $this->get_var('sexe');
			$pays = $this->get_var('pays');
			$club = $this->get_var('club');
			$confirm_email = $this->get_var('confirm_email');
			$email = $this->get_var('email');


			if($event && $name && $datenaissance && $surname &&
				$sexe && $pays && $club && $confirm_email && $email
			){

		    	if(trim($email) ==  trim($confirm_email)){
		    		$list_users = get_post_meta(  $event, 'account_member_participation',true );
		    		if(!$list_users)
		    			$list_users = [];
		    		$find = array_search($email, array_column($list_users, 'email'));
		    		if( $find  === 0 || $find > 0 ){
		    			foreach ($list_users as $indice => $value) {
		    				if($email == $value['email']){

								$link = $this->shapeSpace_add_var( get_the_permalink( $event ) ,'member',hash('md5',$email) );
								$cat = 'SE';
								$age = intval(date('Y')) - intval(explode('-',$datenaissance)[0] ) ;
								if($age>40)
									$cat = "VE";
								else if($age>23)
									$cat = "SE";
								else if($age > 18)
									$cat = "U23";
								else 
									$cat = "U18";


								$variables = array( 
									array(
										'value' => $name.' '.$surname,
										'key' => '{Prenom}'
									),
									array(
										'value' => get_the_title( $event ),
										'key' => '{Nom_de_la_Competition}'
									),
									array(
										'value' => get_post_meta(  $event, 'distance',true ),
										'key' => '{distancekm}'
									),
									array(
										'value' => $this->shapeSpace_add_var( get_the_permalink( $event ) ,'dossard',hash('md5',$email) ),
										'key' => '{URL_Dossard}'
									),
									array(
										'value' => $this->shapeSpace_add_var( get_the_permalink( $event ) ,'member',hash('md5',$email) ),
										'key' => '{URL_Chronos}'
									),
									array(
										'value' => 'https://i.imgur.com/NzV83Fg.png',
										'key' => '{IMG_SRC}'
									)
								);
								$mail = file_get_contents(WPCP_DIR.'template/html/mail_invitation.php');
								foreach ($variables as $cle => $value) {
									$mail = str_replace($value['key'], $value['value'], $mail);
								}
								//wp_mail( $email , 'Mise a jour des informations de la course !', $mail, $this->headers );


								wp_mail(  array( get_option('admin_email', true) , $email ) ,'Mise a jour des informations de la course !', $mail, $this->headers );

								$dossard = count($list_users);
								// var_dump($this->get_var('dossard'));
								// var_dump($list_users[$indice]['dossard']);
								// die();
								if($this->get_var('dossard') && $this->get_var('dossard') != $list_users[$indice]['dossard']){
									$ds = intval($this->get_var('dossard'));
									if($ds < 16 && $ds > 0 ){
										foreach ($list_users as $key => $value) {
											if($value['dossard'] == $ds){
												echo json_encode(array("response"=>300,"message"=>"Ce dossard est deja pris" ) );
												die();
											}
										}

										$dossard = $ds;
									}
								}
					        	$list_users[$indice] = array(
					        		'name'=>$name, 
					        		'datenaissance'=>$datenaissance, 
					        		'surname'=>$surname, 
					        		'email'=>$email, 
					        		'sexe'=>$sexe, 
					        		'pays'=>$pays, 
					        		'club'=>$club, 
					        		'time'=> $this->get_var('time') ,
					        		"updated_date"=>date("Y-m-d"),
					        		"link"=>$this->get_var('link'),
					        		"dossard"=>$list_users[$indice]['dossard'],
					        		"categorie"=>$cat
					        	);

					        	 update_post_meta(  $event, 'account_member_participation' , $list_users);

								echo json_encode(array("response"=>200,"message"=>"Le coureur a ete ajoute a la course, un mail vous a ete envoye contenant votre lien de confirmation. Vous allez etre redirige sur notre page des inscrit" ) );
				           		die();	
		    				}
		    			}
		    		}else{
			    		echo json_encode(array("response"=>300,"message"=>"Cet email ne participe pas  a cette course" ) );
		    		}


		    	}else{
			    	echo json_encode(array("response"=>300,"message"=>"Vos emails ne correspondent pas" ) );
		    	}
			}else{
				echo json_encode(array("response"=>400,"message"=>"Les donnees transmises sont incompletes" ) );
			}
		}else if($module == 'updat_registration_event'){

			global $current_user;

			$event = $this->get_var('event');
			$name = $this->get_var('name');
			$datenaissance = $this->get_var('datenaissance');
			$surname = $this->get_var('surname');
			$sexe = $this->get_var('sexe');
			$pays = $this->get_var('pays');
			$club = $this->get_var('club');
			$confirm_email = $this->get_var('confirm_email');
			$email = $this->get_var('email');

			// wp_mail( $email , 'Inscription a la course !', "BONJOUR CECI EST UN TEST" );
			
			if($event && $name && $datenaissance && $surname &&
				$sexe && $pays && $club && $confirm_email && $email
			){

		    	if(trim($email) ==  trim($confirm_email)){
		    		$list_users = get_post_meta(  $event, 'account_member_participation',true );
		    		if(!$list_users)
		    			$list_users = [];
		    		$find = array_search($email, array_column($list_users, 'email'));
		    		if( $find  === 0 || $find > 0 ){
			    		echo json_encode(array("response"=>300,"message"=>"Cet email participe deja a cette course" ) );
		    		}else{
							
							$link = $this->shapeSpace_add_var( get_the_permalink( $event ) ,'member',hash('md5',$email) );
							$cat = 'SE';
							$age = intval(date('Y')) - intval(explode('-',$datenaissance)[0] ) ;
							if($age>40)
								$cat = "VE";
							else if($age>23)
								$cat = "SE";
							else if($age > 18)
								$cat = "U23";
							else 
								$cat = "U18";


							$variables = array( 
								array(
									'value' => $name.' '.$surname,
									'key' => '{Prenom}'
								),
								array(
									'value' => get_the_title( $event ),
									'key' => '{Nom_de_la_Competition}'
								),
								array(
									'value' => get_post_meta(  $event, 'distance',true ),
									'key' => '{distancekm}'
								),
								array(
									'value' => $this->shapeSpace_add_var( get_the_permalink( $event ) ,'dossard',hash('md5',$email) ),
									'key' => '{URL_Dossard}'
								),
								array(
									'value' => $this->shapeSpace_add_var( get_the_permalink( $event ) ,'member',hash('md5',$email) ),
									'key' => '{URL_Chronos}'
								),
								array(
									'value' => 'https://i.imgur.com/NzV83Fg.png',
									'key' => '{IMG_SRC}'
								)
							);
							$mail = file_get_contents(WPCP_DIR.'template/html/mail_invitation.php');
							foreach ($variables as $key => $value) {
								$mail = str_replace($value['key'], $value['value'], $mail);
							}
							 wp_mail( $email , 'Inscription a la course !', $mail );


							wp_mail(  get_option('admin_email', true) ,'Nouveau Jouer a la competition' . get_the_title( $event ) . ' !', $mail );

							$dossard = count($list_users);
							if($this->get_var('dossard')){
								$ds = intval($this->get_var('dossard'));
								if($ds < 16 && $ds > 0 ){
									foreach ($list_users as $key => $value) {
										if($value['dossard'] == $ds){
											echo json_encode(array("response"=>300,"message"=>"Ce dossard est deja pris" ) );
											die();
										}
									}

									$dossard = $ds;
								}else{
									echo json_encode(array("response"=>300,"message"=>"Le dossard doit etre entre 1 et 15" ) );
									die();
								}
							}
				        	$list_users[] = array(
				        		'name'=>$name, 
				        		'datenaissance'=>$datenaissance, 
				        		'surname'=>$surname, 
				        		'email'=>$email, 
				        		'sexe'=>$sexe, 
				        		'pays'=>$pays, 
				        		'club'=>$club, 
				        		'time'=>"0",
				        		"updated_date"=>"",
				        		"link"=>'',
				        		"dossard"=>$dossard,
				        		"categorie"=>$cat
				        	);

				        	 update_post_meta(  $event, 'account_member_participation' , $list_users);

							echo json_encode(array("response"=>200,"message"=>"Le coureur a ete ajoute a la course, un mail vous a ete envoye contenant votre lien de confirmation. Vous allez etre redirige sur notre page des inscrit" ) );
			            

		    		}


		    	}else{
			    	echo json_encode(array("response"=>300,"message"=>"Vos emails ne correspondent pas" ) );
		    	}
			}else{
				echo json_encode(array("response"=>400,"message"=>"Les donnees transmises sont incompletes" ) );
			}
		}else if($module == 'update_user_participation'){
			if($user_id ){

	        	global $current_user;
				get_currentuserinfo();
				$event= $this->get_var('itineraire');
		    	if($event ){
		    		$list_users = get_post_meta(  $event, 'account_member_participation',true );
		    		if(!$list_users)
		    			$list_users = [];
		    		$find = array_search($user_id, array_column($list_users, 'id_user'));
		    		if( $find  === 0 || $find > 0 ){
			    		echo json_encode(array("response"=>200,"message"=>"This email is already in your list of participants" ) );
		    		}else{
						
							$link = get_the_permalink( $event );
							$body	= '
				    			<div style="padding: 15px 30px 30px 30px;text-align: left;font-family: Helvetica, Arial, sans-serif,Open Sans;line-height: 25px;">
				    				Hi,<br><br>
				    				Fillicitation vous avez ete ajoute a la course <a href="' . $link  . '">' . get_the_title( $event )  . '</a>.<br><br>
									   	Cordially,<br>
								</div>
							';

							//wp_mail( $email , 'Inscription a la course' . get_the_title( $event ) . ' !', $body, $this->headers );
							//wp_mail(  get_option('admin_email', true) ,'Nouveau Jouer a la competition' . get_the_title( $event ) . ' !', $body, $this->headers );

				        	$list_users[] = array('id_user'=>$user_id, 'time'=>"0","updated_date"=>"","sexe"=>'M',"link"=>'');

				        	update_post_meta(  $event, 'account_member_participation' , $list_users);

							echo json_encode(array("response"=>200,"message"=>"You has been add" ) );
			            

		    		}
		    	}else{
			    	echo json_encode(array("response"=>400,"message"=>"not event passed" ) );
		    	}
			}else{
			    echo json_encode(array("response"=>300,"message"=>"user not connected" ) );
		    }
		}else if($module == 'connect_user'){
			$email = $this->get_var('login');
			$password = $this->get_var('password');
			$itineraire = $this->get_var('itineraire');
			if($user_id){
            	echo json_encode(array("response"=>200,"message"=>"Vos etes déjà connecte" ) );
			}else{
				// echo $email;
				// echo ' - ';
				// echo $password; 
				$connect = $this->connexion($email,$password);
				if(!$connect){
					echo json_encode(array("response"=>300,"message"=>"Login ou Mot de passe  incorrect, si vous ne disposez pas de compte creer un compte." ) );
				}else{
			    	echo json_encode(array("response"=>200,"message"=>"Connexion réussie" ) );
				}     
        	}
		}else if($module == 'get_email_participation'){
			$event= $this->get_var('course');
	    	if( $event ){
	    		$list_email = get_post_meta(  $event, 'account_member_participation',true );
	    		if(!$list_email)
	    			$list_email = [];
	    		foreach ($list_email as $key => $value) {
	    			$list_email[$key]['pdf_link'] =  $this->shapeSpace_add_var( get_the_permalink( $event ) ,'dossard',hash('md5',$value['email']) );
	    			$list_email[$key]['secret'] =  $this->shapeSpace_add_var( get_the_permalink( $event ) ,'member',hash('md5',$value['email']) );
	    			$list_email[$key]['secret_edit'] =  $this->shapeSpace_add_var( $this->shapeSpace_add_var( $this->shapeSpace_add_var( get_the_permalink( $event ) ,'edit',hash('md5',$value['email']) ),'secret',hash('md5', $user_id)),'subscribe',1) ;
	    		}
		    	echo json_encode(array("response"=>200,"message"=>"Liste reccuperer",'participants'=> $list_email) );
	    	}else{
		    	echo json_encode(array("response"=>200,"message"=>"user not connected" ) );
	    	}
		}else if($module == 'check_participation_to_Events'){
			//http://leopronos.ars-agency.com/wp-admin/admin-ajax.php?action=Events&function=get_current_Events
			$email= $this->get_var('email');
			$events= $this->get_var('Events');
          	if($events){
          		$email= $this->get_var('email');
				$events= $this->get_var('Events');
		    	if($email ){
		    		$list_email = get_post_meta(  $events, 'account_member_participation',true );
		    		if(!$list_email)
		    			$list_email = [];
		    		if(in_array($email, $list_email)){
			    		echo json_encode(array("response"=>200,"message"=>"Cet email est dans votre liste de participants" ) );
		    		}else{
		    			echo json_encode(array("response"=>300,"message"=>"Cet email n'est pas dans votre liste de participants" ) );
		    		}
		    	}
          	}else{
		    	echo json_encode(array("response"=>400,"message"=>"Ce Events n'existe pas." ) );
          	}
		}
	    die();
    }

    /**
    ** init Ajax Api
    **/
    function init_ajax_api(){
		add_action( 'wp_ajax_'.$this->plugin_slug, array(&$this,'ajax_callback') );
  		add_action( 'wp_ajax_nopriv_'.$this->plugin_slug, array(&$this,'ajax_callback') );

    }

    /**
    ** Init all admin dashboard item
    **/
    function init_config_column(){
    	add_action('manage_'.$this->post_type_Events['post_type'].'_posts_custom_column', array(&$this, 'custom_Events_columns'), 15, 3);
		add_filter('manage_'.$this->post_type_Events['post_type'].'_posts_columns', array(&$this, 'Events_name_columns'), 15, 1);

    }

	/**
	** Front - view of callback Events
	**/
	function Events_custom_box_html(){

		if ( file_exists( WPCP_DIR.'template/html/admin-events-list-participation.php' ) ) {
			include( WPCP_DIR.'template/html/admin-events-list-participation.php' ) ;
		}

	}

	/**
	** Callback of meta box
	**/
	function wporg_add_custom_box()
	{
	    $screens = [$this->post_type_Events['post_type'], 'wporg_cpt'];
	    foreach ($screens as $screen) {
	        add_meta_box(
		        'Events_',//Unique ID
		        'Détails Des Participants',  //Box title
	            array(&$this,'Events_custom_box_html'),//Content callback, must be of type callable
		            $screen// Post type
	        );
	    }

	}
    /**
    ** Init all Meta Box
    **/  
    function init_callback_meta_box(){
    	add_action('add_meta_boxes', array(&$this,'wporg_add_custom_box'));
    }

    /**
    ** Callback of manage name of column
    **/
    function Events_name_columns($defaults ){
		$defaults["distance"] = esc_html__('Distance', 'wp_Events');
		// $defaults['active'] = esc_html__('Date D', 'wp_Events');
		// $defaults['end_date'] = esc_html__('Expiration', 'wp_Events');
		return $defaults;
	}

    /**
    ** Callback of manage column
    **/
    function custom_Events_columns($column_name, $postid){
    	if ( $column_name == "distance" ) {
			$name = get_post_meta($postid,  'distance',  true );
			echo $name;		
		}else if ( $column_name == "distance" ) {
			$name = get_post_meta($postid,  'distance',  true );
			if($name){
				echo "<span credit-number='".$name."' style='background: #09D60A;padding: 6px;border-radius: 6px;'><span class='dashicons dashicons-visibility'></span></span>";
			}else {
				echo "<span style='background: #f7b925;padding: 6px;border-radius: 6px;'><span class='dashicons dashicons-hidden'></span></span>";
			}		
		}else  if ( $column_name == "end_date" ) {
				$name = get_post_meta($postid,  'end_date',  true );
				echo '<span class="dashicons dashicons-calendar"></span>'.$name;
		}

    }
    function wpcs_set_email_content_type() {
        return 'text/html';
    }


}

new WpEventParticipation();