<?php  $type_cagnotte = get_field('visibilite_cagnotte'); ?>
<div class="nom-cagnotteSum wow fadeInUp" data-wow-delay="800ms">
    <div class="content">
        <div class="col col1">
          <?php 
            $terms = get_the_terms( $post->ID, 'categ-cagnotte' );
            $categ = '';
            if ($terms)
              foreach ($terms as $term){
                  $id_parent = $term->parent; 
                  if ( $id_parent != 0 ) { 
                     $t = get_field('picto_sous-categorie', 'categ-cagnotte_'.$term->term_id);
                     if ( is_array( $t ) && array_key_exists('picto_etat_normal', $t))
                      echo '<class class="ico">'.wp_get_attachment_image( $t['picto_etat_normal'], 'cagnotte-picto' ).'</class>';
                     $categ = $term->name;
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
        <div class="col col3">
            <div class="jours">
                <div class="ico2"><img src="<?= IMG_URL ?>ico-jrs.png"></div>
                <?php 
                  if ( 
                        $type_cagnotte == 'solidaire' 
                        || $isInvited 
                        || get_field('titulaire_de_la_cagnotte' )  == get_current_user_id() 
                        || current_user_can('administrator') 
                    ):
                    $diff = get_nbr_de_jour_restant( get_field('deadline_cagnoote') );
                  else:
                    $diff = '--';
                  endif;
                ?>
                <b>
                  <?php 
                    echo $diff.' jour';
                    if ($diff >= 2) echo "s";
                  ?>
                </b>
                <span><?php _e('restant','kotikota'); ?><?php if ($diff >= 2) echo "s"; ?></span>
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
                <span><?php _e('participant','kotikota'); ?><?php if ( count($tous_les_participants) >= 2 && !$masquer_contributions ) echo "s"; ?></span>
            </div>
        </div>
        <?php 
          $masquer_azo_ilaina = get_field('masquer_azo_ilaina');
          
          
            $devise = get_field('devise');
            $devise = $devise['label'] ? $devise['label'] : $devise[0];
        ?>
                <div class="col col5">
                    <div class="collecte">
                        <div class="ico2"><img src="<?= IMG_URL ?>ico-collect.png"></div>
                        <b>
                          <?php 
                            if ( 
                              ($type_cagnotte == 'solidaire' || 
                              $isInvited || 
                              get_field('titulaire_de_la_cagnotte')  == get_current_user_id() || 
                              current_user_can('administrator') ) &&
                              !$masquer_azo_ilaina
                            ){
                              echo '<span class="format_chiffre">'.get_field('montant_recolte').'</span> '. $devise; 
                            }elseif( $masquer_azo_ilaina && ( !current_user_can('administrator') || get_field('titulaire_de_la_cagnotte')  != get_current_user_id() ) ){
                              echo "--";
                            }else{
                              echo "--";
                            }
                          ?>
                        </b>
                        <span><?php _e('collecté','kotikota'); ?><?php if ((int)get_field('montant_recolte') >= 2) echo "s"; ?></span>
                    </div>
                </div>
                <?php  if ( get_field('fixer_un_objectif' ) ): ?>
                  <div class="col col6">
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
                  </div>
                <?php endif; ?>
    </div>
</div>