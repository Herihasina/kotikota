<?php
    $term_id = get_queried_object()->term_id;
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
        <?php 
        
        if (have_posts()):
            include 'sections/content/liste-cagnottes.php';
        else:
    ?>
            <div class="blc-liste-cagnote wow fadeIn" data-wow-delay="850ms">
                <div class="lst-cagnotte-publique center wow fadeIn clr" data-wow-delay="900ms">
                    <h3 style="text-align:center">
                        <?php printf( __( "Aucune cagnotte n'a été trouvée dans cette catégorie", 'kotikota' ) ); ?>
                    </h3>
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