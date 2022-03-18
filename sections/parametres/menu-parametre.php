<div class="nom-cagnotteSum wow fadeInUp" data-wow-delay="800ms">
    <div class="content">
        <div class="col col1">
          <div class="item">
              <div class="ico">
              	<?php
              		$terms = get_the_terms( $idCagnotte, 'categ-cagnotte' );
                  $categ = '';
                  if ($terms){
	                  foreach ($terms as $term){
	                      $id_parent = $term->parent;
	                      if ( $id_parent != 0 ) {
	                         $t = get_field('picto_sous-categorie', 'categ-cagnotte_'.$term->term_id);
                           if( is_array( $t ))
	                         echo wp_get_attachment_image( $t['picto_etat_normal'], 'cagnotte-picto' );
                           $categ = $term->name;
	                      }
	                  }
                  }
              	?>

              </div>
               <div class="nom">
                  <b><?php echo get_the_title( $idCagnotte ); ?></b>
                  <span><?php echo $categ; ?></span>
              </div>
            </div>

        </div>
         <div class="col right">
          <?php
            $devise = get_field('devise', $idCagnotte);
            $devise = $devise['label'] ? $devise['label'] : $devise[0];
            if ( get_field('fixer_un_objectif', $idCagnotte) > 0 ): ?>
            <div class="item">
              <span><?php _e('il reste à collecter','kotikota'); ?></span>
              <?php
                  if ( (int)get_field('objectif_montant', $idCagnotte) - (int)get_field('montant_recolte', $idCagnotte) < 0 ){
                    $reste = "0 ".$devise;
                  }else{
              		  $reste = ((int)get_field('objectif_montant', $idCagnotte) - (int)get_field('montant_recolte', $idCagnotte));
                  }

              ?>
              <span class="link"><span class="format_chiffre"><?php echo $reste; ?></span><?php echo $devise; ?></span>
            </div>
          <?php endif; ?>
          <div class="item">
            <span><?php _e('vous avez collecté','kotikota'); ?></span>
            <span class="link"><span class="format_chiffre"><?php the_field('montant_recolte', $idCagnotte); ?></span> <?php echo $devise; ?></span>
          </div>
        </div>
    </div>
</div>
<div class="blc-step parametre wow fadeIn" data-wow-delay="900ms">
  <div class="lst-step parametre clr">
    <div class="item<?php
    	if ($active == 'info') echo ' active no-ico'; if ($active == 'fond'|| $active == 'description' || $active == 'montant' || $active == 'notif')
    		echo ' active selected';	?>">
      <div class="content">
        <h2><?php _e('Infos principales','kotikota')?></h2>
        <a href="<?php echo get_site_url(); ?>/parametre-info-principale/?parametre=<?= $idCagnotte ?>" class="ico">
          <img src="<?php echo IMG_URL ?>info.png">
        </a>
      </div>
    </div>
    <div class="item<?php if ($active == 'fond') echo ' active no-ico'; if ($active == 'description'|| $active == 'montant' || $active == 'notif') echo ' active selected';	?>">
      <div class="content">
        <h2><?php _e('Fond d’écran','kotikota'); ?></h2>
        <a href="<?php echo get_site_url(); ?>/parametre-fond/?parametre=<?= $idCagnotte ?>" class="ico">
          <img src="<?php echo IMG_URL ?>fond.png">
        </a>
      </div>
    </div>
    <div class="item<?php if ($active == 'description') echo ' active no-ico'; if ( $active == 'montant' || $active == 'notif') echo ' active selected';	?>">
      <div class="content">
        <h2><?php _e('Description','kotikota')?></h2>
        <a href="<?php echo get_site_url() ?>/parametre-description/?parametre=<?= $idCagnotte ?>" class="ico">
          <img src="<?php echo IMG_URL ?>description.png">
        </a>
      </div>
    </div>
    <div class="item<?php if ($active == 'montant') echo ' active no-ico'; if ($active == 'notif') echo ' active selected';	?>">
      <div class="content">
        <h2><?php _e('Montant','kotikota')?></h2>
        <a href="<?php echo get_site_url()?>/parametre-montant/?parametre=<?= $idCagnotte ?>" class="ico">
          <img src="<?php echo IMG_URL ?>montant.png">
        </a>
      </div>
    </div>
    <!--<div class="item<?php if ($active == 'notif') echo ' active no-ico';	?>">
      <div class="content">
        <h2><?php _e('Notifications','kotikota')?></h2>
        <a href="<?php echo get_site_url()?>/parametre-notification/?parametre=<?= $idCagnotte ?>" class="ico">
          <img src="<?php echo IMG_URL ?>notification.png">
        </a>
      </div>
    </div> -->
  </div>
</div>
