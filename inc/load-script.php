<?php

define('CSS_URL', get_template_directory_uri() . '/assets/css/');
define('FONT_URL', get_template_directory_uri() . '/assets/fonts/');
define('JS_URL', get_template_directory_uri() . '/assets/js/');
define('IMG_URL', get_template_directory_uri() . '/assets/images/');
define('VIDEO_URL', get_template_directory_uri() . '/assets/videos/');
define('THEME_URL', get_template_directory_uri() . '/');
define('LOGIN_ASSET', get_template_directory_uri() . '/assets/css/login/');

function load_front_assets() {

    // css
    wp_enqueue_style( 'fancybox', JS_URL . 'fancybox/jquery.fancybox.css' );
    wp_enqueue_style( 'jqui', CSS_URL . 'jquery-ui.min.css' );
    wp_enqueue_style( 'animate', CSS_URL . 'animate.css' );
    wp_enqueue_style( 'animate-icon', CSS_URL . 'animate-icon.css' );
    wp_enqueue_style( 'summernote', CSS_URL . 'summernote-lite.css' );
    wp_enqueue_style( 'reset', CSS_URL . 'reset.css' );
    wp_enqueue_style( 'slick', CSS_URL . 'slick.css' );
    wp_enqueue_style( 'scrollbar', CSS_URL . 'jquery.scrollbar.css' );

    wp_enqueue_style( 'intelTelInput', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css' );

    // if ( is_page('participer') )
    //     wp_enqueue_style( 'intelTelInput', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css' );

    if ( is_page('gestion-cagnotte-invite'))
        wp_enqueue_style( 'email-multipl', CSS_URL . 'email.multiple.css' );
    wp_enqueue_style( 'css-wp', CSS_URL . 'css-wp.css' );

    // js
    wp_register_script( 'jquery_min', JS_URL . 'jquery.min.js', array(), true, false, true );
    wp_register_script( 'slick_min', JS_URL . 'slick.min.js', array(), true, false, true );
    wp_register_script( 'waypoint_min', '//cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js', array(), true, false, true );
    wp_register_script( 'counterup', JS_URL . 'jquery.counterup.js', array(), true, false, true );
    wp_register_script( 'fancybox', JS_URL . 'fancybox/jquery.fancybox.js', array(), true, false, true );
    wp_register_script( 'parallax', JS_URL . 'parallax.js', array(), true, false, true );
    wp_register_script( 'jquery_ui', JS_URL . 'jquery-ui.min.js', array(), true, false, true );
    wp_register_script( 'scrollbar', JS_URL . 'jquery.scrollbar.js', array(), true, false, true );

    if ( is_front_page() || is_page('toutes-les-cagnottes') || is_search() || is_tax() || is_single() || is_page('toutes-mes-cagnottes') || is_page('toutes-mes-participations')){
        wp_register_script( 'circle-bar1', JS_URL . 'jQuery.circleProgressBar1.js', array(), true, false, true );
        wp_register_script( 'circle-bar', JS_URL . 'jQuery.circleProgressBar.js', array(), true, false, true );
    }
    if ( is_page('gestion-cagnotte-invite') || is_single())
        wp_register_script( 'email-multiple', JS_URL . 'jquery.email.multiple.js', array(), true, false, true );

    wp_register_script( 'intlTelInput', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.js', array(), true, false, true );

    // if( is_page( 'participer' ) ){
    //     wp_register_script( 'intlTelInput', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.js', array(), true, false, true );
    // }

    wp_register_script( 'wow', JS_URL . 'wow.js', array(), true, false, true );
    wp_register_script( 'summernote_lite', JS_URL . 'summernote-lite.js', array(), true, false, true );
    wp_register_script( 'custom', JS_URL . 'custom.js', array(), true, false, true );
    wp_register_script( 'custom-wp', JS_URL . 'custom-wp.js', array(), true, false, true );
    wp_register_script( 'ajax-wp', JS_URL . 'kotikota-ajax.js', array(), true, false, true );

    wp_enqueue_media();

    wp_enqueue_script( 'jquery_min', false, array(), false, true );
    wp_enqueue_script( 'slick_min', false, array(), false, true );
    wp_enqueue_script( 'waypoint_min', false, array(), false, true );
    wp_enqueue_script( 'counterup', false, array(), false, true );
    wp_enqueue_script( 'fancybox', false, array(), false, true );
    wp_enqueue_script( 'parallax', false, array(), false, true );
    wp_enqueue_script( 'jquery_ui', false, array(), false, true );
    wp_enqueue_script( 'scrollbar', false, array(), false, true );
    if (is_page('toutes-les-cagnottes') || is_search() || is_tax()|| is_single()|| is_page('toutes-mes-cagnottes') || is_front_page() || is_page('toutes-mes-participations') ){
        wp_enqueue_script( 'circle-bar1', false, array(), false, true );
        wp_enqueue_script( 'circle-bar', false, array(), false, true );
    }
    if ( is_page('gestion-cagnotte-invite') || is_single())
        wp_enqueue_script( 'email-multiple', false, array(), false, true );

    wp_enqueue_script( 'intlTelInput', false, array(), false, true );

    // if( is_page( 'participer' ) ){
    //     wp_enqueue_script( 'intlTelInput', false, array(), false, true );
    //     // wp_enqueue_script( 'utils', false, array(), false, true );
    // }

    wp_enqueue_script( 'wow', false, array(), false, true );
    wp_enqueue_script( 'summernote_lite', false, array(), false, true );
    wp_enqueue_script( 'custom', false, array(), false, true );
    wp_enqueue_script( 'custom-wp', false, array(), false, true );
    wp_enqueue_script( 'ajax-wp', false, array(), false, true );

    wp_localize_script( 'custom', 'placeholder_description', __('Message','kotikota') );
    wp_localize_script( 'ajax-wp', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
    wp_localize_script( 'custom-wp', 'ajaxurl', admin_url( 'admin-ajax.php' ) );

    wp_localize_script( 'email-multiple', 'text',
        array( 'email_entree' => __('Saisir un email + touche entrée', 'kotikota'))
    );

    wp_localize_script( 'ajax-wp', 'text',
        array(
            'conf_montant_devise' => __('Montant équivalent : ', 'kotikota'),
            'conf_invite_email' => __('Votre invitation a bien été envoyée !', 'kotikota'),
            'conf_titre_save_notif' => __('Notification par email', 'kotikota'),
            'conf_relance_auto' => __('La relance automatique a été effectuée !', 'kotikota'),
            'conf_cloture' => __('La cagnotte a bien été clôturée !', 'kotikota'),
            'conf_document_upload' => __('Télécharger', 'kotikota'),
            'conf_document_upload_status' => __('Téléchargement', 'kotikota'),
            'conf_document_upload_instuction' => __('Déposez vos fichiers pour les télécharger', 'kotikota'),
            'conf_document_upload_taille' => __('Taille de fichier maximale pour le téléchargement : 8 Mo.', 'kotikota'),
            'list_priv' => __('privee', 'kotikota'),
            'list_frais_6' => __('Frais 6%', 'kotikota'),
            'list_perso' => __('Personnelle', 'kotikota'),
            'list_solid' => __('Solidaire', 'kotikota'),
            'list_pub' => __('publique', 'kotikota'),
            'list_frais_3' => __('Frais 3%', 'kotikota'),
        )
    );

    wp_localize_script( 'custom-wp', 'text_customwp',
        array(
            'fichier_ajoute' => __('Fichier ajouté', 'kotikota'),
        )
    );
    wp_localize_script( 'custom-wp', 'text',
        array(
            'conf_montant_devise' => __('Montant équivalent : ', 'kotikota'),
            'conf_invite_email' => __('Votre invitation a bien été envoyée !', 'kotikota'),
            'conf_titre_save_notif' => __('Notification par email', 'kotikota'),
            'conf_relance_auto' => __('La relance automatique a été effectuée !', 'kotikota'),
            'conf_cloture' => __('La cagnotte a bien été clôturée !', 'kotikota'),
            'conf_document_upload' => __('Télécharger', 'kotikota'),
            'conf_document_upload_status' => __('Téléchargement', 'kotikota'),
            'conf_document_upload_instuction' => __('Déposez vos fichiers pour les télécharger', 'kotikota'),
            'conf_document_upload_taille' => __('Taille de fichier maximale pour le téléchargement : 8 Mo.', 'kotikota'),
            'list_priv' => __('privee', 'kotikota'),
            'list_frais_6' => __('Frais 6%', 'kotikota'),
            'list_perso' => __('Personnelle', 'kotikota'),
            'list_solid' => __('Solidaire', 'kotikota'),
            'list_pub' => __('publique', 'kotikota'),
            'list_frais_3' => __('Frais 3%', 'kotikota'),
        )
    );

}
add_action( 'wp_enqueue_scripts', 'load_front_assets' );

if ( isset($_REQUEST['action'] ) && !empty($_REQUEST['action'] ) ) {
    if ( $_REQUEST['action'] == 'rp' || $_REQUEST['action'] == 'resetpass' ){
        add_action( 'login_enqueue_scripts', 'login_scripts' );
    }

}

function login_scripts() {
    wp_enqueue_style( 'log-css', LOGIN_ASSET . 'login.css' );

    wp_register_script( 'log-js', LOGIN_ASSET . 'login.js', array(), true, false, true );
    wp_enqueue_script( 'log-js', false, array(), false, true );
}

function my_enqueue($hook) {
    wp_enqueue_script('bo_custom_script', JS_URL . '/bo-script.js');

    wp_localize_script( 'bo_custom_script', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
}

add_action('admin_enqueue_scripts', 'my_enqueue');
