<?php

// add_action('init', 'go_startSession', 1);
// function go_startSession() {
//     if(!session_id()) {
//         session_start();
//     }
// }
define ( 'CACHE_DIR', WP_CONTENT_DIR . '/uploads/pdfs/');

add_action( 'wp_enqueue_scripts', 'kotikota_enqueue_styles' );
function kotikota_enqueue_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); 
} 

// CSS, JS, IMAGES...
require_once( 'inc/load-script.php');

// theme customizer
require_once 'inc/theme-customizer.php';

require_once 'inc/email.php';
require_once 'inc/kotikota-ajax.php';
require_once 'inc/api-orange-money.php';
require_once 'inc/api-mvola.php';
require_once 'inc/api-airtel.php';
require_once 'inc/api-bnipay.php';

//CRON 
require_once 'inc/kk-cron.php';

#Liste des cagnottes perso
#et solidaires

function categoriser_les_cagnottes(){
  $parents = get_terms( array(
      'taxonomy'   => 'categ-cagnotte',
      'hide_empty' => false,
  ) );

  $cagnottes_personnelles_ids = array();
  $cagnottes_solidaires_ids   = array();

  if( is_array( $parents ) ){
    foreach ( $parents as $parent ){
      $enfants = get_terms( array( 
          'taxonomy'   => 'categ-cagnotte',
          'hide_empty' => false,
          'orderby'    => 'tax_position',
          'order'      => 'ASC',
          'meta_key'   => 'tax_position',
          'child_of'   => $parent->term_id
      ));

      if( is_array( $enfants ) ){
        foreach( $enfants as $enfant ){
          $categorie = get_field('selectionner_la_categorie', 'categ-cagnotte_'. $enfant->term_id);

          if( 'perso' == $categorie['value'] ){
            $cagnottes_personnelles_ids[] = $enfant->term_id;
          }elseif( 'solid' == $categorie['value'] ){
            $cagnottes_solidaires_ids[] = $enfant->term_id;
          }
        }
      }
    }
  }

  return array( 
    'personnelles' => $cagnottes_personnelles_ids, 
    'solidaires' => $cagnottes_solidaires_ids 
  );
  
}

function wpb_sender_name( $original_email_from ) {
    return 'Team Koti-Kota';
}
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

function get_slug() {
  $slug = esc_html($_SERVER['REQUEST_URI'] );
  $slugs = explode('/', $slug );

    return  $slugs[1];
}

function save_participant( $idCagnotte, $email, $lname, $fname, $phone, $donation, $paiement, $maskParticipation, $maskIdentite, $mot_doux, $devise  ){
  global $wpdb;

  $customer_table = $wpdb->prefix.'participation';

   $mot_doux = $mot_doux == '' ? '' : $mot_doux;

  $wpdb->insert($customer_table, array(
    "id_cagnotte"           => $idCagnotte,
    "email"               => $email,
    "lname"               => $lname,
    "fname"               => $fname,
    "phone"               =>  str_replace(' ', '', $phone),
    "donation"            => $donation,
    "devise"              => $devise,
    "paiement"            => $paiement,
    "maskParticipation"   => $maskParticipation,
    "maskIdentite"        => $maskIdentite,
    "date"                => date("d-m-Y h:i:s"),
    "mot_doux"            => $mot_doux,    
  ));
  return $wpdb->insert_id;
}

