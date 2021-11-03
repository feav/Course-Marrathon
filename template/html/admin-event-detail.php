<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<div action="" id="event-details"  ng-app="marathonapp">
    <input type="hidden" name="update_course" value="1">
    <div class="double">
        <div style="width: 100%">

           <!--  <h3>A propos du marathon</h3>
            <div class="double">
                <div style="width: 100%">
                    <label for="link_on_live"><?php _e( 'Lien de la  marrathon virtuel:', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="link_on_live" type="link_on_live" id="link_on_live" value="<?php echo get_post_field( 'link_on_live', get_the_ID(), true ); ?>" />
                </div>
         
            </div> -->


            <h3>Fin des Inscription a la  Compétition</h3>
            <div class="double">
                <div style="width: 49%">
                    <label for="date_end_subscribe"><?php _e( 'Date:', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="date_end_subscribe" type="date" id="date_end_subscribe" value="<?php echo get_post_field( 'date_end_subscribe', get_the_ID(), true ); ?>" />
                </div>

                <div style="width: 49%">
                    <label for="time_end_subscribe"><?php _e( 'Hour :', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="time_end_subscribe" type="time" id="time_end_subscribe" value="<?php echo get_post_field( 'time_end_subscribe', get_the_ID(), true ); ?>" />
                </div>
         
            </div>

            <h3>Debut  de la  Compétition</h3>
            <div class="double">
                <div style="width: 49%">
                    <label for="date_start"><?php _e( 'Date:', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="date_start" type="date" id="date_start" value="<?php echo get_post_field( 'date_start', get_the_ID(), true ); ?>"  />
                </div>

                <div style="width: 49%">
                    <label for="time_start"><?php _e( 'Hour :', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="time_start" type="time" id="time_start"  value="<?php echo get_post_field( 'time_start', get_the_ID(), true ); ?>" />
                </div>
         
            </div>


            <h3>Fin de la  Compétition</h3>
            <div class="double">
                <div style="width: 49%">
                    <label for="date_end_"><?php _e( 'Date:', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="date_end_" type="date" id="date_end_" value="<?php echo get_post_field( 'date_end_', get_the_ID(), true ); ?>" />
                </div>

                <div style="width: 49%">
                    <label for="time_end_"><?php _e( 'Hour :', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="time_end_" type="time" id="time_end_" value="<?php echo get_post_field( 'time_end_', get_the_ID(), true ); ?>" />
                </div>
         
            </div>


           

            <hr>
            <div ng-controller="ItineraireController">
                <h2>Les Distances</h2>
                <a class="button" style="margin-bottom: 10px;margin-left: 40%;width: 20%;" ng-click="newCourse()">Ajouter une distance</a>
                <div class="container-itineraire">
                    <div  ng-repeat="itineraire in itineraires track by itineraire.id"   ng-class="itineraire_id==itineraire.id?'itineraire edit':'itineraire'" >
                        <span class="dashicons dashicons-edit edit-itineraire" ng-click="update_modal(itineraire.id)"></span>
                        <div class="name">Distance - <a ng-bind="itineraire.distance" target="blank" href="{{itineraire.url}}"></a></div>
                        <table ng-if="itineraire_id!=itineraire.id">
                            <tr>
                                <td><span class="txt">Nbre Partipants</span></td>
                                <td>
                                    <span class="dashicons dashicons-arrow-right"></span> 
                                    <span ng-bind="itineraire.distance"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="txt">Debut</span></td>
                                <td>
                                    <span class="dashicons dashicons-arrow-right"></span> 
                                    <span  ng-bind="itineraire.debut + ' ' + itineraire.debut_hr"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="txt">Fin</span></td>
                                <td>
                                    <span class="dashicons dashicons-arrow-right"></span> 
                                    <span  ng-bind="itineraire.fin + ' ' + itineraire.fin_hr"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="txt">Fin Inscrition</span></td>
                                <td>
                                    <span class="dashicons dashicons-arrow-right"></span> 
                                    <span ng-bind="itineraire.inscription + ' ' + itineraire.inscription_hr"></span>
                                </td>
                            </tr>
                        </table>
                        <div ng-if="itineraire_id==itineraire.id" >
                            <!-- <span ng-click="update_modal(0)" class="close">x {{itineraire_id}} {{itineraire_id==itineraire.id}}</span> -->

                            <h3>Distance de la Course </h3>
                            <div class="double">
                                <div style="width: 100%">
                                    <label for="distance_start"><?php _e( 'Distance :', 'wp_eventestation_manage' ); ?></label>
                             
                                    <input type="text" name="date_distance_{{itineraire.id}}" ng-model="itineraire.distance" >
                                </div>
                         
                            </div>
                            <h3>Dossards disponnbles </h3>
                            <div class="double">
                                <div style="width: 49%">
                                    <label for="dossard_min{{itineraire.id}}"><?php _e( 'Premier Dossard :', 'dossard_min' ); ?> </label>
                             
                                    <input type="text" name="dossard_min{{itineraire.id}}" ng-model="itineraire.dossard_min" >
                                </div>

                                <div style="width: 49%">
                                    <label for="dossard_max"><?php _e( 'Dernier Dossard  :', 'wp_eventestation_manage' ); ?></label>
                             
                                    <input type="text" name="dossard_max{{itineraire.id}}" ng-model="itineraire.dossard_max" >
                                </div>
                         
                            </div>
                            <h3>Debut de la Course </h3>
                            <div class="double">
                                <div style="width: 49%">
                                    <label for="date_start_{{itineraire.id}}"><?php _e( 'Date :', 'wp_eventestation_manage' ); ?> </label>
                             
                                    <input type="text" name="date_start_{{itineraire.id}}" ng-model="itineraire.debut" >
                                </div>

                                <div style="width: 49%">
                                    <label for="time_start"><?php _e( 'Heure  :', 'wp_eventestation_manage' ); ?></label>
                             
                                    <input type="text" name="time_start_{{itineraire.id}}" ng-model="itineraire.debut_hr" >
                                </div>
                         
                            </div>

                            <h3>Fin de la Course </h3>
                            <div class="double">
                                <div style="width: 49%">
                                    <label for="date_fin_{{itineraire.id}}"><?php _e( 'Date :', 'wp_eventestation_manage' ); ?> </label>
                             
                                    <input type="text" name="date_fin_{{itineraire.id}}" ng-model="itineraire.fin" >
                                </div>

                                <div style="width: 49%">
                                    <label for="time_end_hr{{itineraire.id}}"><?php _e( 'Heure  :', 'wp_eventestation_manage' ); ?> </label>
                             
                                    <input type="text" name="time_end_hr{{itineraire.id}}" ng-model="itineraire.fin_end_hr" >
                                </div>
                         
                            </div>
                            <h3>Fin de l'inscription </h3>
                            <div class="double">
                                <div style="width: 49%">
                                    <label for="date_inscription{{itineraire.id}}"><?php _e( 'Date :', 'wp_eventestation_manage' ); ?></label>
                             
                                    <input type="text" name="date_inscription_{{itineraire.id}}" ng-model="itineraire.inscription" >
                                </div>
                                <div style="width: 49%">
                                    <label for="time_inscription{{itineraire.id}}"><?php _e( 'Heure  :', 'wp_eventestation_manage' ); ?> </label>
                             
                                    <input type="text" name="time_inscription{{itineraire.id}}" ng-model="itineraire.inscription_hr" >
                                </div>
                         
                            </div>
                            <br>
                            <div style="display: flex;justify-content: space-between;">
                                <div>
                                    <span class="button button-primary button-large" ng-click="saveCourse(itineraire)">Enregistrer</span>
                                </div>

                                <div >
                                    <span class="button" ng-click="update_modal(0)" >Annuler</span>
                                </div>

                                <div>
                                    <span class="button deletion" ng-click="deleteCourse(itineraire)">Supprimer</span>
                                </div>
                         
                            </div>
                        </div>
                    </div>
                </div> 
            </div>

        </div>
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
   <?php $wpEventMarathon = new WpEventMarathon() ?>
      var app = angular.module('marathonapp', []);

   app.controller('ItineraireController', function($scope) {
      $scope.ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
      
       $scope.loading = {
         message : "Chargement en cours... ",
         style:  'hide'
       }
       $scope.itineraires = [];
       
       $scope.itineraire_id = 0;
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
       $scope.update_modal = function(itineraire=0){
            $scope.itineraire_id = itineraire;
            $scope.$apply();
       }
       $scope.newCourse = function(){
        

            $scope.loading = {style : '',  message : "Ajout de l'admin... "}

             jQuery.get($scope.ajaxurl, 
                {
                    'action': '<?php echo $wpEventMarathon->plugin_slug; ?>',
                    'function': 'add_empty_itineraire',
                    'course' : <?php echo get_the_ID(); ?> 
                }, 
                function(response) {
                   if(response.response==200){
                      $scope.itineraire_id = response.itineraire;
                      $scope.init();
                   }
                }, 
            'json');
       }
       $scope.saveCourse = function(itineraire){
            $scope.loading = {style : '',  message : "Ajout de l'admin... "}

             jQuery.get($scope.ajaxurl, 
                {
                    'action': '<?php echo $wpEventMarathon->plugin_slug; ?>',
                    'function': 'update_itineraire',
                    'itineraire' : itineraire,
                    'course' : <?php echo get_the_ID(); ?> 
                }, 
                function(response) {
                   if(response.response==200){
                      $scope.itineraire_id = 0;
                      $scope.init();
                   }
                }, 
            'json');
     
       }
       $scope.deleteCourse = function(itineraire){
            $scope.loading = {style : '',  message : "Ajout de l'admin... "}

             jQuery.get($scope.ajaxurl, 
                {
                    'action': '<?php echo $wpEventMarathon->plugin_slug; ?>',
                    'function': 'delete_itineraire',
                    'itineraire' : itineraire,
                    'course' : <?php echo get_the_ID(); ?> 
                }, 
                function(response) {
                   if(response.response==200){
                      $scope.itineraire_id = 0;
                      $scope.init();
                   }
                }, 
            'json');
        
       }
   });
</script>
<style type="text/css">
    #event-details div.double {
        display: flex;
        justify-content: space-between;
    }
    #event-details label {
        display: block;
        font-size: 15px;
        margin: 5px;
    }
    #event-details input {
        width: 100%;
        height: 45px;
        color: #7d7d7d;
    }
    #event-details select {
        height: 40px !important;
    }

    .double-many > div.hide-label{
            display: none;
    }
    .double-many > div img {
        width: 100% !important;
    }

    .double-many > div {
        width: 30% !important;
        display: inline-block;
    }
    .double-many {
        display: block;
    }

    .itineraire {
        width: 25%;
        background: #f1f1f1;
        -webkit-font-smoothing: subpixel-antialiased;
        padding: 20px;
        display: inline-block;
    }
    .itineraire {    
        position: relative;
        width: 43%;
        background: #ffffff;
        -webkit-font-smoothing: subpixel-antialiased;
        padding: 20px;
        display: inline-block;
        margin: 5px;
        transition: .3s transform cubic-bezier(.155,1.105,.295,1.12),.3s box-shadow,.3s -webkit-transform cubic-bezier(.155,1.105,.295,1.12);
    }
.itineraire h3 {
    margin: 5px;
}

    span.dashicons.dashicons-edit.edit-itineraire {
        right: 15px;
        position: absolute;
        top: 15px;
    }
    .itineraire.edit span.dashicons.dashicons-edit.edit-itineraire {
        display: none;
    }
    .itineraire:hover{
        transform: scale(1.05);
        box-shadow: 0 6px 10px rgba(0,0,0,.08), 0 0 6px rgba(0,0,0,.05);
    }
    .container-itineraire {
        background: #f1f1f1;
        padding: 10px;
        display: block;
    }
    .itineraire .txt{

        font-size: 11px;
        font-size: 0.6875rem;
        color: #6c7781;
    }
    .itineraire .name {
        display: block;
        margin-bottom: 5px;
        font-size: 13px;
        font-weight: bold;
        font-size: 0.8875rem;
        text-transform: uppercase;
        color: #6c7781;
    }
    .itineraire.edit {
        position: absolute;
        z-index: 2;
        width: 80%;
        left: 0;
        margin: 10px 10%;
        border: 1px solid #cac4c4;
        box-shadow: 3px 1px 6px 2px #0000004a;
    }
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<div action="" id="event-details"  ng-app="marathonapp">
    <input type="hidden" name="update_course" value="1">
    <div class="double">
        <div style="width: 100%">

           <!--  <h3>A propos du marathon</h3>
            <div class="double">
                <div style="width: 100%">
                    <label for="link_on_live"><?php _e( 'Lien de la  marrathon virtuel:', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="link_on_live" type="link_on_live" id="link_on_live" value="<?php echo get_post_field( 'link_on_live', get_the_ID(), true ); ?>" />
                </div>
         
            </div> -->


            <h3>Fin des Inscription a la  Compétition</h3>
            <div class="double">
                <div style="width: 49%">
                    <label for="date_end_subscribe"><?php _e( 'Date:', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="date_end_subscribe" type="date" id="date_end_subscribe" value="<?php echo get_post_field( 'date_end_subscribe', get_the_ID(), true ); ?>" />
                </div>

                <div style="width: 49%">
                    <label for="time_end_subscribe"><?php _e( 'Hour :', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="time_end_subscribe" type="time" id="time_end_subscribe" value="<?php echo get_post_field( 'time_end_subscribe', get_the_ID(), true ); ?>" />
                </div>
         
            </div>

            <h3>Debut  de la  Compétition</h3>
            <div class="double">
                <div style="width: 49%">
                    <label for="date_start"><?php _e( 'Date:', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="date_start" type="date" id="date_start" value="<?php echo get_post_field( 'date_start', get_the_ID(), true ); ?>"  />
                </div>

                <div style="width: 49%">
                    <label for="time_start"><?php _e( 'Hour :', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="time_start" type="time" id="time_start"  value="<?php echo get_post_field( 'time_start', get_the_ID(), true ); ?>" />
                </div>
         
            </div>


            <h3>Fin de la  Compétition</h3>
            <div class="double">
                <div style="width: 49%">
                    <label for="date_end_"><?php _e( 'Date:', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="date_end_" type="date" id="date_end_" value="<?php echo get_post_field( 'date_end_', get_the_ID(), true ); ?>" />
                </div>

                <div style="width: 49%">
                    <label for="time_end_"><?php _e( 'Hour :', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="time_end_" type="time" id="time_end_" value="<?php echo get_post_field( 'time_end_', get_the_ID(), true ); ?>" />
                </div>
         
            </div>


           

            <hr>
            <div ng-controller="ItineraireController">
                <h2>Les Distances</h2>
                <a class="button" style="margin-bottom: 10px;margin-left: 40%;width: 20%;" ng-click="newCourse()">Ajouter une distance</a>
                <div class="container-itineraire">
                    <div  ng-repeat="itineraire in itineraires track by itineraire.id"   ng-class="itineraire_id==itineraire.id?'itineraire edit':'itineraire'" >
                        <span class="dashicons dashicons-edit edit-itineraire" ng-click="update_modal(itineraire.id)"></span>
                        <div class="name">Distance - <a ng-bind="itineraire.distance" target="blank" href="{{itineraire.url}}"></a></div>
                        <table ng-if="itineraire_id!=itineraire.id">
                            <tr>
                                <td><span class="txt">Nbre Partipants</span></td>
                                <td>
                                    <span class="dashicons dashicons-arrow-right"></span> 
                                    <span ng-bind="itineraire.distance"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="txt">Debut</span></td>
                                <td>
                                    <span class="dashicons dashicons-arrow-right"></span> 
                                    <span  ng-bind="itineraire.debut + ' ' + itineraire.debut_hr"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="txt">Fin</span></td>
                                <td>
                                    <span class="dashicons dashicons-arrow-right"></span> 
                                    <span  ng-bind="itineraire.fin + ' ' + itineraire.fin_hr"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="txt">Fin Inscrition</span></td>
                                <td>
                                    <span class="dashicons dashicons-arrow-right"></span> 
                                    <span ng-bind="itineraire.inscription + ' ' + itineraire.inscription_hr"></span>
                                </td>
                            </tr>
                        </table>
                        <div ng-if="itineraire_id==itineraire.id" >
                            <!-- <span ng-click="update_modal(0)" class="close">x {{itineraire_id}} {{itineraire_id==itineraire.id}}</span> -->

                            <h3>Distance de la Course </h3>
                            <div class="double">
                                <div style="width: 100%">
                                    <label for="distance_start"><?php _e( 'Distance :', 'wp_eventestation_manage' ); ?></label>
                             
                                    <input type="text" name="date_distance_{{itineraire.id}}" ng-model="itineraire.distance" >
                                </div>
                         
                            </div>
                            <h3>Dossards disponnbles </h3>
                            <div class="double">
                                <div style="width: 49%">
                                    <label for="dossard_min{{itineraire.id}}"><?php _e( 'Premier Dossard :', 'dossard_min' ); ?> </label>
                             
                                    <input type="text" name="dossard_min{{itineraire.id}}" ng-model="itineraire.dossard_min" >
                                </div>

                                <div style="width: 49%">
                                    <label for="dossard_max"><?php _e( 'Dernier Dossard  :', 'wp_eventestation_manage' ); ?></label>
                             
                                    <input type="text" name="dossard_max{{itineraire.id}}" ng-model="itineraire.dossard_max" >
                                </div>
                         
                            </div>
                            <h3>Debut de la Course </h3>
                            <div class="double">
                                <div style="width: 49%">
                                    <label for="date_start_{{itineraire.id}}"><?php _e( 'Date :', 'wp_eventestation_manage' ); ?> </label>
                             
                                    <input type="text" name="date_start_{{itineraire.id}}" ng-model="itineraire.debut" >
                                </div>

                                <div style="width: 49%">
                                    <label for="time_start"><?php _e( 'Heure  :', 'wp_eventestation_manage' ); ?></label>
                             
                                    <input type="text" name="time_start_{{itineraire.id}}" ng-model="itineraire.debut_hr" >
                                </div>
                         
                            </div>

                            <h3>Fin de la Course </h3>
                            <div class="double">
                                <div style="width: 49%">
                                    <label for="date_fin_{{itineraire.id}}"><?php _e( 'Date :', 'wp_eventestation_manage' ); ?> </label>
                             
                                    <input type="text" name="date_fin_{{itineraire.id}}" ng-model="itineraire.fin" >
                                </div>

                                <div style="width: 49%">
                                    <label for="time_end_hr{{itineraire.id}}"><?php _e( 'Heure  :', 'wp_eventestation_manage' ); ?> </label>
                             
                                    <input type="text" name="time_end_hr{{itineraire.id}}" ng-model="itineraire.fin_end_hr" >
                                </div>
                         
                            </div>
                            <h3>Fin de l'inscription </h3>
                            <div class="double">
                                <div style="width: 49%">
                                    <label for="date_inscription{{itineraire.id}}"><?php _e( 'Date :', 'wp_eventestation_manage' ); ?></label>
                             
                                    <input type="text" name="date_inscription_{{itineraire.id}}" ng-model="itineraire.inscription" >
                                </div>
                                <div style="width: 49%">
                                    <label for="time_inscription{{itineraire.id}}"><?php _e( 'Heure  :', 'wp_eventestation_manage' ); ?> </label>
                             
                                    <input type="text" name="time_inscription{{itineraire.id}}" ng-model="itineraire.inscription_hr" >
                                </div>
                         
                            </div>
                            <br>
                            <div style="display: flex;justify-content: space-between;">
                                <div>
                                    <span class="button button-primary button-large" ng-click="saveCourse(itineraire)">Enregistrer</span>
                                </div>

                                <div >
                                    <span class="button" ng-click="update_modal(0)" >Annuler</span>
                                </div>

                                <div>
                                    <span class="button deletion" ng-click="deleteCourse(itineraire)">Supprimer</span>
                                </div>
                         
                            </div>
                        </div>
                    </div>
                </div> 
            </div>

        </div>
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
   <?php $wpEventMarathon = new WpEventMarathon() ?>
      var app = angular.module('marathonapp', []);

   app.controller('ItineraireController', function($scope) {
      $scope.ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
      
       $scope.loading = {
         message : "Chargement en cours... ",
         style:  'hide'
       }
       $scope.itineraires = [];
       
       $scope.itineraire_id = 0;
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
       $scope.update_modal = function(itineraire=0){
            $scope.itineraire_id = itineraire;
            $scope.$apply();
       }
       $scope.newCourse = function(){
        

            $scope.loading = {style : '',  message : "Ajout de l'admin... "}

             jQuery.get($scope.ajaxurl, 
                {
                    'action': '<?php echo $wpEventMarathon->plugin_slug; ?>',
                    'function': 'add_empty_itineraire',
                    'course' : <?php echo get_the_ID(); ?> 
                }, 
                function(response) {
                   if(response.response==200){
                      $scope.itineraire_id = response.itineraire;
                      $scope.init();
                   }
                }, 
            'json');
       }
       $scope.saveCourse = function(itineraire){
            $scope.loading = {style : '',  message : "Ajout de l'admin... "}

             jQuery.get($scope.ajaxurl, 
                {
                    'action': '<?php echo $wpEventMarathon->plugin_slug; ?>',
                    'function': 'update_itineraire',
                    'itineraire' : itineraire,
                    'course' : <?php echo get_the_ID(); ?> 
                }, 
                function(response) {
                   if(response.response==200){
                      $scope.itineraire_id = 0;
                      $scope.init();
                   }
                }, 
            'json');
     
       }
       $scope.deleteCourse = function(itineraire){
            $scope.loading = {style : '',  message : "Ajout de l'admin... "}

             jQuery.get($scope.ajaxurl, 
                {
                    'action': '<?php echo $wpEventMarathon->plugin_slug; ?>',
                    'function': 'delete_itineraire',
                    'itineraire' : itineraire,
                    'course' : <?php echo get_the_ID(); ?> 
                }, 
                function(response) {
                   if(response.response==200){
                      $scope.itineraire_id = 0;
                      $scope.init();
                   }
                }, 
            'json');
        
       }
   });
</script>
<style type="text/css">
    #event-details div.double {
        display: flex;
        justify-content: space-between;
    }
    #event-details label {
        display: block;
        font-size: 15px;
        margin: 5px;
    }
    #event-details input {
        width: 100%;
        height: 45px;
        color: #7d7d7d;
    }
    #event-details select {
        height: 40px !important;
    }

    .double-many > div.hide-label{
            display: none;
    }
    .double-many > div img {
        width: 100% !important;
    }

    .double-many > div {
        width: 30% !important;
        display: inline-block;
    }
    .double-many {
        display: block;
    }

    .itineraire {
        width: 25%;
        background: #f1f1f1;
        -webkit-font-smoothing: subpixel-antialiased;
        padding: 20px;
        display: inline-block;
    }
    .itineraire {    
        position: relative;
        width: 43%;
        background: #ffffff;
        -webkit-font-smoothing: subpixel-antialiased;
        padding: 20px;
        display: inline-block;
        margin: 5px;
        transition: .3s transform cubic-bezier(.155,1.105,.295,1.12),.3s box-shadow,.3s -webkit-transform cubic-bezier(.155,1.105,.295,1.12);
    }
.itineraire h3 {
    margin: 5px;
}

    span.dashicons.dashicons-edit.edit-itineraire {
        right: 15px;
        position: absolute;
        top: 15px;
    }
    .itineraire.edit span.dashicons.dashicons-edit.edit-itineraire {
        display: none;
    }
    .itineraire:hover{
        transform: scale(1.05);
        box-shadow: 0 6px 10px rgba(0,0,0,.08), 0 0 6px rgba(0,0,0,.05);
    }
    .container-itineraire {
        background: #f1f1f1;
        padding: 10px;
        display: block;
    }
    .itineraire .txt{

        font-size: 11px;
        font-size: 0.6875rem;
        color: #6c7781;
    }
    .itineraire .name {
        display: block;
        margin-bottom: 5px;
        font-size: 13px;
        font-weight: bold;
        font-size: 0.8875rem;
        text-transform: uppercase;
        color: #6c7781;
    }
    .itineraire.edit {
        position: absolute;
        z-index: 2;
        width: 80%;
        left: 0;
        margin: 10px 10%;
        border: 1px solid #cac4c4;
        box-shadow: 3px 1px 6px 2px #0000004a;
    }
    .container-itineraire{
        min-height: 650px;
    }
</style>