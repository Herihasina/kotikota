<?php
add_action( 'wp_ajax_create_cagnotte', 'create_cagnotte' );
// add_action( 'wp_ajax_nopriv_create_cagnotte', 'create_cagnotte' ); hoan'zay auteur/connecté ihany

function create_cagnotte(){

    $erreurs = [];

    $str = http_build_query($_POST);
    parse_str($str, $Data);
    extract($Data);

    $sousCateg = $sous_categ;

    if( 'mobile' == $device ){
        if ( isset($_FILES['cin_value_mobile'] ) ){

            if (!function_exists('wp_handle_upload')) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
            }

            $upload_overrides = array('test_form' => false);

            $files = $_FILES['cin_value_mobile'];

            foreach ($files as $file => $value) {
                $file = array(
                'name'     => $files['name'],
                'type'     => $files['type'],
                'tmp_name' => $files['tmp_name'],
                'error'    => $files['error'],
                'size'     => $files['size'],
                );
                $filename_cin = $file['name'];
                $movefile = wp_handle_upload($file, $upload_overrides);
                if ($movefile && !isset($movefile['error'])) {
                    $cin = $movefile['url'];
                }
            }
        } else if (isset($cin_value)) {
            $cin = $cin_value;
        }

        if ( isset($_FILES['illustration_mobile'] )){

            if (!function_exists('wp_handle_upload')) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
            }

            $upload_overrides = array('test_form' => false);

            $files = $_FILES['illustration_mobile'];

            foreach ($files as $file => $value) {
                $file = array(
                'name'     => $files['name'],
                'type'     => $files['type'],
                'tmp_name' => $files['tmp_name'],
                'error'    => $files['error'],
                'size'     => $files['size'],
                );

                $filename = $file['name'];
                $movefile = wp_handle_upload($file, $upload_overrides);
                if ($movefile && !isset($movefile['error'])) {
                    $illustration = $movefile['url'];
                }
            }
        }else if(isset($illustration)) {
            $illustration = $illustration;
        }else{
            $erreurs[] = __("Veuillez choisir une image pour illustrer la cagnotte.", "kotikota");
        }

    }else if( 'desktop' == $device ){
        $illustration = $illustration;
        $cin = $cin_value;

    }else{
        $erreurs[] = __("Provenance de la requête inconnue !", "kotikota");
    }


    if ( $accord != 'oui' || !$accord ){
        $erreurs[] = __("Vous devez accepter les CGU et la politique de confidentialité.", "kotikota");
    }

    if ( $_POST['sous-Categ'] == 'undefined' )
        $erreurs[] = __("Choisir le type de cagnotte", "kotikota");

    if ( $_POST['categ'] == 'undefined' )
        $erreurs[] = __("Choisir une catégorie", "kotikota");

    if ( !isset($nomCagnotte) || $nomCagnotte == "" )
       $erreurs[] = __("Entrer un nom pour la cagnotte.", "kotikota");

   if ( !isset($nom_benef) || $nom_benef == "" )
       $erreurs[] = __("Entrer les bénéficiares", "kotikota");

    if ( !isset($illustration) || $illustration == "" )
        $erreurs[] = __("Veuillez choisir une image pour illustrer la cagnotte.", "kotikota");

    if ( !isset($description) || $description == "" )
        $erreurs[] = __("Entrer la description de la cagnotte.", "kotikota");

    if ( !isset($visibilite) || $visibilite == "" )
       $erreurs[] = __("Entrer la visibilité de la cagnotte.", "kotikota");

    if ( !isset($debut) || $debut == "" )
        $erreurs[] = __("Indiquer la date de début.", "kotikota");

    if ( !isset($deadline) || $deadline == "" )
        $erreurs[] = __("Indiquer la date de fin.", "kotikota");

    if ( !isset($estLimite) || $estLimite == "" ) {
        $erreurs[] = __("Cagnotte limitée ou illimitée.", "kotikota");
    }else{
        if ( 'true' === $estLimite ) {
            if ( !isset($montantMax) || $montantMax == "" || $montantMax == '0'){
                $erreurs[] = __("Entrer le montant maximal.", "kotikota");
            }else if ( !preg_match('/^[\d]*[\s]?[\.\,]?[\d]*[\s]?$/', $montantMax)){
                $erreurs[] = __("Entrer uniquement un chiffre comme montant.", "kotikota");
            }
            $estLimite = true; //avadika bool otrzao fa ra castena izy d mahazo false true
        }else{
            $montantMax = 0;
            $estLimite = false;
        }
    }

    if ( !isset($condParticip) || $condParticip == "" ){
        $erreurs[] = __("Choisir votre condition de participation", "kotikota");
    }else{
        $montant = 0;
        switch ( $condParticip ) { //1 libre - 2 conseille - 3 fixe
            case 'conseille':
                if ( !isset($m_conseille) || $m_conseille == "" || !preg_match("/^[\d]*[\s]?[\.\,]?[\d]*[\s]?$/", $m_conseille) ){
                    $erreurs[] = __("Veuillez entrer le montant conseillé", "kotikota");
                }else{
                    $montant = $m_conseille;
                }
                break;
            case 'fixe':
                if ( !isset($m_fixe) || $m_fixe == "" || !preg_match("/^[\d]*[\s]?[\.\,]?[\d]*[\s]?$/", $m_fixe) ){
                    $erreurs[] = __("Veuillez entrer le montant exact à payer", "kotikota");
                }else{
                    $montant = $m_fixe;
                }
                break;
            default: //1
                //nothing special
                break;
        }
    }

    $devise = 'mga';

    if ( !isset($devise) || $devise == "" ){
        $erreurs[] = __("Indiquer la devise pour la cagnotte.", "kotikota");
    }elseif ($devise != 'mga' && $devise != 'eu' && $devise != 'liv'){
        $devise = get_field('devise_par_defaut','option');
        $devise_label = $devise['label'];
        $devise_value = $devise['value'];
    }else{
        // if ( $devise == 'mga' ){
            $devise_label = 'Ar';
            $devise_value = $devise;
        // }
        // if ( $devise == 'eu' ){
        //     $devise_label = '€';
        //     $devise_value = $devise;
        // }
        // if ( $devise == 'liv' ){
        //     $devise_label = '£';
        //     $devise_value = $devise;
        // }
    }

    $categories_cagnotte = categoriser_les_cagnottes();

    if( in_array( $sousCateg , $categories_cagnotte['personnelles'] ) ){
        $post_type = 'cagnotte-perso';
    }elseif( in_array( $sousCateg, $categories_cagnotte['solidaires'] ) ){
        $post_type = 'cagnotte';
    }else{
        $erreurs[] = __("Le type de cagnotte ne correspond à aucun type connu !", "kotikota");
    }

    if ( $erreurs ){
        foreach ($erreurs as $erreur ){
             echo "<li>$erreur</li>";
         }
         wp_die();
    }

    $array = ['violet','jaune','vert','rose'];
    $colors = array_rand($array);
    $couleur = $array[$colors];

    // check les dates début et fin => cagnotte actif si cagnotte mbola anaty date
    $actif_debut = start_date_past_or_now( $debut );
    $actif_fin = end_date_now_or_future( $deadline );

    $actif = false;
    if( $actif_fin && $actif_debut ){
        $actif = true;
    }

    $metas = array(
        'nom_de_la_cagnotte'            => $nomCagnotte,
        'description_de_la_cagnote'     => $description,
        'objectif_montant'              => (int)$montantMax,
        'montant_recolte'               => 0,
        'visibilite_cagnotte'           => $visibilite,
        'condition_de_participation'    => $condParticip,
        'montant_suggere'               => $montant,
        'titulaire_de_la_cagnotte'      => get_current_user_id(),
        'actif'                         => $actif,
        'cagnotte_cloturee'             => 'non',
        'devise'                         => array($devise_label, $devise_value),
        'couleur'                       => $couleur,
        'recevoir_les_notifications_de_participation_par_e-mail' => true,
    );

    $postDetails = array(
        'post_type'  => $post_type,
        'post_title' => $nomCagnotte,
        'post_status'=> 'publish',
        'meta_input' => $metas
    );

    $post_notif = false;

    $now_user = get_current_user_id();

    if ( $cin != '' ){
        if( 'mobile' == $device ){
            if($filename_cin) {
                $cin = get_image_attach_id ( $filename_cin, 'user_'.$now_user );
                update_field('piece_didentite', $cin, 'user_'.$now_user );
            } else {
                $cin = attachment_url_to_postid( $cin );
                update_field('piece_didentite', $cin, 'user_'.$now_user );
            }
        }elseif( 'desktop' == $device ){
            $cin = attachment_url_to_postid( $cin );
            update_field('piece_didentite', $cin, 'user_'.$now_user );
        }

    }

    if ( is_first_cagnotte_de( $now_user ) ){
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $apres_24h = date('d-m-y H', strtotime('+24 hours'));
        $apres_36h = date('d-m-y H', strtotime('+36 hours'));
        $apres_48h = date('d-m-y H', strtotime('+48 hours'));
        update_field('primo_rappel', $apres_24h, 'user_'.$now_user);
        update_field('deuxo_rappel', $apres_36h, 'user_'.$now_user);
        update_field('trio_rappel', $apres_48h, 'user_'.$now_user); //123&é"azE
        update_field('rappel_envoye', 0, 'user_'.$now_user);

        if( $cin == '' )
            $post_notif = true;

    }

    $newPost = wp_insert_post( $postDetails , true );

    if ($newPost){
        wp_set_object_terms( $newPost, array( (int)$sousCateg, (int)$categ ), 'categ-cagnotte' );
        if( 'mobile' == $device ){
            if($filename) {
            $attach_id = get_image_attach_id ( $filename,$newPost );
                update_field('illustration_pour_la_cagnotte', $attach_id, $newPost );
            } else {
                update_field('illustration_pour_la_cagnotte', attachment_url_to_postid( $illustration ), $newPost );
            }

        }elseif( 'desktop' == $device ){
            update_field('illustration_pour_la_cagnotte', attachment_url_to_postid( $illustration ), $newPost );
        }


        update_field('debut_cagnoote', $debut, $newPost);
        update_field('deadline_cagnoote', $deadline, $newPost);
        update_field('fixer_un_objectif', (bool)$estLimite, $newPost);

        $benef = array(
            'post_type' => 'beneficiaire',
            'post_title' => $nom_benef,
            'post_status' => 'publish',
        );

        $newbenef = wp_insert_post( $benef, true );

        if (is_wp_error($newbenef)) {
            $errors = $newbenef->get_error_messages();
            foreach ($errors as $error) {
                echo $error;
                wp_die();
            }
        }else{
            update_field( 'benef_cagnotte', $newbenef , $newPost );
        }

        sendNotificationCreation($newPost);
        $piece_didentite = get_field('piece_didentite', 'user_'.$now_user );

        $profil_valide = get_field('profil_valide', 'user_'.$now_user );

        if( !$piece_didentite && !$profil_valide )
            sendRappelPostCreation( $now_user );

        $single = get_permalink( $newPost );
        echo "$single";
    }
    wp_die();

}