function insert_participant( $idCagnotte, $email, $lname, $fname, $phone, $donation, $modeDePaiement, $maskParticipation, $maskIdentite ){
  //alaina izay participant manana an'io email io (car email est unique)
  $oldParticipant = get_posts(array(
          'post_type' => 'participant',
          'meta_query' => array(
              array(
                  'key' => 'email_participant',
                  'value' => $email
              )
          )
      ));
 
  if ( empty($oldParticipant) ) { //raha mbola tsy ao ilay email
      //echo "DEBUG: nouvel email<br>";
      $metas = array(
              'nom_participant'       => $lname,
              'prenom_participant'    => $fname,
              'email_participant'     => $email,
              'telephone_participant' => $phone,
          );

      $postarr = array(
              'post_type'  => 'participant',
              'post_title' => $fname.' '.$lname,
              'post_status'=> 'publish',
              'meta_input' => $metas
          );
     

      $newParticipant = wp_insert_post( $postarr, true ); 

      if (is_wp_error($post_id)) { //echo "nouvel email: error insert<br>";
          $errors = $post_id->get_error_messages();
          foreach ($errors as $error) {
              echo $error;
          }
          $success = false;
      }else{ //vita tsara insertion
          //echo "nouvel email: success insert<br>";
          update_field('email_participant', $email, $newParticipant);

          $vals = array(
                  'montant_paye' => $donation,
                  'masque_participation' => $maskParticipation,
                  'masque_identite' => $maskIdentite,
                  'mode_paiement'  => $modeDePaiement,
                  'cagnotte' => (int)$idCagnotte
                  );

          $valsCagnotte = array(
              'participant_' => $newParticipant
              );

          add_row( 'toutes_cagnottes_participees', $vals, $newParticipant ); //ajouter dans participant la cagnotte
          
          add_row('tous_les_participants', $valsCagnotte, $idCagnotte ); // ajouter dans cagnotte le participant
          //echo "Ajouténa any @participant ny cagnotte - Ajouténa any @cagnotte ny participant";
          $success = true;
      }
  }else{ //raha efa niasa tao ilay email

      $participant_id = $oldParticipant[0]->ID;
      $newPostKey = (get_post_status($participant_id)) ? 'ID' : 'import_id';

      $metas = array(
              'nom_participant'       => $lname,
              'prenom_participant'    => $fname,
              'telephone_participant' => $phone,                
          );

      $postarr = array(
              $newPostKey  => $participant_id,
              'post_title' => $fname.' '.$lname,
              'meta_input' => $metas
          );

      $update_participant = wp_update_post($postarr, true);

      if (is_wp_error($post_id)) {
          $errors = $post_id->get_error_messages();
          foreach ($errors as $error) {
              echo $error;
          }
          $success = false;
      }else{
          $toutes_cagnottes_participees = get_field('toutes_cagnottes_participees',$update_participant); 
          $row = 1;
          $toutes_cagnottes_participees_id = [];
           foreach ($toutes_cagnottes_participees as $cagn ){ 
              $toutes_cagnottes_participees_id[] = $cagn['cagnotte']->ID;
              if ( $cagn['cagnotte']->ID == $idCagnotte ){
                  //echo "efa nanome t@io cagnotte io email io ==> atao ++ ny participation ef vitany<br>";
                  $newMontant = (int)$cagn['montant_paye']; 
                  $newMontant = $newMontant  + (int)$donation;
                  $vals = array(                        
                      'montant_paye' => $newMontant,
                      'masque_participation' => $maskParticipation,
                      'mode_paiement'  => $paiement,
                      'masque_identite' => $maskIdentite,
                      );
                  update_row( 'toutes_cagnottes_participees', $row, $vals, $update_participant );
                  
              }
              $row++;
           }
           if ( !in_array( $idCagnotte, $toutes_cagnottes_participees_id) ){
              //echo "Tsy mbola nanome t@io cagnotte io ilay email fa mi-existe fotsn ==> ajouténa ao @participant ilay cagnotte<br>";
               $vals = array(
                  'montant_paye' => $donation,
                  'masque_participation' => $maskParticipation,
                  'masque_identite' => $maskIdentite,
                  'mode_paiement'  => $paiement,
                  'cagnotte' => (int)$idCagnotte
                  );
              add_row( 'toutes_cagnottes_participees', $vals, $update_participant );

              $valsCagnotte = array(
              'participant_' => $update_participant
              );
              add_row('tous_les_participants', $valsCagnotte, $idCagnotte );
           }  
           $success = true;       
      }
  }


   //atao + ny montant efa tao ny vaovao d atao MAJ ny cagnotte
  $montantNow = (int)get_field('montant_recolte',$idCagnotte);
  $montantVao = $montantNow + (int)$donation;
  update_field( 'montant_recolte', $montantVao, $idCagnotte);

  return $success;
}

function insert_mot_doux( $idCagnotte, $lname, $fname, $mot_doux ){
  //ajoutena ao @CPT mot_doux ilay message t@ty participation ty    
    $postarr = array(
            'post_type' => 'mot_doux',
            'post_title' => $fname.' '.$lname,
            'post_status' => 'publish',
            'post_content' => $mot_doux 
            );

    $nouveauMotDoux = wp_insert_post( $postarr, true ); 

    if (is_wp_error($post_id)) { //echo "nouvel email: error insert<br>";
        $errors = $post_id->get_error_messages();
        foreach ($errors as $error) {
            echo $error;
        }
        $success = false;
    }else{
        $success = true;

        $list_mot_doux = get_field( 'mot_doux', $idCagnotte ); 

        if( !is_array($list_mot_doux) ):
            $list_mot_doux = array();
        endif;

        array_push( $list_mot_doux, $nouveauMotDoux );

        update_field( 'mot_doux', $list_mot_doux , $idCagnotte );
    }

    return $success;
}

