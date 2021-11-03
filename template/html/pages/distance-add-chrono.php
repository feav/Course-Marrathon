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
$participants = $wpEventMarathon->rank_users_of_itineraire(get_the_ID());
$participant = null;
foreach ($participants as $key => $value) {
   if($_GET['member'] == hash('md5',$value['email']) ){
        $participant = $value;
        break;
   }
}
?>
<script src="<?php echo WPEVENTMARATHON_URL; ?>/template/js/notify.min.js" type="text/javascript"></script>

    <div class="row" style="width: 100%;">
        <div id="primary" class="col-md-12" ng-app="marathonapp">
           
            <div class="content" >
                <form class="inscription-form" id='form-inscription' method="post" style="position: relative;">
                     <div class="title-line">
                      <h2>
                        <span  class="">
                             <span class="title-title">
                                <a>VOTRE CHRONO </a>                
                             </span>
                            <i class="fa fa-lg fa-angle-right" aria-hidden="true" ></i>
                        </span>
                         <span class="other-title"><span class="title-itineraire"><?php echo get_the_title();?></span> <i class="fa fa-lg fa-angle-right" aria-hidden="true" ></i> <?php echo get_post_meta(get_the_ID(),'distance',true)?> - Édition du <?php echo get_post_meta(get_the_ID(),'date_start',true) ?></span>
                      </h2>
                   </div>
                    <div class="modal-loading">
                        <div style="margin-top: 35%;text-align: center;width: 100%a;">Veuillez patienter...</div>                    
                    </div>
                    <input name="token" type="hidden" value="<?php echo $_GET['member']; ?>" >
                    <input name="event" type="hidden" value="<?php echo get_the_Id(); ?>" >

                    <div class="col-md-12 panel-header transblack SpecialFont" id="generalInfos">
                        <span class="enteteCuprum">Informations sur votre course</span>
                        <span style="float: right;">
                            <span style="color:#D7B56D"></span>
                            <span class="glyphicon glyphicon-user"></span>
                        </span>
                    </div>
                    <div class="panel-container">
                        <div class="panel panel-default ">
                            <div class="panel-body form-horizontal">
                                <?php 

                                if(!is_null($participant)){ ?>

                                    <?php if($participant['time'] != '0' && $participant['date_update'] != ''){ ?>
                                    <div style="width: 90%;text-align: center;color: red;margin:20px 5%;">
                                            Desole <?php echo $participant['name']; ?>, mais vous avez deja renseigne un score de <?php echo $participant['time']; ?> a cette competition le <?php echo $participant['date_update']; ?>.
                                            En cas d'erreur veillez contacter l'administrateur.
                                        </div>

                                    <?php }else{ ?>

                                    <div style="width: 90%;text-align: center;color: gray;margin:20px 5%;">
                                            Bravo <?php echo $participant['name']; ?>, vous avez termine votre course.<br>
                                            Veuillez renseigner votre chrono ainsi que les informations sur le lien de votre parcours virtuel.
                                    </div>
                                    <div class="form-group">
                                        <div class="" >
                                            <label for="name" class="control-label">Temps utilise pour terminer</label>
                                            <input itle="time" class="form-control" id="time" type="time" name="time" step="1" required="required">
                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <div class="" >
                                            <label for="club" class="control-label">Le lien de votre parcours </label>
                                            <input name="url" title="Url de confirmation" class="form-control" type="url" id="url" required="required" > 
                                        </div>
                                    </div>
                                    <br>
                                    <!-- <i>Votre classement Final sera disposible a la fin de la course</i> -->
                                    <div style="display: flex;justify-content: center;">
                                        <button type="submit" >S'enregistrer</button>
                                    </div>


                                <?php } ?>
                                <?php }else{ ?>
                                    <div style="width: 90%;text-align: center;color: red;margin:20px 5%;">
                                        Desole, mais nous ne reconnaissons pas ce lein, svp veuillez vous rappeler au pres de l'administrateur pour avoir votre lien valide.
                                    </div>

                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
        
    </div>
<script type="text/javascript">
    jQuery("form#form-inscription").submit(
        function(event){

            event.preventDefault();

            var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

            var formData = new FormData(document.getElementById("form-inscription"));
            
            formData.append('function','updat_chrono_event');

            formData.append('action','<?php echo $wpEventParticipation->plugin_slug; ?>');

            jQuery(".modal-loading").show(500);

            jQuery.ajax({
                url: ajaxurl,
                type: 'POST',
                processData: false, 
                contentType: false, 
                dataType: 'json',
                data: formData,
                success: function(jsonData) {
                    if(jsonData.response==200){

                        jQuery("form#form-inscription button").notify(  jsonData.message,'success');

                        document.location.href="<?php echo  $wpEventMarathon->shapeSpace_add_var(get_the_permalink(),'result',true)?>";
                    }else if(jsonData.response==300){


                        jQuery(".modal-loading").hide(500);
                        jQuery("form#form-inscription button").notify( jsonData.message,'info');
                    }else if(jsonData.response==400){

                        jQuery(".modal-loading").hide(500);
                        jQuery("form#form-inscription button").notify( jsonData.message,'warn');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    jQuery(".modal-loading").hide(500);
                    jQuery("form#form-inscription button").notify( "Echec dans l'enregistrement",'warn');
                }
            });

        return false;
    })
</script>
  <style type="text/css">
    .modal-loading {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: #ffffff78;
        display: none;
    }
    .content {
        display: flex;
        justify-content: center;
    }
    .inscription-form {margin: 10px 10%;width: 100%;border: 1px solid #f1efef; border-top: none;}

        div#generalInfos {
            background: rgb(49 55 105 / 83%);
            color: white;
            text-align: center;
            padding: 5px;
            margin-bottom: 10px;
                margin-top: 30px;
        }
.form-group > div {
    width: 30%;
}
    label.control-label {
        display: block;
        font-size: 15px;
        color: black;
        font-weight: 400;
    }
    .form-group {
        display: flex;
        width: 100%;
        justify-content: center;
    }
    .form-group div input, .form-group div select {
        width: 90%;
    }
    button.submission{
        padding: 10px 25px;
        background: black;
        color: white;
        border: none;
        cursor: pointer;
    }


        span.title-title a {
            font-size: 25px;
        }

        i.fa.fa-lg.fa-angle-right {
            font-size: 25px;
        }

        span.other-title {
            font-size: 22px;
        }

        span.title-itineraire {
            color: #ffffff;
            font-weight: 800;
        }
        .head-template {
            background: rgb(49 55 105 / 83%);
            padding: 10px 25px;
            color: white;
        }
        .title-line {
            border-bottom: 1px solid white;
            margin-bottom: 12px;
        }

        .title-line h2 {
            margin: 0;
        }

        span.title-title a {
            color: white;
        }

        p.alert.alert-warning {
            background: #d7b56d;
            padding: 20px;
        }



        .title-line {
            background: rgb(49 55 105 / 83%);
            margin-bottom: -1px;
        }

        #generalInfos {
            margin-top: 0 !important;
        }

        i.fa.fa-lg.fa-angle-right {color: white;font-size: 15px;}

        span.title-title a {
            font-size: 20px;
        }

        .title-line {
            text-align: center;
        }

        span.other-title {
            font-size: 19px;
            color: white;
        }

        span.title-itineraire {
        }

 </style>