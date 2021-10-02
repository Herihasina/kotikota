<!DOCTYPE html>
<html lang="fr">

<head>
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
        }elseif (is_single()){
          echo get_field('nom_de_la_cagnotte');
        }else{
          wp_title('|', true, 'right').'|'. bloginfo('name'); 
        }
      ?>
    </title>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <?php if ( is_single() ) : 
      $terms = get_the_terms( $post->ID, 'categ-cagnotte' ); 
    ?>
      <meta property="og:url" content="<?php echo get_the_permalink( $post->ID ); ?>" />
      <meta property="og:type" content="<?php _e('cagnotte','kotikota'); ?>" />
      <meta property="og:title" content="<?php the_title(); ?>" />      
      <meta property="og:description" content="<?php echo $terms[0]->name; ?>" />
      <?php 
        $img_url = get_field('illustration_pour_la_cagnotte', $post->ID);
        if ( $img_url ): ?>
          <meta property="og:image" content="<?= $img_url ?>" />
          <meta property="og:image:secure_url" content="<?= $img_url ?>" /> 
        <?php endif;
      
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
      chatbox.setAttribute("page_id", "105522724810462");
      chatbox.setAttribute("attribution", "biz_inbox");
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v11.0'
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
    <!-- HEADER END-->
    <?php
      // $status_am = check_status_AM( 'don_9611618302011' );
     ?>