function get_user_participation($email_participant){
  //prendre les information participant
  $participant = get_posts(array(
    'post_type' => 'participant',
    'meta_query' => array(
        array(
            'key' => 'email_participant',
            'value' => $email_participant
        )
    )
  ))[0];

  $participations = [];

  if($participant):
    //prendres toutes les cagnottes auxquelles le participant a contribué
    $toutes_cagnottes_participees = get_field('toutes_cagnottes_participees',$participant->ID); 
    $toutes_cagnottes_participees_id = [];
    foreach ($toutes_cagnottes_participees as $cagn ){ 
      $toutes_cagnottes_participees_id[] = $cagn['cagnotte']->ID; //prendre les ids des cagnottes
    }

    //prendre les cagnottes
    $per_page = get_field('per_page','options');
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(  
          'post_type' => array('cagnotte','cagnotte-perso'),
          'post_status' => 'publish',
          'posts_per_page' => $per_page, 
          'orderby' => 'ID',
          'order' => 'DESC',
          'paged' => $paged,
          'post__in' => $toutes_cagnottes_participees_id
          
    );

    $participations = query_posts( $args );
  endif;

  return $participations;
}


function get_participation( $id_participation, $email = null, $est_finalise = 'false' ){
  global $wpdb;
  $participation = $wpdb->prefix.'participation';

  if ( $email !== null ){
    $result = $wpdb->get_results(
      "SELECT * FROM $participation 
      WHERE id_participation = '$id_participation'     
          AND email = '$email'
          AND est_finalise = '$est_finalise' "
    ); 
  }else{
    $result = $wpdb->get_results(
      "SELECT * FROM $participation 
      WHERE id_participation = '$id_participation'
          AND est_finalise = '$est_finalise' "
    );
  }
  
  if (!empty($result)) {
      return $result[0];
  }else {
      return false;
  }
}

function update_participation( $id_participation ){
  global $wpdb;
  $participation = $wpdb->prefix.'participation';
  $up_part = $wpdb->update($participation, 
      array(
          "est_finalise"     => 1,
      ),
      array(
        "id_participation" => $id_participation
      )
  );
  if($up_part){
      return true;
  }else {
      return false;
  }
}

function get_devise_cagnotte( $id_cagnotte ){
  $devise = get_field('devise', $id_cagnotte );
  if( array_key_exists('value', $devise) ){
   $devise = $devise['value'];
  }else{
    $devise = $devise[1];
  }
  return $devise;
}

function get_parameters(){
  $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $url_components = parse_url($url);
  parse_str($url_components['query'], $params); 

  return $params;
}

function is_cagnotte($idCagnotte){
  $res = false;
  if ( get_post_type( $idCagnotte ) == "cagnotte" || get_post_type( $idCagnotte ) == "cagnotte-perso" ){
    $res = true;
  }

  return $res;
}

function create_table(){
  global $wpdb;  
  
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );  
    
  $table_name = $wpdb->prefix . "newTitulaire";  
    
  $sql = "CREATE TABLE $table_name ( 
          id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, 
          id_author bigint(20) DEFAULT 0 NOT NULL, 
          first_cagnotte VARCHAR(255) DEFAULT '' NOT NULL, 
          24h_apres VARCHAR(255) DEFAULT '' NOT NULL,
          36h_apres VARCHAR(255) DEFAULT '' NOT NULL,
          48h_apres VARCHAR(255) DEFAULT '' NOT NULL,
          compte_actif tinyint(1) DEFAULT 0 NOT NULL,
          nbr_rappel tinyint(1) DEFAULT 0 NOT NULL,
          PRIMARY KEY  (id) 
      );";  
        
  dbDelta( $sql );  
    
  echo $wpdb->last_error;  
  die();  
}

