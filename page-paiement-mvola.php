<?php
	// Template name: Paiement MVola 
	
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

  /*
    Paramètres API MVola:
      montant 
      ID de transaction (unique koa)
      Description de la transaction == Nom de la cagnotte
      Coordonnées de la livraison
  */

  $id_part = "don_".$participation->id_cagnotte.time();
  $montant = $participation->donation;
  $description = get_field('nom_de_la_cagnotte', $participation->id_cagnotte);
  $description = substr( clean( $description ), 0, 15 );
  $lname = $participation->lname;
  $fname = $participation->fname;

  $retour = create_payment_mvola( $id_part, $montant, $description, $lname, $fname);

  // Test des resultats
  if ( $retour->APIVersion != APIVERSION ) {
    wp_die( "incorrect API Version" );
  }elseif ( $retour->ResponseCode != 0 ) {
    wp_die( "ERROR : " . $retour->ResponseCodeDescription );
  }else {

    /*
      insertion BD params 
        id_participation
        MPGw_TokenID
        ShopTransactionAmount
        ShopTransactionID
        ShopTransactionLabel
        ShopShippingName
        ShopShippingAddress
        status
    */

    $id_participation      = $participation->id_participation;
    $MPGw_TokenID          = $retour->MPGw_TokenID;
    $ShopTransactionAmount = $retour->ShopTransactionAmount;
    $ShopTransactionID     = $retour->ShopTransactionID;
    $ShopTransactionLabel  = $retour->ShopTransactionLabel;
    $ShopShippingName      = $retour->ShopShippingName;
    $ShopShippingAddress   = $retour->ShopShippingAddress;

    $transaction_id = save_mvola_transaction( $id_participation, $MPGw_TokenID, $ShopTransactionAmount, $ShopTransactionID, $ShopTransactionLabel, $ShopShippingName, $ShopShippingAddress);
    
    $link = MPGW_TRANSACTION_URL . $MPGw_TokenID;
    
    header( 'Location: ' . MPGW_TRANSACTION_URL . $MPGw_TokenID );

    get_header();

    get_footer();
  }
