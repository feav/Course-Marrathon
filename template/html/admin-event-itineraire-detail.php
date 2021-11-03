<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    
<div action="" id="event-details" >
    <div class="double">
        <input type="hidden" name="update_itineraire" value="true">
        <div style="width: 100%">
<!-- 
            <h3>A propos du marathon</h3>
            <div class="double">
                <div style="width: 100%">
                    <label for="link_on_live"><?php _e( 'Lien de la Compétition virtuel:', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="link_on_live" type="link_on_live" id="link_on_live" value="<?php echo get_post_field( 'link_on_live', get_the_ID(), true ); ?>" />
                </div>
         
            </div> -->
            
            <h3>Intervalle des dossards</h3>
            <div class="double">
                <div style="width: 49%">
                    <label for="dossard_min"><?php _e( 'Premier Dossard:', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="dossard_min" type="number" id="dossard_min" value="<?php echo get_post_field( 'dossard_min', get_the_ID(), true ); ?>" />
                </div>

                <div style="width: 49%">
                    <label for="dossard_max"><?php _e( 'Dernier Dossard:', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="dossard_max" type="number" id="dossard_max" value="<?php echo get_post_field( 'dossard_max', get_the_ID(), true ); ?>" />
                </div>
         
            </div>

            <h3>Fin des Inscription a la Compétition</h3>
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

            <h3>Debut  de la Compétition</h3>
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


            <h3>Fin de la Compétition</h3>
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


            <h3>Distance a parcourir</h3>
            <div class="double">
                <div style="width: 49%">
                    <label for="distance"><?php _e( 'Distance :', 'wp_eventestation_manage' ); ?></label>
             
                    <input name="distance" type="text" id="distance" value="<?php echo get_post_field( 'distance', get_the_ID(), true ); ?>" placeholder="1000m"  />
                </div>
                <div style="width: 49%">
                    <label for="distance"><?php _e( 'Course : '.get_the_title(get_post_field( 'post_parent', get_the_ID(), true )), 'wp_eventestation_manage' ); ?> </label>
             
                    <input name="parent-id" type="number" disabled="disabled" id="parent-id" value="<?php echo get_post_field( 'post_parent', get_the_ID(), true ); ?>"   />
                </div>
         
         
            </div> 
           <!--  <div class="double">
                <div style="width: 100%">
                    <label for="report_pdf"><?php _e( 'Details PDF du marathon:', 'wp_eventestation_manage' ); ?></label>
             

                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 20%;"><a href="#" target="#report_pdf" class="upload_image_button button button-secondary" title="Choisir un pdf" button="Utiliser ce PDF"><?php _e('Telecharger un pdf'); ?></a></td>
                            <td><input type="text" name="report_pdf" id="report_pdf" value=" <?php echo get_post_field( 'report_pdf', get_the_ID(), true ); ?>"  /></td>
                        </tr>
                    </table>
                </div>
         
            </div> -->

            <hr>



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
</style>