function convert_montant( $donation, $devise_cagnotte, $devise ){
  //alaina alou ny taux 
  $eu_mga = (int)get_field('change_mga_eu', 'option');
  $liv_mga = (int)get_field('change_mga_liv', 'option');
  $liv_eu = (int)get_field('change_eu_liv', 'option');

  if ( $devise_cagnotte == $devise ){
      //pas de conversion
  }elseif ( $devise_cagnotte == 'mga' && $devise == 'liv' ){
      $donation = $donation * $liv_mga;
  }elseif( $devise_cagnotte == 'mga' && $devise == 'eu' ){
      $donation = $donation * $eu_mga;
  }elseif( $devise_cagnotte == 'liv' && $devise == 'mga' ){
      $donation = $donation / $liv_mga;
  }elseif( $devise_cagnotte == 'liv' && $devise == 'eu' ){
      $donation = $donation / $liv_eu;
  }elseif( $devise_cagnotte == 'eu' && $devise == 'mga' ){
      $donation = $donation /  $eu_mga;
  }elseif( $devise_cagnotte == 'eu' && $devise == 'liv' ){
      $donation = $donation * $liv_eu;
  }

  return $donation;
}

function traitement_post_paiement( $participation ){
  $success = false;

  update_participation( $participation->id_participation ); //est_finalisé = 1

  $idCagnotte = $participation->id_cagnotte;
  $email      = $participation->email;
  $lname      = $participation->lname;
  $fname      = $participation->fname;
  $phone      = $participation->phone;
  $donation   = $participation->donation;
  $paiement   = $participation->paiement;
  $maskParticipation = $participation->maskParticipation;
  $maskIdentite      = $participation->maskIdentite;
  $devise            = $participation->devise;

  //convertir la donation dans le même devise si différent de devise cagnotte

  $devise_cagnotte = get_field('devise', $idCagnotte);
  if ( array_key_exists( 'value', $devise_cagnotte) ){
    $devise_cagnotte = $devise_cagnotte['value'];
  }else{
    $devise_cagnotte = $devise_cagnotte[1];
  }

  $donation = convert_montant( $donation, $devise_cagnotte, $devise );

  $mot_doux = $participation->mot_doux;
  $success = insert_participant( $idCagnotte, $email, $lname, $fname, $phone, $donation, $paiement, $maskParticipation, $maskIdentite );

  if ( $success && $mot_doux != '' ){       
      $success = insert_mot_doux( $idCagnotte, $lname, $fname, $mot_doux ); 
   }

  if ( get_field('recevoir_les_notifications_de_participation_par_e-mail', $idCagnotte ) )
      sendNotificationParticipation($idCagnotte);

  $titulaire = get_field('titulaire_de_la_cagnotte', $idCagnotte );
  $prenom = get_user_meta($titulaire);
  $prenom = $prenom['first_name'][0];
  if ( !$prenom )
      $prenom = $prenom['nickname'][0];

  return $success;
}

function get_ids_titulaires(){
  global $wpdb;

  $user_table = $wpdb->prefix.'users';

  $users = $wpdb->get_results(
    "SELECT ID FROM $user_table"
  );
  $out = array();
  if (!empty($users)) {
    foreach( $users as $user ){
        $user_meta = get_userdata( $user->ID );
        $user_roles = $user_meta->roles;
        if ( $user_roles[0] != 'administrator' ){
          $profil_valide = get_field('profil_valide', 'user_'.$user->ID );
          if( !$profil_valide ){
            $out[] = $user->ID;
          }          
        }
    }
    return $out;
  }else {
      return false;
  }
}

function get_nbre_cagnotte_by_id( $id = 0 ){
  $arg = array(
    'post_type'   => array( 'cagnotte', 'cagnotte-perso'),
    'meta_query'  => array(
      array(
        'key' => 'titulaire_de_la_cagnotte',
        'value' => $id
      )
    ),
  );

  $q = new WP_Query( $arg );
  $i = 0;
  while( $q->have_posts() ){
    $q->the_post();
    $i++;
  }
  wp_reset_query();

  return $i;
}

function is_first_cagnotte_de( $id = 0 ){
  $nbr_cagnotte = get_nbre_cagnotte_by_id( $id );

  if ( $nbr_cagnotte == 0 ){
    return true;
  }else{
    return false;
  }
}

function get_user_info_by_id( $id = 0 ){
  global $wpdb;

  $user_table = $wpdb->prefix.'users';

  $user = $wpdb->get_results(
    "SELECT user_email, display_name FROM $user_table
    WHERE ID = '$id'"
  );

  if (!empty($user)) {
    return $user[0];
  }else {
      return false;
  }
}

