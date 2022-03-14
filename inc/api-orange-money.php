<?php
function save_om_transaction( $order_id, $pay_token, $notif_token, $montant, $id_participation, $status = 'INITIATED' ){
  global $wpdb;

  $customer_table = $wpdb->prefix.'om';

  $wpdb->insert($customer_table, array(
    "order_id"         => $order_id,
    "pay_token"        => $pay_token,
    "notif_token"      => $notif_token,
    "montant"          => $montant,
    "id_participation" => $id_participation,
    "status"           => $status,
  ));
  return $wpdb->insert_id;
}

function get_om_transaction(){
  global $wpdb;
  $om = $wpdb->prefix.'om';

  $results = $wpdb->get_results(
    "SELECT * FROM $om 
    WHERE status = 'INITIATED'"
  );
  $out = array();
  if (!empty($results)) {
    foreach( $results as $result ){
      $out[] = $result;      
    }
    return $out;
  }else {
      return false;
  }
}

function get_token_om(){
    $url_token = 'https://api.orange.com/oauth/v3/token';

    $headers        = array(
      'Authorization' => 'Basic dk9CYlBTbTJGQTVGTjM4ZDdWYTc0NGNPQTZTM3pPS3Y6cGtKbjZweUQ2ZmVhQU1IdA==',
      'Content-Type'  => 'application/x-www-form-urlencoded',
      'Accept'        => 'application/json',
    );
    $body           = array(
      'grant_type' => 'client_credentials',
    );
    $args           = array(
      'method' => 'POST',
      'headers' => $headers,
      'body'   => $body,
      'httpversion' => '1.0',
      'sslverify' => false,
    );
    $token = wp_remote_post( $url_token, $args );
    
    if ( 200 == $token['response']['code'] ){
      $token_response = json_decode($token['body']);
    }else{
      $token_response = '';
    }

    return $token_response;
}

function get_om_payment_api($participation, $order_id){
  $token_response = get_token_om();

  $merchent_key = 'cd80db90';
  $url_payment = 'https://api.orange.com/orange-money-webpay/mg/v1/webpayment';

  $headers_payment = array(
    'Authorization' => 'Bearer ' . $token_response->access_token,
    'Content-Type'  => 'application/json',
    'Accept'        => 'application/json',
  );

  $reference = get_field('nom_de_la_cagnotte', $participation->id_cagnotte);
  $referenceout = substr( clean( $reference ) , 15);
  
  $body_payment = array(
      'merchant_key' => $merchent_key,
      'currency'     => "MGA",
      'order_id'     => $order_id,
      'amount'       => $participation->donation,
      'return_url'   => get_permalink( $participation->id_cagnotte ),
      'cancel_url'   => get_permalink( $participation->id_cagnotte ),
      'notif_url'    => site_url()."/succes-om/",
      'lang'         => "fr",
      'reference'    =>  $referenceout,
    
  );
  $body_payment = json_encode( $body_payment );

  $args_payment = array(
    'method' => 'POST',
    'headers' => $headers_payment,
    'body'   => $body_payment,
    'httpversion' => '1.0',
    'sslverify' => false,
  );

  $paiement = wp_remote_post( $url_payment, $args_payment ); 

  $paiement_reponse = $paiement['body'];
  $paiement_reponse = json_decode( $paiement_reponse );

  if ( 'OK' == $paiement_reponse->message ){
    return $paiement_reponse;
  }else{
    return '';
  }
  
}

function get_om_status( $om_transaction ){
  $token_response = get_token_om();

  if ( '' != $token_response ){
    $url_status = "https://api.orange.com/orange-money-webpay/mg/v1/transactionstatus";

    $header_status = array(
      'Authorization' => 'Bearer ' . $token_response->access_token,
      'Content-Type'  => 'application/json',
      'Accept'        => 'application/json',
    );

    $body_status = array(
      "order_id" => $om_transaction->order_id,
      "amount"  => $om_transaction->montant,
      "pay_token"=> $om_transaction->pay_token,
    );

    $body_status = json_encode( $body_status );

    $args_status = array(
      'method' => 'POST',
      'headers' => $header_status,
      'body'   => $body_status,
      'httpversion' => '1.0',
      'sslverify' => false,
    );

    $status = wp_remote_post( $url_status, $args_status );

    $status = json_decode($status['body']);
    return $status;
  }else{
    return '';
  }
}

function update_om_transaction(){
  global $wpdb;
  $all_oms = get_om_transaction();
  if ( is_array($all_oms) ){
    
    $om_table = $wpdb->prefix.'om';

    foreach ( $all_oms as $om_transaction ){
      $status = get_om_status( $om_transaction );
      $up_om = $wpdb->update($om_table, 
          array(
              "status"     => $status->status,
          ),
          array('id' => $om_transaction->id)
      );
    }
    
  }
}

function get_participations_by_successfull_om_transaction(){
    global $wpdb;
    $om = $wpdb->prefix.'om';
    $participation = $wpdb->prefix.'participation';

    $results = $wpdb->get_results(
        "SELECT * FROM $participation as p 
        INNER JOIN $om as o 
            ON p.id_participation = o.id_participation 
        WHERE p.paiement = 'orange' AND p.est_finalise = false AND o.status = 'SUCCESS'"
    ); 
     $out = array();
    if (!empty($results)) {
      foreach( $results as $result ){
        $out[] = $result;      
      }
      return $out;
    }else {
        return false;
    }
}

function traitement_post_om(){
  $oms = get_participations_by_successfull_om_transaction();
  if ( is_array($oms) ){
    foreach( $oms as $participation ){
      traitement_post_paiement( $participation );
    }
  }
}

add_action( 'wp_loaded', 'traitement_post_om' );
add_action( 'wp_head', 'update_om_transaction' );
add_action( 'admin_head', 'update_om_transaction' );