add_action( 'wp_ajax_redirect_single', 'redirect_single' );
add_action( 'wp_ajax_nopriv_redirect_single', 'redirect_single' );
function redirect_single(){
    $resp = "";
    if ( !empty($_POST['id']) && isset($_POST['id']) ){
        $id = (int)strip_tags($_POST['id']);
        $resp = "success";
    }else{
        $resp = "failed";
    }
    echo $resp;
    wp_die();
}

add_action( 'wp_ajax_redirect_gestion', 'redirect_gestion' );
// add_action( 'wp_ajax_nopriv_redirect_single', 'redirect_single' );
function redirect_gestion(){
    $resp = "";
    if ( !empty($_POST['id']) && isset($_POST['id']) ){
        $id = (int)strip_tags($_POST['id']);
        $resp = "success";
    }else{
        $resp = "failed";
    }
    echo $resp;
    wp_die();
}

add_action( 'wp_ajax_creer_participation', 'creer_participation' );
add_action( 'wp_ajax_nopriv_creer_participation', 'creer_participation' );

function creer_participation(){
    $erreurs = [];
    $sucess = '';
    $devise = strip_tags($_POST['devise']);
    $accord = strip_tags($_POST['accord']);

    if ( $accord != 'on' ){
        $erreurs[] = __("Vous devez accepter les CGU et la politique de confidentialité.", "kotikota");
    }

    if ( !isset($_POST['fname']) || $_POST['fname'] == "" )
        $erreurs[] = __("Entrer un prénom valide", "kotikota");
    if ( !isset($_POST['lname']) || $_POST['lname'] == "" )
        $erreurs[] = __("Entrer un nom valide", "kotikota");
    if ( !isset($_POST['mail']) || $_POST['mail'] == "" || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL) )
        $erreurs[] = __("Entrer une adresse email valide", "kotikota");
    if ( !isset($_POST['phone']) || $_POST['phone'] == "" ){
        $erreurs[] = __("Entrer un numéro de téléphone valide", "kotikota");
    }elseif( !preg_match('/^\+*[\d]*[\s]?[\.\,]?[\d]*[\s]?$/', strip_tags( str_replace(' ','',$_POST['phone'] ) ) ) ){
        $erreurs[] = __("Entrer un numero de téléphone valide", "kotikota");
    }

    if ( !isset($_POST['condition']) || $_POST['condition'] == "" )
        $erreurs[] = __("Entrer la condition de participation", "kotikota");

    if ( !isset($_POST['donation']) || $_POST['donation'] == "" ){
        $erreurs[] = __("Entrer le montant à donner", "kotikota");
    }elseif( !preg_match('/^[\d]*[\s]?[\.\,]?[\d]*[\s]?$/', strip_tags( $_POST['donation'] ) ) ){
        $erreurs[] = __("Entrer uniquement un chiffre comme montant.", "kotikota");
    }

    if ( !isset($_POST['maskIdentite']) || $_POST['maskIdentite'] == "" )
        $erreurs[] = __("Masquer/Afficher identité", "kotikota");
    if ( !isset($_POST['maskParticipation']) || $_POST['maskParticipation'] == "" )
        $erreurs[] = __("Masquer/Afficher participation", "kotikota");

    if ( !isset($_POST['paiement']) || $_POST['paiement'] == "" )
        $erreurs[] = __("Choisir un mode de paiement", "kotikota");

    if ( !isset($_POST['idCagnotte']) || $_POST['idCagnotte'] == "" || !isset($_POST['devise']) || $_POST['devise'] == "" )
        $erreurs[] = __("Petit malin va!", "kotikota");

    if ( !isset($_POST['devise']) || $_POST['devise'] == "" ){
        $erreurs[] = __("Veuillez choisir votre devise", "kotikota");
    }elseif ($devise != 'mga' && $devise != 'eu' && $devise != 'liv' && 'cad' != $devise && 'usd' != $devise ){
        $devise = get_field('devise_par_defaut','option');
        $devise = $devise['value'];
    }

    $idCagnotte = strip_tags($_POST['idCagnotte']);

    $condition = strip_tags( $_POST['condition'] );

    $donation = (int)strip_tags( $_POST['donation'] );

    # Eto isika manao ny #
    # resaka conversion devise #
    if( 'mga' != $devise ){
        $change_mga_eu  = get_field('change_mga_eu','options');
        $change_mga_liv = get_field('change_mga_liv','options');
        $change_mga_usd = get_field('change_mga_usd','options');
        $change_mga_cad = get_field('change_mga_cad','options');

        $donation = calcul_devise_en_mga( $donation, $devise, $change_mga_eu, $change_mga_liv, $change_mga_cad, $change_mga_usd );

    }
    # /tapitra #

    //lé field 'montant_suggere' io est le même pour montant fixe et montant suggéré :)
    # fixe == montant minimum imposé
    # conseille == montant minimum conseillé

    if ( strip_tags($_POST['condition']) == "fixe"){

        $montant_suggere = (int)get_field('montant_suggere', $_POST['idCagnotte'] );

        if ( $montant_suggere && preg_match('/^[\d]*[\s]?[\.\,]?[\d]*[\s]?$/', strip_tags( $montant_suggere ) ) ){
            if ( $donation < $montant_suggere ){
                $erreurs[] = __("Attention montant minimum imposé", "kotikota");
            }
        }elseif( !preg_match('/^[\d]*[\s]?[\.\,]?[\d]*[\s]?$/', strip_tags( $montant_suggere ) ) ){
            $erreurs[] = __("Entrer uniquement un chiffre comme montant.", "kotikota");
        }
    }

    if ( $erreurs ){
        $success = false;
        foreach ($erreurs as $erreur ){
             echo "<li>$erreur</li>";
         }
         wp_die();
    }

    $fname = strip_tags($_POST['fname']);
    $lname = strip_tags($_POST['lname']);
    $email = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
    $phone = strip_tags($_POST['phone']);
    $phone33 = strip_tags($_POST['phone33']);

    $mot_doux = strip_tags($_POST['message']);

    $maskIdentite = strip_tags( $_POST['maskIdentite'] );
    if ($maskIdentite == "on"){
        $maskIdentite = true;
    }else{
        $maskIdentite = false;
    }

    $maskParticipation = strip_tags( $_POST['maskParticipation'] );
    if ($maskParticipation == "on"){
        $maskParticipation = true;
    }else{
        $maskParticipation = false;
    }

    $paiement = strip_tags( $_POST['paiement'] );

    $id_participation = save_participant( $idCagnotte, $email, $lname, $fname, $phone, $donation, $paiement, $maskParticipation, $maskIdentite, $mot_doux, $devise );

    if ( $paiement == "paypal" ){

        echo get_site_url() ."/don/?id=$id_participation&cl=$email";
    }elseif ( $paiement == "orange" ){
        echo get_site_url() ."/paiement-orange-money/?id=$id_participation&cl=$email";
    }elseif ( $paiement == "telma" ){
        echo get_site_url() ."/paiement-mvola/?id=$id_participation&cl=$email";
    }elseif( $paiement == "airtel" ){
        // $id_participation = save_participant( $idCagnotte, $email, $lname, $fname, $phone33, $donation, $paiement, $maskParticipation, $maskIdentite, $mot_doux, $devise );
        // echo get_site_url() ."/paiement-airtel-money/?id=$id_participation&cl=$email";
        echo "trigger_popup=popup_airtel&idCagnotte=$idCagnotte&email=$email&lname=$lname&fname=$fname&phone=$phone&donation=$donation&maskParticipation=$maskParticipation&maskIdentite=$maskIdentite&mot_doux=$mot_doux&devise=$devise";
    }elseif( $paiement == "bni" || $paiement == "visa"){
        echo get_site_url() ."/virement-bancaire/?id=$id_participation&cl=$email";
    }

    // echo $url;
    wp_die();
}

