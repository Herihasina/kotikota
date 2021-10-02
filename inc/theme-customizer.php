<?php

// social network wp_customize
add_action('customize_register', 'socialnetwork_register_theme_customizer');
function socialnetwork_register_theme_customizer($wp_customize)
{

    // panel
    $wp_customize->add_panel('sn_panel', array(
        'priority' => 500,
        'theme_supports' => '',
        'title' => __('Contact & Social Network', 'kotikota'),
        'description' => __('Edition des réseaux sociaux', 'kotikota'),
    ));

    // section contact
    $wp_customize->add_section('ct_section', array(
        'title' => __('Contact', 'kotikota'),
        'panel' => 'sn_panel',
        'priority' => 1
    ));

    $wp_customize->add_setting('ct_address', array(
        'default' => '<ul><li>'.__('Lot II Lorem ipsum dolor sit amet <br>101 Antananarivo MADAGASCAR', 'kotikota').'</li></ul>',
        //'sanitize_callback' => 'sanitize_textarea'
    ));
    $wp_customize->add_control(new WP_Customize_Control(
            $wp_customize,
            'ct_addr_ctrl',
            array(
                'label' => __('Adresse', 'kotikota'),
                'section' => 'ct_section',
                'settings' => 'ct_address',
                'type' => 'textarea'
            )
        )
    );

    $wp_customize->add_setting('ct_phone', array(
        'default' => '<ul><li>'.__('<a href="tel:+261343200087" title="(+261) 34 32 000 87 ">(+261) 34 32 000 87 </a>', 'kotikota').'</li></ul>',
        //'sanitize_callback' => 'sanitize_textarea'
    ));
    $wp_customize->add_setting('ct_whatsapp', array(
        'default' => '<ul><li>'.__('<a href="tel:+33641012943" title="(+33) 6 41 01 29 43 ">(+33) 6 41 01 29 43 </a>', 'kotikota').'</li></ul>',
        //'sanitize_callback' => 'sanitize_textarea'
    ));
    $wp_customize->add_control(new WP_Customize_Control(
            $wp_customize,
            'ct_phone_ctrl',
            array(
                'label' => __('Téléphone', 'kotikota'),
                'section' => 'ct_section',
                'settings' => 'ct_phone',
                'type' => 'textarea'
            )
        )
    );
    $wp_customize->add_control(new WP_Customize_Control(
            $wp_customize,
            'ct_whatsapp_ctrl',
            array(
                'label' => __('Whatsapp', 'kotikota'),
                'section' => 'ct_section',
                'settings' => 'ct_whatsapp',
                'type' => 'textarea'
            )
        )
    );

    $wp_customize->add_setting('ct_email', array(
        'default' => '<ul><li>'.__('<a href="mailto:kotikota@gmail.com">kotikota@gmail.com</a>', 'kotikota').'</li></ul>',
        //'sanitize_callback' => 'sanitize_textarea'
    ));
    $wp_customize->add_control(new WP_Customize_Control(
            $wp_customize,
            'ct_email_ctrl',
            array(
                'label' => __('E-mail', 'kotikota'),
                'section' => 'ct_section',
                'settings' => 'ct_email',
                'type' => 'textarea'
            )
        )
    );

    // section social network
    $wp_customize->add_section('sn_section', array(
        'title' => __('Réseaux sociaux', 'kotikota'),
        'panel' => 'sn_panel',
        'priority' => 2
    ));

    $wp_customize->add_setting('sn_fb_setting', array(
        'default' => __('#', 'kotikota'),
        'sanitize_callback' => 'sanitize_input'
    ));
    $wp_customize->add_control(new WP_Customize_Control(
            $wp_customize,
            'fb_section',
            array(
                'label' => __('Facebook', 'kotikota'),
                'section' => 'sn_section',
                'settings' => 'sn_fb_setting',
                'type' => 'text'
            )
        )
    );

    $wp_customize->add_setting('sn_insta_setting', array(
        'default' => __('#', 'kotikota'),
        'sanitize_callback' => 'sanitize_input'
    ));
    $wp_customize->add_control(new WP_Customize_Control(
            $wp_customize,
            'insta_section',
            array(
                'label' => __('Instagram', 'kotikota'),
                'section' => 'sn_section',
                'settings' => 'sn_insta_setting',
                'type' => 'text'
            )
        )
    );

    $wp_customize->add_setting('sn_tweet_setting', array(
        'default' => __('#', 'kotikota'),
        'sanitize_callback' => 'sanitize_input'
    ));
    $wp_customize->add_control(new WP_Customize_Control(
            $wp_customize,
            'tweeter_section',
            array(
                'label' => __('Tweeter', 'kotikota'),
                'section' => 'sn_section',
                'settings' => 'sn_tweet_setting',
                'type' => 'text'
            )
        )
    );

    $wp_customize->add_setting('sn_yt_setting', array(
        'default' => __('#', 'kotikota'),
        'sanitize_callback' => 'sanitize_input'
    ));
    $wp_customize->add_control(new WP_Customize_Control(
            $wp_customize,
            'youtube_section',
            array(
                'label' => __('Youtube', 'kotikota'),
                'section' => 'sn_section',
                'settings' => 'sn_yt_setting',
                'type' => 'text'
            )
        )
    );

    function sanitize_input($text)
    {
        return sanitize_text_field($text);
    }

    function sanitize_textarea($text)
    {
        return sanitize_textarea_field($text);
    }
}

