<?php

ini_set('default_socket_timeout', 120);

define('MPGW_BASEURL', 'https://www.telma.net/mpgw/v2');
define('MPGW_WS_URL', MPGW_BASEURL . '/ws/MPGwApi');
define('MPGW_TRANSACTION_URL', MPGW_BASEURL . '/transaction/');
define('APIVERSION', "2.0.0");

define("LOGINWS", "KOTIKOTA2021");
define("PWDWS", "COTICOTA2019");
define("HASH", "c836e9ee07bd85291bac8d3d0445b660a95f01b2ff0a9bf722f2dbe2a55838bb");

/*
  @params
    montant 
    ID de transaction (unique koa)
    Description de la transaction == Nom de la cagnotte
    Coordonnées de la livraison
*/
function create_payment_mvola( $ShopTransactionId, $amount, $ShopTransactionLabel, $nom_donneur, $prenom_donneur){
  
  $MPGW_BASEURL = MPGW_BASEURL;
  $MPGW_WS_URL = MPGW_WS_URL;
  $APIVersion = APIVERSION;

  $loginws = LOGINWS;
  $pwdws = PWDWS;
  $hash = HASH;

  $parameters = new \stdClass();
  $parameters->Login_WS = $loginws;
  $parameters->Password_WS = $pwdws;
  $parameters->HashCode_WS = $hash;
  $parameters->ShopTransactionAmount = $amount;
  $parameters->ShopTransactionID = $ShopTransactionId;
  $parameters->ShopTransactionLabel = $ShopTransactionLabel;
  $parameters->ShopShippingName = $nom_donneur;
  $parameters->ShopShippingAddress = $prenom_donneur;
  $parameters->UserField1 = "";
  $parameters->UserField2 = "";
  $parameters->UserField3 = "";

  // Initialisation du web service
  $ws = new \SoapClient($MPGW_WS_URL);
  // Appel de la methode
  $retour = $ws->WS_MPGw_PaymentRequest($APIVersion, $parameters);

  return $retour;
}

function save_mvola_transaction( $id_participation, $MPGw_TokenID, $ShopTransactionAmount, $ShopTransactionID, $ShopTransactionLabel, $ShopShippingName, $ShopShippingAddress, $status = 'INITIATED' ){
  global $wpdb;

  $customer_table = $wpdb->prefix.'mvola';

  $wpdb->insert($customer_table, array(
    "id_participation"      => $id_participation,
    "MPGw_TokenID"          => $MPGw_TokenID,
    "ShopTransactionAmount" => $ShopTransactionAmount,
    "ShopTransactionID"     => $ShopTransactionID,
    "ShopTransactionLabel"  => $ShopTransactionLabel,
    "ShopShippingName"      => $ShopShippingName,
    "ShopShippingAddress"   => $ShopShippingAddress,
    "status"                => $status,
  ));
  return $wpdb->insert_id;
}

function get_mvola_transaction( $shopID ){
  global $wpdb;
  $mvola = $wpdb->prefix.'mvola';

  $result = $wpdb->get_results(
    "SELECT MPGw_TokenID FROM $mvola 
    WHERE ShopTransactionID = '$shopID'"
  );
  
  if (!empty($result)) {
    return $result[0];
  }else {
      return false;
  }
}

function get_mvola_participation( $shopID ){
  global $wpdb;
  $mvola         = $wpdb->prefix.'mvola';
  $participation = $wpdb->prefix.'participation';

  $result = $wpdb->get_results(
    "SELECT * 
    FROM $participation as p
    LEFT JOIN $mvola as m
    ON p.id_participation = m.id_participation
    WHERE m.ShopTransactionID = '$shopID'
    "
  );
  
  if (!empty($result)) {
    return $result[0];
  }else {
      return false;
  }
}

function get_mvola_transaction_notif(){
  $MPGW_BASEURL = MPGW_BASEURL;
  $MPGW_WS_URL = MPGW_WS_URL;
  $TRANSACTION = MPGW_TRANSACTION_URL;
  $APIVersion = APIVERSION;

  $loginws = LOGINWS;
  $pwdws = PWDWS;
  $hash = HASH;

  $shopID = strip_tags( $_GET["Shop_TransactionID"] );

  if (!$shopID) {
    wp_die( "Erreur! Cette transaction n'existe pas." );
  }

  $token = get_mvola_transaction( $shopID ); 
  $token = $token->MPGw_TokenID;

  $ws = new SoapClient($MPGW_WS_URL);

  $parameters = new \stdClass(); 
  $parameters->Login_WS    = $loginws;
  $parameters->Password_WS = $pwdws;
  $parameters->HashCode_WS = $hash;
  $parameters->MPGw_TokenID= $token; 

  $retour = $ws->WS_MPGw_CheckTransactionStatus($APIVersion, $parameters);
  // Verrification du resultat de l'appel
  if ( $retour->APIVersion != $APIVersion) {
    echo "incorrect API Version";
    die();
  } elseif ($retour->ResponseCode != 0) {
    echo "ERROR : " . $retour->ResponseCodeDescription;
    die();
  } else {
    if( $retour->MvolaTransactionStatus == 'SUCCESS' ){
      $participation = get_mvola_participation( $shopID );
      $out = array(
        'status'  => true,
        'row'     => $participation,
      );
      return $out;
    }else{
      return false;
    }
  }
}

function create_bni_table(){
  global $wpdb;

  $table_name = $wpdb->prefix . "bni";

  if( $wpdb->query( 'SELECT * FROM ' . $table_name ) === false ) {

    $query = "CREATE TABLE " . $table_name . " (
      id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      id_participation int(40),
      order_id varchar(40) NOT NULL,
      amount varchar(10) NOT NULL,
      status varchar(20) NOT NULL,
      PRIMARY KEY  (id)
    );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($query);
  }
 
}

add_action( 'init', 'create_bni_table');