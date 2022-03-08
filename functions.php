<?php

// add_action('init', 'go_startSession', 1);
// function go_startSession() {
//     if(!session_id()) {
//         session_start();
//     }
// }

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
    "phone"               => $phone,
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

  var_dump($participant);


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

  function get_beneficiaire_info( $idBenef ){
    $info = new stdClass();
    $info->nom    = get_field('nom_benef', $idBenef ) != '' ? get_field('nom_benef', $idBenef ) : get_the_title( $idBenef );
    $info->prenom = get_field('prenom_benef', $idBenef );
    $info->email  = get_field('email_benef', $idBenef );
    $info->telephone = get_field('telephone_benef', $idBenef );
    $info->rib    = get_field('rib_benef', $idBenef );
    $info->code    = get_field('code_benef', $idBenef );

    return $info;
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