add_action( 'wp_ajax_pay_airtel', 'pay_airtel' );
add_action( 'wp_ajax_nopriv_pay_airtel', 'pay_airtel' );
function pay_airtel(){
    if( isset($_POST) ){
        $infos = $_POST['infos'];
        $infos = explode("trigger_popup=popup_airtel&", $infos);
        $infos = $infos[1];
        parse_str($infos, $Data);
        extract($Data);

        $num_airtel = strip_tags( $_POST['num_airtel'] );

         $id_participation = save_participant( $idCagnotte, $email, $lname, $fname, $phone, $donation, "airtel", $maskParticipation, $maskIdentite, $mot_doux, $devise );

         echo get_site_url() ."/paiement-airtel-money/?id=$id_participation&cl=$email&msisdn=$num_airtel";

        wp_die();
    }
}

add_action( 'wp_ajax_send_invite', 'send_invite' );

function send_invite(){
    $erreurs = [];

    if ( !isset($_POST['emails']) || $_POST['emails'] == "" ){
        $erreurs[] = __("Entrer au moins une adresse email","kotikota");
    }
    if ( !isset($_POST['idCagnotte']) || !is_cagnotte($_POST['idCagnotte']) )
        $erreurs[] = __("ID de cagnotte incorrecte.", "kotikota");

    if ( $erreurs ){
        $text_erreurs ="";
        foreach ($erreurs as $erreur ){
            $text_erreurs .="<li>$erreur</li>";
        }
        echo json_encode(array('resp' => 'error', 'erreurs' => $text_erreurs ));
        wp_die();
    }

    $idCagnotte = $_POST['idCagnotte'];


    //vérification si cela provient de la page de gestion d'invités
    $cagnotte_url = get_permalink($idCagnotte);

    $resp= sendInvitation( $_POST['emails'], $idCagnotte );

    echo json_encode(array('resp' => $resp, 'url' => $cagnotte_url));

    wp_die();
}

add_action( 'wp_ajax_save_info_principale', 'save_info_principale' );

function save_info_principale(){
    $erreurs = [];

    if ( !isset($_POST['nomCagnotte']) || $_POST['nomCagnotte'] == "" )
       $erreurs[] = __("Entrer un nom pour la cagnotte.", "kotikota");

    if ( !isset($_POST['debut']) || $_POST['debut'] == "" )
       $erreurs[] = __("Indiquer la date de début.", "kotikota");
    if ( !isset($_POST['fin']) || $_POST['fin'] == "" )
       $erreurs[] = __("Indiquer la date de fin.", "kotikota");

    if ( !isset($_POST['idBenef']) || $_POST['idBenef'] == "" )
       $erreurs[] = __("Vous avez supprimé l'ID du bénéficiaire.", "kotikota");
    if ( !isset($_POST['nom']) || $_POST['nom'] == "" )
       $erreurs[] = __("Entrer le nom du bénéficiaire.", "kotikota");
    //if ( !isset($_POST['prenom']) || $_POST['prenom'] == "" )
      // $erreurs[] = __("Entrer le prénom du bénéficiaire.", "kotikota");
    if ( !isset($_POST['email']) || $_POST['email'] == "" )
       $erreurs[] = __("Entrer l'adresse email du bénéficiaire.", "kotikota");
    if ( !isset($_POST['tel']) || $_POST['tel'] == "" ){
       $erreurs[] = __("Entrer le numéro de contact du bénéficiaire.", "kotikota");
    } elseif( !preg_match('/^\+[\d]*[\s]?[\.\,]?[\d]*[\s]?$/', strip_tags( str_replace(' ','',$_POST['tel'] ) ) ) ){
        // $erreurs[] = __("Entrer un numero de téléphone valide", "kotikota");
    }
    // if ( !isset($_POST['rib']) || $_POST['rib'] == "" )
    //    $erreurs[] = __("Entrer le RIB du bénéficiaire.", "kotikota");

    //if ( !isset($_POST['categ']) || $_POST['categ'] == "" )
    //   $erreurs[] = __("Indiquer la catégorie de cagnotte.", "kotikota");

    if ( !isset($_POST['sousCateg']) || $_POST['sousCateg'] == "" )
       $erreurs[] = __("Indiquer une type de cagnotte.", "kotikota");

    if ( !isset($_POST['idCagnotte']) || !is_cagnotte($_POST['idCagnotte']) )
        $erreurs[] = __("ID de cagnotte incorrecte.", "kotikota");

    if ( $erreurs ){
        foreach ($erreurs as $erreur ){
             echo "<li>$erreur</li>";
         }
         wp_die();
    }

    $idCagnotte = $_POST['idCagnotte'];

    // check les dates début et fin => cagnotte actif si cagnotte mbola anaty date
    $actif_debut = start_date_past_or_now( $_POST['debut'] );
    $actif_fin = end_date_now_or_future( $_POST['fin'] );

    $actif = false;
    if( $actif_fin && $actif_debut ){
        $actif = true;
    }
    update_field( 'actif', $actif, $idCagnotte );

    update_field('nom_de_la_cagnotte', strip_tags( $_POST['nomCagnotte'] ), $idCagnotte );

    $efa_nanova_debut = get_field('modif_debut', $idCagnotte );
    $efa_nanova_fin   = get_field('modif_fin', $idCagnotte );

    $debu = strtotime( get_field('debut_cagnoote',$idCagnotte) ); //debut taloha format yyyymmdd
    //$debu = date('m-d-Y',$debu); //ovaina ho m/d/Y --> mba hitovy @ilay ao @$_POST

    $fain = strtotime( get_field('deadline_cagnoote',$idCagnotte) ); //debut taloha format yyyymmdd
    //$fain = date('m-d-Y',$fain); //ovaina ho m/d/Y --> mba hitovy @ilay ao @$_POST

    if ( $debu != strtotime($_POST['debut']) )
        if ( !$efa_nanova_debut ){
            $debut = $_POST['debut'];
            update_field( 'debut_cagnoote', $debut , $idCagnotte );
            update_field( 'modif_debut', true, $idCagnotte );
        }
    if ( $fain != strtotime($_POST['fin']) )
        if ( !$efa_nanova_fin ){
            $fin = $_POST['fin'];
            update_field( 'deadline_cagnoote', $fin, $idCagnotte );
            update_field( 'modif_fin', true, $idCagnotte );
        }

    // info beneficiaire
    $idBenef   = strip_tags( $_POST['idBenef'] );
    $nom       = strip_tags( $_POST['nom'] );
    $prenom    = strip_tags( $_POST['prenom'] );
    $email     = strip_tags( $_POST['email'] );
    $telephone = strip_tags( $_POST['tel'] );
    $code      = strip_tags( $_POST['code'] );
    $rib       = strip_tags( $_POST['rib'] );
    update_field('code_benef', $code, $idBenef );

    $erreurs[] = $idBenef + ' ' +$nom + ' ' + $prenom + ' ' + $email + ' ' + $telephone + ' ' + $code;

    if ( $erreurs ){
        foreach ($erreurs as $erreur ){
             echo "<li>$erreur</li>";
         }
         wp_die();
    }

    $update_benef = update_beneficiaire_info( $idBenef,$nom,$prenom,$email,$telephone,$rib );
    update_field('benef_cagnotte', $idBenef, $idCagnotte);

    // update categorie/sous-categorie cagnotte
    $categ = strip_tags( $_POST['categ'] );
    $sousCateg = strip_tags( $_POST['sousCateg'] );
    wp_set_object_terms( $idCagnotte, array( (int)$sousCateg, (int)$categ ), 'categ-cagnotte' );

    $single = get_lang_url().'/parametre-fond';
    echo $single;
    wp_die();
}

