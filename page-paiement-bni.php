<?php
	/* template name: paiement BNI
	*
	*/		
	if ( ( !isset($_GET['id']) && empty( $_GET['id'] ) ) || ( !isset($_GET['cl']) && empty( $_GET['cl'] ) ) ){
    wp_redirect( '/' );
    exit();
  }

  $id_participation = strip_tags($_GET['id']);
  $email            = strip_tags($_GET['cl']);

  $participation = get_participation( $id_participation, $email );

  if ( false == $participation ){
  	get_header();
  	echo '<div class="blc-liste-cagnote resultat-recherche wow fadeIn" data-wow-delay="850ms">
                <div class="lst-cagnotte-publique wow fadeIn clr" data-wow-delay="900ms">
                    <div style="text-align:center">
                        <h3> -- '.__("Cette transation a déjà été effectuée ou n'exsite pas !",'kotikota').' --</h3>
                    </div>
                </div>
            </div>';
  	get_footer();
  	die;
  }

		$id_order = "don_".$participation->id_cagnotte.time();	// your generated order
		$amount = (int)$participation->donation * 100;  		// in cents
		$currency = 'MGA';			// possibilities : MUR, USD, GBP, EUR
		$custom_url = get_permalink( $participation->id_cagnotte ); // url dynamique sans le HTTP/HTTPS
		
		/***Do not change***/
		$id_merchant = 'StHDi9awTiU63272B9ikt8ykCYSmuHOO';
		$id_form = 'E9owxWESSLtJadyFwI5YETZ1BOxxz2Ny';
		$salt = 'E3TBSEXdgxtaj4OxyTHHvh5hhORdIl4oBuAvWV9Xfymc7gNGPI';
		$cipher_key = '01D3TKzcYnRgkc7k2Nh1qAGt0Y8UL1j7BhiUUlOj1c4vkrDCx9dyPABqnIYqIoVtI2zGpG21nuP11PcctC6YtaFuUfaqk1G9UOZ2';
					
		$checksum = hash('sha256',$id_form.$id_order.$amount.$currency.$salt);
		$json_data = json_encode(['id_form'=>$id_form,'id_order'=>$id_order,'amount'=>$amount,'currency'=>$currency,'checksum'=>$checksum,'is_custom_redirection'=>'yes','is_ssl'=>'yes','cust_url'=>$custom_url]);
		$crypted_data = openssl_encrypt($json_data,'AES-128-ECB',$cipher_key);
		$final_data = base64_encode($crypted_data);
		/***Do not change***/

		save_virement( $participation->id_participation, $id_order, $amount/100 );

	get_header();
?>

<main id="BNI_page">
  <?php
    include 'sections/content/parallax.php';
  ?>

  <div class="blc-cagnotte-participation mention">
    <div class="wrapper">
          <div class="fom-participe">
              <div class="titre wow fadeIn" data-wow-delay="800ms">
                 <h2 id="AM_titre"><?php echo __('Paiement carte bancaire','kotikota') ?></h2>
              </div>
              <div class="blc-liste-cagnote wow fadeIn" data-wow-delay="850ms" style="text-align:center">
                <script type="text/javascript" src="https://go.mips.mu/gomips.js"></script>
								<iframe width="425" height="680" frameborder="no" scrolling="0" src="https://go.mips.mu/mipsit.php?c=<?php echo $final_data; ?>&smid=<?php echo $id_merchant; ?>"></iframe>
              </div>
          </div>
          <div class="blc-img">
            <ul>
              <li><img src="<?= IMG_URL ?>256bitSSLEncryption.png" alt="Kotikota"></li>
              <li><img src="<?= IMG_URL ?>mastercard1.png" alt="Kotikota"></li>
              <li><img src="<?= IMG_URL ?>visa1.png" alt="Kotikota"></li>
              <li><img src="<?= IMG_URL ?>bni2.png" alt="Kotikota"></li>
            </ul>
          </div>

          <div class="btn wow fadeIn" data-wow-delay="850ms">
          	<a href="<?= get_permalink( $participation->id_cagnotte ) ?>" class="link" title="<?php _e('Revenir à la liste','kotikota'); ?>">
              <?php _e('Revenir à la cagnotte','kotikota'); ?>
              </a>
          </div>
    </div>
  </div>
  </main>

<?php get_footer(); ?>