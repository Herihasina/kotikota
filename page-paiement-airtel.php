<?php
	// Template name: Paiement Airtel Money 
	
	if ( ( !isset($_GET['id']) && empty( $_GET['id'] ) ) || ( !isset($_GET['cl']) && empty( $_GET['cl'] ) ) ){
    wp_redirect( '/' );
    exit();
  }

  add_filter( 'http_request_args', function( $params, $url )
    {

    add_filter( 'https_ssl_verify', '__return_false' );

    return $params;
}, 90, 2 );

  $id_participation = strip_tags($_GET['id']);
  $email            = strip_tags($_GET['cl']);

  $participation = get_participation( $id_participation, $email );

  if ( false == $participation ){
  	get_header();
  	echo '<div class="blc-liste-cagnote resultat-recherche wow fadeIn" data-wow-delay="850ms">
                <div class="lst-cagnotte-publique wow fadeIn clr" data-wow-delay="900ms">
                    <div style="text-align:center">
                        <h3> '. __("-- Cette transation a déjà été effectuée ou n'exsite pas ! .","kotikota") .'--</h3>
                    </div>
                </div>
            </div>';
  	get_footer();
  	die;
  }

  $reference = get_field('nom_de_la_cagnotte', $participation->id_cagnotte);
  $reference = clean( $reference );

  $order_id = $participation->id_cagnotte.time();

  $amount = $participation->donation;  
  $num = '00000';
  if( isset( $_GET['msisdn']) && !empty( $_GET['msisdn']) ) $num = strip_tags( $_GET['msisdn'] );
  $retour = create_payment( $order_id, $reference, $num, $amount );

  if( true === $retour->status->success && '200' == $retour->status->code ){
    $transaction_id = save_AM_transaction( $participation->id_participation, $order_id );
  }

  get_header();
  ?>

  <main id="AM_page">
  <?php
    include 'sections/content/parallax.php';
  ?>

  <div class="blc-cagnotte-participation mention">
    <div class="wrapper">
          <div class="fom-participe">
              <div class="titre wow fadeIn" data-wow-delay="800ms">
                 <h2 id="AM_titre"><?php echo __('Paiement en cours ...','kotikota') ?></h2>
              </div>
              <div class="blc-liste-cagnote wow fadeIn" data-wow-delay="850ms">
                <div id="AM_response" class="lst-cagnotte-publique wow fadeIn clr" data-wow-delay="900ms">
                  <!-- Ajax no mameno anty -->
                </div>
              </div>
          </div>
          <div class="btn wow fadeIn" data-wow-delay="850ms">
          	<a href="<?= get_permalink( $participation->id_cagnotte ) ?>" class="link" title="Revenir à la liste">
              <?php _e('Revenir à la cagnotte','kotikota'); ?>
              </a>
          </div>
    </div>
  </div>
  <div id="loader">
    <p><img src="<?php echo IMG_URL.'loader.gif' ?>" alt="loader"></p>
    <p><?= __('Vous allez recevoir une demande de confirmation de code secret sur votre téléphone pour valider votre don','kotikota') ?>.</p>
    <p><?php _e('Veuillez consulter votre téléphone...','kotikota'); ?></p>
  </div>
  </main>
  <input type="hidden" id="order_id" name="order_id" value="<?= $order_id ?>">
<?php
  get_footer();

