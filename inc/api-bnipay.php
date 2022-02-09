<?php
	function save_virement( $id_participation, $order_id, $amount, $status = 'INITIATED'){
		global $wpdb;

	  $customer_table = $wpdb->prefix.'bni';

	  $wpdb->insert($customer_table, array(
	  	"id_participation" => $id_participation,
	    "order_id"         => $order_id,	    
	    "amount"         	 => $amount,	    
	    "status"           => $status,
	  ));
	  return $wpdb->insert_id;
	}

	function get_bni_participation( $order_id ){
	  global $wpdb;
	  $bni        	 = $wpdb->prefix.'bni';
	  $participation = $wpdb->prefix.'participation';

	  $result = $wpdb->get_results(
	    "SELECT * 
	    FROM $participation as p
	    LEFT JOIN $bni as b
	    ON p.id_participation = b.id_participation
	    WHERE b.order_id = '$order_id'
	    "
	  );
	  
	  if (!empty($result)) {
	    return $result[0];
	  }else {
	      return false;
	  }
	}

?>