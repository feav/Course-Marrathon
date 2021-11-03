<?php $wpEventMarathon = new WpEventMarathon(); ?>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

                    <?php
                        $link = $wpEventMarathon->shapeSpace_add_var(
                            $wpEventMarathon->shapeSpace_add_var(
                                get_the_permalink(get_the_ID()),'subscribe',1),"admin-subscribe",hash('md5', get_current_user_id()));
                    ?>
<a style="margin: 15px;" class="overlay-admin-notice-a button" target="blank" href="<?php echo $link ?>">Ajout d'un coureur</a>
<div class="detail-event"  ng-app="marathonapp">
	<input type="hidden" name="manage_event" value="1">
	<div class="row" ng-controller="ParticipantController">
        <table width="100%" border="0"   id="results">
            <thead>
                <tr style="background: #2b2a2a;color: white;border: 0;">
                        <th>Lien</th>
                        <th>Dossard</th>
                        <th>Prenom</th>
                        <th>Nom</th>
                        <th>email</th>
                        <th >Sexe</th>
                        <th >Categorie</th>
                        <th >Chrono</th>
                        <th ></th>
                </tr>
            </thead>
            <tbody>
                <tr  ng-repeat="participant in participants">
                <td><a href="{{participant.secret}}" class="button overlay-admin-notice-a">Validation</a></td>
                <td>{{participant.dossard}}</td>
                <td>{{participant.name}}</td>
                <td>{{participant.surname}}</td>
                <td>{{participant.email}}</td>
                <td> {{participant.sexe}}</td>
                <td>{{participant.categorie}}</td>
                <td>{{participant.time}}</td>
                <td style="display: flex;"> 
                    <?php
                        $link = $wpEventMarathon->shapeSpace_add_var(
                            $wpEventMarathon->shapeSpace_add_var(
                                get_the_permalink(get_the_ID()),'subscribe',1),"admin-subscribe",hash('md5', get_current_user_id()));
                    ?>
                    <a href="{{participant.secret_edit}}" target="blank" class="dashicons dashicons-edit edit-itineraire"></a>
                    <a ng-click="delete(participant.email)" target="blank" class="dashicons dashicons-trash"></a>
                    <a href="{{participant.pdf_link}}" target="blank" class="dashicons dashicons-format-aside"></a>

                    
                </td>
                </tr>
            </tbody>
                
        </table>
	</div>
</div>
<script type="text/javascript">
            jQuery(function($){
                $('body').on('click', '.upload_image_button', function(e){
                    e.preventDefault();
              
                    var button = $(this),
                    aw_uploader = wp.media({
                        title: button.attr("title"),
                        button: {
                            text: button.attr("button")
                        },
                        multiple: false
                    }).on('select', function() {
                        var attachment = aw_uploader.state().get('selection').first().toJSON();
                        $(button.attr("target")).val(attachment.url);
                    })
                    .open();
                });
            });
   <?php $wpEventParticipation = new WpEventParticipation(); ?>
      var app = angular.module('marathonapp', []);

   app.controller('ParticipantController', function($scope) {
      $scope.ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
      
       $scope.loading = {
         message : "Chargement en cours... ",
         style:  'hide'
       }
       $scope.participants = [];
       
       $scope.participant_id = 0;
       $scope.init = function(){
         $scope.loading = {style : '',  message : "Mise a jour en cours... "}
         jQuery.get($scope.ajaxurl, 
            {
                'action': '<?php echo $wpEventParticipation->plugin_slug; ?>',
                'function': 'get_email_participation',
                'course' : <?php echo get_the_ID(); ?> 
            }, 
            function(response) {
               if(response.response==200){
                  $scope.participants = response.participants;
                  $scope.loading.style = 'hide';
                  $scope.$apply();
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
               }
            }, 
            'json');
       }
       $scope.init();
       $scope.update_modal = function(itineraire=0){
            $scope.participant_id = itineraire;
            $scope.$apply();
       }
       $scope.newCourse = function(){
        

            $scope.loading = {style : '',  message : "Ajout de l'admin... "}

             jQuery.get($scope.ajaxurl, 
                {
                    'action': '<?php echo $wpEventParticipation->plugin_slug; ?>',
                    'function': 'add_empty_itineraire',
                    'course' : <?php echo get_the_ID(); ?> 
                }, 
                function(response) {
                   if(response.response==200){
                      $scope.participant_id = response.itineraire;
                      $scope.init();
                   }
                }, 
            'json');
       }
       $scope.delete = function(email){
            $scope.loading = {style : '',  message : "Ajout de l'admin... "}

             jQuery.get($scope.ajaxurl, 
                {
                    'action': '<?php echo $wpEventParticipation->plugin_slug; ?>',
                    'function': 'delete_email',
                    'email' : email,
                    'event' : <?php echo get_the_ID(); ?> 
                }, 
                function(response) {
                   if(response.response==200){
                      $scope.init();
                   }
                }, 
            'json');
     
       }
       $scope.deleteCourse = function(itineraire){
        
       }
   });
</script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            // jQuery('#results').DataTable();
        } );
    </script>
<style type="text/css">
    .modal-participan{
        position: absolute;
        top: 0;
        right: 0;
        background: white;
        width: 500px;
        padding: 15px;

    }
	.detail-event {
	    font-size: 15px;
	}
	.detail-event h2 {
	    font-size: 20px !important;
	    font-weight: 500 !important;
	}
	.double {
	    display: flex;
	    width: 100%;
	    justify-content: space-between;
	    padding: 10px 0px;
	}
	.detail-event input {
	    width: 50%;
	}
	.detail-event .row {
	    padding-left: 10px;
	    font-size: 16px;
	}
	.detail-event .row .item {
	    background: #f1f1f1;
	    padding: 10px;
	    margin-bottom: 10px;
	}
    
    #results_wrapper{
        overflow-x: scroll;
    }
</style>