<?php

function sendNotificationCreation($id){
    $titulaire = get_field('titulaire_de_la_cagnotte', $id );
    $nomcagnotte = get_field('nom_de_la_cagnotte', $id);
    $prenom = get_user_meta($titulaire);  
    $email_titulaire = get_userdata( $titulaire )->user_email;  
    $prenom = $prenom['first_name'][0];
    if ( !$prenom )
        $prenom = $prenom['nickname'][0];
    
    $headers = array('Reply-To: '. get_field('admin_email','option'),'Cc:'. get_field('admin_email','option'),'Content-Type: text/html; charset=UTF-8');

    if( 'mg' == ICL_LANGUAGE_CODE ){
      $tpl = locate_template( 'email-tpl/creation-cagnotte.php', false, false );
    }elseif( 'en' == ICL_LANGUAGE_CODE ){
      $tpl = locate_template( 'email-tpl/creation-cagnotte.php', false, false );
    }else{
      $tpl = locate_template( 'email-tpl/creation-cagnotte.php', false, false );
    }
    
    ob_start();
      include( $tpl );
    $html = ob_get_clean();

    $objet = get_field('objet_creation','option') ? get_field('objet_creation','option') : __("Création de cagnotte avec succès","kotikota");

    if (@wp_mail( $email_titulaire, $objet, $html, $headers ) ){
      return true;
    }else{
      return false;
    }
}
 
function sendNotificationParticipation($id){
    $titulaire = get_field('titulaire_de_la_cagnotte', $id );
    $nomcagnotte = get_field('nom_de_la_cagnotte', $id);
    $prenom = get_user_meta($titulaire);
    $email_titulaire = get_userdata( $titulaire )->user_email;

    $prenom = $prenom['first_name'][0];
    if ( !$prenom )
        $prenom = $prenom['nickname'][0];

    $headers = array('Reply-To: '. get_field('admin_email','option'),'Cc:'. get_field('admin_email','option'),'Content-Type: text/html; charset=UTF-8');

    if( 'mg' == ICL_LANGUAGE_CODE ){
      $tpl = locate_template( 'email-tpl/notif-participation.php', false, false );
    }elseif( 'en' == ICL_LANGUAGE_CODE ){
      $tpl = locate_template( 'email-tpl/notif-participation.php', false, false );
    }else{
      $tpl = locate_template( 'email-tpl/notif-participation.php', false, false );
    }

    ob_start();
      include( $tpl );
    $html = ob_get_clean();

    $objet = get_field('objet_participation','option') ? get_field('objet_participation','option') : __("Participation à votre cagnotte","kotikota");

    if ( @wp_mail( $email_titulaire, $objet, $html, $headers ) ){
      return true;
    }else{
      return false;
    }
}

function sendInvitation($invites, $idCagnotte){
  $emails = $invites;
  $nomcagnotte = get_field('nom_de_la_cagnotte', $idCagnotte);
  $titulaire = get_field('titulaire_de_la_cagnotte', $idCagnotte );
  $prenom = get_user_meta($titulaire);
  $prenom = $prenom['first_name'][0];
  $nom     = $prenom['last_name'][0];

  $headers = array('Reply-To: '. get_field('admin_email','option'),'Cc:'. get_field('admin_email','option'),'Content-Type: text/html; charset=UTF-8');

  if( 'mg' == ICL_LANGUAGE_CODE ){
    $tpl = locate_template( 'email-tpl/invitation.php',false, false );
  }elseif( 'en' == ICL_LANGUAGE_CODE ){
    $tpl = locate_template( 'email-tpl/invitation.php',false, false );
  }else{
    $tpl = locate_template( 'email-tpl/invitation.php',false, false );
  }

  $objet = get_field('objet_invitation','option') ? get_field('objet_invitation','option') : __("Invitation à la cagnotte","kotikota");
    
  foreach ( $emails as $email ){
        if ( sanitize_email( $email ) ){ 
          ob_start();
              include($tpl);
          $html = ob_get_clean();

          $resp = '';
          if ( wp_mail( $email, $objet, $html, $headers ) ) {
              $resp = "success"; 
          }else{
              $resp = "erreur";
          }
          $postarr = array(
            'post_title' => $email,
            'post_type'  => 'invite',
            'post_status'=> 'publish',
            'ID'         => get_page_by_title( $email, $output = OBJECT, $post_type = 'invite' ),
            );
          $new_invite = wp_insert_post( $postarr );

          $list_invites = get_field( 'invitations', $idCagnotte ); 

          if( !is_array($list_invites) ):
              $list_invites = array();
          endif;

          array_push( $list_invites, $new_invite );
          $list_invites = array_unique($list_invites);

          update_field( 'invitations', $list_invites , $idCagnotte );

        }else{
            $resp = "<li>".__('Adresse email erronée : ', 'kotikota').$email. "</li>";
        }
    }

    echo $resp;
}