// there is no theme activation hook but we can use this instead to update an option upon theme activation
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
    $myavatar = IMG_URL.'no-profil.jpg';
    update_option( 'avatar_default' , $myavatar ); // set the new avatar to be the default 
}
 
// add a new default avatar to the list in WordPress admin
function mytheme_addgravatar( $avatar_defaults ) {
    $myavatar = IMG_URL.'no-profil.jpg';
    $avatar_defaults[$myavatar] = 'No profil';
    return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'mytheme_addgravatar' );

add_action( 'after_setup_theme', 'add_custom_size' );
function add_custom_size(){
    add_image_size( 'cagnotte-home', 320, 210, true );
    add_image_size( 'cagnotte-picto', 50, 50, true );
    add_image_size( 'cagnotte-choix-upload', 95, 90, true );
    add_image_size( 'cagnotte-single', 1025, 420, true );
    add_image_size( 'banniere', 1350, 285, true );
    add_image_size( 'banniere-single', 1024, 421, true );
    add_image_size( 'flag-translate', 31, 31, true );
    add_image_size( 'icone-serasera', 80, 80, true );
}

add_action('after_setup_theme', 'remove_admin_bar');
add_action('after_setup_theme', 'my_theme_setup');
function my_theme_setup(){
    load_theme_textdomain( 'kotikota', get_template_directory() . '/lang' );
}


function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
      show_admin_bar(false);
    }
}

function kotikota_menu() {
  register_nav_menus(
    array(
      'top_menu' => __( 'Menu principal','kotikota' ),
      'top_menu_home' => __( 'Menu Home','kotikota' ),
    )
  );
}
add_action( 'init', 'kotikota_menu' );

function change_menu($items){
    if ( !is_home() && !is_front_page() )
          foreach($items as $item){
            if ( in_array("menu-item-home", $item->classes) ){
                    $item->url = get_bloginfo("url") . "/#comment-ca-marche";
            }
          }
  return $items;
}
add_filter('wp_nav_menu_objects', 'change_menu');

function add_menuclass($ulclass) {
    return preg_replace('/<a/', '<a class="scroll"', $ulclass, -1);
}
add_filter('wp_nav_menu','add_menuclass');

add_action( 'wp_login_failed', 'custom_login_failed' );
function custom_login_failed( $username )
{
    $referrer = wp_get_referer();

    if ( $referrer && ! strstr($referrer, 'wp-login') && ! strstr($referrer,'wp-admin') )
    {
        wp_redirect( add_query_arg('login', 'failed', $referrer) );
        exit;
    }
}

add_filter( 'authenticate', 'custom_authenticate_username_password', 30, 3);
function custom_authenticate_username_password( $user, $username, $password )
{
    if ( is_a($user, 'WP_User') ) { return $user; }

    if ( empty($username) || empty($password) )
    {
        $error = new WP_Error();
        $user  = new WP_Error('authentication_failed', __('<strong>ERREUR</strong>: Identifiant ou mot de passe erroné','kotikota') );

        return $error;
    }
}

