<?php 
	/*
	Template Name: participer
	*/

  if( isset($_GET['part'] ) && !empty( $_GET['part'] ) ){
	 $id_cagnotte = strip_tags( $_GET['part'] );
   $id = $id_cagnotte;
  }else{
    wp_die( 'Erreur! !!!' );
  }

  if( !get_field('actif', $id_cagnotte) ) wp_die( __('Participation impossible','kotikota'), 'Lien direct' );

	if ( get_post_type( $id_cagnotte ) == "cagnotte" ||  get_post_type( $id_cagnotte ) == "cagnotte-perso" ): 
  $user = wp_get_current_user();
  if ( $user )
    $user_data = get_user_meta($user->ID);
  
	get_header();
?>
<main id="homepage">
<?php
	include 'sections/content/parallax.php';
?>

<div class="blc-cagnotte-participation">
  <div class="wrapper">
    <form class="participation">
        <div class="fom-participe">
            <div class="titre wow fadeIn" data-wow-delay="800ms">
               <h2><span><img src="<?php echo IMG_URL ?>identite.png"></span> <?php echo __('Votre identité', 'kotikota'); ?></h2>
            </div>
            <div class="formulaire clr wow fadeIn" data-wow-delay="900ms">
              <div class="col">
                  <div class=" blc-chp ">
                      <label for="fname"><?php echo __('Prénom','kotikota'); ?><span>*</span></label>
                      <div class="chp">
                        <input type="text" name="fname" id="fname" placeholder="<?php echo __('Indiquez votre prénom','kotikota'); ?>" required
                          value="<?php echo $user_data['first_name'][0]; ?>">
                      </div>
                  </div>
              </div>
              <div class="col">
                  <div class=" blc-chp">
                      <label for="lname"><?php echo __('Nom', 'kotikota'); ?> <span>*</span></label>
                      <div class="chp">
                        <input type="text" name="lname" id="lname" placeholder="<?php echo __('Indiquez votre nom','kotikota'); ?>" required
                          value="<?php echo $user_data['last_name'][0]; ?>">
                        
                      </div>
                  </div>
              </div>
              <div class="col ">
                  <div class="blc-chp">
                      <label for="mail"><?php echo __('E-mail', 'kotikota'); ?> <span>*</span></label>
                      <div class="chp">
                        <input type="email" name="mail" id="mail" placeholder="<?php echo __('Indiquez votre adresse mail','kotikota'); ?>" required
                          value="<?php echo $user->data->user_email; ?>">
                        
                      </div>
                  </div>
              </div>
              <div class="col ">
                  <div class="blc-chp relative">
                  <input type="hidden" value="<?php echo $user_data['code'][0]; ?>" id="code" name="code">
                      <label for="phone"><?php echo __('Téléphone', 'kotikota'); ?> <span>*</span></label>
                      <input type="tel" name="phone" id="phone" class="chp" required pattern="[0-9]{9}" value="<?php echo $user_data['numero_de_telephone'][0]; ?>" placeholder="">
                      <span id="valid-msg" class="hide">✓</span>
                      <span id="error-msg" class="hide">✗</span>
                  </div>
              </div>
            </div>             
        </div>

        <div class="fom-participe">
            <div class="titre wow fadeIn" data-wow-delay="850ms">
                <h2><span><img src="<?php echo IMG_URL ?>participation.png"></span><?php echo __('Votre participation', 'kotikota'); ?></h2>
            </div>
            <div class="formulaire clr wow fadeIn" data-wow-delay="900ms">
              <div class="col100">
                  <div class=" blc-chp participe">
                      <?php 
                        $deviseB = get_field('devise', $id ); 
                        $devise = $deviseB['value'];
                      ?>
                      <label for="donation"><?php echo __('Ma participation', 'kotikota'); ?> <span>*</span></label>
                      <div class="chp">
                        <input type="number" name="donation" id="donation" placeholder="Saisissez un montant" required>
                        <select class="input-select appended-select" id="choix-devise" style="background: none !important;">
                          <option value="mga" <?php if ($devise == 'mga') echo "selected"; ?>>Ar</option>
                          <option value="eu" <?php if ($devise == 'eu') echo "selected"; ?>>€</option>
                          <option value="liv" <?php if ($devise == 'liv') echo "selected"; ?>>£</option>
                          <option value="cad" <?php if ($devise == 'liv') echo "selected"; ?>>CAD</option>
                          <option value="usd" <?php if ($devise == 'liv') echo "selected"; ?>>USD</option>
                        </select>
                      </div>
                      <div class="tip change-texte">
                        
                      </div>
                      <!-- <div class="tip">
                        Pour un paiement via Paypal, sélectionner la devise Euro (€).
                      </div> -->
                          <?php if ( get_field('montant_suggere', $id ) != 0 && get_field('condition_de_participation', $id ) == "conseille" ): ?>
                      		<span class="montant"> 
                            <?php echo __('Montant minimum conseillé : ', 'kotikota');  
                            
                              $devise_lbl = $deviseB['label'];                             
                              echo "<span id='span_montant' class='format_chiffre'>".get_field('montant_suggere', $id ).'</span> <span id="span_devise">'.$devise_lbl.'</span>' ?>
                          </span>
                          <?php elseif ( get_field('montant_suggere', $id ) != 0 && get_field('condition_de_participation', $id ) == "fixe" ): ?>
                      		<span class="montant"> 
                            <?php echo __('Montant minimum imposé : ', 'kotikota');  
                            
                              $devise_lbl = $deviseB['label'];                             
                              echo "<span id='span_montant' class='format_chiffre'>".get_field('montant_suggere', $id ).'</span> <span id="span_devise">'.$devise_lbl.'</span>' ?>
                          </span>
                          <?php endif; ?>
                        <input type="hidden" name="condition" id="condition" value="<?php echo get_field('condition_de_participation', $id ); ?>">
                  </div>
              </div>
              <div class="col100">
                <div class="blc-check">
                  <div class="option">
                    <ul>
                       <li class="chp">
                          <!--input id="masque1" type="checkbox"-->
                          <label for="masque1"><?php echo __('Masquer mon identité auprès des autres participants','kotikota'); ?></label>
                          <div class="check"></div>
                          <div class="on-off">
                            <input type="checkbox" class="onoff" id="masque1">
                            <label for="masque1"><span>on</span></label>
                          </div>


                        </li>
                        <li class="chp">
                          <!--input id="masque2" type="checkbox"-->
                          <label for="masque2"><?php echo __('Masquer le montant de ma participation auprès des autres participants','kotikota'); ?></label>
                          <div class="check"></div>

                          <div class="on-off">
                            <input type="checkbox" class="onoff" id="masque2">
                            <label for="masque2"><span>on</span></label>
                          </div>


                        </li>
                    </ul>
                  </div>
                </div>
              </div>

            </div>             
        </div>

        <div class="fom-participe">
            <div class="titre">
                <h2><span><img src="<?php echo IMG_URL ?>message3.png"></span><?php echo __('Votre message', 'kotikota'); ?></h2>
            </div>
            <?php if ( is_user_logged_in() ){ ?>
              <div class="formulaire fix-bloc">
                <div class=" blc-chp">
                    <label for="message"><?php echo __('Laisser un petit mot doux pour la cagnotte', 'kotikota'); ?> <span>*</span></label>
                    <textarea id="message" class="chp-txtarea" placeholder="<?php echo __('Votre message', 'kotikota'); ?>" required></textarea>
                </div>
              </div>
            <?php 
             } else{ 
            ?>
            <div class="blc-liste-cagnote force-login">
                <div class="lst-cagnotte-publique wow fadeIn clr">
                    <h3 style="text-align:center">
                        <?php _e('Vous devez vous authentifier pour pouvoir laisser un message!','kotikota'); ?>
                    </h3>
                </div>
            </div>
          <?php } ?>
        </div>

         <div class="fom-participe wow fadeIn" data-wow-delay="950ms">
            <div class="titre">
                <h2><span><img src="<?php echo IMG_URL ?>mode-paiement.png"></span><?php echo __('Votre mode de paiement', 'kotikota'); ?></h2>
            </div>
            <div class="formulaire clr">
              <div class="col100">
                  <div class=" blc-chp blc-radio">
                      <h3><?php echo __('Mobile money','kotikota'); ?></h3>
                      <div class="option">
                        <ul class="clr">
                          <li>
                            <input id="mvola" name="selector" checked="" type="radio" value="telma">
                            <label for="mvola"><img src="<?php echo IMG_URL ?>mvola2.png"></label>
                            <div class="check"></div>
                          </li>
                          <li>
                            <input id="orangemoney" name="selector" type="radio" value="orange">
                            <label for="orangemoney"><img src="<?php echo IMG_URL ?>OM.png"></label>
                            <div class="check"></div>
                          </li>
                           <li>
                            <input id="airtel" name="selector" type="radio" value="airtel">
                            <label for="airtel"><img src="<?php echo IMG_URL ?>airtel2.png"></label>
                            <div class="check"></div>
                          </li>
                        </ul>
                      </div>
                  </div>
              </div>
              <div class="col100 ">
                  <div class=" blc-chp blc-radio">
                      <h3>
                        <?php echo __('Dépôt bancaire','kotikota');?>,
	                      <br><?php echo __('Virement bancaire','kotikota');?>
                      </h3>
                      <div class="option">
                        <ul class="clr">

                          <!--<li>
                            <input id="boa" name="selector" checked type="radio">

                           <li>
                            <input id="boa" name="selector" checked="" type="radio" value="boa">
