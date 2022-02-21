<?php
	// Template name: info montant
	
  if ( array_key_exists("parametre", $_GET) )
    $idCagnotte = strip_tags($_GET['parametre']);

  if ( !is_cagnotte( $idCagnotte ) )
    die( __('Cette ID ne correspond à votre cagnotte :)','kotikota') );

	if ( (is_user_logged_in() && get_field('titulaire_de_la_cagnotte', $idCagnotte )  == get_current_user_id() ) || current_user_can('administrator')  ):
		
		$active = "montant";
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
            <h2><span><img src="<?php echo IMG_URL ?>ico-montant.png"></span><?php _e('Je personnalise le montant','kotikota'); ?></h2>
          </div>
          <div class="formulaireParametre montant clr wow fadeIn" data-wow-delay="950ms">
            <form>
              <div class="col coll">
                <div class="blc-chp">
                  <label><?php _e('Montant à atteindre', 'kotikota'); ?></label>
                  <input type="text" name="montant" class="chp" id="ilaina" value="<?php echo get_field('objectif_montant', $idCagnotte) ?>">
                  <div class="on-off">
                      <input type="checkbox" class="onoff" id="onoff">
                      <label for="onoff"><span>on</span></label>
                  </div>

                </div>
              </div>
            <!--   <div class="col">
                <div class="blc-chp">
                   <div class="blc-check">
                      <div class="option">
                        <ul>
                           <li class="chp">
                              <input id="masque1"  type="checkbox"<?php if ( get_field('masquer_azo_ilaina', $idCagnotte) ) echo " checked"; ?>>
                              <label for="masque1"><?php _e('Masquer montant à atteindre/montant collecté','kotikota'); ?></label>
                              <div class="check"></div>
                            </li>
                        
                        </ul>
                      </div>
                    </div>
                  
                </div>
              </div> -->
              <div class="col">
                <div class="blc-chp">
                  <label><?php _e('Suggérer un montant de don','kotikota'); ?></label>
                  <input type="text" name="montantdon" class="chp" id="suggere" value="<?php echo get_field('montant_suggere', $idCagnotte) ?>">

                  <div class="on-off">
                      <input type="checkbox" class="onoff" id="onoff1">
                      <label for="onoff1"><span>on</span></label>
                  </div>

                </div>
              </div>
          <!--     <div class="col">
                <div class="blc-chp">   
                   <div class="blc-check">
                      <div class="option">
                        <ul>
                           <li class="chp">
                              <input id="masque2" type="checkbox"<?php if ( get_field('masquer_toutes_les_contributions', $idCagnotte) ) echo " checked"; ?>>
                              <label for="masque2"><?php _e('Masquer toutes les contributions','kotikota'); ?></label>
                              <div class="check"></div>
                            </li>
                        
                        </ul>
                      </div>
                    </div>
                </div>
              </div>
 -->
               <div class="col">
                <div class="blc-chp">
                   <label><?php _e('Devise','kotikota'); ?></label>
                   <?php
                    $devise = get_field('devise', $idCagnotte);
                    $devise = $devise['value'];
                   ?>
                   <select id="devise" disabled style="background: none !important;">
                      <option value="mga" <?php if ($devise == 'mga') echo "selected"; ?>>ARIARY (Ar)</option>
                      <!-- <option value="eu" <?php if ($devise == 'eu') echo "selected"; ?>>EURO (€)</option> -->
                      <!-- <option value="liv" <?php if ($devise == 'liv') echo "selected"; ?>>LIVRE (£)</option>                      -->
                   </select>

                  <div class="on-off">
                      <input type="checkbox" class="onoff" id="onoff2">
                      <label for="onoff2"><span>on</span></label>
                  </div>

                </div>
              </div>
            <!--   <div class="col">
                <div class="blc-chp">
                   <div class="blc-check">
                      <div class="option">
                        <ul>
                           <li class="chp">
                              <input id="masque3" type="checkbox"<?php if ( get_field('masquer_le_montant_de_la_contribution', $idCagnotte) ) echo " checked"; ?>>
                              <label for="masque3"><?php _e('Masquer le montant de la contribution','kotikota'); ?></label>
                              <div class="check"></div>
                            </li>
                        
                        </ul>
                      </div>
                    </div>
                </div>
              </div> -->

            </form>
          </div>
          <input type="hidden" id="idCagnotte" name="idCagnotte" value="<?php echo $idCagnotte ?>">
          <ul id="response"></ul>
	        <div class="btn wow fadeIn" data-wow-delay="950ms">
	          <a href="<?php echo get_permalink( $idCagnotte ) ?>" class="link" title="<?php _e('annuler','kotikota') ?>"><?php _e('annuler','kotikota') ?></a>
	           <a href="<?php echo get_site_url()?>/parametre-notification/" class="link submit" title="<?php _e('éTAPE SUIVANTE','kotikota') ?>" id="submit-montant"><?php _e('éTAPE SUIVANTE','kotikota') ?></a>
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