add_action( 'wp_ajax_save_info_banque', 'save_info_banque' );

function save_info_banque(){
    $erreurs = [];

    if ( !isset($_POST['titulaire']) || $_POST['titulaire'] == "" )
       $erreurs[] = array('key'=> 'titulaire', 'error_msg'=> __("Entrer un nom titulaire du compte.", "kotikota"));

    if ( !isset($_POST['banque']) || $_POST['banque'] == "" )
       $erreurs[] = array('key'=> 'banque', 'error_msg'=> __("Indiquer le nom de la banque.", "kotikota"));

    if ( !isset($_POST['domicile']) || $_POST['domicile'] == "" )
       $erreurs[] = array('key'=> 'domicile', 'error_msg'=> __("Indiquer l'adresse de domiciliation de la banque.", "kotikota"));

    if ( !isset($_POST['codebanque']) || $_POST['codebanque'] == "" )
       $erreurs[] = array('key'=> 'codebanque', 'error_msg'=> __("Indiquer le code banque.", "kotikota"));
    //verification code banque
    if ( isset($_POST['codebanque']) && $_POST['codebanque'] != "" && ! preg_match('/^\w{5}$/', $_POST['codebanque'], $output_array) )
       $erreurs[] = array('key'=> 'codebanque', 'error_msg'=> __("Veuillez entrer un code banque valide avec exactement 5 caractères.", "kotikota"));

    if ( !isset($_POST['codeguichet']) || $_POST['codeguichet'] == "" )
       $erreurs[] = array('key'=> 'codeguichet', 'error_msg'=> __("Indiquer le code guichet ou code agence.", "kotikota"));
    //verification code guichet
    if ( isset($_POST['codeguichet']) && $_POST['codeguichet'] != "" && ! preg_match('/^\w{5}$/', $_POST['codeguichet'], $output_array))
       $erreurs[] = array('key'=> 'codeguichet', 'error_msg'=>__("Veuillez entrer un code guichet ou code agence valide avec exactement 5 caractères.", "kotikota"));

    if ( !isset($_POST['numcompte']) || $_POST['numcompte'] == "" )
       $erreurs[] = array('key'=> 'numcompte', 'error_msg'=> __("Indiquer le numero de compte.", "kotikota"));
    //verification numero de compte
    if ( isset($_POST['numcompte']) && $_POST['numcompte'] != "" &&  ! preg_match('/^\w{11}$/', $_POST['numcompte'], $output_array))
       $erreurs[] = array('key'=> 'numcompte', 'error_msg'=>__("Veuillez entrer un numéro de compte valide avec exactement 11 caractères.", "kotikota"));

    if ( !isset($_POST['cle']) || $_POST['cle'] == "" )
       $erreurs[] = array('key'=> 'cle', 'error_msg'=> __("Entrer la clé Rib.", "kotikota"));
    //verification cle rib
    if ( isset($_POST['cle']) && $_POST['cle'] != "" && ! preg_match('/^\w{2}$/', $_POST['cle'], $output_array))
       $erreurs[] = array('key'=> 'cle', 'error_msg'=>__("Veuillez entrer une clé Rib valide avec exactement 2 caractères.", "kotikota"));

    // vérification IBAN
    if ( isset($_POST['iban']) && $_POST['iban'] !="" && ! preg_match('/^\w{27}$/', $_POST['iban'], $output_array))
       $erreurs[] = array('key'=> 'iban', 'error_msg'=>__("Veuillez entrer un numéro IBAN valide avec exactement 27 caractères.", "kotikota"));

   // if ( !isset($_POST['fichier']) || $_POST['fichier'] == "" ){
   //    $erreurs[] = __("Vous devez téléverser un fichier Image ou PDF", "kotikota");
   //  }

    /*if ( $erreurs ){
        foreach ($erreurs as $erreur ){
             echo "<li>$erreur</li>";
         }
         wp_die();
    }*/

    $idCagnotte = $_POST['idCagnotte'];


    if ( $erreurs ){
        echo json_encode(array('resp' => 'error', 'errors' => $erreurs ));
        wp_die();
    }

    // info beneficiaire
    $idBenef   = strip_tags( $_POST['idBenef'] );
    $titulaire       = strip_tags( $_POST['titulaire'] );
    $banque    = strip_tags( $_POST['banque'] );
    $domicile     = strip_tags( $_POST['domicile'] );
    $codebanque = strip_tags( $_POST['codebanque'] );
    $codeguichet      = strip_tags( $_POST['codeguichet'] );
    $numcompte       = strip_tags( $_POST['numcompte'] );
    $cle       = strip_tags( $_POST['cle'] );
    $iban       = strip_tags( $_POST['iban'] );
    $bic       = strip_tags( $_POST['bic'] );
    $rib_file  = attachment_url_to_postid(strip_tags($_POST['fichier']));

    update_field('rib_fichier', $rib_file, $idCagnotte );

    update_beneficiaire_info_rib( $idCagnotte,$titulaire,$banque,$domicile,$codebanque,$codeguichet,$numcompte,$cle,$iban,$bic);

    $single = get_lang_url().'/parametre-info-principale';
    echo json_encode(array('resp' => 'success', 'url' => $single ));
    wp_die();
}

add_action( 'wp_ajax_save_fond', 'save_fond' );