function get_all_transactions($col = '*', $orderby = 'id_participation', $order = 'DESC'){
    global $wpdb;
    $participation = $wpdb->prefix.'participation';

    $results = $wpdb->get_results(
        "SELECT $col FROM $participation 
        WHERE est_finalise = 1
        ORDER BY $orderby $order"
    );

    return $results;
  }

  function get_all_transactions_by_cagnotte_name($cagnotte, $orderby = 'id_participation', $order = 'DESC'){
      global $wpdb;
      $participation = $wpdb->prefix.'participation';
      $posts = $wpdb->prefix.'posts';

      $results = $wpdb->get_results(
        "SELECT * 
        FROM $participation as particip
        LEFT JOIN $posts as posts
        ON particip.id_cagnotte = posts.ID
        WHERE particip.est_finalise = 1
        AND posts.post_title = '$cagnotte'
        ORDER BY particip.$orderby + 0 $order"
      );

      return $results;
    }

  function get_all_transactions_by_date($date, $orderby = 'id_participation', $order = 'DESC'){
    global $wpdb;
    $participation = $wpdb->prefix.'participation';

    $results = $wpdb->get_results(
      "SELECT * 
      FROM $participation as particip
      WHERE particip.est_finalise = 1 
      AND particip.date LIKE '%$date%'
      ORDER BY $orderby $order"
    );

    return $results;
  }

  function get_all_transactions_by_paiement($paiement, $orderby = 'id_participation', $order = 'DESC'){
    global $wpdb;
    $participation = $wpdb->prefix.'participation';

    $results = $wpdb->get_results(
      "SELECT * 
      FROM $participation as particip
      WHERE particip.est_finalise = 1 
      AND particip.paiement LIKE '%$paiement%'
      ORDER BY $orderby $order"
    );

    return $results;
  }
  
  function clean($string) {
   $string = preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.

   return $string; // Replaces all spaces with hyphens.
  }

  function get_nbr_de_jour_restant( $deadline ){
    $deadline = DateTime::createFromFormat('Ymd', $deadline);
    $now = DateTime::createFromFormat('Ymd', date('Ymd'));
    $diff = $now->diff($deadline)->format("%r%a");
    $diff = $diff < 0 ? 0 : $diff;

    return $diff;
  }

  function get_categorie_cagnotte( $idCagnotte ){
    $parent = array();
    $terms = get_the_terms( $idCagnotte, 'categ-cagnotte');
    foreach( $terms as $term ){
      if( $term->parent == 0 ){
        $parent['id'] = $term->term_id;
        $parent['name'] = $term->name;
      }else{
        $parent['enfant'] = $term->term_id;
      }
    }

    return $parent;
  }

  function get_siblings_categories( $idCagnotte ){
    $parent = get_categorie_cagnotte( $idCagnotte );
    $enfants = get_terms( array( 
        'taxonomy'   => 'categ-cagnotte',
        'hide_empty' => false,
        'orderby'    => 'tax_position',
        'order'      => 'ASC',
        'meta_key'   => 'tax_position',
        'child_of'   => $parent['id'],
    ));
    ob_start();
      foreach ( $enfants as $enfant ):
        $visu = get_field('picto_sous-categorie', 'categ-cagnotte_'. $enfant->term_id);
        $couleur = "";
        if( is_array($visu) && array_key_exists( 'class_de_cette_categorie' , $visu ) ):
            $couleur = $visu['class_de_cette_categorie'];
        endif;
       
      ?>        
           <div class="item <?php if( $parent['enfant'] == $enfant->term_id ) echo 'active' ?>">
               <div class="content">
                   <div class="inner <?php echo $couleur; ?>">
                      <?php echo $enfant->name; ?>
                      <span></span>
                         <input type="hidden" name="sous-categ" value="<?php echo $enfant->term_id ?>"> 
                         <input type="hidden" name="categ" value="<?php echo $parent['id'] ?>">
                  </div>
               </div>
           </div>
      <?php endforeach;

    echo ob_get_clean();    
  }

  function get_beneficiaire_cagnotte( $idCagnotte ){
    $benef_array = get_field('benef_cagnotte', $idCagnotte ); 
    $benef = $benef_array[0];
    
    return $benef;
  }

  function get_beneficiaire_info( $idBenef, $idCagnotte = 0 ){
    $info = new stdClass();
    $info->nom    = get_field('nom_benef', $idBenef ) != '' ? get_field('nom_benef', $idBenef ) : get_the_title( $idBenef );
    $info->prenom = get_field('prenom_benef', $idBenef );
    $info->email  = get_field('email_benef', $idBenef );
    $info->telephone = get_field('telephone_benef', $idBenef );
    $info->rib    = get_field('rib_benef', $idBenef );
    $info->code    = get_field('code_benef', $idBenef );
    
    // RIB
    $info->rib_nom    = get_field('rib_nom', $idCagnotte );
    $info->rib_banque    = get_field('rib_banque', $idCagnotte );
    $info->rib_adresse_de_domiciliation    = get_field('rib_adresse_de_domiciliation', $idCagnotte );
    $info->rib_code_banque    = get_field('rib_code_banque', $idCagnotte );
    $info->rib_code_agence    = get_field('rib_code_agence', $idCagnotte );
    $info->rib_num_de_compte    = get_field('rib_num_de_compte', $idCagnotte );
    $info->rib_cle_rib    = get_field('rib_cle_rib', $idCagnotte );
    $info->rib_iban    = get_field('rib_iban', $idCagnotte );
    $info->rib_bic    = get_field('rib_bic', $idCagnotte );
    $info->rib_file    = get_field('rib_fichier', $idCagnotte );
    
    return $info;
  }
  
  function update_beneficiaire_info_rib( 
    $idCagnotte,
    $rib_nom,
    $rib_banque,
    $rib_adresse_de_domiciliation,
    $rib_code_banque,
    $rib_code_agence,
    $rib_num_de_compte,
    $rib_cle_rib,
    $rib_iban,
    $rib_bic
  )
  {
    if(
      update_field('rib_nom', $rib_nom, $idCagnotte ) &&
      update_field('rib_banque', $rib_banque, $idCagnotte ) &&
      update_field('rib_adresse_de_domiciliation', $rib_adresse_de_domiciliation, $idCagnotte ) &&
      update_field('rib_code_banque', $rib_code_banque, $idCagnotte ) &&
      update_field('rib_code_agence', $rib_code_agence, $idCagnotte ) &&
      update_field('rib_num_de_compte', $rib_num_de_compte, $idCagnotte ) &&
      update_field('rib_cle_rib', $rib_cle_rib, $idCagnotte ) &&
      update_field('rib_iban', $rib_iban, $idCagnotte ) &&
      update_field('rib_bic', $rib_bic, $idCagnotte )
    ){
      $result = true;
    }else{
      $result = false;
    }
    return $result;
  }

  function update_beneficiaire_info( $idBenef,$nom,$prenom,$email,$telephone,$rib = '' ){
    if( 
      update_field('nom_benef', $nom, $idBenef ) &&
      update_field('prenom_benef', $prenom, $idBenef ) &&
      update_field('email_benef', $email, $idBenef ) &&
      update_field('telephone_benef', $telephone, $idBenef ) &&
      update_field('rib_benef', $rib, $idBenef )
    ){
      $result = true;
    }else{
      $result = false;
    }
    return $result;
  }

