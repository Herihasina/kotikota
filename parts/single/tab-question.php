<div class="tab-content" id="question">
    <div class="lst-comment">
      <?php
        $questions = get_field('questions', $post->ID);
        if ( $questions ):
          usort($questions,function($a, $b) {
            return strcmp($b->post_date, $a->post_date);
          });
          foreach ( $questions as $question ):
            $user_data = get_user_meta($question->post_author);
      ?>
            <div class="listComment">
                <div class="content-comment" id="relative">
                    <div class="profil">
                      <?php
                         $bg = wp_get_attachment_image_src(get_field('photo', 'user_'.$question->post_author),'icone-serasera' )[0];
                          if ( !$bg ) $bg = get_field('default_gravatar','option'); ?>
                           <img src="<?php echo $bg ?>" alt="" >

                    </div>
                    <b class="author-name">
                      <?php
                        if ( $user_data['first_name'][0] != '' || $user_data['last_name'][0] != '' ){
                          echo $user_data['first_name'][0].' '.$user_data['last_name'][0];
                        }elseif ($user_data['nickname'][0] != '') {
                          echo $user_data['nickname'][0];
                        } else {
                          echo __('Anonyme','kotikota');
                        }
                      ?>
                    </b>
                    <?php
                      $date = new DateTime($question->post_date);
                    ?>
                    <span class="date"><? _e('a écrit le ','kotikota') $date->format('d/m/Y'); ) ?></span>
                    <div class="txt">
                        <?php echo $question->post_content; ?>

                    </div>
                    <?php
                      if( get_current_user_id() == $question->post_author ):
                    ?>
                    <div class="edit">
                      <a href="#" title="" data-edit="<?php echo $question->ID ?>">&#9998;</a>
                    </div>
                      <?php
                      endif;
                      if(
                        (
                          is_user_logged_in()
                          && get_field('titulaire_de_la_cagnotte', $post->ID )  == get_current_user_id()
                        ) || current_user_can('administrator')
                        || get_current_user_id() == $question->post_author
                        ):
                    ?>
                    <div class="delete">
                      <a href="#" title="" data-delete="<?php echo $question->ID ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24" fill="#f00"><path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path></svg>
                      </a>
                    </div>
                  <?php endif; ?>
                </div>

            </div>
      <?php
        endforeach;
        else:
      ?>
          <div class="cont-message wow fadeIn" data-wow-delay="900ms">
            <div class="ico"><img src="<?php echo IMG_URL ?>ico-login2.png"></div>
            <p><?php _e("Il n'y a pas encore de questions", 'kotikota') ?></p>
          </div>
      <?php
        endif;
      ?>
      <?php if ( is_user_logged_in() ):
        $current_id = get_current_user_id();
        $user_data = get_user_meta( $current_id );
        endif;
      ?>
       <div class="chp-comment" id="chp-comment">
          <div class="content-comment">
              <div class="profil">
                <?php
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
                <input type="hidden" id="idCagnotte-question" value="<?= $post->ID ?>">
                <input type="text" name="" id="la-question" placeholder="<?= __('Rédigez votre question et/ou commentaire','kotikota') ?>" class="chp">
                <input type="button" id="add-question" class="btn-send">
                <input type="button" id="edit-question" class="btn-send">
              </div>
          </div>
      </div>
      <?php //endif; ?>
    </div>
</div>