function save_fond(){
    $errors = [];

    if ( !isset($_POST['bg']) || $_POST['bg'] == "" )
        $erreurs[] = __("Choisir une image de fond", "kotikota");

    if ( !isset($_POST['idCagnotte']) || !is_cagnotte($_POST['idCagnotte']) )
        $erreurs[] = __("ID de cagnotte incorrecte.", "kotikota");

    if ( $erreurs ){
        foreach ($erreurs as $erreur ){
             echo "<li>$erreur</li>";
         }
         wp_die();
    }

    $bg = sanitize_url( $_POST['bg'] );
    $idCagnotte = $_POST['idCagnotte'];

    update_field('illustration_pour_la_cagnotte', attachment_url_to_postid($bg), $idCagnotte );

    $resp =  get_lang_url().'/parametre-description?parametre='.$idCagnotte;
    echo $resp;

    wp_die();
}

add_action( 'wp_ajax_save_descr', 'save_descr' );
function save_descr(){
    $erreurs = [];
    $success = false;

    if ( !isset($_POST['descr']) || $_POST['descr'] == "" )
        $erreurs[] = __("Veuillez entrer la description de la cagnotte.", "kotikota");

    if ( !isset($_POST['idCagnotte']) || !is_cagnotte($_POST['idCagnotte']) )
        $erreurs[] = __("ID de cagnotte incorrecte.", "kotikota");

    if ( $erreurs ){
        foreach ($erreurs as $erreur ){
             echo "<li>$erreur</li>";
         }
         wp_die();
    }

    $newDescr = $_POST['descr'];
    $idCagnotte = $_POST['idCagnotte'];

    if ( $newDescr == '&lt;p&gt;&lt;br&gt;&lt;/p&gt;' || $newDescr == '<p><br></p>'){
        //tsy manao inin
    }else{
        update_field('description_de_la_cagnote', $newDescr, $idCagnotte );
    }

    $success = true;
    echo get_lang_url().'/parametre-montant?parametre='.$idCagnotte;
    wp_die();

}

add_action( 'wp_ajax_save_montant', 'save_montant' );

function save_montant(){
    $erreurs = [];
    $devise = strip_tags($_POST['devise']);

    if ( !isset($_POST['ilaina']) || $_POST['ilaina'] == "" || !preg_match("/^[\d]*[\s]?[\.\,]?[\d]*[\s]?$/", $_POST['ilaina'] ) ){
        $erreurs[] = __("Veuillez entrer l'objectif de montant", "kotikota");
    }
    if ( !isset($_POST['suggere']) || $_POST['suggere'] == "" || !preg_match("/^[\d]*[\s]?[\.\,]?[\d]*[\s]?$/", $_POST['suggere'] ))
        $erreurs[] = __("Veuillez suggérer un montant", "kotikota");

    if ( !isset($_POST['devise']) || $_POST['devise'] == "" ){
        $erreurs[] = __("Veuillez choisir la devise pour la cagnotte", "kotikota");
    }elseif ($devise != 'mga' && $devise != 'eu' && $devise != 'liv'){

        $devise = get_field('devise_par_defaut','option');
        $devise = $devise['value'];
    }

    if ( !isset($_POST['maskIlainaAzo']) || $_POST['maskIlainaAzo'] == "" )
        $erreurs[] = __("Masquer montant à atteindre/montant collecté", "kotikota");

    if ( !isset($_POST['maskToutesContribution']) || $_POST['maskToutesContribution'] == "" )
        $erreurs[] = __("Masquer toutes les contributions", "kotikota");

    if ( !isset($_POST['maskContribution']) || $_POST['maskContribution'] == "" )
        $erreurs[] = __("Masquer le montant de la contribution", "kotikota");

    if ( !isset($_POST['idCagnotte']) || !is_cagnotte($_POST['idCagnotte']) )
        $erreurs[] = __("ID de cagnotte incorrecte.", "kotikota");

    if ( $erreurs ){
        foreach ($erreurs as $erreur ){
             echo "<li>$erreur</li>";
         }
         wp_die();
    }

    $ilaina = strip_tags($_POST['ilaina']);
    $suggere = strip_tags($_POST['suggere']);
    $idCagnotte = $_POST['idCagnotte'];

    $maskIlainaAzo = strip_tags( $_POST['maskIlainaAzo'] );
    if ($maskIlainaAzo == "on"){
        $maskIlainaAzo = true;
    }else{
        $maskIlainaAzo = false;
    }
    $maskToutesContribution = strip_tags( $_POST['maskToutesContribution'] );
    if ($maskToutesContribution == "on"){
        $maskToutesContribution = true;
    }else{
        $maskToutesContribution = false;
    }
    $maskContribution = strip_tags( $_POST['maskContribution'] );
    if ($maskContribution == "on"){
        $maskContribution = true;
    }else{
        $maskContribution = false;
    }

    update_field('objectif_montant', $ilaina , $idCagnotte );
    update_field('montant_suggere', $suggere , $idCagnotte );
    update_field('devise',$devise , $idCagnotte );
    update_field('fixer_un_objectif', $maskIlainaAzo, $idCagnotte );
    update_field('masquer_toutes_les_contributions', $maskToutesContribution, $idCagnotte );
    update_field('masquer_le_montant_de_la_contribution', $maskContribution, $idCagnotte );

    //echo get_site_url().'/parametre-notification?parametre='.$idCagnotte;
    echo get_site_url();
    wp_die();
}

add_action( 'wp_ajax_save_notif', 'save_notif' );

function save_notif(){
    $erreurs = [];

    if ( !isset($_POST['recevoirNotif']) || $_POST['recevoirNotif'] == "" )
        $erreurs[] = __("Recevoir les notifications de participation par e-mail", "kotikota");

    if ( !isset($_POST['notifParticip']) || $_POST['notifParticip'] == "" )
        $erreurs[] = __("Notifier les participants lors de la dépense de la cagnotte", "kotikota");

    if ( !isset($_POST['idCagnotte']) || !is_cagnotte($_POST['idCagnotte']) )
        $erreurs[] = __("ID de cagnotte incorrecte.", "kotikota");

    if ( $erreurs ){
        foreach ($erreurs as $erreur ){
             echo "<li>$erreur</li>";
         }
         wp_die();
    }

    $idCagnotte = $_POST['idCagnotte'];
    $recevoirNotif = strip_tags( $_POST['recevoirNotif'] );
    if ($recevoirNotif == "on"){
        $recevoirNotif = true;
    }else{
        $recevoirNotif = false;
    }
    $notifParticip = strip_tags( $_POST['notifParticip'] );
    if ($notifParticip == "on"){
        $notifParticip = true;
    }else{
        $notifParticip = false;
    }

    update_field( 'recevoir_les_notifications_de_participation_par_e-mail', $recevoirNotif, $idCagnotte );
    update_field( 'notifier_les_participants_lors_de_la_depense_de_la_cagnotte', $notifParticip, $idCagnotte );

    $output = '<div>';

    if( $recevoirNotif ){
        $output .= "<p>" . __('Notifications de participation :','kotikota') ." <b>". __('Actives','kotikota') . "</b></p>";
    }else{
        $output .= "<p>" . __('Notifications de participation :','kotikota') ." <b>". __('Inactives','kotikota') . "</b></p>";
    }

    if( $notifParticip ){
        $output .= "<p>" . __('Notifications des participations lors de la dépense de la cagnotte :','kotikota') ." <b>". __('Actives','kotikota') . "</b></p>";
    }else{
        $output .= "<p>" . __('Notifications des participations lors de la dépense de la cagnotte :','kotikota') ." <b>". __('Inactives','kotikota') . "</b></p>";
    }

    $output .= '</div>';

    echo $output;
    wp_die();
}

add_action( 'wp_ajax_ask_question', 'ask_question' );
add_action( 'wp_ajax_nopriv_ask_question', 'ask_question' );

