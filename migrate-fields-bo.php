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
    if($cagnottes && have_posts(  )){
        foreach ( $cagnottes as $cagnotte){
            $RIB_fichier = get_field(' rib_fichier', $cagnotte->ID);
            dump($RIB_fichier);

        }
    }

    get_footer();
?>

