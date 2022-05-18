<?php
	/*
	Template Name: Liste cagnottes
	*/
	// global $wp_query;

	get_header();
?>
<main id="homepage">
<?php
    global $wpdb;
	include 'sections/content/parallax.php';
?>

<div class="blc-cagnotte-liste wow fadeIn" data-wow-delay="850ms">
    <div class="wrapper">
        <div class="zone-search">
            <div class="blc-menu">
                <div class="menu-cagnotte"><?php _e('Toutes les cagnottes', 'kotikota'); ?></div>
            </div>
            <?php get_search_form(); ?>
        </div>
        <ul id="response"></ul>
        <?php
        	$per_page = get_field('per_page','option');
        	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        	$args = array(
            'post_type' => array('cagnotte','cagnotte-perso'),
            'post_status' => 'publish',
            'posts_per_page' => $per_page,
            'meta_key' => 'visibilite_cagnotte',
            'meta_value' => 'publique',
            'orderby' => 'ID',
            'paged' => $paged,
            //'meta_key' => 'tous_les_participants',
            /*'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'   => 'visibilite_cagnotte',
                    'value' => 'publique'
                ),
                array(
                    'key'   => 'tous_les_participants',
                )
            ),
            'orderby' => 'meta_value_num',*/
            'order' => 'DESC',
        );

        //$loop = query_posts( $args );
        $sql = 'SELECT
        SQL_CALC_FOUND_ROWS
        wp_posts.ID, (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(meta_value,":",2),":",-1) from wp_postmeta WHERE meta_key = "tous_les_participants" AND wp_postmeta.post_id = wp_posts.ID) as count_part
        FROM wp_posts
        INNER JOIN wp_postmeta ON ( wp_posts.ID = wp_postmeta.post_id )
            WHERE 1=1
            AND ( ( wp_postmeta.meta_key = "visibilite_cagnotte" AND wp_postmeta.meta_value = "publique" ) )
            AND wp_posts.post_type IN ("cagnotte", "cagnotte-perso")
            AND ((wp_posts.post_status = "publish"))
        GROUP BY wp_posts.ID ORDER BY CONVERT(count_part,SIGNED INTEGER) DESC LIMIT 0, 9';

        $loop = $wpdb->get_results($sql);

        //$results = new WP_Query( $args );
        //echo $results->request;

        /*if ( $loop ){
            $i = 1;
            while ( have_posts() ) : the_post();
                $length = get_field('tous_les_participants');
                if ( !$length ) {
                    $length = [];
                }

                $all_posts[$i] = $post;
                $i++;
            endwhile;
            wp_reset_postdata();
        }

        ksort($all_posts);
        print_r($all_posts);*/

        if ( $loop ):
            include 'sections/content/liste-cagnottes.php';
        else:
    ?>
            <div class="blc-liste-cagnote wow fadeIn" data-wow-delay="850ms">
                <div class="lst-cagnotte-publique wow fadeIn clr" data-wow-delay="900ms">
                    <div style="text-align:center">
                        <h3>
                            <?php printf( __( 'Aucune cagnotte n\'a été trouvée', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                        </h3>
                    </div>
                </div>
            </div>
    <?php
        endif;
    ?>
    </div>
 </div>
 <div id="loader">
  <img src="<?php echo IMG_URL.'loader.gif' ?>" alt="loader">
</div>
</main>
<?php get_footer(); ?>