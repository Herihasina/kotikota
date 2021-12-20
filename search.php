<?php 

	get_header();
?>
<main id="homepage">
<?php
	include 'sections/content/parallax.php';
?>

<div class="blc-cagnotte-liste resultat" data-wow-delay="850ms">
    <div class="wrapper">
         <div class="titre wow fadeIn" data-wow-delay="800ms">
            <h2><span><img src="<?php echo IMG_URL ?>ico-recherche.png"></span><?php _e('Résultat de votre recheche','kotikota'); ?></h2>
        </div>
        <div class="zone-search wow fadeIn" data-wow-delay="900ms">
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
            <div class="blc-liste-cagnote resultat-recherche wow fadeIn" data-wow-delay="850ms">
                <div class="lst-cagnotte-publique wow fadeIn clr" data-wow-delay="900ms">
                    <div style="text-align:center">
                        <h3>
                            <?php printf( __( "Aucune cagnotte contenant %s n'a été trouvée", 'kotikota' ), esc_html( get_search_query() ) ); ?>
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