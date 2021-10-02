<?php
/**
* Template Name: CreerCagnotte
*/

get_header(); ?>

<main id="homepage">

    <?php include 'sections/content/parallax.php'; ?>
    <?php 
    	if ( is_user_logged_in() ){
    		include 'sections/content/creer-cagnotte.php';
    	}	else { ?>
              <div class="blc-liste-cagnote force-login wow fadeIn" data-wow-delay="850ms">
                <div class="lst-cagnotte-publique wow fadeIn clr" data-wow-delay="900ms">
                    <h3 style="text-align:center">
                        <?php _e("Vous devez vous authentifier pour pouvoir créer une cagnotte!", "kotikota"); ?>
                    </h3>
                </div>
            </div> 
    	<?php
        }
    	
    ?>

</main>
<div id="loader">
  <img src="<?php echo IMG_URL.'loader.gif' ?>" alt="loader">
</div>
<?php get_footer(); ?>