function choose_photo_and_insert_to_acf( $posted_img, $custom_field_key, $postID ){
  if ( isset($_FILES)){

    if (!function_exists('wp_handle_upload')) {
      require_once(ABSPATH . 'wp-admin/includes/file.php');
    }
    $upload_overrides = array('test_form' => false);

    $files = $posted_img;
  
    if ($files['name']) {
      $file = array(
        'name'     => $files['name'],
        'type'     => $files['type'],
        'tmp_name' => $files['tmp_name'],
        'error'    => $files['error'],
        'size'     => $files['size'],
      );
      $movefile = wp_handle_upload($file, $upload_overrides); 
      
      $image = getimagesize($file['tmp_name']);
      $poids = $file['size'];
      $minimum = array(
          'width' => '1024',
          'height' => '475'
      );
      $maximum = array(
          'width' => '2000',
          'height' => '1500'
      );
      $image_width = $image[0];
      $image_height = $image[1];

      if( $poids > 8000000 ){
          $file['error'] = __('📸 taille 8 Mo autorisée 😉','kotikota'); 
      }
      elseif( !strpos('image', $file['type']) ){
          $file['error'] = __('Format de fichier non pris en charge','kotikota');
      }

      if ( $movefile && !isset( $movefile['error'] ) && 0 == $file['error'] ) {
        $img = $movefile['file'];
        update_field( $custom_field_key, $img, $postID );
        return "success" ;

      }else{
        return $file['error'];
      }
    }
   
  } 
}

