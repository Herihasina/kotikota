<?php
	/* *
	*Template Name: Gestion Mot doux
	*/

  if ( array_key_exists("gest", $_GET) )
    $id_cagnotte = strip_tags($_GET['gest']);

  if ( !is_cagnotte( $id_cagnotte ) )
    die(__('Cette ID ne correspond à votre cagnotte :)','kotikota') );

if ( (is_user_logged_in() && get_field('titulaire_de_la_cagnotte', $id_cagnotte )  == get_current_user_id() ) || current_user_can('administrator') ):
  $active = "message";
	get_header();
 ?>
 <main id="homepage">
 <?php
	include 'sections/content/parallax.php';
?>

  <div class="gestion-cagnotte message message2">
    <div class="wrapper">
        <!-- Menu    -->
        <?php 
          include 'sections/parametres/menu-gestion.php';

          $mot_doux = get_field('mot_doux', $id_cagnotte);
        ?>

        <div class="titre wow fadeIn" data-wow-delay="900ms">
          <h2><span><img src="<?php echo IMG_URL ?>message2.png"></span>
            <?php _e('Messages','kotikota') ?> 
            <b>
              <?php 
                if (is_array($mot_doux) ){ 
                  echo ' ('.count($mot_doux).')';
                }else{ 
                  echo ' (0)';
                } ?>
            </b>
          </h2>
        </div>

        <div class="liste-message wow fadeIn" data-wow-delay="950ms" id="relative">
            <div class="s-titre">
              <h3>
                <img src="<?php echo IMG_URL ?>ico-cagnotte1.png">
                <span><?php _e('cagnotte Organisée par :','kotikota'); ?> </span>
                    <?php 
                        $user = get_user_meta( get_field('titulaire_de_la_cagnotte', $id_cagnotte) );
                        if ( $user['first_name'][0] != '' || $user['last_name'][0] != '' ){
                          echo $user['first_name'][0].' '.$user['last_name'][0]; 
                        }else{
                          echo $user['nickname'][0];
                        }
                    ?>
              </h3>
            </div>

            <div class="lst-msg">
                <?php
                  if ( $mot_doux ):
                    foreach ( $mot_doux as $mot_dou ):
                      $user_data = get_user_meta($mot_dou->post_author);
                ?>
                <div class="item">
                  <div class="content">
                      <div class="profil">
                    <?php
                          $bg = wp_get_attachment_image_src(get_field('photo', 'user_'.$mot_dou->post_author),'icone-serasera' )[0];
                                            if ( !$bg ) $bg = get_field('default_gravatar','option'); ?>
                                             <img src="<?php echo $bg ?>" alt="" > 
                      </div>
                  
                  <!-- <div class="profil"><img src="images/profil2.jpg"></div> -->
                    <div class="txt">
                      <h4>
                        <?php
                          if ( $user_data['first_name'][0] != '' || $user_data['last_name'][0] != '' ){
                              echo $user_data['first_name'][0].' '.$user_data['last_name'][0]; 
                            }else{
                              echo $user_data['nickname'][0];
                            }
                        ?>
                      </h4>
                      <?php 
                        $date = new DateTime($mot_dou->post_date);     
                        $date = remplace_mois_($date->format('d M Y'));                               
                      ?>
                      <span class="date"><?php echo sprintf( __('Le %s', 'kotikota'), $date ); ?></span>
                      <p><?php echo $mot_dou->post_content; ?></p>
                    </div>
                  </div>
                  <div class="delete">
                    <a href="#" title="" data-delete="<?php echo $mot_dou->ID ?>">
                      <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24" fill="#00f"><path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path></svg>
                    </a>
                  </div>
                </div>

              <?php 
              endforeach; 
              else:
                ?>
                <div class="cont-message wow fadeIn" data-wow-delay="900ms">
                  <div class="ico"><img src="<?php echo IMG_URL ?>message1.png"></div>
                  <p><?php _e('Il n’y a pas encore de mots doux','kotikota') ?></p>
                  <div class="btn wow fadeIn" data-wow-delay="950ms">
                    <a name="" class="link submit" value="relancer" href="<?php echo get_permalink( get_page_by_path('gestion-cagnotte-invite') ) ?>">
                      <?php _e('Relancer','kotikota'); ?>
                    </a>
                  </div>
                </div>
              <?php
              endif; ?>
            </div>
            <!-- pagination eto -->
            <?php
              $uri = $_SERVER['REQUEST_URI'];
              kotikota_pagination($uri);
            ?>
        </div>
        <ul id="response"></ul>
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