function ask_question(){
    $erreurs = [];

    if ( !isset($_POST['question']) || $_POST['question'] == "" ){
        $erreurs[] = __("Veuillez bien poser votre question.", "kotikota");
    }

    if ( !isset($_POST['idCagnotte']) || !is_cagnotte($_POST['idCagnotte']) )
        $erreurs[] = __("ID de cagnotte incorrecte.", "kotikota");

    if ( $erreurs ){
        foreach ($erreurs as $erreur ){
             echo "<li>$erreur</li>";
         }
         wp_die();
    }

    $question = strip_tags( $_POST['question'] );
    $idCagnotte = $_POST['idCagnotte'];

    //ajoutena ao @CPT mot_doux ilay message t@ty participation ty
    $postarr = array(
            'post_type' => 'question',
            'post_title' => substr($question, 0, 40),
            'post_status' => 'publish',
            'post_content' => $question,
            'post_date'  => the_time('d/m/y'),
            'post_author' => get_current_user_id() ? get_current_user_id() : 0
            );


    $editID = strip_tags( $_POST['id_question'] );
    if ($editID != ''){
        $postarr['ID'] =  $editID;
    }

    $newQuestion = wp_insert_post( $postarr, true );

    if (is_wp_error($post_id)) {
        $errors = $post_id->get_error_messages();
        foreach ($errors as $error) {
            echo $error;
            wp_die();
        }
    }else{

        $list_questions = get_field( 'questions', $idCagnotte );

        if( !is_array($list_questions) ):
            $list_questions = array();
        endif;

        array_push( $list_questions, $newQuestion );

        update_field( 'questions', $list_questions , $idCagnotte );

        $html = 'update successfull';

        /*$newQuestion = get_post($newQuestion);
        $user_data = get_user_meta($newQuestion->post_author);
        $date = new DateTime($newQuestion->post_date);
        $html = '';

        if ( $newQuestion == $editID){
            $html .= '<div class="listComment">';
        }
            $html .= '<div class="content-comment">
                        <div class="profil">';
            $html .=          get_avatar( $newQuestion->post_author,80 );
            $html .= '    </div>';
            $html .= '    <b class="author-name">';
            $html .=           $user_data['first_name'][0].' '.$user_data['last_name'][0];
            $html .= '    </b>';
            $html .= '    <span class="date">'.printf( __('a écrit le %s','kotikota'), $date->format('d/m/y') ).'</span>';
            $html .= '    <div class="txt">';
            $html .=        $newQuestion->post_content;
            $html .=     '</div>';
            $html .= ' </div>';
        if ( $newQuestion == $editID)
            $html .= ' <div class="edit">
                        <a href="#" title="" data-edit="'.$editID.'">&#9998;</a>
                      </div>';
        if ( $newQuestion == $editID)
            $html .= ' <div class="delete">
                        <a href="#" title="" data-delete="'.$editID.'">&#10008;</a>
                      </div>';
        if ( $newQuestion == $editID){
            $html .= ' </div>';
        }*/

        echo $html;
        wp_die();
    }
}

add_action( 'wp_ajax_delete_pst', 'delete_pst' );

function delete_pst(){
    $erreur = '';

    if ( !isset($_POST['id']) || $_POST['id'] == "" ){
        $erreur = __("Quoi effacer ?", "kotikota");
        echo "<li>$erreur</li>";
        wp_die();
    }
    $id = strip_tags($_POST['id']);

    if (wp_delete_post($id )) echo "success";

    wp_die();
}

add_action( 'wp_ajax_edit_profile', 'edit_profile' );

function edit_profile(){

    $str = http_build_query($_POST);
    parse_str($str, $Data);
    extract($Data);

    $erreurs = [];

    if ( $lname == "" )
        $erreurs[] = __("Entrez votre nom", "kotikota");

    if ( $fname == "" )
        $erreurs[] = __("Entrez votre prénom", "kotikota");

    if ( $mail == "" || !filter_var( $mail, FILTER_VALIDATE_EMAIL) )
        $erreurs[] = __("Entrez votre adresse email valide.", "kotikota");

    if ( $tel == "" )
        $erreurs[] = __("Entrez votre numéro de téléphone.", "kotikota");

    //if ( $code == "" )
    //    $erreurs[] = __("Entrez votre code indicatif.", "kotikota");

    if ( isset($_POST['newpwd']) && $_POST['newpwd'] != '' ){

        if ( !preg_match(('/.{8,}/'), strip_tags($_POST['newpwd']) ) ){
            $erreurs[] = __("Le mot de passe doit avoir au moins 8 caractères dont 1 minuscule 1 majuscule 1 nombre et 1 caractère spécial", "kotikota");
        }else{
            $newpwd = strip_tags($_POST['newpwd']);
        }
    }

    if( $device != 'mobile' && $device != 'desktop' ){
        $erreurs[] = "Mba tsy rariny kos zan hafetsenao zan dada a";
    }

    if ( $erreurs ){
        /*foreach ($erreurs as &$erreur ){
            $erreur = $erreur;
        }*/
        echo json_encode( $erreurs );
        wp_die();
    }

    $userdata = array(
        'ID'         => get_current_user_id(),
        'first_name' => strip_tags($_POST['fname']),
        'last_name'  => strip_tags($_POST['lname']),
        'user_email' => strip_tags($_POST['mail']),
    );

    if ( isset($newpwd) && $newpwd ){
        $userdata['user_pass'] = $newpwd;
    }

    $update_user = wp_update_user( $userdata );

    if ($update_user && isset($userdata['user_pass']) ){
        $sessions = WP_Session_Tokens::get_instance(get_current_user_id());
        $sessions->destroy_all();
    }



    if( 'mobile' == $device ){
        if ( isset($_POST['choix-photo']) && $_POST['choix-photo'] != '' ){
            $pdp = attachment_url_to_postid( $_POST['choix-photo'] );
        } else if( $_FILES['choix-photo_mobile'] ){
            $pdp = $_FILES['choix-photo_mobile'];
            $pdp = $pdp['name'];

            $pdp = get_image_attach_id ( $pdp, 'user_'. get_current_user_id() );
        }

        if ( isset($_POST['cin_value']) && strip_tags( $_POST['cin_value'] ) != '' ){
            $cin = attachment_url_to_postid(strip_tags($_POST['cin_value']));
        } else if( $_FILES['cin_value_mobile'] ){
            $cin = $_FILES['cin_value_mobile'];
            $cin = $cin['name'];

            $cin = get_image_attach_id ( $cin, 'user_'. get_current_user_id() );
        }

    }else if( 'desktop' == $device ){
        if ( isset($_POST['choix-photo']) && $_POST['choix-photo'] != '' ){
            $pdp = attachment_url_to_postid( $_POST['choix-photo'] );
        }

        if ( isset($_POST['cin_value']) && strip_tags( $_POST['cin_value'] ) != '' ){
            $cin = attachment_url_to_postid(strip_tags($_POST['cin_value']));
        }
    }

    if( $pdp )
        update_field('photo', $pdp, 'user_'.get_current_user_id());

    if( $cin )
        update_field('piece_didentite', $cin, 'user_'.get_current_user_id());

    update_field('code', $_POST['code'], 'user_'.get_current_user_id());
    update_field('numero_de_telephone', strip_tags( $tel ), 'user_'.get_current_user_id());

    $out = array();

    $out[] = __('Votre profil a bien été mis à jour !','kotikota');

    echo  json_encode( $out );

    wp_die();
}

add_action( 'wp_ajax_relance_auto', 'relance_auto' );

function relance_auto(){
    $erreurs = [];

    if ( !isset($_POST['emails']) || $_POST['emails'] == "" )
        $erreurs[] = __("Emails non trouvés", "kotikota");

    if ( !isset($_POST['idCagnotte']) || !is_cagnotte($_POST['idCagnotte']) )
        $erreurs[] = __("ID de cagnotte incorrecte.", "kotikota");

    if ( count($erreurs) ){
        foreach ($erreurs as $erreur ){
             echo "<li>$erreur</li>";
         }
         wp_die();
    }
    $idCagnotte = $_POST['idCagnotte'];
    $emails = array();
    $tmp = $_POST['emails'];
    foreach( $tmp as $t ){
        $emails[] = sanitize_email( $t );
    }

    $resp = sendInvitation( $emails, $idCagnotte );

    echo $resp;

    wp_die();
}

function startsWith($string, $startString) {
  return preg_match('#^' . $startString . '#', $string) === 1;
}

add_action( 'wp_ajax_kk_search', 'kk_search' );
add_action( 'wp_ajax_nopriv_kk_search', 'kk_search' );

