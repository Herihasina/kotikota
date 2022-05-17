<?php
	/*
	Template Name: Liste cagnottes
	*/
	// global $wp_query;

	get_header();
?>
<main id="homepage">
<?php
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
            //'orderby' => 'ID',
            //'order' => 'DESC',
            'paged' => $paged,
        );

        $loop = query_posts( $args );

        if ( $loop ){
            $i = 1;
            while ( have_posts() ) : the_post();
                $length = get_field('tous_les_participants');
                if ( !$length ) {
                    $length = [];
                }

                $all_posts[count($length).'0'.$i] = $post;
                $i++;
            endwhile;
            wp_reset_postdata();
        }

        ksort($all_posts);

        if ( $all_posts ):
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