<?php
	// template name: Paiement MVola Status 

	$retour = get_mvola_transaction_notif();

	if( true === $retour['status'] ){
		$row = $retour['row'];

		$proces_mvola = traitement_post_paiement( $row );
	}

	exit();

?>