function get_user_id_by_display_name( $display ){
  // SELECT ID FROM `wp_users` WHERE `display_name` LIKE '%gp sc%';

  global $wpdb;

  $users         = $wpdb->prefix.'users';

  $result = $wpdb->get_results(
    "SELECT ID 
    FROM $users as u
    WHERE u.display_name = '$display'
    "
  );

  if (!empty($result)) {
    return $result[0];
  }else {
    return false;
  }
}

// function calcul_frais_cagnotte( $idCagnotte, $typeCagnotte ){
//   $montant_recolte = get_field( 'montant_recolte', $idCagnotte );

//   if( 'cagnotte-perso' == $typeCagnotte ){
//     $frais = 6
//   }
// }

function calcul_devise_en_mga( $montant, $devise, $taux_eu, $taux_liv, $taux_cad, $taux_usd ){
  if( 'eu' == $devise ){
    return $montant * $taux_eu;
  }elseif( 'liv' == $devise ){
    return $montant * $taux_liv;
  }elseif( 'cad' == $devise ){
    return $montant * $taux_cad;
  }elseif( 'usd' == $devise ){
    return $montant * $taux_usd;
  }
}

function get_image_attach_id ( $filename, $cagnotteID ) {
      
    // Get the path to the upload directory. 
    // If it was uploaded to WP, wp_upload_dir() does the job
    $wp_upload_dir = wp_upload_dir();
    $full_path = $wp_upload_dir['path'] .'/'. $filename;

    // Check the type of file. We'll use this as the 'post_mime_type'.
    $filetype = wp_check_filetype(basename($full_path), null);

    // Prepare an array of post data for the attachment.
    $attachment = array(
        'guid'           => $wp_upload_dir['url'] . '/' . basename($full_path), 
        'post_mime_type' => $filetype['type'],
        'post_title'     => preg_replace( '/\.[^.]+$/', '', basename($full_path) ),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );

    // Insert the attachment.
    $attach_id = wp_insert_attachment( $attachment, $full_path, $cagnotteID );

    return $attach_id;
}

function get_youtube_video_detail($video_id){
  $video_data=[];
  $myApiKey = 'AIzaSyBhJk7J2pzZ5ZF5K1mlm_V5l3xcKwc6rSU'; 
  $youtubeDataAPI = 'https://www.googleapis.com/youtube/v3/videos?id='. $video_id . '&key=' . $myApiKey . '&part=contentDetails,snippet';

  /* Create new resource */
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  /* Set the URL and options  */
  curl_setopt($ch, CURLOPT_URL, $youtubeDataAPI);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_VERBOSE, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  /* Grab the URL */
  $curlResource = curl_exec($ch);

 /* Close the resource */
  curl_close($ch);

  $youtubeData = json_decode($curlResource);

  $youtubeVals = json_decode(json_encode($youtubeData), true);

  if($youtubeVals['pageInfo']['totalResults']>0){
    $video_data['url'] = "https://www.youtube.com/watch?v=".$video_id;
    $video_data['title'] = $youtubeVals['items'][0]['snippet']['title'];
    $video_data['description'] = wp_trim_words( $youtubeVals ['items'][0]['snippet']['description'], 6, '...' );
    $video_data['vignette'] = $youtubeVals ['items'][0]['snippet']['thumbnails']['standard']['url'];
    $iso8601_duration = $youtubeVals ['items'][0]['contentDetails']['duration'];
    $date_interval= new DateInterval($iso8601_duration);
    $video_data['duration']= $date_interval->i.":".$date_interval->s;
    return $video_data;
  }else{
    return false;
  }
}

function custom_js_to_head() {
    global $post;
    $id = $post->ID;
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $actual_link .= '&rib=1&postID='.$id;
    ?>
    <!--<script>
    jQuery(function(){
        jQuery("body.post-type-cagnotte .wrap a.page-title-action").after('<a href="<?=$actual_link?>" class="page-title-action rib-action">Télécharger RIB</a>');
        jQuery("body.post-type-cagnotte-perso .wrap a.page-title-action").after('<a href="<?=$actual_link?>" class="page-title-action rib-action">Télécharger RIB</a>');      
    });
    </script> -->
    <?php
}
add_action('admin_head', 'custom_js_to_head');