function admin_default_page() {
    $user = wp_get_current_user();
    if ( in_array( 'cagnotte-init', (array) $user->roles ) ) {
        return '/new-dashboard-url';
    }
  
}

function start_date_past_or_now( $start ){
    $today = time();
    $start = strtotime( $start );

    if( $start > $today ){
        return false;
    }else{
        return true;
    }
}

function end_date_now_or_future( $end ){
    $today = time();
    $end = strtotime( $end );

    if( $end < $today ){
        return false;
    }elseif( $end >= $today ){
        return true;
    }
}

function is_closed( $idCagnotte ){
    $etat_cloture = get_field('cagnotte_cloturee', $idCagnotte);

    if( $etat_cloture == 'oui' ){
        return true;
    }else{
        return false;
    }
}

add_action( 'wp_loaded', 'check_cagnotte_actif');

function check_cagnotte_actif(){
    $args = array(  
        'post_type' => array('cagnotte'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_key'      => 'actif',
        'meta_value'    => true,  
    );

    $q = new WP_Query( $args ); 
    $res = $q->posts; 
    if ($res){
        foreach($res as $re){
            
            $id = $re->ID;

            $debut = get_field('debut_cagnoote', $id);
            $fin   = get_field('deadline_cagnoote', $id);

            /**
            * si date de début == androany na efa lasa
            * et date de fin == androany na mbola ho avy
            * et cagnotte tsy mbola cloturée
            ==> actif, non cloturee

            * si daate début mbola tsy tonga
            ==> non actif, non cloturee

            * si date de fin dépassé
            ==> non actif, cloturée, et envoi notification
            **/
            if( start_date_past_or_now( $debut ) && end_date_now_or_future( $fin ) && !is_closed( $id ) ){
                update_field('actif', true, $id );
                update_field('cagnotte_cloturee', 'non', $id );

            }elseif( !start_date_past_or_now( $debut ) ){
                update_field('actif', false, $id );
                update_field('cagnotte_cloturee', 'non', $id );

            }elseif( !end_date_now_or_future( $fin ) ){
                update_field('actif', false, $id );
                update_field('cagnotte_cloturee', 'oui', $id);
                notifier_date_fin_cagnotte($id);

            }
        }
        
    }
   
    wp_reset_postdata();

}

function notifier_date_fin_cagnotte($id){
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
    wp_die();
}

function kotikota_pagination($uri ){
 
    global $wp_query;

    $base = home_url().$uri;



    $base = home_url().$uri;
    $uri = explode('/', $uri); 
    $url =  home_url().'/'.$uri[1];
    if (is_search() ){
       $search_query = explode( "/?", $base );
       $search_query = "/?" .$search_query[1];
       $url = home_url();
    }else{
        $search_query = '';
    }
    if (is_tax()){
        $url =  home_url().'/'.$uri[1].'/'.$uri[2];
    }

    $posts_per_page = (int) $wp_query->query_vars['posts_per_page']; 
   
    $current_page = (int) $wp_query->query_vars['paged'];
    
    $max_page = $wp_query->max_num_pages;
 
    if( $max_page <= 1 ) return;
 
    if( empty( $current_page ) || $current_page == 0) $current_page = 1;
 
    $links_in_the_middle = 3;
    $links_in_the_middle_minus_1 = $links_in_the_middle-1;
 
    $first_link_in_the_middle = $current_page - floor( $links_in_the_middle_minus_1/2 );
    $last_link_in_the_middle = $current_page + ceil( $links_in_the_middle_minus_1/2 );
 
    if( $first_link_in_the_middle <= 0 ) $first_link_in_the_middle = 1;
    if( ( $last_link_in_the_middle - $first_link_in_the_middle ) != $links_in_the_middle_minus_1 ) { $last_link_in_the_middle = $first_link_in_the_middle + $links_in_the_middle_minus_1; }
    if( $last_link_in_the_middle > $max_page ) { $first_link_in_the_middle = $max_page - $links_in_the_middle_minus_1; $last_link_in_the_middle = (int) $max_page; }
    if( $first_link_in_the_middle <= 0 ) $first_link_in_the_middle = 1;
 
    $pagination = '<div class="pagination"><ul>';

    if ($current_page != 1)
        $pagination.= '<li class="prev"><a href="'.$url.'/page/' . ($current_page-1).$search_query.'"></a></li>';

    if ($first_link_in_the_middle >= 3 && $links_in_the_middle < $max_page) {
        $pagination.= '<li><a href="'. $url . $search_query . '">1</a></li>';
 
        if( $first_link_in_the_middle != 2 )
            $pagination .= '<li><span>...</span></li>';
 
    }  
 
    for($i = $first_link_in_the_middle; $i <= $last_link_in_the_middle; $i++) {
        if($i == $current_page) {
            $pagination.= '<li class="active"><a href="#">'.$i.'</a></li>';
        } else {
            $pagination .= '<li><a href="'.$url.'/page/' . $i . $search_query .'">'.$i.'</a></li>';
        }
    }
 
    if ( $last_link_in_the_middle < $max_page ) {
 
        if( $last_link_in_the_middle != ($max_page-1) )
            $pagination .= '<li><span>...</span></li>';
 
        $pagination .= '<li><a href="'.$url.'/page/' . $max_page . $search_query .'">'. $max_page .'</a></li>';
    }
  
    if ($current_page != $last_link_in_the_middle )
        $pagination.= '<li class="next"><a href="'.$url.'/page/' . ($current_page+1) . $search_query .'"></a></li>';
 
    $pagination.= "</ul></div>\n";
 
 
    echo str_replace(array("/page/1?", "/page/1\""), array("?", "\""), $pagination);
}





function remplace_mois($mois){
    $wrong = array(
        "Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"
        );
    $ok = array(
        __("janvier","kotikota"),
        __("février","kotikota"),
        __("mars","kotikota"),
        __("mai","kotikota"),
        __("juin","kotikota"),
        __("juillet","kotikota"),
        __("aout","kotikota"),
        __("septembre","kotikota"),
        __("octobre","kotikota"),
        __("novembre","kotikota"),
        __("décembre","kotikota"),
        );
    echo str_replace( $wrong, $ok, $mois );
}

function remplace_mois_($mois){
    $wrong = array(
        "Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"
        );
    $ok = array(
        __("janvier","kotikota"),
        __("février","kotikota"),
        __("mars","kotikota"),
        __("mai","kotikota"),
        __("juin","kotikota"),
        __("juillet","kotikota"),
        __("aout","kotikota"),
        __("septembre","kotikota"),
        __("octobre","kotikota"),
        __("novembre","kotikota"),
        __("décembre","kotikota"),
        );
    return str_replace( $wrong, $ok, $mois );
}


add_action( 'admin_menu', 'my_remove_menu_pages',100 );
function my_remove_menu_pages() {
  global $user_ID;

  if ( current_user_can( 'author' ) ) { //your user id
   remove_menu_page('upload.php'); // Media
   remove_menu_page('link-manager.php'); // Links
   remove_menu_page('edit-comments.php'); // Comments
   remove_menu_page('edit.php?post_type=page'); // Pages
   remove_menu_page('edit.php?post_type=cagnotte'); // Pages
   remove_menu_page('edit.php?post_type=cagnotte-perso'); // Pages
   remove_menu_page('edit.php?post_type=question'); // Pages
   remove_menu_page('edit.php?post_type=mot_doux'); // Pages
   remove_menu_page('edit.php?post_type=participant'); // Pages
   remove_menu_page('edit.php?post_type=faq'); // Pages
   remove_menu_page('plugins.php'); // Plugins
   remove_menu_page('themes.php'); // Appearance
   remove_menu_page('users.php'); // Users
   remove_menu_page('tools.php'); // Tools
   remove_menu_page('options-general.php'); // Settings
   remove_menu_page('edit.php'); // Posts
   remove_menu_page('upload.php'); // Media
   remove_menu_page('index.php'); // Media
   remove_menu_page('post-new.php'); // Media
   remove_menu_page('acf-options');  
  }

  add_submenu_page( 'all-transactions.php', __("Etats de virement des cagnottes","kotikota"), __("Etats de virement des cagnottes","kotikota"), 'administrator', 'status-des-cagnottes', 'list_cagnotte_admin' );
  add_submenu_page( 'all-transactions.php', __("Les cagnottes non virées","kotikota"), __("Les cagnottes non virées","kotikota"), 'administrator', 'les-cagnottes-non-virees', 'list_cagnotte_non_vire_admin' );
}

function list_cagnotte_admin(){
    global $post;

    if ( isset( $_POST['post'] ) ){
        $ids = $_POST['post'];
        foreach ( $ids as $id ){ 
            notificationVirementTitulaire( $id );
            if( true === get_field('notifier_les_participants_lors_de_la_depense_de_la_cagnotte') ){
                $participants = array();
                // andefasana notif daholo ny participant rehetra
                $participants = get_field('tous_les_participants');
                if( count( $participants > 0 ) ):
                    foreach( $participants as $participant ){
                        $part = $participant['participant_'];
                        $partID = $part->ID;
                        $nom_participant = get_field('nom_participant', $partID);
                        $prenom_participant = get_field('prenom_participant', $partID);
                        $email_participant = get_field('email_participant', $partID);

                        $sent = notificationVirementParticipant($id, $emailParticipant, $nomParticipant, $prenomParticipant);
                    }
                endif;
                
            }
            update_field('cagnotte_viree','oui', $id);
        }
    }
?>
    <div class="wrap">
        <h1 class="wp-heading-inline">
            <?php esc_html_e( 'Etat des virements', 'kotikota' );?>
        </h1>
        <form method="post" action="">
        <div class="tablenav top">

            <div class="alignleft actions bulkactions">
                <label for="bulk-action-selector-top" class="screen-reader-text">Sélectionnez les cagnottes à virer</label>
                <input type="submit" id="do-payment" class="button action" value="Virer">
            </div> 
            <br class="clear">
        </div>
        <table class="wp-list-table widefat fixed striped table-view-list posts">
            <thead>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1">Tout sélectionner</label>
                        <input id="cb-select-all-1" type="checkbox">
                    </td>
                    <th scope="col" id="title" class="manage-column column-title column-primary">
                            <span>Nom de la cagnotte</span>
                    </th>
                    <th scope="col" id="benef_cagnotte" class="manage-column column-date"><span>Bénéficiaire de la cagnotte</span></th> 
                    <th scope="col" id="date_debut" class="manage-column column-date"><span>Début de la cagnotte</span></th> 
                    <th scope="col" id="date_fin" class="manage-column column-date"><span>Fin de la cagnotte</span></th> 
                    <th scope="col" id="etat_paiement" class="manage-column column-date"><span>Cagnotte virée</span></th> 
                </tr>
            </thead>
            <tbody id="the-list">
<?php
        $per_page = -1;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $args = array(  
        'post_type' => array('cagnotte','cagnotte-perso'),
        'post_status' => 'publish',
        'posts_per_page' => $per_page, 
        'orderby' => 'ID',
        'order' => 'DESC',
        'paged' => $paged,
        );

        $loop = query_posts( $args );
        if (have_posts()):
            while( have_posts()):
                the_post();
?>
            <tr>
                <th class="check-column">
                    <label for="cb-select-<?php echo $post->ID ?>"><?php __('Sélectionner','kotikota'); ?></label>
                    <input id="cb-select-<?php echo $post->ID ?>" type="checkbox" name="post[]" value="<?php echo $post->ID ?>">
                </th>
                <td class="title column-title has-row-actions column-primary page-title">
                    <strong><?php echo get_field('nom_de_la_cagnotte') ?></strong>
                    <div class="row-actions">
                        <span class="view"><a href="<?php echo get_permalink() ?>">Visualiser</a></span>
                    </div>
                </td>
                <td>
                    <?php 
                        $benef = get_beneficiaire_cagnotte( $post->ID );
                        $info = get_beneficiaire_info( $benef );
                        echo $info->nom. ' '. $info->prenom;
                    ?>
                </td>
                <td>
                    <?php $format = new DateTime(get_field('debut_cagnoote')); echo $format->format('d M y') ?>
                </td>
                <td>
                    <?php $format = new DateTime(get_field('deadline_cagnoote')); echo $format->format('d M y') ?>
                </td>
                <td>
                    <?php echo get_field('cagnotte_viree') ?>
                </td>
            </tr>
<?php
            endwhile;
        endif;
?>
            </tbody>
        </table>
        </form>
    </div>
<?php
}

function list_cagnotte_non_vire_admin(){
    global $post;
?>
    <div class="wrap">
        <h1 class="wp-heading-inline">
            <?php esc_html_e( 'Toutes mes cagnottes non virées', 'kotikota' );?>
        </h1>
        
        <table class="wp-list-table widefat fixed striped table-view-list posts">
            <thead>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1">Tout sélectionner</label>
                        <input id="cb-select-all-1" type="checkbox">
                    </td>
                    <th scope="col" id="title" class="manage-column column-title column-primary">
                            <span>Nom de la cagnotte</span>
                    </th>
                    <th scope="col" id="date_debut" class="manage-column column-date"><span>Début de la cagnotte</span></th> 
                    <th scope="col" id="date_fin" class="manage-column column-date"><span>Fin de la cagnotte</span></th> 
                    <th scope="col" id="etat_paiement" class="manage-column column-date"><span>Cagnotte virée</span></th> 
                </tr>
            </thead>
            <tbody id="the-list">
<?php
        $per_page = -1;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $args = array(  
        'post_type' => array('cagnotte','cagnotte-perso'),
        'post_status' => 'publish',
        'posts_per_page' => $per_page, 
        'orderby' => 'ID',
        'order' => 'DESC',
        'paged' => $paged,
        'meta_query' => array(
            array(
                'key' => 'cagnotte_viree',
                'value' => 'non'
                )
        )
        );

        $loop = query_posts( $args );
        if (have_posts()):
            while( have_posts()):
                the_post();
?>
            <tr>
                <th class="check-column">
                    <label for="cb-select-<?php echo $post->ID ?>"><?php __('Sélectionner','kotikota'); ?></label>
                    <input id="cb-select-<?php echo $post->ID ?>" type="checkbox" name="post[]" value="<?php echo $post->ID ?>">
                </th>
                <td class="title column-title has-row-actions column-primary page-title">
                    <strong><?php echo get_field('nom_de_la_cagnotte') ?></strong>
                    <div class="row-actions">
                        <span class="view"><a href="<?php echo get_permalink() ?>">Visualiser</a></span>
                    </div>
                </td>
                <td>
                    <?php $format = new DateTime(get_field('debut_cagnoote')); echo $format->format('d M y') ?>
                </td>
                <td>
                    <?php $format = new DateTime(get_field('deadline_cagnoote')); echo $format->format('d M y') ?>
                </td>
                <td>
                    <?php echo get_field('cagnotte_viree') ?>
                </td>
            </tr>
<?php
            endwhile;
        endif;
?>
            </tbody>
        </table>
    </div>
<?php
    if ( isset($_POST['post']) ){
        $ids =$_POST['post'];
        foreach ( $ids as $id ){ 
            update_field('cagnotte_viree','non',$id);
        }
    }
}



function hide_update_notice_to_all_but_admin_users()
{
    if (current_user_can('author')) {
        echo '<style type="text/css">
        .update-nag{
            display:none;
        }
        </style>';
        remove_action( 'admin_notices', 'update_nag', 3 );
    }
}
add_action( 'admin_head', 'hide_update_notice_to_all_but_admin_users', 10 );

// add_filter('wp_handle_upload_prefilter', 'author_cagnotte_upload_filter' );

function author_cagnotte_upload_filter( $file ){
    // if ( get_slug() == 'creer-cagnotte' ){
         $img=getimagesize($file['tmp_name']);
        $minimum = array('width' => '1024', 'height' => '420');
        $width= $img[0];
        $height =$img[1];

        if ($width < $minimum['width'] || $height <  $minimum['height'] )
            return array("error"=>__('Image trop petite. Taille minimale requise : ','kotikota').$minimum['width'].' x '. $minimum['height'].' px');
        else
            return $file; 
    // }
}

function acme_change_some_text( $text ) {
    if ( 'New password' === $text ) {
        $text = __('Nouveau mot de passe','kotikota');
    }
    if ( 'Enter your new password below or generate one.' === $text || 'Enter your new password below.' === $text ){
        $text = __('Entrer votre nouveau mot de passe','kotikota');
    }
    if ( 'Strength indicator' === $text ) {
        $text = __('Très faible','kotikota');
    }
    if ( 'Weak' === $text ) {
        $text = __('Faible','kotikota');
    }
    if ( 'Medium' === $text ) {
        $text = __('Moyen','kotikota');
    }
    if ( 'Strong' === $text ) {
        $text = __('Fort','kotikota');
    }
    if ( 'Back to' === $text ) {
        $text = __('Revenir','kotikota');
    }
    if ( 'Confirm use of weak password' === $text ) {
        $text = __('Confirmer le mot de passe faible','kotikota');
    }
    if ( 'Reset Password' === $text || 'Save Password' === $text) {
        $text = __('Réinitialiser','kotikota');
    }
    if ( 'Generate Password' === $text ) {
        $text = __('Générer','kotikota');
    }
    if ( 'Your password has been reset.' === $text ) {
        $text = __('Mot de passe réinitialisé. ','kotikota');
    }

    // Important to return the text stream.
    return $text;
}

// Hook this function up.
add_action( 'gettext','acme_change_some_text' );
add_action( 'ngettext','acme_change_some_text' );

add_filter( 'password_hint', function( $hint )
{
  return __( 'Astuce : 8 caractères dont 1 minuscule 1 majuscule 1 nombre et 1 caractère spécial','kotikota' );
} );



add_filter('pre_get_posts', function ($query) {
    $shouldApply =
        (!is_admin() || (defined('DOING_AJAX') && DOING_AJAX))
        && $query->is_search;

    if ($shouldApply) {
        $query->set('meta_query', array(
        'relation' => 'OR',
            array(
                'key' => 'actif',
                'compare' => '!=',
                'value' => false,
            ),
            array(
                'key' => 'actif',
                'compare' => 'NOT EXISTS',
                'value' => ''
            ),
        ));
    }

    return $query;
});

function posts_for_current_author($query) {
    global $pagenow;
 
    if( 'edit.php' != $pagenow || !$query->is_admin )
        return $query;
 
    if( !current_user_can( 'edit_others_posts' ) ) {
        global $user_ID;
        $query->set('author', $user_ID );
    }
    return $query;
}
add_filter('pre_get_posts', 'posts_for_current_author');

function check_om_transaction(){
  global $wpdb;
  $om = $wpdb->prefix.'om';
  $participation = $wpdb->prefix.'participation';

  $results = $wpdb->get_results(
      "SELECT * FROM $participation as p 
      INNER JOIN $om as o 
          ON p.id_participation = o.id_participation 
      WHERE p.paiement = 'orange'
      ORDER BY id DESC"
  ); 
?>
  <style type="text/css">
    .status_success{
      background: #00C851;
    }
    .status_failed{
      background: #ff4444;
    }
    .status_initiated{
      background: #33b5e5;
    }
    .status{
      color: #fff !important;
      font-weight: bold;
    }
  </style>
  <div class="wrap">
    <div>
      <img src="<?= IMG_URL ?>OM.png" alt="">
    </div>
    <h1 class="wp-heading-inline">
      Les dons via Orange Money
    </h1>
    <?php if ( !is_array($results) ): ?>
      <h2>Aucun don via Orange Money pour l'instant.</h2>
    <?php else: ?>
      <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th><b>Commande</b></th>
                <th>Nom et prénoms du donateur</th>
                <th>Nom de la cagnotte</th>
                <th>Montant</th>
                <th>Etat du don</th>
            </tr>
        </thead>
        <tbody>
        <?php 
          foreach( $results as $res ):
            $status = $res->status;
            switch ( $status ) {
              case 'SUCCESS':
                $status_class = 'status_success';
                break;
              case 'FAILED':
                $status_class = 'status_failed';
                break;
              
              default:
                $status_class = 'status_initiated';
                break;
            }
        ?>
          <tr>
            <td><b><?= $res->order_id ?></b></td>
            <td><?= $res->fname.' '.$res->lname ?></td>
            <td><?= get_field('nom_de_la_cagnotte', $res->id_cagnotte) ?></td>
            <td><?= $res->donation ?></td>
            <td class="status <?= $status_class ?>"><?= $res->status ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
<?php
}

add_action( 'admin_menu', 'om_transaction' );

function om_transaction(){
  add_submenu_page( 'options-general.php', 'Dons via Orange Money', 'Status des dons OM', 'administrator', 'om-transactions', 'check_om_transaction');
}

add_filter( 'manage_users_columns', 'kk_columns_managing' );
function kk_columns_managing( $columns ){
    $columns['valide'] = 'Valide';
    unset( $columns['posts'] );
    unset( $columns['role'] );
    return $columns;
}

//Adds Content To The Custom Added Column
function custom_show_valide_column_content($value, $column_name, $user_id) {

    if ( 'valide' == $column_name ){
        $is_valid = get_field('profil_valide', 'user_'.$user_id);
        if ( $is_valid ){
            ob_start();
            ?> 
                <div style="background: #00c851; color: #fff; text-align: center; border: 1px solid #007e33; padding: 5px 10px;">VALIDE</div>
            <?php
            $out = ob_get_clean();
        }else{
             ob_start();
            ?> 
                <div style="background: #f44; color: #fff; text-align: center;  border: 1px solid #c00; padding: 5px 10px;">INVALIDE</div>
            <?php
            $out = ob_get_clean();
        }

        return $out;
    }
}
add_filter('manage_users_custom_column',  'custom_show_valide_column_content', 10, 3);

add_action('pre_get_posts', 'kk_custom_order_by');
function kk_custom_order_by( $query ){
    if( ! is_admin() || ! $query->is_main_query() ) {
    return;
  }

  if ( 'order_by_profil_valide' === $query->get( 'orderby') ){
    $query->set( 'orderby', 'meta_value' );
    $query->set( 'meta_key', 'profil_valide' );
  }

}

function kk_sortable_columns( $col ){
    $col['valide'] = 'order_by_profil_valide';

    return $col;
}
// add_filter( 'manage_users_sortable_columns', 'kk_sortable_columns');

require_once 'transactions_list.php';

// add_action( 'save_post_cagnotte', 'my_save_post_function', 10, 3 );

function my_save_post_function( $post_ID, $post, $update ) {
    // Check to see if we are autosaving
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

  $etat_paiement = get_field('cagnotte_viree');

  if( 'oui'== $etat_paiement ){
    notificationVirementTitulaire( $post_ID );
    if( true === get_field('notifier_les_participants_lors_de_la_depense_de_la_cagnotte') ){
        $participants = array();
        // andefasana notif daholo ny participant rehetra
        $participants = get_field('tous_les_participants');
        if( count( $participants > 0 ) ):
            foreach( $participants as $participant ){
                $part = $participant['participant_'];
                $partID = $part->ID;
                $nom_participant = get_field('nom_participant', $partID);
                $prenom_participant = get_field('prenom_participant', $partID);
                $email_participant = get_field('email_participant', $partID);

                $sent = notificationVirementParticipant($id, $emailParticipant, $nomParticipant, $prenomParticipant);
            }
        endif;
        
    }
  }
}

add_filter('wp_handle_upload_prefilter','mdu_validate_image_size');
add_filter( 'wp_handle_sideload_prefilter', 'mdu_validate_image_size');

function mdu_validate_image_size( $file ) {
    $origin = $_SERVER['HTTP_REFERER'];

    if( strpos( $origin, 'creer-cagnotte') || strpos( $origin, 'parametre-fond') ){
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
            return $file;
        }
        elseif ( $image_width < $minimum['width'] || $image_height < $minimum['height'] ) {
            // add in the field 'error' of the $file array the message 
            $file['error'] = __('Largeur minimale : 1024px, Hauteur minimale : 475px','kotikota'); 
            return $file;
        }
        elseif ( $image_width > $maximum['width'] || $image_height > $maximum['height'] ) {
            //add in the field 'error' of the $file array the message
            $file['error'] = __('Largeur maximale : 2000px, Hauteur maximale : 1500px','kotikota'); 
            return $file;
        }
        else
            return $file;

    }else{
        return $file;
    }

    
    
    
}