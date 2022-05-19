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
            $offset = ($paged - 1)*$per_page;

        	/*$args = array(
            'post_type' => array('cagnotte','cagnotte-perso'),
            'post_status' => 'publish',
            'posts_per_page' => $per_page,
            'meta_key' => 'visibilite_cagnotte',
            'meta_value' => 'publique',
            'orderby' => 'ID',
            'paged' => $paged,
            'order' => 'DESC',
            );

            $loop = query_posts( $args );*/

            $sql = 'SELECT SQL_CALC_FOUND_ROWS ID, count_part
                FROM
                (SELECT posts.ID, count_part, "id1" OrderKey
            FROM (('.$wpdb->posts.' posts
            INNER JOIN '.$wpdb->postmeta.' mp3 ON (posts.ID = mp3.post_id))
            INNER JOIN
            (SELECT mp2.post_id,SUBSTRING_INDEX(SUBSTRING_INDEX(meta_value, ":", 2), ":", -1) AS count_part
            FROM '.$wpdb->postmeta.' mp2
            WHERE mp2.meta_key = "tous_les_participants") Subquery
            ON (posts.ID = Subquery.post_id))
            INNER JOIN '.$wpdb->postmeta.' mp1 ON (posts.ID = mp1.post_id)
            WHERE 1=1
            AND ( (mp1.meta_key = "visibilite_cagnotte" AND mp1.meta_value = "publique")
            AND ( mp3.meta_key = "cagnotte_cloturee" AND mp3.meta_value = "non"))
            AND (posts.post_type IN ("cagnotte", "cagnotte-perso")
            AND (posts.post_status = "publish"))
            GROUP BY posts.ID
            UNION ALL
            SELECT posts.ID, count_part, "id2" OrderKey
            FROM (('.$wpdb->posts.' posts
            INNER JOIN '.$wpdb->postmeta.' mp1 ON (posts.ID = mp1.post_id))
            INNER JOIN '.$wpdb->postmeta.' mp3 ON (posts.ID = mp3.post_id))
            INNER JOIN
            (SELECT mp2.post_id,SUBSTRING_INDEX(SUBSTRING_INDEX(meta_value, ":", 2), ":", -1)
                  AS count_part
            FROM '.$wpdb->postmeta.' mp2
            WHERE mp2.meta_key = "tous_les_participants") Subquery
            ON (posts.ID = Subquery.post_id)
            WHERE 1=1
            AND ( CONVERT(Subquery.count_part,SIGNED INTEGER) > 0
            AND ( (mp1.meta_key = "visibilite_cagnotte" AND mp1.meta_value = "publique")
            AND ( mp3.meta_key = "cagnotte_cloturee" AND mp3.meta_value = "oui"))
            AND (posts.post_type IN ("cagnotte", "cagnotte-perso")
            AND (posts.post_status = "publish")))
            GROUP BY posts.ID) AS m
                ORDER BY OrderKey, CONVERT(count_part,SIGNED INTEGER) DESC';

            //query the posts with pagination
            $query_limit = $sql . " LIMIT ".$offset.", ".$per_page."; ";

            // run query to count the result later
            $total_result = $wpdb->get_results( $sql, OBJECT);
            $total_post = count($total_result);

            $wp_query->found_posts = count($total_result);
            $wp_query->max_num_pages =  ceil($total_post / $per_page);
            $wp_query->posts_per_page = $per_page;

            $loop = $wpdb->get_results($query_limit);

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