//add_action('admin_enqueue_scripts', 'rib_pdf_admin_enqueue_scripts');
function rib_pdf_admin_enqueue_scripts() {
    global $post;
    $id = $post->ID;
  
    wp_enqueue_script( 'rib-pdf-input-js', get_stylesheet_directory_uri() . '/assets/js/admin-script.js', false, '1.0.0' );
    wp_localize_script( 'rib-pdf-input-js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'postID' => $id ) );  
}

add_action('wp_ajax_download_rib_report', 'download_rib_report_handler');
add_action('wp_ajax_nopriv_download_rib_report', 'download_rib_report_handler');

function download_rib_report_handler() {
    return generate_post_to_pdf_file($_POST['postID']);
}
add_action ( 'admin_init', 'rib_on_admin_Init');
function rib_on_admin_Init() {
  if ( isset($_GET['rib']) ) {
    generate_post_to_pdf_file($_GET['postID']);
  }
  
  if (isset($_GET['message']) && $_GET['message'] == 4) {
    generate_post_to_pdf_file($_GET['post']);
  }
  
}

function generate_post_to_pdf_file($postID) {

      //$logo_width = '';
      $post = get_post ( $postID );
      $content = $post->post_content;
      //echo get_stylesheet_directory_uri();
  
      if (! class_exists ( 'TCPDF' )) {
        require_once  get_stylesheet_directory() . '/libs/tcpdf_min/tcpdf.php';
      }
      /*if (! class_exists ( 'pdfheader' )) {
        require_once  get_stylesheet_directory() . '/pdfheader.php';
      }
      
      if (! class_exists ( 'simple_html_dom_node' )) {
        require_once  get_stylesheet_directory() . '/libs/simplehtmldom/simple_html_dom.php';
      }*/
  
      $filePath = CACHE_DIR . '/' . $post->ID . '.pdf';
      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $pdf->SetCreator ( 'kotikota' . PDF_CREATOR );
      $pdf->SetAuthor ( get_bloginfo ( 'name' ) );
      $pdf_title = 'Informations RIB de la cagnotte ' . $post->post_title;
  
      $pdf->setPrintHeader(false);
      $pdf->AddPage();
      $html .= "<body>";
      $html .= "<h2 style=\"text-align:center\">".apply_filters ( 'the_post_title', $pdf_title )."</h2><hr>";
      $html .= '<br><br>'."Titulaire du compte : " . get_field('rib_nom', $post->ID) .'<br>';
      $html .= '<br>'."Nom de la banque : " .get_field('rib_banque', $post->ID).'<br>';
      $html .= '<br>'."Adresse de domiciliation : " .get_field('rib_adresse_de_domiciliation', $post->ID).'<br>';
      $html .= '<br>'."RIB : " .get_field('rib_code_banque', $post->ID) .' '.get_field('rib_code_agence', $post->ID) .' '.get_field('rib_num_de_compte', $post->ID) .' '.get_field('rib_cle_rib', $post->ID).'<br>';
      $html .= '<br>'."IBAN : " .get_field('rib_iban', $post->ID).'<br>';
      $html .= '<br>'."BIC : " .get_field('rib_bic', $post->ID).'<br>';
      $html .="</body>";
  
      /*$html = '<h1>Welcome to <a href="http://techbriefers.com/" style="text-decoration:none;padding: 10px;"> <span style="background-color:#ef3e47;color:#fff;"> Tech</span><span style="background-color:#fff1f0;color:#000;">Briefers</span> </a>!</h1>
      <i>This is the two minute example of TCPDF library by <a href="http://techbriefers.com/">techbriefers</a>.</i>
      <h2>What is Lorem Ipsum?</h2>
      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>';*/

      $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
      $pdf->Output($filePath, 'F');
      $pdf->Output($post->ID . '.pdf', 'D');
    }
  
  function cvf_td_generate_random_code($length=10) {

     $string = '';
     $characters = "23456789ABCDEFHJKLMNPRTVWXYZabcdefghijklmnopqrstuvwxyz";

     for ($p = 0; $p < $length; $p++) {
         $string .= $characters[mt_rand(0, strlen($characters)-1)];
     }

     return $string;

  }
