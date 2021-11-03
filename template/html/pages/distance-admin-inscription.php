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
$min = intval(get_post_meta(get_the_ID(),'dossard_min',true));
$max = intval(get_post_meta(get_the_ID(),'dossard_max',true));
$number = $max - $min;
$participants = $wpEventMarathon->rank_users_of_itineraire(get_the_ID());
$number_taken = 0;
if($participants)
    $number_taken = count($participants);
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
                                <a>INSCRIPTION </a>                
                             </span>
                            <i class="fa fa-lg fa-angle-right" aria-hidden="true" ></i>
                        </span>
                         <span class="other-title"><span class="title-itineraire"><?php echo get_the_title();?></span> <i class="fa fa-lg fa-angle-right" aria-hidden="true" ></i> <?php echo get_post_meta(get_the_ID(),'distance',true)?> - Édition du <?php echo get_post_meta(get_the_ID(),'date_start',true) ?></span>
                      </h2>
                   </div>
					<div class="modal-loading">
                        <div style="margin-top: 35%;text-align: center;width: 100%a;">Veuillez patienter...</div>                    
                    </div>
                    <input name="event" type="hidden" value="<?php echo get_the_Id(); ?>" >

                    <?php if($number_taken < $number){ ?>
					<div class="col-md-12 panel-header transblack SpecialFont" id="generalInfos">
					    <span class="enteteCuprum"> Informations Générales</span>
					    <span style="float: right;">
					    	<span style="color:#D7B56D"></span>
					    	<span class="glyphicon glyphicon-user"></span>
					    </span>
					</div>

                    <div style="width: 90%;text-align: center;color: red;margin:20px 5%;">
                        Il reste <?php echo $number - $number_taken   ?> disponibles pour cette course.
                        <br>
                        Cette interface est reservee aux admins elle vous permet d'ajouter un nouveau coureur en lui assignant directement un dossard de preference un parmis les 15 premiers
                    </div>

					<div class="panel-container">
					    <div class="panel panel-default ">
					        <div class="panel-body form-horizontal">
					            <div class="form-group">
					                <div class="">
					                    <label for="name" class="control-label">Nom</label>
					                    <input name="name" title="Nom" class="form-control" maxlength="45" type="text" id="name" required="required" aria-required="true">
					                </div>
					                <div class="">
					                    <label for="datenaissance" class="control-label">Date de Naissance </label>
					                    <input name="datenaissance" title="Date de naissance" class="form-control" type="date" id="datenaissance" required="required" > 
					                </div>

					            </div>

					            <div class="form-group">
					                <div class="">
					                	<label for="UserName" class="control-label">Prénom </label>
					                    <input name="surname" title="Prénom" class="form-control"  type="text" id="UserName" required="required" aria-required="true">
					                </div>
					                <div class="">
					                    <label for="sexe" class="control-label">Sexe </label>
                                        <select name="sexe" title="sexe" class="form-control"  type="text" id="sexe" required="required">
                                            <option value="M">Masculin</option>
                                            <option value="F">Feminin</option>
                                        </select> 
					                </div>

					            </div>

					            <div class="form-group">
					                <div class="">
					                	<label for="pays" class="control-label">Pays </label>
					                    <select name="pays" required="required" >
											<option value="FR">France</option>
											<option value="AF">Afghanistan</option>
											<option value="ZA">Afrique du Sud</option>
											<option value="AL">Albanie</option>
											<option value="DZ">Algérie</option>
											<option value="DE">Allemagne</option>
											<option value="AD">Andorre</option>
											<option value="AO">Angola</option>
											<option value="AI">Anguilla</option>
											<option value="AQ">Antarctique</option>
											<option value="AG">Antigua-et-Barbuda</option>
											<option value="AN">Antilles néerlandaises</option>
											<option value="SA">Arabie saoudite</option>
											<option value="AR">Argentine</option>
											<option value="AM">Arménie</option>
											<option value="AW">Aruba</option>
											<option value="AU">Australie</option>
											<option value="AT">Autriche</option>
											<option value="AZ">Azerbaïdjan</option>
											<option value="BJ">Bénin</option>
											<option value="BS">Bahamas</option>
											<option value="BH">Bahreïn</option>
											<option value="BD">Bangladesh</option>
											<option value="BB">Barbade</option>
											<option value="PW">Belau</option>
											<option value="BE">Belgique</option>
											<option value="BZ">Belize</option>
											<option value="BM">Bermudes</option>
											<option value="BT">Bhoutan</option>
											<option value="BY">Biélorussie </option>
											<option value="MM">Birmanie </option>
											<option value="BO">Bolivie</option>
											<option value="BA">Bosnie-Herzégovine </option>
											<option value="BW">Botswana</option>
											<option value="BR">Brésil</option>
											<option value="BN">Brunei</option>
											<option value="BG">Bulgarie</option>
											<option value="BF">Burkina Faso</option>
											<option value="BI">Burundi</option>
											<option value="CI">Côte d'Ivoire</option>
											<option value="KH">Cambodge</option>
											<option value="CM">Cameroun</option>
											<option value="CA">Canada</option>
											<option value="CV">Cap-Vert</option>
											<option value="CL">Chili</option>
											<option value="CN">Chine</option>
											<option value="CY">Chypre</option>
											<option value="CO">Colombie</option>
											<option value="KM">Comores</option>
											<option value="CG">Congo</option>
											<option value="KP">Corée du Nord</option>
											<option value="KR">Corée du Sud</option>
											<option value="CR">Costa Rica</option>
											<option value="HR">Croatie</option>
											<option value="CU">Cuba</option>
											<option value="DK">Danemark</option>
											<option value="DJ">Djibouti</option>
											<option value="DM">Dominique</option>
											<option value="EG">Égypte</option>
											<option value="AE">Émirats arabes unis</option>
											<option value="EC">Équateur</option>
											<option value="ER">Érythrée</option>
											<option value="ES">Espagne</option>
											<option value="EE">Estonie</option>
											<option value="US">États-Unis</option>
											<option value="ET">Éthiopie</option>
											<option value="FI">Finlande</option>
											<option value="GE">Géorgie</option>
											<option value="GA">Gabon</option>
											<option value="GM">Gambie</option>
											<option value="GH">Ghana</option>
											<option value="GI">Gibraltar</option>
											<option value="GR">Grèce</option>
											<option value="GD">Grenade</option>
											<option value="GL">Groenland</option>
											<option value="GP">Guadeloupe</option>
											<option value="GU">Guam</option>
											<option value="GT">Guatemala</option>
											<option value="GN">Guinée</option>
											<option value="GQ">Guinée équatoriale</option>
											<option value="GW">Guinée-Bissao</option>
											<option value="GY">Guyana</option>
											<option value="GF">Guyane française</option>
											<option value="HT">Haïti</option>
											<option value="HN">Honduras</option>
											<option value="HK">Hong Kong</option>
											<option value="HU">Hongrie</option>
											<option value="BV">Ile Bouvet</option>
											<option value="CX">Ile Christmas</option>
											<option value="NF">Ile Norfolk</option>
											<option value="KY">Iles Cayman</option>
											<option value="CK">Iles Cook</option>
											<option value="FO">Iles Féroé</option>
											<option value="FK">Iles Falkland</option>
											<option value="FJ">Iles Fidji</option>
											<option value="GS">Iles Géorgie du Sud et Sandwich du Sud</option>
											<option value="HM">Iles Heard et McDonald</option>
											<option value="MH">Iles Marshall</option>
											<option value="PN">Iles Pitcairn</option>
											<option value="SB">Iles Salomon</option>
											<option value="SJ">Iles Svalbard et Jan Mayen</option>
											<option value="TC">Iles Turks-et-Caicos</option>
											<option value="VI">Iles Vierges américaines</option>
											<option value="VG">Iles Vierges britanniques</option>
											<option value="CC">Iles des Cocos (Keeling)</option>
											<option value="UM">Iles mineures éloignées des États-Unis</option>
											<option value="IN">Inde</option>
											<option value="ID">Indonésie</option>
											<option value="IR">Iran</option>
											<option value="IQ">Iraq</option>
											<option value="IE">Irlande</option>
											<option value="IS">Islande</option>
											<option value="IL">Israël</option>
											<option value="IT">Italie</option>
											<option value="JM">Jamaïque</option>
											<option value="JP">Japon</option>
											<option value="JO">Jordanie</option>
											<option value="KZ">Kazakhstan</option>
											<option value="KE">Kenya</option>
											<option value="KG">Kirghizistan</option>
											<option value="KI">Kiribati</option>
											<option value="KW">Koweït</option>
											<option value="LA">Laos</option>
											<option value="LS">Lesotho</option>
											<option value="LV">Lettonie</option>
											<option value="LB">Liban</option>
											<option value="LR">Liberia</option>
											<option value="LY">Libye</option>
											<option value="LI">Liechtenstein</option>
											<option value="LT">Lituanie</option>
											<option value="LU">Luxembourg</option>
											<option value="MO">Macao</option>
											<option value="MG">Madagascar</option>
											<option value="MY">Malaisie</option>
											<option value="MW">Malawi</option>
											<option value="MV">Maldives</option>
											<option value="ML">Mali</option>
											<option value="MT">Malte</option>
											<option value="MP">Mariannes du Nord</option>
											<option value="MA">Maroc</option>
											<option value="MQ">Martinique</option>
											<option value="MU">Maurice</option>
											<option value="MR">Mauritanie</option>
											<option value="YT">Mayotte</option>
											<option value="MX">Mexique</option>
											<option value="FM">Micronésie</option>
											<option value="MD">Moldavie</option>
											<option value="MC">Monaco</option>
											<option value="MN">Mongolie</option>
											<option value="MS">Montserrat</option>
											<option value="MZ">Mozambique</option>
											<option value="NP">Népal</option>
											<option value="NA">Namibie</option>
											<option value="NR">Nauru</option>
											<option value="NI">Nicaragua</option>
											<option value="NE">Niger</option>
											<option value="NG">Nigeria</option>
											<option value="NU">Nioué</option>
											<option value="NO">Norvège</option>
											<option value="NC">Nouvelle-Calédonie</option>
											<option value="NZ">Nouvelle-Zélande</option>
											<option value="OM">Oman</option>
											<option value="UG">Ouganda</option>
											<option value="UZ">Ouzbékistan</option>
											<option value="PE">Pérou</option>
											<option value="PK">Pakistan</option>
											<option value="PA">Panama</option>
											<option value="PG">Papouasie-Nouvelle-Guinée</option>
											<option value="PY">Paraguay</option>
											<option value="NL">Pays-Bas</option>
											<option value="PH">Philippines</option>
											<option value="PL">Pologne</option>
											<option value="PF">Polynésie française</option>
											<option value="PR">Porto Rico</option>
											<option value="PT">Portugal</option>
											<option value="QA">Qatar</option>
											<option value="CF">République centrafricaine</option>
											<option value="CD">République démocratique du Congo</option>
											<option value="DO">République dominicaine</option>
											<option value="CZ">République tchèque</option>
											<option value="RE">Réunion</option>
											<option value="RO">Roumanie</option>
											<option value="GB">Royaume-Uni</option>
											<option value="RU">Russie</option>
											<option value="RW">Rwanda</option>
											<option value="SN">Sénégal</option>
											<option value="EH">Sahara occidental</option>
											<option value="KN">Saint-Christophe-et-Niévès</option>
											<option value="SM">Saint-Marin</option>
											<option value="PM">Saint-Pierre-et-Miquelon</option>
											<option value="VA">Saint-Siège </option>
											<option value="VC">Saint-Vincent-et-les-Grenadines</option>
											<option value="SH">Sainte-Hélène</option>
											<option value="LC">Sainte-Lucie</option>
											<option value="SV">Salvador</option>
											<option value="WS">Samoa</option>
											<option value="AS">Samoa américaines</option>
											<option value="ST">Sao Tomé-et-Principe</option>
											<option value="SC">Seychelles</option>
											<option value="SL">Sierra Leone</option>
											<option value="SG">Singapour</option>
											<option value="SI">Slovénie</option>
											<option value="SK">Slovaquie</option>
											<option value="SO">Somalie</option>
											<option value="SD">Soudan</option>
											<option value="LK">Sri Lanka</option>
											<option value="SE">Suède</option>
											<option value="CH">Suisse</option>
											<option value="SR">Suriname</option>
											<option value="SZ">Swaziland</option>
											<option value="SY">Syrie</option>
											<option value="TW">Taïwan</option>
											<option value="TJ">Tadjikistan</option>
											<option value="TZ">Tanzanie</option>
											<option value="TD">Tchad</option>
											<option value="TF">Terres australes françaises</option>
											<option value="IO">Territoire britannique de l'Océan Indien</option>
											<option value="TH">Thaïlande</option>
											<option value="TL">Timor Oriental</option>
											<option value="TG">Togo</option>
											<option value="TK">Tokélaou</option>
											<option value="TO">Tonga</option>
											<option value="TT">Trinité-et-Tobago</option>
											<option value="TN">Tunisie</option>
											<option value="TM">Turkménistan</option>
											<option value="TR">Turquie</option>
											<option value="TV">Tuvalu</option>
											<option value="UA">Ukraine</option>
											<option value="UY">Uruguay</option>
											<option value="VU">Vanuatu</option>
											<option value="VE">Venezuela</option>
											<option value="VN">Viêt Nam</option>
											<option value="WF">Wallis-et-Futuna</option>
											<option value="YE">Yémen</option>
											<option value="YU">Yougoslavie</option>
											<option value="ZM">Zambie</option>
											<option value="ZW">Zimbabwe</option>
											<option value="MK">ex-République yougoslave de Macédoine</option>
					                    </select>
					                </div>
					                <div class="">
					                    <label for="email" class="control-label">Email </label>
					                   	<input name="email" title="email" class="form-control" type="email" id="email" required="required" > 

					                </div>

					            </div>

                                <div class="form-group">
                                    <div class="" >
                                        <label for="club" class="control-label">Nom du club ou Nom Team </label>
                                        <input name="club" title="confirm_email" class="form-control" type="text" id="club" required="required" > 
                                    </div>
                                    <div class="">
                                        <label for="email" class="control-label">Confirmation Email </label>
                                        <input name="confirm_email" title="confirm_email" class="form-control" type="email" id="confirm_email" required="required" > 

                                    </div>
                                </div>
                                <hr style="margin: 10px 23% 10px 20%;">

                                <div class="form-group">
                                    <div class="" >
                                        <label for="dossard" class="control-label">Dossard du courreur </label>
                                        <input name="dossard" title="dossard" class="form-control" type="number" id="dossard" required="required" > 
                                    </div>
                                    <div class="">

                                    </div>
                                </div>
                                <br>
					        </div>
					    </div>
					</div>

					<div class="col-md-12 panel-header transblack SpecialFont" id="generalInfos">
					    <span class="enteteCuprum">Règlement - Conditions d'acceptation</span>
					    <span style="float: right;">
					    	<span style="color:#D7B56D"></span>
					    	<span class="glyphicon glyphicon-user"></span>
					    </span>
					</div>
					<div class="panel-container" style="padding-bottom: 20px;">
					    <div class="panel panel-default " style="padding: 15px 20%;">
					        <div class="panel-body form-horizontal">
					            <div>
					            	<input type="checkbox" name="reglement" required=""> J'accepte le reglement de la competition
					            </div>
					            <div>
					            	<input type="checkbox" name="reglement" required="">  J'accepte que mes donnees soient stockees (RGPD)
					            </div>
					            
					        </div>
					    </div>
					    <div style="display: flex;justify-content: center;">
					    	<button type="submit" >S'enregistrer</button>
					    </div>
					</div>
                    <?php } else {?>
                    <div class="panel-container">
                        <div class="panel panel-default ">
                            <div class="panel-body form-horizontal">
                                <div style="width: 90%;text-align: center;color: red;margin:20px 5%;">
                                            Desole cette  course n'est plus disponible. Tous les dossard ont deja ete pris.
                                </div>


                                <br>
                            </div>
                        </div>
                    </div>
                    <?php }?>
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
            
            formData.append('function','updat_registration_event');

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

                        jQuery("form#form-inscription button").notify( "Connexion reussie, vous allez etre rediriger vers la liste des inscrits",'success');

                        //document.location.href="<?php echo  $wpEventMarathon->shapeSpace_add_var(get_the_permalink(),'membres',true)?>";
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
		    background: rgba(34, 34, 34, 0.83);
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
<?php