<div class="blc-step wow fadeIn" data-wow-delay="800ms">
  <div class="lst-step clr">
    <div class="item col1 active">
      <div class="content">
        <h2><?php _e('Inviter','kotikota'); ?></h2>
        <a href="<?php echo get_permalink( get_page_by_path('gestion-cagnotte-invite') ) ?>?gest=<?= $id_cagnotte ?>" class="ico">
          <img src="<?php echo IMG_URL ?>invite.png" alt="<?php _e('Inviter','kotikota'); ?>">
        </a>
      </div>
    </div>
    <div class="item col2<?php if ( $active != "invitation" ) echo ' active'; ?>">
      <div class="content">
        <h2><?php _e('Participations','kotikota'); ?></h2>
        <a href="<?php echo get_permalink( get_page_by_path('gestion-cagnotte-participant') ) ?>?gest=<?= $id_cagnotte ?>" class="ico">
          <img src="<?php echo IMG_URL ?>participe2.png" alt="<?php _e('Participations','kotikota'); ?>">
        </a>
      </div>
    </div>
 
    <div class="item col3<?php if ($active == "message" ) echo ' active'; ?>">
      <div class="content">
        <h2><?php _e('Messages','kotikota'); ?></h2>
        <a href="<?php echo get_permalink( get_page_by_path('gestion-cagnotte-mot-doux') ) ?>?gest=<?= $id_cagnotte ?>" class="ico">
          <img src="<?php echo IMG_URL ?>message.png" alt="<?php _e('Messages','kotikota'); ?>">
        </a>
      </div>
    </div>

  </div>
</div> 