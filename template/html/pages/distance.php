<?php
/**
 * The template for displaying all single posts.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Shapely
 */
$wpEventMarathon = new WpEventMarathon();
$wpEventParticipation = new WpEventParticipation();
$global_id = get_the_ID();
?>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
	
	<div id="my-envent" class="row" style="width: 100%;">
		<div id="primary" class="col-md-12" ng-app="marathonapp">

			<div class="head-template">
			   <div class="title-line">
			      <h2>
			        <span  class="">
				         <span class="title-title">
				         	<a>PARCOURS </a>                
				         </span>
			        	<i class="fa fa-lg fa-angle-right" aria-hidden="true" ></i>
			        </span>
			         <span class="other-title"><span class="title-itineraire"><?php echo get_the_title(get_post_field( 'post_parent', $global_id , true ));?></span> <i class="fa fa-lg fa-angle-right" aria-hidden="true" ></i> <?php echo get_post_meta(get_the_ID(),'distance',true)?> - Édition du <?php echo get_post_meta(get_the_ID(),'date_start',true) ?></span>
			      </h2>
			   </div>
			   <?php 
			   		$participants = $wpEventMarathon->rank_users_of_itineraire(get_the_ID());
			   		$distances = $wpEventMarathon->get_itineraire_of_course_basique(get_post_field( 'post_parent', $global_id , true ));
			   		$proportion_sexe = array_count_values( array_column($participants, 'sexe') );
			    ?>


			   <div class="col-md-6 col-sm-6 col-xs-12" id="results_header_subline">
			   	  <select class="itineraire-select">
			   	  	<?php foreach ($distances as $key => $value): ?>
			   	  		<option 
			   	  		<?php 
			   	  		if($global_id  == $value['id']) echo 'selected="selected"';
			   	  		?> 
			   	  		value="<?php echo get_the_permalink($value['id']) ?>"><?php echo get_post_meta($value['id'],'distance',true) ?> </option>
			   	  	<?php endforeach ?>
			   	  				   	  </select>
			      <p  style="font-size: 11pt;margin-top: 0px;letter-spacing: 1px;margin-bottom: 5px;">
			      	<?php echo count($participants);?> participants - 
			      	<?php 
			      	if(isset($proportion_sexe['F'])) 
			      		echo $proportion_sexe['F'];
			      	else echo 0;
			      	?> Femmes
			         - <?php 
			         if(isset($proportion_sexe['M']))
			         	echo $proportion_sexe['M'];
			         else echo 0;?> Hommes 
			      </p>
			      <p class="Cuprum" style="font-size: 10pt;margin-top: 2px;letter-spacing: 1px">Date des inscriptions - 
			          <?php echo get_post_meta(get_the_ID(),'date_end_subscribe',true) ?>
			      </p> 
			      <!-- <p class="Cuprum" style="font-size: 10pt;margin-top: 2px;letter-spacing: 1px">Temps moyen
			         : 00:51:47 
			      </p> -->
			   </div>
			   <div class="row">
			      <div class="col-xs-12">
			        <p class="alert alert-warning"> Course virtuelle : Les classements seront comptabilisés sur vos performances, le classement final sera publié le <?php echo get_post_meta(get_the_ID(),'date_end_',true) ?> à <?php echo get_post_meta(get_the_ID(),'time_end_',true) ?>

			         </p>
			      </div>
			   </div>
			   <div class="table-responsive">
			   <hr style="background: #D7B571;margin: 5px 2px;">
            <table class="table table-hover" id="results">
                <thead id="leaderboard_head">
	                <tr class="">
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th >Sexe</th>
                        <th >Age</th>
                        <th> Pays</th>
                        <th >Equipe</th>
                        <th >Chrono</th>
	                </tr>
                </thead>
                <tbody>
                	<?php
                		foreach ($participants as $key => $value) {
                			?>
							<tr>
                                <td><?php echo  $value['name']; ?></td>
                                <td><?php echo  $value['surname']; ?></td>
                                <td> <?php echo  $value['sexe']; ?></td>
                                <td><?php echo  $value['age']; ?> </td>
                                <td><?php echo  $value['pays']; ?> </td>
                                <td><?php echo  $value['club']; ?> </td>
                                <td><?php echo  $value['time']; ?> </td>
		                    </tr>

                			<?php
                		}
                	?>
                    
               	</tbody>
            </table>
        </div>
			</div>
			<div class="body-template">
				<table id="example" class="display" width="100%"></table>
			</div>
		</div>
		
	</div>
	<style type="text/css">
        #my-envent .content-head{
        width: 100%;
        }

        #my-envent span.title-title a {
        font-size: 25px;
        }

        #my-envent i.fa.fa-lg.fa-angle-right {
        font-size: 25px;
        }

        #my-envent span.other-title {
        font-size: 22px;
        }

        #my-envent span.title-itineraire {
        color: #68119b !important;

        }
        #my-envent .head-template {
        background: #ffffff;
        padding: 10px 25px;
        color: #000000;
        }
        #my-envent .title-line {
        border-bottom: 1px solid white;
        margin-bottom: 12px;
        }

        #my-envent .title-line h2 {
        margin: 0;
        }

        #my-envent span.title-title a {
            color: #484646;
        }

        #my-envent p.alert.alert-warning {
        background: #DCDCDC;
        padding: 20px;
        }

        #my-envent thead{
        background-color: #DCDCDC;
        }
        #my-envent tr{
        text-align: center;
        }

        #my-envent th {
        color: #68119b !important;
        font-weight: normal;
        text-decoration: none;
        height: 50px;
        text-align: center;
        }

        #my-envent th > a{
        color:#68119b !important;
        }

        #my-envent #row_style {
        background-color: #EFEFEF;
        border-bottom: 2px solid #68119b;
        }

        

        #my-envent div#results_filter , .dataTables_wrapper .dataTables_filter input  , div#results_length, .dataTables_wrapper .dataTables_length select , .dataTables_wrapper .dataTables_paginate .paginate_button.disabled, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active, .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
        color: black !important;
        }

        #my-envent table.dataTable tbody tr {
        background: none;
        }
        
        #my-envent select.itineraire-select {    background: none;
            color: #68119b !important;
            font-size: large;
            font-weight: 400;
            min-width: 200px;
            border: 2px solid #232121;
            padding: 5px 5px;
            margin: 5px 0;
            width: max-content;
            display: inline-block;
        }
