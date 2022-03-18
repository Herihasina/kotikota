<!DOCTYPE html>
<html <?php language_attributes() ?> prefix="og: https://ogp.me/ns#">

<head>
    <script src="https://www.google.com/recaptcha/api.js?render=6Lc7PboaAAAAAO615AOfhbSRGs8wLcCEj3dClpC7"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="google-site-verification" content="flt7o3SjFMndrKi6LSiFALha1_yJAl0nzZRpgIKEEIE" />
    <!-- <script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v8.0&appId=103654281972420&autoLogAppEvents=1" nonce="PvABvkTR"></script> -->
    <title>
      <?php
        // if ( !is_single() ){
        //
        // }
        if( is_search() ){
          echo esc_html( get_search_query() ).' : '. __('Résultat de recherche','kotikota');
        }elseif (is_singular('cagnotte')){
          echo get_field('nom_de_la_cagnotte');
        }else{
          wp_title('|', true, 'right').'|'. bloginfo('name');
        }
      ?>
    </title>
    <!-- TrustBox script -->
    <script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
    <!-- End TrustBox script -->
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <?php if ( is_singular( array('cagnotte', 'cagnotte-perso') ) ) :
      $terms = get_the_terms( $post->ID, 'categ-cagnotte' );
    ?>
      <meta property="og:url" content="<?php echo get_the_permalink( $post->ID ); ?>" />
      <meta property="og:type" content="article" />
      <meta property="og:title" content="<?php echo get_the_title(); ?>" />
      <meta property="og:description" content="<?php echo $terms[0]->name; ?>" />
      <meta property="fb:app_id" content="3122702584626959">
      <?php
        $img_url = get_field('illustration_pour_la_cagnotte', $post->ID);
        if ( $img_url ): ?>
          <meta property="og:image:width" content="1200" />
          <meta property="og:image:height" content="630" />
          <meta property="og:image" content="<?= $img_url ?>" />
          <meta property="og:image:secure_url" content="<?= $img_url ?>" />
        <?php endif;
        elseif( is_home() || is_front_page() ):
      ?>
          <meta property="og:url" content="<?php echo home_url('/'); ?>" />
          <meta property="og:type" content="article" />
          <meta property="og:title" content="KOTI KOTA" />
          <meta property="og:description" content="<?php echo __('Le premier site de cagnotte en ligne à Madagascar','kotikota') ?>" />
          <meta property="fb:app_id" content="3122702584626959">
          <meta property="og:image:width" content="1200" />
          <meta property="og:image:height" content="630" />
          <meta property="og:image" content="https://koti-kota.com/wp-content/uploads/2021/09/unicefmada_118782353_313714943185395_1746931575050700793_n.jpg" />
          <meta property="og:image:secure_url" content="https://koti-kota.com/wp-content/uploads/2021/09/unicefmada_118782353_313714943185395_1746931575050700793_n.jpg" />
          <meta property="og:image:alt" content="Image de Koti Kota" />
      <?php
        endif;
     wp_head(); ?>
</head>
<body <?php body_class() ?>>

    <!-- Messenger Chat plugin Code -->
    <div id="fb-root"></div>

    <!-- Your Chat plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "2322299898051607");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v13.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/fr_FR/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>

<div id="wrapper">
    <header id="header">
      <?php

        if (is_home() || is_front_page() ):?>
      <input type="hidden" name="isHome" value=1>

      <?php
        endif;
      ?>
      <?php
        include 'sections/header/top.php';
        include 'sections/header/slider.php';
        include 'sections/header/popup-connecter.php';
        include 'sections/header/popup-sinscrire.php';
        if (is_home() || is_front_page() ):
          include 'sections/header/popup-apropos.php';
          include 'sections/header/popup-simulation.php';
        endif;
      ?>
    </header>

    <?php if( isset( $_GET['new'] ) ){ ?>
      <a href="#new_user" data-fancybox id="new_btn">X</a>
    <?php } ?>
