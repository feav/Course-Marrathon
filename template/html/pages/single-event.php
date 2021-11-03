<?php

$wpEventMarathon = new WpEventMarathon();
$wpEventParticipation = new WpEventParticipation();
$wpEventMarathon->init_urls();
$post_id =  get_the_ID();

?>
<script src="<?php echo WPEVENTMARATHON_URL; ?>/template/js/notify.min.js" type="text/javascript"></script>

	<div class="row" id="my-event" style="width: 100%;">
		<div id="primary" class="col-md-12" ng-app="marathonapp">

			<h1><?php echo get_the_title()?></h1>
			<div class="content" >
				<?php

				while ( have_posts() ) :
					the_post();

					$distances = $wpEventMarathon->get_itineraire_of_course( $post_id );
				?>
				<div class="main" ng-controller="ItineraireController" style="position: relative;">
					
					<?php foreach ($distances as $key => $value) {
							$global_id = $value['id'];
							$date_sub = get_post_meta( $global_id, 'date_end_subscribe', true );
		                    $time_sub = get_post_field(  $global_id,'time_end_', true );
		                    $date_com_sub = date("Y-m-d H:I", strtotime($date_sub.' '.$time_sub) );
		                    $diff = human_time_diff( strtotime(date("Y-m-d H:I")), strtotime($date_sub.' '.$time_sub) );
		                    $in_future_inscription = true;
		                    if(strtotime(date("Y-m-d H:I")) >= strtotime($date_sub.' '.$time_sub) )
		                        $in_future_inscription = false;


		                    $date_sub = get_post_meta( $global_id, 'date_end_', true );
		                    $time_sub = get_post_field(  $global_id,'time_end_', true );
		                    $date_com_sub = date("Y-m-d H:I", strtotime($date_sub.' '.$time_sub) );
		                    // var_dump(strtotime($date_sub.' '.$time_sub));
		                    if(isset($_GET['debbug'])){
		                        echo $date_com_sub;
		                        echo '-';
		                        echo date("Y-m-d H:I") ;
		                        echo '-'.($date_sub.' '.$time_sub);
		                    }
		                    $diff = human_time_diff( strtotime(date("Y-m-d H:I")), strtotime($date_sub.' '.$time_sub) );
		                    $in_future = true;
		                    if(strtotime(date("Y-m-d H:I")) >= strtotime($date_sub.' '.$time_sub) )
		                        $in_future = false;
					?>
					
						<div class="itineraire"  id="block-itineraire-<?php echo $value['id']; ?>">
							<div class="itineraire-head">
								<div>
									<h2>* <span><?php echo $value['distance'] ?></span> *</h2>
								</div>
								<div class="action-button">
									<div>
										<?php if($in_future_inscription): ?>
										<a href="<?php echo  $wpEventMarathon->shapeSpace_add_var(get_the_permalink($value['id']),'subscribe',true)?>" class="subscribe">S'inscrire Maintenant</a>
		                               <?php else:?>
										<a class="subscribe" style="background: #ef7272;" >Inscriptions Cloturées </a>
		                               <?php endif;?>
									</div>
									<div>
										<a class="subscribe" href="<?php echo  $wpEventMarathon->shapeSpace_add_var(get_the_permalink($value['id']),'membres',true)?>">Liste d'inscrits <?php echo $value['participant'] ?></a>
									</div>

									<div>
										<a class="subscribe" href="<?php echo  $wpEventMarathon->shapeSpace_add_var(get_the_permalink($value['id']),'result',true)?>">Les Resultats</a>
									</div>
								</div>
									
							</div>
						</div>

					<?php } ?>
				</div>
				<div class="resume">
					<?php echo get_the_title(); ?>
					<hr>
					<table>

						<?php 
							$date = get_post_field( 'date_end_subscribe', get_the_ID(), true ); ;
							$time = get_post_field( 'time_end_subscribe', get_the_ID(), true ); ;
							if($date) echo '<tr><td>Inscriptions</td><td>'.$date .' '.$time .'</td></tr>';
						?>

						<?php 
							$date = get_post_field( 'date_start', get_the_ID(), true ); ;
							$time = get_post_field( 'time_start', get_the_ID(), true ); ;
							if($date) echo '<tr><td>Debut</td><td>'.$date .' '.$time .'</td></tr>';
						?>

						<?php 
							$date = get_post_field( 'date_end_', get_the_ID(), true ); ;
							$time = get_post_field( 'time_end_', get_the_ID(), true ); ;
							if($date) echo '<tr><td>Fin</td><td>'.$date .' '.$time .'</td></tr>';
						?>
					</table>

					<table>
						<tr>
							<td>
								Participnts
							</td>
							<td>
								238
							</td>
						</tr>
						<tr>
							<td>
								Itineraires
							</td>
							<td>
								4
							</td>
						</tr>
					</table>
				</div>
				<script type="text/javascript">
					   var app = angular.module('marathonapp', []);

					   app.controller('ItineraireController', function($scope) {
					      $scope.ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
					      $scope.id_user = <?php echo get_current_user_id()?get_current_user_id():0; ?>;
					      $scope.se_connecter = true;
					       $scope.loading = {
					         message : "Chargement en cours... ",
					         style:  'hide'
					       }
					       $scope.itineraires = [];
					       
					       $scope.itineraire_id = 0;
					       $scope.update_login_state = function(item){
					       		$scope.se_connecter = item;
					       		$scope.$apply();
					       }
					       $scope.init = function(){
					         $scope.loading = {style : '',  message : "Mise a jour en cours... "}
					         jQuery.get($scope.ajaxurl, 
					            {
					                'action': '<?php echo $wpEventMarathon->plugin_slug; ?>',
					                'function': 'get_itineraire',
					                'course' : <?php echo get_the_ID(); ?> 
					            }, 
					            function(response) {
					               if(response.response==200){
					                  $scope.itineraires = response.itineraires;
					                  $scope.loading.style = 'hide';
					                  $scope.$apply();
					               }
					            }, 
					            'json');
					       }
					       $scope.init();
					       $scope.close_modal_connexion = function(){
					       		jQuery(".modal-connexion-log").slideUp(500);
					       }
					       $scope.update_modal = function(itineraire=0){
					            $scope.itineraire_id = itineraire;
					            $scope.$apply();
					       }
					       $scope.error_connexion = false;
					       succes_connexion = false;
							$scope.inscrire = function(){
					            $scope.loading = {style : '',  message : "Ajout de l'admin... "}
					             var itineraire = jQuery("#inscrire input[name='selected-course']").val();
					             jQuery.get($scope.ajaxurl, 
					                {
					                    action	: 	'<?php echo $wpEventParticipation->plugin_slug; ?>',
					                    function	: 	'subscrive_user',
					                    login : jQuery("#connecter input[name='name']").val(),
					                    login : jQuery("#connecter input[name='surname']").val(),
					                    login : jQuery("#connecter input[name='sexe']").val(),
					                    login : jQuery("#connecter input[name='login']").val(),
					                    itineraire : itineraire,
					                    password : jQuery("#connecter input[name='password']").val(),
					                }, 
					                function(response) {
					                   	if(response.response==200){
					                   		$scope.subscribe(itineraire);
					                   		jQuery(".modal-connexion-log").slideUp(500);

					                   	  	jQuery("#connecter  button").notify(
					                   	  		"Connexion reussie, en encours d'inscription a la course",'success');
					                      	// document.location.reload()
					                   	}else if(response.response == 300){
					                   	  	jQuery("#connecter  button").notify("Login ou mot de passe incorrect",'error');
					                   	}
					                   	$scope.$apply();
					                }, 
					            'json');
					       	}
				
					       $scope.connexion = function(){
					            $scope.loading = {style : '',  message : "Ajout de l'admin... "}
					             var itineraire = jQuery("#connecter input[name='selected-course']").val();
					             jQuery.get($scope.ajaxurl, 
					                {
					                    action	: 	'<?php echo $wpEventParticipation->plugin_slug; ?>',
					                    function	: 	'connect_user',
					                    login : jQuery("#connecter input[name='login']").val(),
					                    itineraire : itineraire,
					                    password : jQuery("#connecter input[name='password']").val(),
					                }, 
					                function(response) {
					                   	if(response.response==200){
					                   		$scope.subscribe(itineraire);
					                   		jQuery(".modal-connexion-log").slideUp(500);

					                   	  	jQuery("#connecter  button").notify(
					                   	  		"Connexion reussie, en encours d'inscription a la course",'success');
					                      	// document.location.reload()
					                   	}else if(response.response == 300){
					                   	  	jQuery("#connecter  button").notify("Login ou mot de passe incorrect",'error');
					                   	}
					                   	$scope.$apply();
					                }, 
					            'json');
					       	}

					       $scope.subscribe = function($itineraire_id){
					            $scope.loading = {style : '',  message : "Ajout de l'admin... "}
					             jQuery.get($scope.ajaxurl, 
					                {
					                    'action'	: 	'<?php echo $wpEventParticipation->plugin_slug; ?>',
					                    'function'	: 	'update_user_participation',
					                    'itineraire'	: 	$itineraire_id 
					                }, 
					                function(response) {
					                   if(response.response==200){
					                   	  jQuery("#block-itineraire-"+$itineraire_id).notify(response.message,'success');
					                      $scope.init();

					                      // document.location.reload()
					                   }
					                   else if(response.response == 300){
					                   		jQuery(".modal-connexion-log").slideDown(500);
					                   		jQuery("input.selected-course").val($itineraire_id);
					                   }
					                }, 
					            'json');
					       	}
					       
					   });
					</script>
				<?php
				endwhile; 
				?>
			</div>
		</div>
		
	</div>

	<style type="text/css">
		#my-event .content{
			display: flex;
		}
		#my-event .content .main{
			width: 100%;
		}
		#my-event .content .resume{
			/*width: 25%;*/
			display: none;
			border: 1px solid #ddd;
		    padding: 10px 10px 3px 10px;
		    background: white;
		    margin-top: -75px;
		    z-index: 3;
		}
		#my-event .details-profil {
		    display: flex;
		    position: absolute;
		    justify-content: start;
		    width: 100%;
		    background: #6639a3;
		    z-index: 10;
		    bottom: 0;
		    left: 0;
		}

		#my-event .rank {
		    background: #f9f9f9;
		    width: 30%;
		}
		#my-event .score {
		    font-size: 12px;
		    color: white;
		    text-align: center;
		    width: 70%;
		    padding-top: 4px;
		}
		#my-event .profile img {
		    width: 100px;
		    height: 100px;
		    margin: 0;
		    padding: 0;
		}
		#my-event .profile:hover{
			transform: scale(1.3);
		}

		#my-event .profile:first-child:hover{
			transform: scale(1.4);
		}
		#my-event .profile {
		    width: max-content;
		    display: inline-block;
		    border: 1px solid black;
		    border-radius: 10px;
		    background: #6639a3;
		    margin-left: 10px;
		    margin-right: 10px;
		    overflow: hidden;
		    position: relative;
		    box-shadow: 2px 3px 1px #a79292bf;
		    transition: .3s transform cubic-bezier(.155,1.105,.295,1.12),.3s box-shadow,.3s -webkit-transform cubic-bezier(.155,1.105,.295,1.12);
		    cursor: pointer;

		 }

		#my-event  .profile .score > *{
		 	width: 100%;
		 }
		#my-event  .profile .score .score{
		 	display: none;
		 }

		#my-event .profile:hover .score .score{
			display: block;
		}
		#my-event .profile:hover .score .name{
			display: none;
		}
		#my-event  .profile:first-child {
		    transform: scale(1.2);
		    box-shadow: 2px 3px 1px #efebebbf;
		    border: 2px solid #6639a3;
		}
		#my-event .itineraire-head{
			display: flex;
			    justify-content: center;

		}
		#my-event .itineraire-head > div {
		    padding-right: 10px;
		}
		#my-event .itineraire-head > div:first-child{
		    border-right: 1px solid #e4d9d9;
		}
		#my-event .subscribe {
		    background: #000;
		    color: white;
		    border: none;
		        padding: 8px 15px;
		}
		#my-event .itineraire {
		    background: #8080800d;
		    padding: 15px 20px;
		    margin-bottom: 11px;
		    box-shadow: 1px 1px 2px #00000070;
		}
		#my-event .itineraire-head h2{
			margin:0;
		}



		#my-event .modal-connexion-log {
		  position: absolute;
		  width: 100%;
		  height: 100%;
		  background: #ffffffa6;
		  z-index: 1000;
		  display: none;
		}
		#my-event .content-modal-connexion {
		  border: 1px solid #cac4c4;
		  background: white;
		  padding: 20px;
		  height: max-content;
		  box-shadow: 2px 3px 6px #d2caca;
		  width: 450px;
		}
		#my-event .content-modal-connexion-head {
		  font-weight: 800;
		  margin-bottom: 14px;
		  position: relative;
		}
		#my-event .content-modal-connexion-content input {
		  display: block;
		  width: 100%;
		  margin-bottom: 15px;
		}
		#my-event .content-modal-connexion-content button {
		  margin-top: 15px;
		  width: 100%;
		  background: black;
		  border: none;
		  color: white;
		}
		#my-event .content-modal-connexion-content input[type=radio] {
		  display: inline;
		  max-width: max-content;
		  margin-left: 30px;
		  margin-right: 30px;
		}
		#my-event .close-modal {
		    position: absolute;
		    right: 0;
		    top: 0;
		}
		#my-event .action-button{
				display: flex;
				padding-top: 15px;
				justify-content: space-around;
		}
		#my-event .action-button > div {
			    margin: 0 10px;
			}
		@media (max-width: 992px) {
		 	#my-event .itineraire-head  {
			    flex-direction: column;
			}
			#my-event .itineraire-head > div {
			    width: 100% !important;
			}
			#my-event .action-button{
				display: block;
			}
			#my-event .action-button{
				display: inline-block;
				width: 30%;
			}

			#my-event .action-button > div {
			    margin: 0 10px;
			}

			div {}

			#my-event .action-button > div {
			    width: 30%;
			    min-width: 200px;
			    margin: 10px 0;
			    display: inline-block;
			}

			#my-event .action-button {
			    padding-top: 5px;
			    padding-bottom: 10px;
			}
		
		}
		
		
	</style>

