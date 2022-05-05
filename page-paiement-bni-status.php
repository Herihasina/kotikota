<?php
	// template name: Virement bancaire Status

$salt = 'E3TBSEXdgxtaj4OxyTHHvh5hhORdIl4oBuAvWV9Xfymc7gNGPI';
$cipher_key = '01D3TKzcYnRgkc7k2Nh1qAGt0Y8UL1j7BhiUUlOj1c4vkrDCx9dyPABqnIYqIoVtI2zGpG21nuP11PcctC6YtaFuUfaqk1G9UOZ2';

$id_order = $_GET['id_order'];

$posted_data = base64_decode($_POST['posted_data']);
$decrypted_data = openssl_decrypt($posted_data,'AES-128-ECB',$cipher_key);
$data = json_decode($decrypted_data, true);


$amount = $data['amount'];
$currency = $data['currency'];
$status = $data['status'];
$checksum = $data['checksum'];
$transaction_id = $data['transaction_id'];

$checksum_data = hash('sha256',$amount.$currency.$status.$salt);

if($checksum == $checksum_data)
{
	// Your Important variable are :
	// $id_order -> it is your initial id order
	// $currency 	-> is equal to be currency you input initially (MUR, or EUR, or GBP, or USD, ect.)
	// $amount		-> is equal to be amount you input initially in CENTS

	if(strtolower($status) == "success")	// SUCCESS PAYMENT
	{
			// PUT ALL SUCCESS CODE FOR CREDIT CARDS PAYMENTS TO EXECUTE HERE <---------

			/*
			* Cette partie du code a déjà été testé séparément
			* avec un numéro de commande fixe ( à la place de la variable $id_order )
			*/
			// on prend $id_order et fait une requête en BD pour récupérer la transaction ayant le
			// même numéro de commande
			$participation = get_bni_participation( $id_order );

			// si on obtient un résultat (donc la bonne transaction),
			// on continue le process de update de database
			if( $participation ){
				$proces_bni = traitement_post_paiement( $participation );
			}
			/*
			* fin de partie testée
			*/

		echo 'success'; // Do not remove
	}
	else									// FAILED PAYMENT
	{
		// PUT ALL FAIL CODE FOR CREDIT CARDS PAYMENTS TO EXECUTE HERE <---------
		// TIP : Usualy just used as notification. Remember that a buyer can retry his payment.


		//echo 'fail'; // Do not remove
		echo 'success';
	}
}
else
{
	//echo 'Invalid Sender.';
	echo 'success';
}

?>
