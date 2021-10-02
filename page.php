<?php 
	get_header();
?>
<main id="homepage">
<?php
	include 'sections/content/parallax.php';
?>

<div class="blc-cagnotte-participation mention">
  <div class="wrapper">
        <div class="fom-participe">
            <div class="titre wow fadeIn" data-wow-delay="800ms">
               <h2><?php echo get_the_title(); ?></h2>
            </div>
            <div class="blc-liste-cagnote wow fadeIn" data-wow-delay="850ms">
              <div class="lst-cagnotte-publique wow fadeIn clr" data-wow-delay="900ms">
                <?php the_content(); ?>
              </div>
            </div>
        </div>

  </div>
</div>
<div id="loader">
  <img src="<?php echo IMG_URL.'loader.gif' ?>" alt="loader">
</div>
</main>
<?php get_footer();
?>