<?php  $is_activ = get_field('actif'); ?>
<div class="btn-partage clr wow fadeIn" data-wow-delay="850ms">
    <?php if ( $is_activ ): ?>
     <div id="btn_participer_wrap">
        <a href="<?php echo get_permalink(get_page_by_path( 'participer')).'?part='.$post->ID ?>" id="participat" data-id="<?php echo $post->ID ?>" data-url="<?php echo get_permalink(get_page_by_path( 'participer')) ?>" class="link participe" title="Participer">
          <span><?php echo __('Participer','kotikota'); ?></span>
        </a>            
      </div>
   <?php 
      endif; 
      $link = "https://www.facebook.com/sharer/sharer.php?u=".get_permalink();
  ?>
    <div>
      <a target="_blank" 
          href="<?php echo $link; ?>" 
          class="link partage" title="<?php _e('Partager sur Facebook','kotikota') ?>"
          rel="noopener noreferrer">
        <span><?php _e('Partager sur Facebook','kotikota') ?></span>
      </a>
    </div>
</div>