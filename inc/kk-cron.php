<?php
/* 
	fonction miactivé automatique ny compte 
	ra vo misy fichier uploadé
	sinon activation manuelle depuis bool
*/
function check_compte_titulaire(){
	$titulaires = get_ids_titulaires();

	foreach ( $titulaires as $titulaire ){
		$cin = get_field('piece_didentite', 'user_'.$titulaire );
		if ( $cin ){
			update_field('profil_valide', true, 'user_'.$titulaire );
		}
	}

	return true;
}

add_action('check_valididty','envoi__rappel');

function envoi__rappel(){
	$now = date('d-m-y H');
	$user_ids = (array)get_ids_titulaires(); //ID anzay tsy mbola valide ihany no alaina eto

		foreach( $user_ids as $user_id ){	
				
			$rappel_envoye = get_field('rappel_envoye', 'user_'.$user_id );

			if ( !$rappel_envoye || is_null( $rappel_envoye ) ) $rappel_envoye = 0;

			if ( $rappel_envoye == 0 ){
				$rappel1 = get_field('primo_rappel', 'user_'.$user_id );
				if ( ($now == $rappel1 || $now > $rappel1) && $rappel1 != '' ){
					$rappel_24h = envoiPremierRappel($user_id);

						$rappel_envoye++;
						update_field('rappel_envoye', $rappel_envoye, 'user_'.$user_id );

				}
			}elseif ( $rappel_envoye == 1 ){ 
				$rappel2 = get_field('deuxo_rappel', 'user_'.$user_id );
				if ( ($now == $rappel2 || $now > $rappel2) && $rappel2 != '' ){
					$rappel_36h = envoiSecondRappel($user_id);

						$rappel_envoye++;
						update_field('rappel_envoye', $rappel_envoye, 'user_'.$user_id );

				}
			}elseif ( $rappel_envoye == 2 ){
				$rappel3 = get_field('trio_rappel', 'user_'.$user_id );
				if ( ($now == $rappel3 || $now > $rappel3) && $rappel3 != '' ){
					$rappel_48h = envoiTroisiemeRappel($user_id);

						$rappel_envoye++;
						update_field('rappel_envoye', $rappel_envoye, 'user_'.$user_id );
						
				}
			}
		}

}
