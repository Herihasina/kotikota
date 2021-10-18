<?php
	/*
	Staging -- https://openapiuat.airtel.africa/
	Production -- https://openapi.airtel.africa/
	*/

	define('HOST_AIRTEL', 'https://openapi.airtel.africa/');
	define('SELLS_GOOD_API', 'merchant/v1/payments/');
	define('OAUTH_SELLS_API', 'merchant/v1/payments/oauth2/token');
	define('TXN_ENQ', 'standard/v1/payments/');

	define('CONSUMER_KEY','49ccd32c-7566-484d-8963-cc970fdc369e');
	define('CONSUMER_SECRET','61888cc8-d896-4110-886a-071f68580d1f');

	add_action( 'wp_ajax_check_status_AM', 'check_status_AM' );
	add_action( 'wp_ajax_nopriv_check_status_AM', 'check_status_AM' );

	function get_sells_token(){
		$url_token = HOST_AIRTEL . OAUTH_SELLS_API;

		$headers = array(
			'Content-Type' => 'application/json',
			'Accept' 	   => '*/*',
		);
		$body           = array(
			'client_id'		=> CONSUMER_KEY,
			'client_secret' => CONSUMER_SECRET,
	      	'grant_type' 	=> 'client_credentials',
	    );

		$args = array(
			'method' => 'POST',
		    'headers' => $headers,
		    'body'   => json_encode($body),
		);

		$token = wp_remote_post( $url_token, $args);
		if( is_array( $token )){
			$token = json_decode($token['body']);
			$token = $token->access_token;
			return $token;
		}else{
			return false;
		}		
	}

	function create_payment( $idTransaction, $reference, $num, $amount ){
		$url_token = HOST_AIRTEL . SELLS_GOOD_API;

		$bearer = get_sells_token();
 		
 		if( false !== $bearer ):
			$headers = array(
				
				'Content-Type' => 'application/json',
				'Accept' 	   => '*/*',
				'X-Country'	   => 'MG',
				'X-Currency'   => 'MGA',	
				'Authorization'=> 'Bearer ' . $bearer,		
			);
	 		$body           = array(
	 			'reference' => $reference,
	 			'subscriber'=> array(
					'country' 	=> 'MG',
					'currency'  => 'MGA',
	 				'msisdn' 	=> (int)$num,
				),
				'transaction'=> array(
	 				'amount' => (int)$amount,
	 				'currency' => 'MGA',
					'country' => 'MG',
					'id'	  => (string)$idTransaction,
	 			),
		    );

			$args = array(
	 			'method' => 'POST',
	 		    'headers' => $headers,
			    'body'   => json_encode($body),
	 		);

	 		$response = wp_remote_post( $url_token, $args);
	 		if( is_array( $response ) ){
	 			$response = json_decode( $response['body']);
	 			return $response;
	 		}else{
	 			return false;
	 		}
	 		/*
	 		 * $response
	 		 * public 'data' => 		   
			      public 'transaction' => 
			        object(stdClass)[542]
			          public 'id' => string 
			          public 'status' => string
			  public 'status' => 
			      public 'message' => string 
			      public 'code' => string '200'
			      public 'result_code' => string 
			      public 'success' => boolean true
			*/	 		
	 	else:
	 		return false;
	 	endif;

		
	}

	function check_status_AM(){
		$response = array();

		if( isset( $_POST['order_id']) && !empty( $_POST['order_id'] ) ){
			$order_id = strip_tags( $_POST['order_id'] );
		}else{
			$response['message'] = 'KO';
			wp_die();
		}

		$url_token = HOST_AIRTEL . TXN_ENQ . $order_id;

		$bearer = get_sells_token();
 
		$headers = array(
			'Accept' 	   => '*/*',
			'X-Country'	   => 'MG',
			'X-Currency'   => 'MGA',	
			'Authorization'=> 'Bearer ' . $bearer		
		);

		$args = array(
 			// 'method' => 'GET',
 		    'headers' => $headers
 		);

 		$status = wp_remote_get( $url_token, $args);
 		$status = json_decode( $status['body'] );
 		$status = $status->data->transaction;

 		if( "TS" == $status->status && "success" == $status->message ){ // Don bien effectué
 			$participation = get_AM_participation( $order_id );
 			$process 	   = traitement_post_paiement( $participation );
 			$response['message'] = __('Votre don a bien été enregistré. Merci :)','kotikota');
 			$response['code']	 = 'OK';
 			$response['titre']	 = 'Don effectué';
 			$response['class']	 = 'success';
 		}else{ // Don nisy olana
 			$response['message'] = $status->message;
 			$response['code']	 = 'KO';
 			$response['titre']	 = 'Don non effectué';
 			$response['class']	 = 'failed';
 		}
 		
 		echo json_encode( $response );
 		wp_die();
	}

	function save_AM_transaction( $id_participation, $order_id, $status = 'INITIATED' ){
	  global $wpdb;

	  $customer_table = $wpdb->prefix.'airtel';

	  $wpdb->insert($customer_table, array(
	  	"id_participation" => $id_participation,
	    "order_id"         => $order_id,	    
	    "status"           => $status,
	  ));
	  return $wpdb->insert_id;
	}

	function get_AM_participation( $order_id ){
	  global $wpdb;

	  $airtel         = $wpdb->prefix.'airtel';
	  $participation = $wpdb->prefix.'participation';

	  $result = $wpdb->get_results(
	    "SELECT * 
	    FROM $participation as p
	    LEFT JOIN $airtel as a
	    ON p.id_participation = a.id_participation
	    WHERE a.order_id = '$order_id'
	    "
	  );
	  
	  if (!empty($result)) {
	    return $result[0];
	  }else {
	    return false;
	  }
	}
