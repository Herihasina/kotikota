<?php 
	/*
	Template name: TYP paiement
	*/

	$p = get_parameters();
	if ( !isset($p['mod']) && empty( $p['mod'] ) ){
		die('hahaha');
	}
	$success = false;
	$participation = get_participation( strip_tags( $p['participation']) );

	if ( strip_tags( $p['mod'] ) == 'paypal' ){
		$success = traitement_post_paiement( $participation );
	}	

	get_header();
?>
	
  		<main id="homepage">
			<?php
				include 'sections/content/parallax.php';

				if ( $success ){
					$idCagnotte = $participation->id_cagnotte;
		  		include 'sections/content/typ.php';
			  }
			?>
			</main>
  
<?php get_footer(); ?>