function kk_search(){
    if ( empty($_POST['str']) && !isset($_POST['str']) ){
        die();
    }
    $str = strip_tags( $_POST['str'] );

    $metaquery = array(
        array(
            'key'     => 'nom_de_la_cagnotte',
            'value'   => $str,
            'compare' => 'LIKE',
        ),
        array(
            'key' => 'visibilite_cagnotte' ,
            'value' => 'publique',
            'compare' => '=',
        ),
    );

    $args = array(
        'post_type'      => array( 'cagnotte', 'cagnotte-perso' ),
        'posts_per_page' => -1,
        'meta_query'     => $metaquery
        );

    $q = new WP_Query( $args );

    while ( $q->have_posts()) {
        $q->the_post();
        $nom = get_field('nom_de_la_cagnotte');
        $nom = strtolower($nom);
        if ( startsWith( $nom , strtolower($str)) ){
            echo $nom;
        }
    }
    wp_reset_postdata();
    die();
}

# Ajax ao @ BO (liste de toutes les transactions )

add_action( 'wp_ajax_update_cagnotte', 'update_cagnotte' );
function update_cagnotte(){
  if( $_POST['filtre'] == '' )
    wp_die('Paramètre incorrect !');

  $out = array();

  $filtre = strip_tags( $_POST['filtre'] );

  $cagnottes = get_participation_column('id_cagnotte');

  if( is_array($cagnottes) ){
    foreach ($cagnottes as $c) {
      $out['nom_cagnottes'][] = get_field('nom_de_la_cagnotte',  $c->id_cagnotte);
    }
    $_SESSION['filtre_col'] = 'id_cagnotte';
    $out['nom_cagnottes'] = array_unique( $out['nom_cagnottes']);
    $out['msg'] = "OK";
  }else{
    $out['msg'] = "NOK";
  }
  echo json_encode( $out );
  wp_die();
}

add_action( 'wp_ajax_update_paiement', 'update_paiement' );
function update_paiement(){
  if( $_POST['filtre'] == ''  )
    wp_die('Paramètre incorrect !');

  $out = array();

    $_SESSION['filtre_col'] = 'paiement';
    $out['msg'] = "OK";

  echo json_encode( $out );
  wp_die();
}

add_action( 'wp_ajax_update_date', 'update_date' );
function update_date(){
  if( $_POST['filtre'] == ''  )
    wp_die('Paramètre incorrect !');

  $out = array();

  $filtre = strip_tags( $_POST['filtre'] );

  $cagnottes = get_participation_column('date');

  if( is_array($cagnottes) ){
    foreach ($cagnottes as $c) {
      $date = explode(' ', $c->date);
      $date = $date[0];
      $out['date'][] = $date;
    }
    $_SESSION['filtre_col'] = 'date';
    $out['date'] = array_unique( $out['date']);
    $out['msg'] = "OK";
  }else{
    $out['msg'] = "NOK";
  }

  echo json_encode( $out );
  wp_die();
}

add_action( 'wp_ajax_update_reset', 'update_reset' );
function update_reset(){
  if( $_POST['filtre'] == ''  )
    wp_die('Paramètre incorrect !');

  unset( $_SESSION['filtre_col'] );
  unset( $_SESSION['filtre_tri'] );

  $out = array();
  $out['msg'] = 'reload';

  echo json_encode( $out );
  wp_die();
}

function get_participation_column( $column_name ){
  global $wpdb;
  $participation = $wpdb->prefix.'participation';

  $results = $wpdb->get_results(
      "SELECT $column_name FROM $participation
      WHERE est_finalise = 1
      ORDER BY id_participation DESC"
  );

  return $results;
}