function sendNotificationFin($id, $emailParticipant, $nomParticipant, $prenomParticipant){
    $titulaire = get_field('titulaire_de_la_cagnotte', $id );
    $nomcagnotte = get_field('nom_de_la_cagnotte', $id);
    $prenom = get_user_meta($titulaire);  
    $email_titulaire = get_userdata( $titulaire )->user_email;  
    $prenom = $prenom['first_name'][0];
    if ( !$prenom )
        $prenom = $prenom['nickname'][0];
    

    $headers = array('Reply-To: '. get_field('admin_email','option'),'Cc:'. get_field('admin_email','option'),'Content-Type: text/html; charset=UTF-8');

    if( 'mg' == ICL_LANGUAGE_CODE ){
      $tpl = locate_template( 'email-tpl/notif-fin-cagnotte.php',false, false );
    }elseif( 'en' == ICL_LANGUAGE_CODE ){
      $tpl = locate_template( 'email-tpl/notif-fin-cagnotte.php',false, false );
    }else{
      $tpl = locate_template( 'email-tpl/notif-fin-cagnotte.php',false, false );
    }

    $objet = get_field('objet_fin','option') ? get_field('objet_fin','option') : __("Fin de cagnotte","kotikota");

    ob_start();
        include($tpl);
    $html = ob_get_clean();

    if ( @wp_mail( $emailParticipant, $objet, $html, $headers ) ){
      return true;
    }else{
      return false;
    }
}

function sendNotificationFinPourTitulaire( $idCagnotte ){
  $titulaire = get_field('titulaire_de_la_cagnotte', $idCagnotte );
  $titulaire = get_userdata( $titulaire );
  $titulaire_email = $titulaire->data->user_email;

  $headers = array('Reply-To: '. get_field('admin_email','option'),'Cc:'. get_field('admin_email','option'),'Content-Type: text/html; charset=UTF-8');

  if( 'mg' == ICL_LANGUAGE_CODE ){
    $tpl = locate_template( 'email-tpl/notif-fin-cagnotte-titulaire.php',false, false );
  }elseif( 'en' == ICL_LANGUAGE_CODE ){
    $tpl = locate_template( 'email-tpl/notif-fin-cagnotte-titulaire.php',false, false );
  }else{
    $tpl = locate_template( 'email-tpl/notif-fin-cagnotte-titulaire.php',false, false );
  }

  $objet = get_field('objet_invitation','option') ? get_field('objet_invitation','option') : __("Clôture de votre cagnotte","kotikota");
  ob_start();
      include($tpl);
  $html = ob_get_clean();

  if ( @wp_mail( $titulaire_email, $objet, $html, $headers ) ){
    return true;
  }else{
    return false;
  }
}

function notificationVirementTitulaire( $idCagnotte ){
  $titulaire = get_field('titulaire_de_la_cagnotte', $idCagnotte );
  $titulaire = get_userdata( $titulaire );
  $titulaire_email = $titulaire->data->user_email;

  $headers = array('Reply-To: '. get_field('admin_email','option'),'Cc:'. get_field('admin_email','option'),'Content-Type: text/html; charset=UTF-8');

  if( 'mg' == ICL_LANGUAGE_CODE ){
    $tpl = locate_template( 'email-tpl/notif-virement-titulaire.php',false, false );
  }elseif( 'en' == ICL_LANGUAGE_CODE ){
    $tpl = locate_template( 'email-tpl/notif-virement-titulaire.php',false, false );
  }else{
    $tpl = locate_template( 'email-tpl/notif-virement-titulaire.php',false, false );
  }

  $objet = get_field('objet_invitation','option') ? get_field('objet_invitation','option') : __("Virement de votre cagnotte","kotikota");
  ob_start();
      include($tpl);
  $html = ob_get_clean();

  if ( @wp_mail( $titulaire_email, $objet, $html, $headers ) ){
    return true;
  }else{
    return false;
  }
}

function notificationVirementParticipant($id, $emailParticipant, $nomParticipant, $prenomParticipant){
    $titulaire = get_field('titulaire_de_la_cagnotte', $id );
    $nomcagnotte = get_field('nom_de_la_cagnotte', $id);
    $prenom = get_user_meta($titulaire);  
    $email_titulaire = get_userdata( $titulaire )->user_email;  
    $prenom = $prenom['first_name'][0];
    if ( !$prenom )
        $prenom = $prenom['nickname'][0];
    

    $headers = array('Reply-To: '. get_field('admin_email','option'),'Cc:'. get_field('admin_email','option'),'Content-Type: text/html; charset=UTF-8');

    if( 'mg' == ICL_LANGUAGE_CODE ){
      $tpl = locate_template( 'email-tpl/notif-virement-participant.php',false, false );
    }elseif( 'en' == ICL_LANGUAGE_CODE ){
      $tpl = locate_template( 'email-tpl/notif-virement-participant.php',false, false );
    }else{
      $tpl = locate_template( 'email-tpl/notif-virement-participant.php',false, false );
    }

    $objet = get_field('objet_fin','option') ? get_field('objet_fin','option') : __("Virement de la cagnotte effectuée","kotikota");

    ob_start();
        include($tpl);
    $html = ob_get_clean();

    if ( @wp_mail( $emailParticipant, $objet, $html, $headers ) ){
      return true;
    }else{
      return false;
    }
}

