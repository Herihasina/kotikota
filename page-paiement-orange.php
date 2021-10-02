<?php
	// Template name: Paiement Orange Money 
	
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

	$token_response = get_token_om();

	if ( '' != $token_response ){		
		$order_id = "don_".$participation->id_cagnotte.time();
		$paiement_reponse = get_om_payment_api($participation, $order_id);

		$page_link = "";
		if ('OK' == $paiement_reponse->message){
			$page_link = $paiement_reponse->payment_url;
			$save_om_transaction = save_om_transaction( $order_id, $paiement_reponse->pay_token, $paiement_reponse->notif_token, $participation->donation, $participation->id_participation );
      header('Location: ' . $page_link);
		}else{
			wp_die( $paiement_reponse->message );
		}
	}
	
	get_header();
?>
<main id="payment-om">
	<div class="blc-liste-cagnote resultat-recherche wow fadeIn" data-wow-delay="850ms">
      <div class="lst-cagnotte-publique wow fadeIn clr" data-wow-delay="900ms">
          <div style="text-align:center">
              <h3><a href="<?= $page_link ?>" id="go-om" target="_blank" title="<?= get_field('nom_de_la_cagnotte', $participation->id_cagnotte) ?>"><?= __('Paiement par Orange Money','kotikota') ?><br><img src="<?php echo IMG_URL ?>OM.png"></a></h3>
          </div>
      </div>
  </div>
</main>
<?php get_footer(); ?>

