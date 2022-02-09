<?php
	// Template name: info notif
	
	if ( array_key_exists("parametre", $_GET) )
    $idCagnotte = strip_tags($_GET['parametre']);

  if ( !is_cagnotte( $idCagnotte ) )
    die( __('Cette ID ne correspond à votre cagnotte :)','kotikota') );

	if ( (is_user_logged_in() && get_field('titulaire_de_la_cagnotte', $idCagnotte )  == get_current_user_id() ) || current_user_can('administrator') ):
		
		$active = "notif";
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
					
					<div class="titre wow fadeIn" data-wow-delay="950ms">
            <h2><span><img src="<?php echo IMG_URL ?>ico-notification.png"></span><?php _e('Je personnalise les notifications','kotikota'); ?></h2>
          </div>
           <div class="notification wow fadeIn" data-wow-delay="950ms">
               <div class=" blc-check">
                  <div class="option">
                    <ul class="clr">
                      <li class="col chp">
                        <input id="recevoir" name="recevoir" type="checkbox">
                        <label for="recevoir"><?php _e('Recevoir les notifications de <br> participation par e-mail','kotikota'); ?></label>
                        <div class="check"></div>
                      </li>
                      <li class="col chp">
                        <input id="notifie" name="notifie" type="checkbox">
                        <label for="notifie"><?php _e('Notifier les participants lors de la dépense <br>de la cagnotte','kotikota'); ?></label>
                        <div class="check"></div>
                      </li> 
                    </ul>
                  </div>  
            </div>
          </div>
          	<ul id="response"></ul>
	        <div class="btn wow fadeIn" data-wow-delay="950ms">
	          <a href="<?php echo get_permalink( $idCagnotte ) ?>" class="link" title="<?php _e('annuler','kotikota') ?>"><?php _e('Annuler','kotikota') ?></a>
	           <a href="<?php echo get_permalink( $idCagnotte)?>" class="link submit" title="Valider" id="submit-parametre"><?php _e('Valider','kotikota') ?></a>
	        </div>

				</div>
			</div>
			<input type="hidden" id="idCagnotte" name="idCagnotte" value="<?php echo $idCagnotte ?>">
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
