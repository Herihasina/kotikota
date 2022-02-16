<div class="titre jaune">
  <span class="ico"><img src="<?= IMG_URL ?>ico-cagnotte1.png"></span>
  <span class="label"><?php _e('cagnotte Organisée par :','kotikota'); ?></span>
  <span class="nom">
    <?php 
      $user = get_user_meta( get_field('titulaire_de_la_cagnotte') );
      if ( $user['first_name'][0] != '' || $user['last_name'][0] != '' ){
        echo $user['first_name'][0].' '.$user['last_name'][0]; 
      }else{
        echo $user['nickname'][0];
      }
    ?>
   </span>
</div>
<div class="txt">
  <?php if ( get_field('description_de_la_cagnote') ) : ?>
    <p>
      <?php 
        // if ( 
        //   $type_cagnotte == "solidaire" || 
        //   $isInvited ||
        //   get_field('titulaire_de_la_cagnotte')  == get_current_user_id() || 
        //   current_user_can('administrator') 
        // ){
          echo get_field('description_de_la_cagnote');
        // }
        // elseif ( $type_cagnotte == "perso"){
        //   echo substr(get_field('description_de_la_cagnote'), 0, 220 ).'...';
        // }
      ?>
    </p>
  <?php endif; ?>

  <div class="pp-document-photos">
    <div class="blcbtn">
      <a href="#pp-document" class="link fancybox" title="Document">Document</a>
      <a href="#" class="link" title="Photos et vidéos">Photos et vidéos</a>

      <div class="pp-document" id="pp-document" style="display: none">
        <div class="Document cont-pp">
            <div class="titre">
                <h2>Documents</h2>
            </div>
            <div class="inner-pp">
              <div class="scroll-wrapper lst-document scrollbar-inner">
                  <div class="row">
                    <div class="col">
                      <h3>documents word</h3>
                      <div class="lst-option">
                        
                        <div class="item">
                          <input type="checkbox" class="document" id="doc1"> 
                          <label for="doc1">
                            <div class="ico"><img src="<?= IMG_URL ?>word.png" alt="Kotikota"></div>
                            <div class="txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</div>
                          </label>
                        </div>

                        <div class="item">
                          <input type="checkbox" class="document" id="doc2"> 
                          <label for="doc2">
                            <div class="ico"><img src="<?= IMG_URL ?>word.png" alt="Kotikota"></div>
                            <div class="txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</div>
                          </label>
                        </div>


                      </div>
                    </div>
                    <div class="col">
                      <h3>documents pdf</h3>
                    </div>
                  </div>
              </div>
            </div>
        </div>
      </div>

    </div>
  </div>
</div> 
