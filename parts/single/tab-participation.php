<div class="tab-content" id="participation">
  <div class="liste-participation" data-wow-delay="950ms">
    <div class="lst-msg participation clr">
    <?php                       
      $tous_les_participants = get_field( 'tous_les_participants' );

      if ( $tous_les_participants && !$masquer_contributions): 
        usort($tous_les_participants,function($a, $b) {
          return strcmp($b['participant_']->post_modified, $a['participant_']->post_modified);
        });
        foreach ( $tous_les_participants as $un ):

          $email_participant = $un['participant_']->email_participant;
           
          $date_participation = new DateTime( $un['participant_']->post_modified );  
          $date_participation = $date_participation->format('d/m/y');

          $id_participant = $un['participant_']->ID;
            $cagnottes_participees = (array)get_field('toutes_cagnottes_participees', $id_participant);
            if ( $cagnottes_participees ):
    ?>
                <div class="item">
                  <div class="content">
                    <div class="profil">
                      <?php
                        foreach ($cagnottes_participees as $une_cagnotte) {
                          if ( $une_cagnotte['cagnotte']->ID == $post->ID){

                            # compte existant && tsy masqué identité
                            if ( !$une_cagnotte['masque_identite'] && email_exists( $email_participant ) ){
                                $user = get_user_by( 'email', $email_participant );
                                $user = $user->data->ID;

                                $bg = wp_get_attachment_image_src(get_field('photo', 'user_'.$user),'icone-serasera' )[0];
                                if ( !$bg ){
                                  $bg = get_field('default_gravatar','option');

                                  if( $une_cagnotte['avatar_participant_dans_cagnotte'] ){
                                    $bg = $une_cagnotte['avatar_participant_dans_cagnotte'];
                                  }
                                }
                        ?>
                                 <img src="<?php echo $bg ?>" alt="" >
                        <?php
                            # compte n'existe pas/non connecté && tsy masqué identité
                            }elseif( !$une_cagnotte['masque_identite'] && !email_exists( $email_participant ) ){

                              if( $une_cagnotte['avatar_participant_dans_cagnotte'] ){
                        ?>
                                <img src="<?php echo $une_cagnotte['avatar_participant_dans_cagnotte'] ?>" alt="<?php echo esc_html( $un['participant_']->post_title ); ?>">
                        <?php 
                              }else{
                        ?>
                              <img src="<?php echo get_field('default_gravatar','option') ?>" alt="<?php echo esc_html( $un['participant_']->post_title ); ?>">
                        <?php
                              }                                                                                                
                            }
                            # masqué identité
                            elseif( $une_cagnotte['masque_identite'] ){
                              if( $une_cagnotte['avatar_participant_dans_cagnotte'] ){
                        ?>
                              <img src="<?php echo $une_cagnotte['avatar_participant_dans_cagnotte'] ?>" alt="<?php echo esc_html( $un['participant_']->post_title ); ?>">
                        <?php
                              }else{
                                $bg = get_field('default_gravatar','option');
                        ?>
                                <img src="<?php echo $bg ?>" alt="" >
                        <?php 
                              }   
                            }
                            break;                                              
                          } 
                        }
                        ?>
                    </div>
                    <div class="txt">
                      <h4>
                        <?php
                          if ( $une_cagnotte['masque_identite'] && $une_cagnotte['pseudo_participant_dans_cagnotte']  ){
                            echo $une_cagnotte['pseudo_participant_dans_cagnotte'];
                          }elseif( $un['participant_']->post_title ){
                            echo esc_html( $un['participant_']->post_title ); 
                          }else{
                            echo __('Anonyme','kotikota');
                          }                                            
                        ?>
                      </h4>
                      <p><?php echo __('a participé le', 'kotikota').' '.$date_participation ?></p>
                      <?php
                        $masquer_montant = get_field('masquer_le_montant_de_la_contribution');
                        if ( !$masquer_montant ):
                            if ( !$une_cagnotte['masque_participation'] ){
                              $devise = get_field('devise',$post->ID);
                              $devise = $devise['label'] ? $devise['label'] : $devise[0];
                        ?>
                              <p><?php echo '<span class="format_chiffre">'.$une_cagnotte['montant_paye'].'</span> '. $devise ?></p>
                            <?php } 
                      endif; ?>
                    </div>
                  </div>
                </div>
      <?php 
            endif;
          endforeach;
        elseif($masquer_contributions): ?>
          <div class="cont-message wow fadeIn" data-wow-delay="900ms">
            <div class="ico"><img src="<?php echo IMG_URL ?>ico-login2.png"></div>
            <p><?php _e('Les participations sont masquées par le propriétaire de cette cagnotte.','kotikota') ?></p>
          </div>
      <?php
        else:
      ?>
          <div class="cont-message wow fadeIn" data-wow-delay="900ms">
            <div class="ico"><img src="<?php echo IMG_URL ?>ico-login2.png"></div>
            <p><?php _e('Il n’y a pas encore de participants','kotikota') ?></p>
          </div>
      <?php
        endif; 
      ?>
    </div>
  </div>
</div>