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
            $rib_file_id = get_field('rib_fichier', $cagnotte->ID);
            if($rib_file_id){
                echo "cagnotte id: ".$cagnotte->ID;
                dump($rib_file_id);
                $rib_file = attachment_url_to_postid(strip_tags($rib_file_id));
                $add_rib_file = add_row('fichiers_rib',array('fichier' => $rib_file),$cagnotte->ID);
                dump($add_rib_file);
            }

        }
    }

    get_footer();
?>

