<?php
	/* *
	*Template Name: Gestion Participation
	*/

  if ( array_key_exists("gest", $_GET) )
    $id_cagnotte = strip_tags($_GET['gest']);
  elseif( array_key_exists("origin", $_GET) && trim( $_GET['origin'] ) == 'post-setup' && array_key_exists("gest", $_GET) )
    $idCagnotte = strip_tags($_GET['gest']);
  
  if ( !is_cagnotte( $id_cagnotte ) )
    die('Cette ID ne correspond à votre cagnotte :)');

if ( (is_user_logged_in() && get_field('titulaire_de_la_cagnotte', $id_cagnotte )  == get_current_user_id() ) || current_user_can('administrator') ):
  $active = "participation";
	get_header();
 ?>
 <main id="homepage">
 <?php
	include 'sections/content/parallax.php';
?>

  <div class="gestion-cagnotte message message2">
    <div class="wrapper">
        <!-- Menu    -->
        <?php include 'sections/parametres/menu-gestion.php'; ?>

        <?php
          $participants = get_field('tous_les_participants', $id_cagnotte);
          if ( !$participants ) {
            $participants = [];
          }
        ?>

        <div class="titre participation wow fadeIn" data-wow-delay="900ms">
          <h2><span><img src="<?php echo IMG_URL ?>ico-liste.jpg"></span> <?php _e('Liste des participants','kotikota'); ?><b> <?php echo '('.count($participants).')' ?> </b></h2>
        </div>

        <?php if ( count($participants) > 0 ): ?>
        <div class="liste-participation wow fadeIn" data-wow-delay="950ms" id="relative">
          <div class="lst-msg participation clr">

          <?php 
          foreach ( $participants as $participant ):
              $id_participant = $participant['participant_']->ID;
              $email_participant = $participant['participant_']->email_participant;
          ?>
              <!-- item -->
              <div class="item">
                <div class="content">
                  <div class="profil">
                    <?php if ( email_exists( $email_participant ) ){
                                $user = get_user_by( 'email', $email_participant );
                                $user = $user->data->ID;
                                $bg = wp_get_attachment_image_src(get_field('photo', 'user_'.$user),'icone-serasera' )[0];
                                            if ( !$bg ) $bg = get_field('default_gravatar','option'); ?>
                                             <img src="<?php echo $bg ?>" alt="" >                         
                     
                            <?php }else{ ?>
                              <img src="<?php echo get_field('default_gravatar','options') ?>" alt="<?php echo esc_html( $participant['participant_']->post_title ); ?>">
                            <?php 
                                                                               
                            } ?>
                  </div>
                  <div class="txt">
                    <h4>
                      <?php echo esc_html( get_field('prenom_participant', $id_participant) ).' '. esc_html( get_field('nom_participant', $id_participant) ); ?>
                    </h4>
                    <p>a participé</p>
                    <?php
                      $cagnottes_participees = get_field('toutes_cagnottes_participees', $id_participant);
                    ?>
                    <?php
                        if ( $cagnottes_participees ):
                        foreach ($cagnottes_participees as $une_cagnotte){
                          if ( $une_cagnotte['cagnotte']->ID == $id_cagnotte ){
                      ?>
                            <p><?php echo "<span class='format_chiffre'>".$une_cagnotte['montant_paye'].'</span> '. get_field('devise',$id_cagnotte)['label'] ?></p>
                          <?php } ?>
                    <?php }
                    endif; ?>
                  </div>
                </div>
              </div>
              <!-- /item -->
            <?php endforeach; ?>
          </div>
        </div>
        <?php
            $uri = $_SERVER['REQUEST_URI'];
            kotikota_pagination($uri);
        ?>
        <?php else: ?>
          <div class="cont-message wow fadeIn" data-wow-delay="900ms">
          <div class="ico"><img src="<?php echo IMG_URL ?>ico-login2.png"></div>
          <p><?php _e('Il n’y a pas encore de participants','kotikota') ?></p>
          <div class="btn wow fadeIn" data-wow-delay="950ms">
            <input type="submit" name="" class="link submit" value="<?= __('relancer','kotikota') ?>">
          </div>
        </div>
        <?php endif; ?>
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