function envoiPremierRappel($userid){
  $info_rappel = get_user_info_by_id( $userid );
  $email = $info_rappel->user_email;
  
  $headers = array('Reply-To: '. get_field('admin_email','option'),'Cc:'. get_field('admin_email','option'),'Content-Type: text/html; charset=UTF-8');

  if( 'mg' == ICL_LANGUAGE_CODE ){
    $tpl = locate_template( 'email-tpl/email-24h.php',false, false );
  }elseif( 'en' == ICL_LANGUAGE_CODE ){
    $tpl = locate_template( 'email-tpl/email-24h.php',false, false );
  }else{
    $tpl = locate_template( 'email-tpl/email-24h.php',false, false );
  }

  $objet = get_field('objet_rappel1','option') ? get_field('objet_rappel1','option') : __("Rappel N° 1","kotikota");

  ob_start();
        include($tpl);
    $html = ob_get_clean();

  $send = wp_mail( $email, $objet, $html, $headers );

  if ($send){
    return true;
  }else{
    return false;
  }
}
function envoiSecondRappel($userid){
  $info_rappel = get_user_info_by_id( $userid );
  $email = $info_rappel->user_email;
  
  $headers = array('Reply-To: '. get_field('admin_email','option'),'Cc:'. get_field('admin_email','option'),'Content-Type: text/html; charset=UTF-8');

  if( 'mg' == ICL_LANGUAGE_CODE ){
    $tpl = locate_template( 'email-tpl/email-36h.php',false, false );
  }elseif( 'en' == ICL_LANGUAGE_CODE ){
    $tpl = locate_template( 'email-tpl/email-36h.php',false, false );
  }else{
    $tpl = locate_template( 'email-tpl/email-36h.php',false, false );
  }

  ob_start();
        include($tpl);
    $html = ob_get_clean();

  $objet = get_field('objet_rappel2','option') ? get_field('objet_rappel2','option') : __("Rappel N° 2","kotikota");

  ob_start();
        include($tpl);
    $html = ob_get_clean();

  $send = wp_mail( $email, $objet, $html, $headers );

  if ($send){
    return true;
  }else{
    return false;
  }
}
function envoiTroisiemeRappel($userid){
  $info_rappel = get_user_info_by_id( $userid );

  $email = $info_rappel->user_email;

  $headers = array('Reply-To: '. get_field('admin_email','option'),'Cc:'. get_field('admin_email','option'),'Content-Type: text/html; charset=UTF-8');

  if( 'mg' == ICL_LANGUAGE_CODE ){
    $tpl = locate_template( 'email-tpl/email-48h.php',false, false );
  }elseif( 'en' == ICL_LANGUAGE_CODE ){
    $tpl = locate_template( 'email-tpl/email-48h.php',false, false );
  }else{
    $tpl = locate_template( 'email-tpl/email-48h.php',false, false );
  }

  ob_start();
        include($tpl);
    $html = ob_get_clean();

  $objet = get_field('objet_rappel3','option') ? get_field('objet_rappel3','option') : __("Rappel N° 3","kotikota");

  ob_start();
        include($tpl);
    $html = ob_get_clean();

  $send = wp_mail( $email, $objet, $html, $headers );

  if ($send){
    return true;
  }else{
    return false;
  }
}

function sendRappelPostCreation($userid){
  $info_rappel = get_user_info_by_id( $userid );

  $email = $info_rappel->user_email;

  $headers = array('Reply-To: '. get_field('admin_email','option'),'Cc:'. get_field('admin_email','option'),'Content-Type: text/html; charset=UTF-8');

  if( 'mg' == ICL_LANGUAGE_CODE ){
    $tpl = locate_template( 'email-tpl/email-0h.php',false, false );
  }elseif( 'en' == ICL_LANGUAGE_CODE ){
    $tpl = locate_template( 'email-tpl/email-0h.php',false, false );
  }else{
    $tpl = locate_template( 'email-tpl/email-0h.php',false, false );
  }

  ob_start();
        include($tpl);
    $html = ob_get_clean();

  $objet = get_field('objet_rappel0','option') ? get_field('objet_rappel0','option') : __("document à fournir sous 48h","kotikota");

  ob_start();
        include($tpl);
    $html = ob_get_clean();

  $send = wp_mail( $email, $objet, $html, $headers );

  if ($send){
    return true;
  }else{
    return false;
  }
}