>>>>>>> 16954a9cce674c75db63f8bfbf8082f84ddfd849
                            <label for="boa"><img src="<?php echo IMG_URL ?>boa2.png"></label>
                            <div class="check"></div>
                          </li> -->
                         <!--  <li>
                            <input id="bni" name="selector" type="radio" value="bni">
                            <label for="bni"><img src="<?php echo IMG_URL ?>bni2.png"></label>
                            <div class="check"></div>
                          </li> -->
                           <li>
                            <input id="visa" name="selector" type="radio" value="visa">
                            <label for="visa"><img src="<?php echo IMG_URL ?>visa.png"><img src="<?php echo IMG_URL ?>master-card.png"></label>
                            <div class="check"></div>
                          </li>
                          <li class="blc-securise">
                            <div class="securise"><span><?= __('sécurisé par BNI','kotikota') ?></span><img src="<?php echo IMG_URL ?>bni2.png"></div>
                          </li>
                          <!-- <li>
                            <input id="bmoi" name="selector" type="radio" value="bmoi">
                            <label for="bmoi"><img src="<?php echo IMG_URL ?>bmoi2.png"></label>
                            <div class="check"></div>
                          </li>
                          <li>
                            <input id="bfv" name="selector" type="radio" value="bfv">
                            <label for="bfv"><img src="<?php echo IMG_URL ?>bfv2.png"></label>
                            <div class="check"></div>
                          </li> -->
                        </ul>
                      </div>
                  </div>
              </div>
         <!--      <div class="col100 ">
                  <div class=" blc-chp blc-radio">
                      <h3>
                      <?php echo __('Paypal','kotikota');?>,
	                      <br><?php echo __('Virement<br>international','kotikota');?></h3>
                      <div class="option">
                        <ul class="clr">
                          <li>
                            <input id="paypal" name="selector" checked="" type="radio" value="paypal">
                            <label for="paypal"><img src="<?php echo IMG_URL ?>paypal2.png"></label>
                            <div class="check"></div>
                          </li>
                        
                        </ul>
                      </div>  
                  </div>
              </div> --> 
              <div class="col100">
                <div class="blc-chp acc">
                  <label><input type="checkbox" name="accord" id="accord">
                    <?php
                      printf( __('En participant à la cagnotte vous acceptez les %1s et la %2s','kotikota'), '<a href="'.home_url('/cgu/').'" title="">CGU</a>', '<a href="'.home_url('/politique-de-confidentialite/') .'">'.__('politique de confidentialité','kotikota').'</a>' )
                    ?>
                  </label>
                </div>
              </div>
            </div>
            <ul id="response"></ul>
        </div>
        <input type="hidden" name="" id="change-mga-eu" value="<?php echo get_field('change_mga_eu','options'); ?>">
        <input type="hidden" name="" id="change-mga-liv" value="<?php echo get_field('change_mga_liv','options'); ?>">
        <input type="hidden" name="" id="change-mga-usd" value="<?php echo get_field('change_mga_usd','options'); ?>">
        <input type="hidden" name="" id="change-mga-cad" value="<?php echo get_field('change_mga_cad','options'); ?>">
        <div class="btn">
        <?php //echo do_shortcode( '[wp_paypal button="buynow" name="My product" amount="1.00"]' ) ?>
          <a href="#" onclick="window.history.back();" class="link" title="<?= __('Annuler','kotikota') ?>"><?= __('Annuler','kotikota') ?></a>
          <input type="hidden" name="id_cagnotte" value="<?php echo $id_cagnotte; ?>">          
          <input type="submit" name="" value="<?= __('Valider','kotikota') ?>" id="creer-participation" class="link submit" >
        </div>
    </form>

  </div>