</style>
	<script type="text/javascript">
		jQuery(document).ready(function() {
		    jQuery('#results').DataTable({language:{
			    "sEmptyTable":     "Aucune donnée disponible dans le tableau",
			    "sInfo":           "Affichage de  _START_ à _END_ sur _TOTAL_ coureurs",
			    "sInfoEmpty":      "Affichage de  0 à 0 sur 0 coureurs",
			    "sInfoFiltered":   "(filtré à partir de _MAX_ coureurs au total)",
			    "sInfoPostFix":    "",
			    "sInfoThousands":  ",",
			    "sLengthMenu":     "Afficher _MENU_ lignes",
			    "sLoadingRecords": "Chargement...",
			    "sProcessing":     "Traitement...",
			    "sSearch":         "Rechercher :",
			    "sZeroRecords":    "Aucun élément correspondant trouvé",
			    "oPaginate": {
			        "sFirst":    "Premier",
			        "sLast":     "Dernier",
			        "sNext":     "Suivant",
			        "sPrevious": "Précédent"
			    },
			    "oAria": {
			        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
			        "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
			    },
			    "select": {
			            "rows": {
			                "_": "%d lignes sélectionnées",
			                "0": "Aucune ligne sélectionnée",
			                "1": "1 ligne sélectionnée"
			            } 
			    }
			}});
		    jQuery('select.itineraire-select').change(function(){
		    	document.location.href = jQuery(this).val();
		    })
		} );
	</script>
