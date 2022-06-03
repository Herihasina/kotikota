<?php
	/*
	Template Name: Migrate Fields
	*/

	get_header();

    function migrate_cagnottes_rib(){
        $test_migration = false;
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
                    echo get_field('<br> nom_de_la_cagnotte',$cagnotte->ID);
                    dump($rib_file_id);
                    $add_rib_file = add_row('fichiers_rib',array('fichier' => $rib_file_id),$cagnotte->ID);
                    $test_migration = $add_rib_file;
                    dump($add_rib_file);
                    if(!$add_rib_file) return false;
                }

            }
        }

        return $test_migration;
    }

    function migrate_user_cin(){
        $test_migration = false;
        //users
        global $wpdb;

        $user_table = $wpdb->prefix.'users';
      
        $users = $wpdb->get_results(
          "SELECT ID FROM $user_table"
        );
        if (!empty($users)) {
            foreach( $users as $user ){
                $piece_id = get_field('piece_didentite', 'user_'.$user->ID);
                if($piece_id){
                    echo "user id: ".$user->ID;
                    echo get_field('<br> user name: ',$user->ID);
                    dump($piece_id);
                    $add_cin_file = add_row('pieces_didentite',array('image' => $piece_id),'user_'.$user->ID);
                    $test_migration = $add_cin_file;
                    dump($add_cin_file);
                    if(!$add_cin_file) return false;
                }

            }
        }

        return $test_migration;
    }

    echo "<p> migration user CIN to new fields... </p>";
    dump(migrate_user_cin());

    get_footer();
?>

