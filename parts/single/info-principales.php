<?php  $type_cagnotte = get_field('visibilite_cagnotte'); ?>
<div class="nom-cagnotteSum wow fadeInUp" data-wow-delay="800ms">
    <div class="content">

        <div class="col col1">
          <?php
            $terms = wp_get_post_terms( $post->ID, 'categ-cagnotte' );
            $categ = '';
            if ($terms)
              foreach ($terms as $key=>$term){
                  if($key == 0){
                    $id_parent = $term->parent;
                    if ( $id_parent != 0 ) {
                       $t = get_field('picto_sous-categorie', 'categ-cagnotte_'.$term->term_id);
                       if ( is_array( $t ) && array_key_exists('picto_etat_normal', $t))
                        echo '<class class="ico">'.wp_get_attachment_image( $t['picto_etat_normal'], 'cagnotte-picto' ).'</class>';
                       $categ = $term->name;
                    }
                  }
              }
          ?>
        </div>
        <div class="col col2">
            <div class="nom">
                <b><?php echo get_field('nom_de_la_cagnotte') ?></b>
                <span><?php echo $categ; ?></span>
            </div>
        </div>
        <?php
            $objectif = (int)get_field('objectif_montant');
            if (!$objectif ) $objectif = 1;
            $devise = get_field('devise');
            $devise = $devise['label'] ? $devise['label'] : $devise[0];
        ?>
        <?php  if ( get_field('fixer_un_objectif' ) ): ?>
        <?php
         if($objectif > 1) {
        ?>
        <div class="col col6">
            <div class="objectifs">
              <div class="ico2"><img src="<?= IMG_URL ?>ico-rst-collct.png"></div>
              <b><?= number_format($objectif, 0, '.', ' '); ?> <?= $devise ?></b>
              <span><?php _e('Objectif','kotikota'); ?></span>
            </div>
        </div>
        <?php
              }
        ?>
        <?php endif; ?>
        <div class="col col3">
            <div class="jours">
                <div class="ico2"><img src="<?= IMG_URL ?>ico-jrs.png"></div>
                <?php
                    $diff = get_nbr_de_jour_restant( get_field('deadline_cagnoote') );
                ?>
                <b>
                  <?php
                    echo $diff; ?>
                    <?php
                      if ($diff >= 2 && ICL_LANGUAGE_CODE == 'fr') {
                        echo ' '._e('jours','kotikota');
                      }else{
                        echo ' '._e('jour','kotikota');
                      }
                    ?>
                </b>
                <span><?php _e('restant','kotikota'); ?><?php if ($diff >= 2 && ICL_LANGUAGE_CODE == 'fr' ) echo "s"; ?></span>
            </div>
        </div>
        <div class="col col4">
            <div class="participant">
                <div class="ico2"><img src="<?= IMG_URL ?>ico-participant.png"></div>
                 <?php
                    $masquer_contributions = get_field('masquer_toutes_les_contributions');
                    $tous_les_participants = get_field( 'tous_les_participants' );
                 ?>
                <b>
                  <?php
                    if ( !$tous_les_participants ) $tous_les_participants = [];
                    echo count( $tous_les_participants); ?>
                </b>
                <span><?php _e('participant','kotikota'); ?><?php if ( count($tous_les_participants) >= 2 && !$masquer_contributions && ICL_LANGUAGE_CODE == 'fr' ) echo "s"; ?></span>
            </div>
        </div>
        <?php
          $masquer_azo_ilaina = get_field('masquer_azo_ilaina');
        ?>
                <div class="col col5">
                    <div class="collecte">
                        <div class="ico2"><img src="<?= IMG_URL ?>ico-collect.png"></div>
                        <b>
                          <?php
                              echo '<span class="format_chiffre">'.get_field('montant_recolte').'</span> '. $devise;
                          ?>
                        </b>
                        <span><?php
                          _e('collecté','kotikota');
                          if ((int)get_field('montant_recolte') >= 2 && ICL_LANGUAGE_CODE == 'fr' ) echo "s"; ?>
                        </span>
                    </div>
                </div>
                <?php  if ( get_field('fixer_un_objectif' ) ): ?>
                 <!-- <div class="col col6">
                       <div class="rest-collect">
                          <div class="ico2"><img src="<?= IMG_URL ?>ico-rst-collct.png"></div>
                          <?php
                            if ( $masquer_azo_ilaina || $type_cagnotte == 'perso'){
                              $reste = '--';
                            }
                            if ( $type_cagnotte == 'perso' ){
                              if ( get_current_user_id() == get_field('titulaire_de_la_cagnotte') || current_user_can('administrator') || $isInvited ){
                                $reste = (int)get_field('objectif_montant') - (int)get_field('montant_recolte');
                                if ( $reste < 0){
                                  $reste = '0 ';
                                }else{
                                  $reste = ((int)get_field('objectif_montant') - (int)get_field('montant_recolte'));
                                }

                              }
                            }else{
                              $reste = (int)get_field('objectif_montant') - (int)get_field('montant_recolte');
                              if ( $reste < 0){
                                $reste = '0 ';
                              }else{
                                $reste = ((int)get_field('objectif_montant') - (int)get_field('montant_recolte'));
                              }
                            }

                          ?>
                          <b><?php echo '<span class="format_chiffre">'.$reste.'</span> '.$devise; ?></b>
                          <span><?php _e('reste à collecter','kotikota'); ?></span>
                      </div>
                  </div>-->
                <?php endif; ?>
    </div>
</div>
