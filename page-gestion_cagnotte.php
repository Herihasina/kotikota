<?php
	/* *
	*Template Name: GestionCagnotte
	*/

  if ( array_key_exists("gest", $_GET) )
    $id_cagnotte = strip_tags($_GET['gest']);

  if ( !is_cagnotte( $id_cagnotte ) )
    die(__('Cette ID ne correspond à votre cagnotte :)','kotikota') );

if ( (is_user_logged_in() && get_field('titulaire_de_la_cagnotte', $id_cagnotte )  == get_current_user_id() ) || current_user_can('administrator')):
  $active = "invitation";
	get_header();
 ?>
 <main id="homepage">
 <?php
	include 'sections/content/parallax.php';
?>

<div class="gestion-cagnotte">
  <div class="wrapper">
      <!-- Menu    -->
      <?php include 'sections/parametres/menu-gestion.php'; ?>

      <div class="invitation">
        <div class="titre wow fadeIn" data-wow-delay="900ms">
          <h2><span><img src="<?php echo IMG_URL ?>ico-invite2.png"></span><?php _e('Invitez vos amis par message','kotikota'); ?></h2>
        </div>
        <div class="liste-invitation clr wow fadeIn" data-wow-delay="950ms">
          <ul class="clr">
              <li class="whatsapp"><a href="https://wa.me/?text=<?php echo get_permalink($id_cagnotte) ?>?origin=invite" title="whatsapp" target="_blank"><?php _e('whatsapp','kotikota'); ?></a></li>
              <li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink($id_cagnotte); ?>?origin=invite" title="Facebook" target="_blank"><?php _e('facebook','kotikota'); ?></a></li>
              <li class="twitter"><a class="twitter-share-button" href="https://twitter.com/intent/tweet?text=<?php echo urlencode( get_the_title( $id_cagnotte )) ?>?origin=invite" data-size="large" title="Twitter" target="_blank"><?php _e('twitter','kotikota'); ?></a></li>
          </ul>
        </div>
        <div class="titre link-cagnotte wow fadeIn">
          <h2><span><img src="<?php echo IMG_URL ?>icon-link.png"></span><?= __('Lien de votre cagnotte','koikota'); ?></h2>
        </div>

        <div class="chp-lien wow fadeIn" data-wow-delay="950ms">
          <div class="blc-chp">
            <div class="chp">
              <input type="text" name="" placeholder="<?php printf(__('Lien de votre cagnotte.Exemple : %s','kotikota'), get_permalink($id_cagnotte) ) ?>" value="<?php echo get_permalink($id_cagnotte) ?>" readonly>
            </div>
          </div>
        </div>
        <div class="invitation-mail wow fadeIn" data-wow-delay="950ms">
          <div class="titre">
            <h2><span><img src="<?php echo IMG_URL ?>ico-invite-mail.png"></span><?php _e('Invitez vos amis par e-mail','kotikota'); ?></h2>
          </div>
          <?php
            $sents = get_field('invitations', $id_cagnotte);
            if ( is_array($sents) ): // raha efa nandefa invitation ihany vo misy anty
              $invitations = array();
              foreach($sents as $sent ){
                $invitations[] = get_the_title($sent);
              }
              $invitations = array_unique($invitations);
              $participants= get_field('tous_les_participants', $id_cagnotte);
              $ont_deja_participe = array();
              $ont_pas_encore_participe = array();

              if ( is_array($participants) ){
                foreach( $participants as $k => $participant ){ 
                  $email_participant = get_field('email_participant', $participant['participant_']->ID);
                  if ( false !== $key = array_search($email_participant, $invitations) ){
                    $ont_deja_participe[] = $participant;
                    unset( $invitations[$key]);
                  }
                }
              }
              ?>
                <div class="list_invite">
                  <?php if ( count($ont_deja_participe) ): ?>
                    <div class="titre">
                      <h3><?= __('Ceux qui ont répondu à votre précédente invitation','kotikota') ?> :</h3>
                      <ul class="ont_participe">
                        <?php foreach ($ont_deja_participe as $key => $value) {
                          ?>
                          <li><?= get_field('email_participant', $value['participant_']->ID); ?></li>
                          <?php
                        } ?>
                      </ul>
                    </div>
                  <?php endif; ?>
                  <div class="titre">
                    <h3><?= __("Ceux qui n'ont pas encore répondu à votre précédente invitation",'kotikota') ?> :</h3>
                    <form>
                    <ul class="ont_pas_pariticipe">
                      <?php foreach ($invitations as $key => $value) {
                        ?>
                          <li>
                            <label>
                              <input type="checkbox" name="relance[]" value="<?= $value ?>">
                              <span><?= $value ?></span>
                            </label>
                          </li>
                        <?php
                      } ?>
                    </ul>
                    <input type="submit" name="" id="relance_auto" class="link submit" value="<?php _e('Relancer les invités','kotikota'); ?>">
                    </form>
                  </div>
                </div>
              <?php
            endif;
          ?>
          <div class="blc-chp">
            <div class="chp">
              <!-- <div class="tip"><?= __("saisir un email + touche entrée",'kotikota') ?></div> -->
              <!-- <textarea placeholder="Votre / vos adresse(s) e-mail.Exemple : johndoe@gmail.com;loremipsum@gmail.com" id="emails_list"></textarea> -->
              <input type="text" id="emails_list" name="" placeholder="<?= __("saisir un email + touche entrée",'kotikota') ?>">
            </div>
          </div>
          
            <div class="tip">
              * Appuyez sur la touche Entrée pour valider et en ajouter une autre
            </div>
          
          <div class="info clr">
            <!-- <a href="#" title="Importer mes contacts">Importer mes contacts</a> -->
            <span><?= __("Nombre d'invitations restantes",'kotikota') ?> : <b id="compt">100</b> / 100</span>
          </div>
        </div>
        <ul id="response"></ul>
        <div class="btn wow fadeIn" data-wow-delay="950ms">
          <input type="hidden" id="idCagnotte" name="idCagnotte" value="<?php echo $id_cagnotte ?>">
          <a href="<?php echo get_permalink( $id_cagnotte ) ?>" class="link" title="<?php _e('Annuler','kotikota'); ?>"><?php _e('Annuler','kotikota'); ?></a>
          <input type="submit" id="invite_email" name="" class="link submit" data-source="gestion-invite" value="<?php _e('Valider','kotikota'); ?>">
        </div>
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
