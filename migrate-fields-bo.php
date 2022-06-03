<?php
	/*
	Template Name: Migrate Fields
	*/

	get_header();

    //cagnottes
    $args = array(
        'post_type' => array('cagnotte','cagnotte-perso'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'ID',
        'order' => 'DESC',

  );

  $cagnottes= query_posts( $args );
  dump($cagnottes);
?>


<?php get_footer()?>