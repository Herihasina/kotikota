<?php
  $type_cagnotte = get_field('visibilite_cagnotte');
  $isInvited = false;

  if ( isset($_GET['origin']) && $_GET['origin'] = 'invite' ){
    $isInvited = true;
  }
  get_header(); 
?>
<main id="homepage">
<?php
  include 'sections/content/parallax.php'; 

  

  if ( (have_posts() ) || ( have_posts() && current_user_can( 'administrator' ) ) || ( get_field('titulaire_de_la_cagnotte') == get_current_user_id() ) ):
    while (have_posts()): the_post();

      $particips = [];
?>

<div class="blc-cagnotte-details">
  <div class="wrapper">
      <?php 
        get_template_part('parts/single/info-principales'); 
        get_template_part('parts/single/top-buttons'); 

      ?>
      
      <div class="det-cagnotte wow fadeIn" data-wow-delay="850ms">
          <div class="content">
              <?php 
                get_template_part('parts/single/image');
                get_template_part('parts/single/description');  ?>
              
              <div class="blcTab">
                <ul class="tab-nav">
                    <li class="participation"><a href="#participation"><span><?php _e('Participants','kotikota'); ?></span></a></li>
                    <li class="mot-doux"><a href="#mot-doux"><span><?php _e('Messages','kotikota'); ?></span></a></li>
                    <li class="question"><a href="#question"><span><?php _e('Questions','kotikota'); ?></span></a></li>
                </ul>
                <div class="content-tab">
                  <?php
                    get_template_part('parts/single/tab-participation');
                    get_template_part('parts/single/tab-message');
                    get_template_part('parts/single/tab-question');
                  ?>
                </div>
              </div>
          </div>
          <div class="btn wow fadeIn" data-wow-delay="850ms">
              <input type="hidden" id="idCagnotte" name="idCagnotte" value="<?php echo $post->ID ?>">
              <a href="<?php echo get_permalink( get_page_by_path( "toutes-les-cagnottes" ) ) ?>" class="link" title="Revenir à la liste">
              <?php _e('Revenir à la liste','kotikota'); ?>
              </a>

              <?php if ( (is_user_logged_in() && get_field('titulaire_de_la_cagnotte')  == get_current_user_id()) || current_user_can('administrator') ): ?>
                <a href="<?php echo get_permalink(get_page_by_path( 'parametre-info-principale')).'?parametre='.$post->ID ?>" class="link" title="<?php _e('Paramètres cagnotte','kotikota'); ?>"><?php _e('Paramètres cagnotte','kotikota'); ?></a> 

                <a href="#" id="gestionner" data-id="<?php echo $post->ID ?>" data-url="<?php echo get_permalink(get_page_by_path( 'gestion-cagnotte-invite')) ?>" class="link" title="<?php _e('Gestion des Participations','kotikota'); ?>"><?php _e('Gestion des Participations','kotikota'); ?></a>

                <?php if( get_field('cagnotte_cloturee') == "non" ): ?>
                  <a href="#confirme-cloture" id="cloturer-confirm" class="link" data-fancybox title="Clôturer"><?php _e('Clôturer','kotikota'); ?></a>

                  <div id="confirme-cloture" style="display: none;text-align: center;">
                    <div class="content">
                      <div class="conf_titre"><?= __('Êtes-vous sûr de vouloir clôturer votre cagnotte ?','kotikota') ?></div>
                      <div class="conf_text">
                        <?= __('Cette action est irréversible.<br>Une fois clôturée, il sera impossible à tout utilisateur de participer à votre cagnotte. Toutefois, vous pourrez toujours la partager sur vos réseaux.','kotikota'); ?>
                      </div>
                    </div>
                    <div class="btn">
                      <a href="#" class="link close-fancy" title="<?= __('Revenir à la cagnotte','kotikota') ?>" class="link">
                        <?= __('Revenir à la cagnotte','kotikota') ?>
                      </a>
                      <a href="#" id="cloturer" class="link" title="<?= __('confirmer la clôture','kotikota') ?>">
                        <?= __('Confirmer la clôture','kotikota') ?>
                      </a>
                    </div>
                  </div>

                <?php endif; ?>
              <?php endif; ?>
          </div>
      </div>
  </div>
</div>
<div id="loader">
  <img src="<?php echo IMG_URL.'loader.gif' ?>" alt="loader">
</div>
</main>
<?php 
      endwhile; 
  endif;

 get_footer(); ?>