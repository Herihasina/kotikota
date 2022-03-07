<?php 
	/*
	Template Name: Liste mes participations
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
        <?php
        	$userdata = wp_get_current_user();
            $email_user =$userdata->data->user_email ;

            $loop = get_user_participation($email_user);
            
            if (have_posts()):
                include 'sections/content/liste-cagnottes.php';
            else:
        ?>
                <div class="blc-liste-cagnote wow fadeIn" data-wow-delay="850ms">
                    <div class="lst-cagnotte-publique wow fadeIn clr" data-wow-delay="900ms">
                        <div style="text-align:center">
                            <h3 style="text-align:center">
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