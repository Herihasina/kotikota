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

			$cin = get_field('piece_didentite', 'user_'. $user_id );

			if( $cin ) break;

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

add_action('check_cagnotte_cloture','cloture_cagnotte');

function cloture_cagnotte() {
	$arg = array(
      'post_type'   => array( 'cagnotte', 'cagnotte-perso'),
      'post_status' => 'publish',
      'posts_per_page' => -1,
    );

	$q = new WP_Query( $arg );

    while( $q->have_posts() ){
      $q->the_post();
      $id = get_the_ID();
      $deadline = get_nbr_de_jour_restant( get_field('deadline_cagnoote', $id) );
      $is_activ = get_field('actif', $id);
  	  $closed = get_field('cagnotte_cloturee', $id) == 'oui' ? true : false;

      if($deadline == 0 && !$closed ) { // si deadline 0 cloturer la cagnotte et cagnotte non cloturée
        update_field('actif', false, $id );
		update_field('cagnotte_cloturee', 'oui', $id );

		$participants = array();
		// andefasana notif daholo ny participant rehetra
		$participants = get_field('tous_les_participants', $id);
		if( is_array( $participants ) ):
		foreach( $participants as $participant ){
			$part = $participant['participant_'];
			$partID = $part->ID;
			$nom_participant = get_field('nom_participant', $partID);
			$prenom_participant = get_field('prenom_participant', $partID);
			$email_participant = get_field('email_participant', $partID);

			$sent = sendNotificationFin($id, $email_participant, $nom_participant, $prenom_participant);
		}
		endif;
		// andefasana notif koa ny titulaire
		$sent_2 = sendNotificationFinPourTitulaire( $id );
      }

    }

    wp_reset_postdata();

}