add_action( 'wp_ajax_cloturer_cagnotte', 'cloturer_cagnotte' );
function cloturer_cagnotte(){
    if( isset( $_POST ) && !empty( $_POST ) ){
        $id = $_POST['id_a_cloturer'];

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
    wp_die();
}

add_action( 'wp_ajax_insert_doc_cagnotte', 'insert_doc_cagnotte' );
function insert_doc_cagnotte(){
    $erreurs = [];

    if ( isset($_POST)){
        $html="";
        $str = http_build_query($_POST);
        parse_str($str, $Data);
        extract($Data);

        $doc = attachment_url_to_postid(strip_tags($doc_file));
        $add_doc = add_row('liste_document_fichiers_cagnotte',array('fichier' => $doc),$cagnotte_id);
        $titulaire_id = get_field('titulaire_de_la_cagnotte',$cagnotte_id);
        $curr_userdata = wp_get_current_user();
        if($add_doc){
            $docs = get_field('liste_document_fichiers_cagnotte',$cagnotte_id);
            if($docs ):
                $key_field=1;
                $word_doc=[];
                $pdf_doc=[];
                foreach($docs as $doc ):
                  $file_data=[];
                  $fichier_id = $doc['fichier'];
                  $file_data['id'] = $key_field;
                  $fichier = get_attached_file( $fichier_id);
                  $file_data['name'] = basename ( $fichier );
                  $file_data['url'] =wp_get_attachment_url( $fichier_id );;
                  $extension = pathinfo( $fichier )['extension'];
                  if($extension=='pdf'):
                      $pdf_doc[]=$file_data;
                  elseif($extension=='docx' || $extension=='docx'):
                      $word_doc[]=$file_data;
                  endif;
                  $key_field++;
                endforeach;
                ?>
                <div class="row">
                    <div class="col">
                    <h3>documents word</h3>
                    <?php if($word_doc):?>
                        <div class="lst-option">
                        <?php
                        foreach($word_doc as $doc ):
                            $section_document = locate_template( 'parts/single/sections/section-document-word.php', false, false );
                            include($section_document);
                        endforeach; ?>
                        </div>

                    <?php
                    else:
                    ?>
                        <div style="text-align:center">
                            <h4 style="text-align:center">
                                <?php printf( __( 'Aucun document', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                            </h4>
                        </div>
                    <?php endif; ?>
                    </div>
                    <div class="col">
                        <h3>documents pdf</h3>
                        <?php if($pdf_doc):?>
                            <div class="lst-option">
                            <?php foreach($pdf_doc as $doc ):
                              $section_pdf = locate_template( 'parts/single/sections/section-document-pdf.php', false, false );
                              include($section_pdf);
                            endforeach; ?>
                            </div>
                            <?php
                        else:
                        ?>
                            <div style="text-align:center">
                                <h4 style="text-align:center">
                                    <?php printf( __( 'Aucun document', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                                </h4>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
        <?php
        else:
        ?>
            <div style="text-align:center">
                <h4 style="text-align:center">
                    <?php printf( __( 'Aucun document', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                </h4>
            </div>
        <?php
            endif;
            echo $html;

        }

        wp_die();
    }

}

add_action( 'wp_ajax_remove_doc_cagnotte', 'remove_doc_cagnotte' );
function remove_doc_cagnotte(){
    $erreurs = [];

    if ( isset($_POST)){
        $html="";
        $str = http_build_query($_POST);
        parse_str($str, $Data);
        extract($Data);

        $delete_doc=false;
        foreach($file_ids as $id){
            $delete_doc = delete_row('liste_document_fichiers_cagnotte', $id, $cagnotte_id);
        }
        $titulaire_id = get_field('titulaire_de_la_cagnotte',$cagnotte_id);
        $curr_userdata = wp_get_current_user();
        if($delete_doc){
            $docs = get_field('liste_document_fichiers_cagnotte',$cagnotte_id);
            if($docs ):
                $key_field=1;
                $word_doc=[];
                $pdf_doc=[];
                foreach($docs as $doc ):
                  $file_data=[];
                  $fichier_id = $doc['fichier'];
                  $file_data['id'] = $key_field;
                  $fichier = get_attached_file( $fichier_id);
                  $file_data['name'] = basename ( $fichier );
                  $file_data['url'] =wp_get_attachment_url( $fichier_id );;
                  $extension = pathinfo( $fichier )['extension'];
                  if($extension=='pdf'):
                      $pdf_doc[]=$file_data;
                  elseif($extension=='docx' || $extension=='docx'):
                      $word_doc[]=$file_data;
                  endif;
                  $key_field++;
                endforeach;
                ?>
                <div class="row">
                    <div class="col">
                    <h3>documents word</h3>
                    <?php if($word_doc):?>
                        <div class="lst-option">
                        <?php foreach($word_doc as $doc ):
                            $section_document = locate_template( 'parts/single/sections/section-document-word.php', false, false );
                            include($section_document);
                        endforeach; ?>
                        </div>

                    <?php
                    else:
                    ?>
                        <div style="text-align:center">
                            <h4 style="text-align:center">
                                <?php printf( __( 'Aucun document', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                            </h4>
                        </div>
                    <?php endif; ?>
                    </div>
                    <div class="col">
                        <h3>documents pdf</h3>
                        <?php if($pdf_doc):?>
                            <div class="lst-option">
                            <?php foreach($pdf_doc as $doc ):
                              $section_pdf = locate_template( 'parts/single/sections/section-document-pdf.php', false, false );
                              include($section_pdf);
                            endforeach; ?>
                            </div>
                            <?php
                        else:
                        ?>
                            <div style="text-align:center">
                                <h4 style="text-align:center">
                                    <?php printf( __( 'Aucun document', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                                </h4>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
        <?php
            else:
            ?>
                <div style="text-align:center">
                    <h4 style="text-align:center">
                        <?php printf( __( 'Aucun document', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                    </h4>
                </div>
        <?php
            endif;
            echo $html;

        }

        wp_die();
    }

}

add_action( 'wp_ajax_insert_image_cagnotte', 'insert_image_cagnotte' );
function insert_image_cagnotte(){
    $erreurs = [];

    if ( isset($_POST)){
        $html="";
        $str = http_build_query($_POST);
        parse_str($str, $Data);
        extract($Data);

        $image = attachment_url_to_postid(strip_tags($image_url));
        $add_doc = add_row('liste_images_cagnotte',array('image' => $image),$cagnotte_id);
        $titulaire_id = get_field('titulaire_de_la_cagnotte',$cagnotte_id);
        $curr_userdata = wp_get_current_user();
        $photos = get_field('liste_images_cagnotte',$cagnotte_id);

       ?>
            <h3><?php _e('images','kotikota') ?></h3>
            <?php if($photos): $key_image=1;?>
            <div class="lst-option blcphotos">
                <?php foreach($photos as $photo ):
                    $image = wp_get_attachment_url( $photo['image'] );
                    $section_photo = locate_template( 'parts/single/sections/section-document-photo.php', false, false );
                    include($section_photo);
                    $key_image++;
                endforeach; ?>
            </div>
            <?php
            else:
            ?>
                <div style="text-align:center">
                    <h4 style="text-align:center">
                        <?php printf( __( 'Aucune image', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                    </h4>
                </div>
            <?php endif; ?>
            </div>
       <?php
        echo $html;


        wp_die();
    }

}

add_action( 'wp_ajax_insert_video_cagnotte', 'insert_video_cagnotte' );
function insert_video_cagnotte(){
    $erreurs = [];

    if ( isset($_POST)){
        $html="";
        $str = http_build_query($_POST);
        parse_str($str, $Data);
        extract($Data);

        $video_data = get_youtube_video_detail($video_id);
        if(!$video_data){
            echo "Veuillez entrer un ID valide !";
            wp_die();
        }
        $add_doc = add_row('liste_videos_cagnotte',array('lien_youtube' => $video_id),$cagnotte_id);
        $titulaire_id = get_field('titulaire_de_la_cagnotte',$cagnotte_id);
        $curr_userdata = wp_get_current_user();
        $videos = get_field('liste_videos_cagnotte',$cagnotte_id);

       ?>
            <h3><?php _e('vidéos','kotikota') ?></h3>
            <div class="lst-option blcvideos ">
                <?php if($videos):
                    $key_video=1;
                    $count_correct_id=0;
                ?>
                <div class="lst-option">
                    <?php foreach($videos as $video ):
                        $video_id= $video['lien_youtube'];
                        $video_data = get_youtube_video_detail($video_id);
                        if($video_data): $count_correct_id++;
                            $section_video = locate_template( 'parts/single/sections/section-document-video.php', false, false );
                            include($section_video);
                        endif;
                        $key_video++;
                    endforeach; ?>
                </div>

                <?php
                elseif($count_correct_id!=count($videos)):
                ?>
                    <div style="text-align:center">
                        <h4 style="text-align:center">
                            <?php printf( __( 'Aucune video', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                        </h4>
                    </div>

                <?php   else: ?>
                    <div style="text-align:center">
                        <h4 style="text-align:center">
                            <?php printf( __( 'Aucune video', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                        </h4>
                    </div>
                <?php endif; ?>
            </div>
       <?php
        echo $html;


        wp_die();
    }

}

add_action( 'wp_ajax_remove_photos_cagnotte', 'remove_photos_cagnotte' );
function remove_photos_cagnotte(){
    $erreurs = [];

    if ( isset($_POST)){
        $html="";
        $str = http_build_query($_POST);
        parse_str($str, $Data);
        extract($Data);

        $delete_image=false;
        if($image_ids && !empty($image_ids)){
            foreach($image_ids as $id){
                $delete_image = delete_row('liste_images_cagnotte', $id, $cagnotte_id);
            }
        }
        $titulaire_id = get_field('titulaire_de_la_cagnotte',$cagnotte_id);
        $curr_userdata = wp_get_current_user();
        $photos = get_field('liste_images_cagnotte',$cagnotte_id);

       ?>
            <h3><?php _e('images','kotikota') ?></h3>
            <?php if($photos): $key_image=1;?>
            <div class="lst-option blcphotos">
                <?php foreach($photos as $photo ):
                    $image = wp_get_attachment_url( $photo['image'] );
                    $section_photo = locate_template( 'parts/single/sections/section-document-photo.php', false, false );
                    include($section_photo);
                    $key_image++;
                endforeach; ?>
            </div>
            <?php
            else:
            ?>
                <div style="text-align:center">
                    <h4 style="text-align:center">
                        <?php printf( __( 'Aucune image', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                    </h4>
                </div>
            <?php endif; ?>
            </div>
       <?php
        echo $html;


        wp_die();
    }

}


add_action( 'wp_ajax_remove_videos_cagnotte', 'remove_videos_cagnotte' );
function remove_videos_cagnotte(){
    $erreurs = [];

    if ( isset($_POST)){
        $html="";
        $str = http_build_query($_POST);
        parse_str($str, $Data);
        extract($Data);

        if($video_ids && !empty($video_ids)){
            foreach($video_ids as $id){
                $delete_video = delete_row('liste_videos_cagnotte', $id, $cagnotte_id);
            }
        }
        $titulaire_id = get_field('titulaire_de_la_cagnotte',$cagnotte_id);
        $curr_userdata = wp_get_current_user();
        $videos = get_field('liste_videos_cagnotte',$cagnotte_id);

        ?>
            <h3><?php _e('vidéos','kotikota') ?></h3>
            <div class="lst-option blcvideos ">
                <?php if($videos):
                    $key_video=1;
                    $count_correct_id=0;
                ?>
                <div class="lst-option">
                    <?php foreach($videos as $video ):
                        $video_id= $video['lien_youtube'];
                        $video_data = get_youtube_video_detail($video_id);
                        if($video_data): $count_correct_id++;
                            $section_video = locate_template( 'parts/single/sections/section-document-video.php', false, false );
                            include($section_video);
                        endif;
                        $key_video++;
                    endforeach; ?>
                </div>

                <?php
                elseif($count_correct_id!=count($videos)):
                ?>
                    <div style="text-align:center">
                        <h4 style="text-align:center">
                            <?php printf( __( 'Aucune video', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                        </h4>
                    </div>

                <?php   else: ?>
                    <div style="text-align:center">
                        <h4 style="text-align:center">
                            <?php printf( __( 'Aucune video', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                        </h4>
                    </div>
                <?php endif; ?>
            </div>
        <?php
        echo $html;


        wp_die();
    }

}