</div>
<div id="loader">
  <img src="<?php echo IMG_URL.'loader.gif' ?>" alt="loader">
</div>
</main>
<a href="#popup_airtel" id="popup_airtel_trig" class="fancybox_conf" data-fancybox="" title="" style="display: none;">X</a>
<a href="#popup_bni" id="popup_bni_trig" class="fancybox_conf" data-fancybox="" title="" style="display: none;">X</a>
<div id="popup_airtel" style="display: none">
    <div class="content form-participe">
        <div class="conf_titre"><?= __('Paiement par Airtel Money','kotikota') ?></div>
        <div class="conf_text">
          <p>
            <?= __('Vous avez choisi le mode de paiement Airtel Money, veuillez confirmer votre numéro Airtel pour la transaction.','kotikota') ?>
          </p>
          <div class="output-normal">
            <form id="airtelinput" class="formulaire" action="pay_airtel">
              <input type="hidden" name="all_datas" value="">
              <div class="chp">
                <input type="text" name="num_airtel">
              </div>            
              <input type="submit" name="submit_airtel" id="pay_airtel" value="Valider" class="link submit">
            </form>
          </div>
          <div class="output-response" style="display: none;">
            <p><?= __('Vous allez recevoir une demande de confirmation de code secret sur votre téléphone pour valider votre don','kotikota') ?>.</p>
          </div>
        </div>
    </div>
</div>

<?php get_footer();
	else:
		wp_redirect(get_permalink( get_page_by_path( 'toutes-les-cagnottes' ) ) );
		exit;
	endif;
?>
