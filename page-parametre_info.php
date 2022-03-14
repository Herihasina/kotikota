<?php
	// Template name: info principale

	if ( array_key_exists("parametre", $_GET) ){
		$idCagnotte = strip_tags($_GET['parametre']);
	}elseif( array_key_exists("origin", $_GET) && trim( $_GET['origin'] ) == 'post-setup' && array_key_exists("cgid", $_GET) ){
		$idCagnotte = strip_tags($_GET['cgid']);
	}

	if ( !is_cagnotte( $idCagnotte ) )
		die(__('Cette ID ne correspond à votre cagnotte :)','kotikota'));

	if ( (is_user_logged_in() && get_field('titulaire_de_la_cagnotte', $idCagnotte )  == get_current_user_id() ) || current_user_can('administrator') ):
		
		$active = "info";
		get_header(); ?>

		<main id="homepage">
<?php
		include 'sections/content/parallax.php';
?>
			<div class="parametreCagnotte">
        <div class="wrapper">
				<?php
						include 'sections/parametres/menu-parametre.php';
				?>
					<div class="formulaireParametre clr wow fadeIn" data-wow-delay="950ms">
	          <form>
	            <div class="col">
	              <div class="blc-chp">
	                <label><?php _e('Donnes un nom à ta cagnotte','kotikota'); ?> <span>*</span></label>
	                <input type="text" name="nom" class="chp" id="nom_cagnotte" value="<?php echo get_field('nom_de_la_cagnotte',$idCagnotte); ?>" required>
	              </div>
	            </div>
	            <div class="col">
	              <div class="blc-chp">
	              	<label><?php _e('Choisir un type de cagnotte','kotikota'); ?> <span>*</span></label>
	              	<div class="zone-beneficiaire">
				        <div class="zone-search">
				          		<div class="blc-menu">
					                <div class="menu-cagnotte"><?php _e('Types cagnottes','kotikota'); ?></div>             
					            </div>					            
					            <div class="menu-liste-cagnotte">
					            	<form class="form-type clr">
					            		<div class="lst-form-type clr">
					            			<div class="cosl">
                              <div class="offrir-cadeau">
                              		<!-- aleo tsy aseho alou ty catégorie be ty -->
                              		<!-- ####
                                  <h3 class="titre">
                                  	<?php $parent = get_categorie_cagnotte( $idCagnotte ); echo $parent['name']; ?>
                                  </h3>
                                	-->
                                  <div class="lst-type">
                                      <?php get_siblings_categories($idCagnotte) ?>     
                                  </div>
                              </div>
                          </div>
					            		</div>
					            	</form>
					            </div>
				        </div>
		      		</div>
		      	  </div>
	            </div>
	            
	            <div class="col"> 
	              <div class="blc-chp">
	                <label><?php _e('Date de début','kotikota'); ?> <span>*</span></label>
	                <?php
	                	$debu = strtotime( get_field('debut_cagnoote',$idCagnotte) );
										$newformatdeb = date('d-m-Y',$debu);									
	                ?>
	                <input type="text" name="debut" class="chp datepicker debut_cagnotte" id="datepicker_debut_param" value="<?php echo $newformatdeb; ?>" required
	                <?php if ( get_field('modif_debut', $idCagnotte) ) echo "disabled"; ?>
	                >
	              </div>
	            </div>
	            <div class="col">
	              <div class="blc-chp">
	                <label><?php _e('Date de fin','kotikota'); ?> <span>*</span></label>
	                <?php
	                	$time = strtotime( get_field('deadline_cagnoote',$idCagnotte) );
										$newformat = date('d-m-Y',$time);										
	                ?>
	                <input type="text" name="fin" class="chp datepicker deadline_cagnotte"
	                id="datepicker_fin_param" 
	                value="<?php echo $newformat; ?>" 
	                required
	                data-min="<?php echo $newformatdeb ?>"
	                <?php if ( get_field('modif_fin', $idCagnotte) ) echo "disabled"; ?>
	                >
	              </div>
	            </div>
	            <div class="blc-chp tip" style="text-align:center">
	            	<?php _e('Vous ne pouvez modifier les dates qu\'une seule fois, après quoi vous devrez contacter l\'administrateur pour pouvoir modifier à nouveau.','kotikota'); ?>
	            </div>

	            <div class="Info-principale clr">
	            	<div class="titre wow fadeIn" data-wow-delay="950ms" style="visibility: visible; animation-delay: 950ms; animation-name: fadeIn;">
		            	<h2><span><img src="http://kotikota.maki-group.mg/wp-content/themes/kotikota/assets/images/ico-information.png"></span><?php _e('Informations sur le bénéficiaire','kotikota'); ?> </h2>
		          	</div>
		          	<?php 
		          		$benef = get_beneficiaire_cagnotte( $idCagnotte );
		          		$info = get_beneficiaire_info( $benef->ID, $idCagnotte  );
		          	 ?>
		          	<div class="form clr">
		          		<div class="col">
		          			<div class="blc-chp">
				                <label><?php _e('Nom','kotikota'); ?><span>*</span></label>
				                <input type="text" name="nom" class="chp" id="nom" placeholder="<?php _e('Nom','kotikota'); ?>" required="" value="<?= $info->nom ?>">
				                <input type="hidden" name="benef" class="chp" id="benef" required="" value="<?= $benef->ID ?>">
				              </div>
		          		</div>
		          		<div class="col">
		          			<div class="blc-chp">
				                <label><?php _e('Prénom','kotikota'); ?><span>*</span></label>
				                <input type="text" name="prenom" class="chp" id="prenom" placeholder="<?php _e('Prénom','kotikota'); ?>" required="" value="<?= $info->prenom ?>">
				              </div>
		          		</div>

		          		<div class="col">
		          			<div class="blc-chp">
				                <label><?php _e('Email','kotikota'); ?><span>*</span></label>
				                <input type="email" name="email" class="chp" id="email" placeholder="<?php _e('Email','kotikota'); ?>" required="" value="<?= $info->email ?>">
				              </div>
		          		</div>
		          		<div class="col">
		          			<div class="blc-chp">
								<input type="hidden" value="<?= $info->code ?>" id="code" name="code">
				                <label><?php _e('Téléphone','kotikota'); ?><span>*</span></label>
				                <input type="tel" name="tel" class="chp" id="tel" pattern="[0-9]{9}" placeholder="xxxxxxxxx" required="" value="<?= $info->telephone ?>">
				            	<span id="valid-msg" class="hide">✓</span>
                      			<span id="error-msg" class="hide">✗</span>  
							</div>
		          		</div>

		          		<div class="blcFormulaire fichier wow fadeIn" data-wow-delay="1000ms" style="visibility: visible; animation-delay: 1000ms; animation-name: fadeIn;">
                            <label><?php _e('Ajouter un RIB','kotikota'); ?></label>
                           <!--  <div class="chp">
                                <div class="cont-file">
                                		<?php if( $info->rib == '' || $info->rib == 0 ): ?>
                                    	<span><?php _e('Aucun fichier sélectionné','kotikota'); ?></span>
                                  	<?php else: ?>
                                  		<span><?= get_the_title( $info->rib ) ?></span>
                                  	<?php endif; ?>
                                    <input type="text" name="file[]" class="input-file" id="rib_btn">
                                    <input type="hidden" name="" value="<?= $info->rib ?>" id="rib_value">
                                    <i> <?php _e('Parcourir','kotikota'); ?></i>
                                    <i class="reset" style="display: none"><?php _e('Supprimer','kotikota'); ?></i>
                                </div>
                                <div class="zone-img-rib"></div>
                            </div> -->
                            <div class="blc-rib">
                            	<input type="text" name="rib" class="chp" id="rib" placeholder="Aucun fichier" required="" value="">
                            	<a href="#pp-rib" class="link submit fancybox">Remplir le RIB du Bénéficiaire</a>
                            </div>

                            <div class="pp-rib" id="pp-rib" style="display: none">
                            	<div class="cont-rib cont-pp">
                            		<div class="titre"><h2>RIB du Bénéficiaire</h2></div>
                            		<div class="inner-pp">
                            			<form class="form-rib">
                            				<p>Vous êtes prié de renseigner le Relevé d’Identité Bancaire du bénéficiaire de votre cagnotte afin que nous puissions lui transférer le montant récupéré. </p>
                            				<p>Merci de compléter les informations suivantes :</p>
                            				<div class="formulaireParametre ">
                            					<div class="col col-100">
	                            					<div class="blc-chp">
	                            						<label>Titulaire du compte <span>*</span></label>
	                            						<input type="text" name="" placeholder="Votre nom" class="chp" id="rib_nom" value="<?= $info->rib_nom ?>">
	                            					</div>
                            					</div>
                            					<div class="col col-100">
                            						<div class="blc-chp">
	                            						<label>Banque</label>
	                            						<input type="text" name="" placeholder="Le nom de votre banque" class="chp" id="rib_bank" value="<?= $info->rib_banque ?>">
	                            					</div>
                            					</div>
                            					<div class="col col-100">
                            						<div class="blc-chp">
	                            						<label>Domiciliation bancaire</label>
	                            						<input type="text" name="" placeholder="Votre adresse de domiciliation" class="chp" id="rib_domicile" value="<?= $info->rib_adresse_de_domiciliation ?>">
	                            					</div>
                            					</div>
                            					<div class="col">
                            						<div class="blc-chp">
	                            						<label>Code Banque</label>
	                            						<input type="text" name="" placeholder="----" class="chp" id="rib_codebank" value="<?= $info->rib_code_banque ?>">
	                            					</div>
                            					</div>
                            					<div class="col">
                            						<div class="blc-chp">
	                            						<label>Code Guichet</label>
	                            						<input type="text" name="" placeholder="----" class="chp" id="rib_codeguichet" value="<?= $info->rib_code_agence ?>">
	                            					</div>
                            					</div>
                            					<div class="col col-70">
                            						<div class="blc-chp">
	                            						<label>Numéro de Compte</label>
	                            						<input type="text" name="" placeholder="-----------" class="chp" id="rib_numcompte" value="<?= $info->rib_num_de_compte ?>">
	                            					</div>
                            					</div>
                            					<div class="col col-30">
                            						<div class="blc-chp">
	                            						<label>Clé RIB</label>
	                            						<input type="text" name="" placeholder="--" class="chp" id="rib_cle" value="<?= $info->rib_cle_rib ?>">
	                            					</div>
                            					</div>

                            					<div class="col col-100">
                            						<div class="blc-chp">
	                            						<label>IBAN </label>
	                            						<input type="text" name="" placeholder="---- ---- ---- ---- ---- ---- ---" class="chp" id="rib_iban">
	                            					</div>
                            					</div>
                            					<div class="col col-100">
                            						<div class="blc-chp">
	                            						<label>BIC</label>
	                            						<input type="text" name="" placeholder="-----------" class="chp" id="rib_bic">
	                            					</div>
                            					</div>

                            					<div class="info-rib">
                            						<p>Pour assurer une double vérification, vous pouvez fournir une photo du RIB du bénéficiaire</p>
                            					</div>
                            					<div class="col col-100">
                            						<div class="blc-chp">
                            						<label><?php _e('Ajouter un RIB','kotikota'); ?></label>
						                            <div class="chpfile">
						                                <div class="cont-file">
						                                		<?php if( $info->rib == '' || $info->rib == 0 ): ?>
						                                    	<span><?php _e('Aucun fichier sélectionné','kotikota'); ?></span>
						                                  	<?php else: ?>
						                                  		<span><?= get_the_title( $info->rib ) ?></span>
						                                  	<?php endif; ?>
						                                    <input type="text" name="file[]" class="input-file" id="rib_btn">
						                                    <input type="hidden" name="" value="<?= $info->rib ?>" id="rib_value">
						                                    <i> <?php _e('Parcourir','kotikota'); ?></i>
						                                    <i class="reset" style="display: none"><?php _e('Supprimer','kotikota'); ?></i>
						                                </div>
						                                <div class="zone-img-rib"></div>
						                            </div>
						                            </div>
                            					</div>
                            					<div class="info-rib">
                            						<p>Pour assurer une double vérification, vous aSi vous souhaitez obtenir un transfert via Mobile Money, il faudra effectuer une demande spéciale à l’adresse hello@koti-kota.com en précisant le Nom de votre cagnotte, votre Identifiant Koti Kota (Profil), le montant à récupérer, votre numéro de téléphone ainsi qu’un justificatif d’identité (CIN, passeport,…)</p>
                            					</div>
                            					<div class="btn">
										           <a href="https://koti-kota.com/cagnotte/voyage-test/" class="link" title="annuler">annuler</a>
										           <input type="submit" name="" value="enregistrer" class="link submit" >
										        </div>
                            				</div>
                            			</form>
                            		</div>
                            	</div>
                            </div>

                        </div>
	            	</div>
		          	<div class="clear"></div>
		        </div>
	          </form>
	          <ul id="response"></ul>
	        </div>
	        <input type="hidden" id="idCagnotte" name="idCagnotte" value="<?php echo $idCagnotte ?>">              
	        <div class="btn wow fadeIn" data-wow-delay="950ms">
	          <a href="<?php echo get_permalink( $idCagnotte ) ?>" class="link" title="<?php _e('annuler','kotikota') ?>"><?php _e('annuler','kotikota') ?></a>
	           <a href="<?php echo get_site_url()?>/parametre-fond/" class="link submit" title="<?php _e('éTAPE SUIVANTE','kotikota') ?>" id="submit-info-principale"><?php _e('éTAPE SUIVANTE','kotikota') ?></a>
	        </div>

				</div>
			</div>	
			

			<div id="loader">
			  <img src="<?php echo IMG_URL.'loader.gif' ?>" alt="loader">
			</div>

		</main>

<?php
	get_footer();
	else:
		wp_redirect(get_permalink( get_page_by_path( 'toutes-les-cagnottes' ) ) );
		exit;
	endif;
?>
