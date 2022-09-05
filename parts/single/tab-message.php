<div class="tab-content" id="mot-doux">
    <div class="lst-comment">
      <?php
        $mot_doux = get_field('mot_doux', $post->ID); 
        
        if ( $mot_doux ):
          usort($mot_doux,function($a, $b) {
            return strcmp($b->post_date, $a->post_date);
          });
          foreach ( $mot_doux as $mot_dou ):
            
            $authorID = get_user_id_by_display_name( $mot_dou->post_title );
            $user_data = get_user_meta($mot_dou->post_author);
      ?>
      <div class="listComment">
          <div class="content-comment" id="relative">
              <div class="profil">
                <?php
                  $bg = wp_get_attachment_image_src(get_field('photo', 'user_'. $authorID->ID ),'icone-serasera' )[0];

                  if( get_post_meta( $mot_dou->ID, 'avatar_mot_doux', true ) ){
                ?>
                    <img src="<?php echo get_post_meta( $mot_dou->ID, 'avatar_mot_doux', true ) ?>" alt="" > 
                <?php 
                  }else{
                    if( !$bg ) $bg = get_field('default_gravatar','option');  
                ?>
                    <img src="<?php echo $bg ?>" alt="" > 
                <?php } ?>
              </div>
              <b class="author-name">
                <?php
                  if( get_post_meta( $mot_dou->ID, 'pseudo_mot_doux', true ) ){
                    echo get_post_meta( $mot_dou->ID, 'pseudo_mot_doux', true );
                  }elseif ( $user_data['first_name'][0] != '' || $user_data['last_name'][0] != '' ){
                    echo $user_data['first_name'][0].' '.$user_data['last_name'][0]; 
                  }else{
                    echo $mot_dou->post_title;
                  }
                ?>
              </b>
              <?php $date = new DateTime($mot_dou->post_date); ?>
              <span class="date">
                <?php 
                $date = $date->format("d/m/y");

                printf( __('a écrit le %s','kotikota'), $date ) ?>
              </span>
              <div class="txt">
                  <?php echo $mot_dou->post_content; ?>

              </div>
              <?php
                if( is_user_logged_in() &&
                    (get_field('titulaire_de_la_cagnotte')  == get_current_user_id() 
                    || current_user_can('administrator') 
                    || get_current_user_id() == $mot_dou->post_author
                    )
                  ):
                    ?>
                    <div class="delete">
                      <a href="#" title="" data-delete="<?php echo $mot_dou->ID ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24" fill="#f00"><path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path></svg>
                      </a>
                    </div>
                  <?php endif; ?>
          </div>

        </div>


      <?php endforeach; 
       else: ?>
        <div class="cont-message wow fadeIn" data-wow-delay="900ms">
            <div class="ico"><img src="<?php echo IMG_URL ?>message1.png"></div>
            <p><?php _e("Il n'y a pas encore de mots doux", 'kotikota') ?></p>
          </div>
      <?php endif; ?>

          <div class="chp-comment" id="chp-message">
              <div class="content-comment">
                  <div class="profil">
                    <?php
                    if ( is_user_logged_in() ):
                      $current_id = get_current_user_id();
                      $user_data = get_user_meta( $current_id );
                    endif;
                      if($current_id) {
                        $bg = wp_get_attachment_image_src(get_field('photo', 'user_'.$current_id),'icone-serasera' )[0];
                      }
                      if ( !$bg && isset($bg) ) $bg = get_field('default_gravatar','option'); ?>
                      <img src="<?php echo $bg ?>" alt="" >

                  </div>
                  <b class="author-name">
                    <?php
                      if($current_id) {
                        if ( $user_data['first_name'][0] != '' || $user_data['last_name'][0] != '' ){
                          echo $user_data['first_name'][0].' '.$user_data['last_name'][0];
                        }else{
                          echo $user_data['nickname'][0];
                        }
                      } else {
                        echo __('Anonyme','kotikota');
                      }
                    ?>
                  </b>
                  <div class="blc-chp">
                    <input type="hidden" id="idCagnotte-md" value="<?= $post->ID ?>">
                    <input type="text" name="" id="la-md" placeholder="<?= __('Rédigez votre message/mot doux','kotikota') ?>" class="chp">
                    <input type="button" id="add-md" class="btn-send">
                    <input type="button" id="edit-md" class="btn-send">
                  </div>
              </div>
          </div>
 
    </div>
</div>