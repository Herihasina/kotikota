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

                        <div class="item">
                          <input type="checkbox" class="document" id="doc3"> 
                          <label for="doc3">
                            <div class="ico"><img src="<?= IMG_URL ?>word.png" alt="Kotikota"></div>
                            <div class="txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</div>
                          </label>
                        </div>
                        <div class="item">
                          <input type="checkbox" class="document" id="doc4"> 
                          <label for="doc4">
                            <div class="ico"><img src="<?= IMG_URL ?>word.png" alt="Kotikota"></div>
                            <div class="txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</div>
                          </label>
                        </div>
                        <div class="item">
                          <input type="checkbox" class="document" id="doc5"> 
                          <label for="doc5">
                            <div class="ico"><img src="<?= IMG_URL ?>word.png" alt="Kotikota"></div>
                            <div class="txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</div>
                          </label>
                        </div>
                        <div class="item">
                          <input type="checkbox" class="document" id="doc6"> 
                          <label for="doc6">
                            <div class="ico"><img src="<?= IMG_URL ?>word.png" alt="Kotikota"></div>
                            <div class="txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</div>
                          </label>
                        </div>
                        <div class="item">
                          <input type="checkbox" class="document" id="doc7"> 
                          <label for="doc7">
                            <div class="ico"><img src="<?= IMG_URL ?>word.png" alt="Kotikota"></div>
                            <div class="txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</div>
                          </label>
                        </div>

                      </div>
                    </div>
                    <div class="col">
                      <h3>documents pdf</h3>
                        <div class="lst-option">        
                          <div class="item">
                            <input type="checkbox" class="document" id="pdf1"> 
                            <label for="pdf1">
                              <div class="ico"><img src="<?= IMG_URL ?>pdf.png" alt="Kotikota"></div>
                              <div class="txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</div>
                            </label>
                          </div>
                          <div class="item">
                            <input type="checkbox" class="document" id="pdf2"> 
                            <label for="pdf2">
                              <div class="ico"><img src="<?= IMG_URL ?>pdf.png" alt="Kotikota"></div>
                              <div class="txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</div>
                            </label>
                          </div>
                          <div class="item">
                            <input type="checkbox" class="document" id="pdf3"> 
                            <label for="pdf3">
                              <div class="ico"><img src="<?= IMG_URL ?>pdf.png" alt="Kotikota"></div>
                              <div class="txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</div>
                            </label>
                          </div>
                          <div class="item">
                            <input type="checkbox" class="document" id="pdf4"> 
                            <label for="pdf4">
                              <div class="ico"><img src="<?= IMG_URL ?>pdf.png" alt="Kotikota"></div>
                              <div class="txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</div>
                            </label>
                          </div>
                          <div class="item">
                            <input type="checkbox" class="document" id="pdf5"> 
                            <label for="pdf5">
                              <div class="ico"><img src="<?= IMG_URL ?>pdf.png" alt="Kotikota"></div>
                              <div class="txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</div>
                            </label>
                          </div>
                          <div class="item">
                            <input type="checkbox" class="document" id="pdf6"> 
                            <label for="pdf6">
                              <div class="ico"><img src="<?= IMG_URL ?>pdf.png" alt="Kotikota"></div>
                              <div class="txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</div>
                            </label>
                          </div>
                          <div class="item">
                            <input type="checkbox" class="document" id="pdf7"> 
                            <label for="pdf7">
                              <div class="ico"><img src="<?= IMG_URL ?>pdf.png" alt="Kotikota"></div>
                              <div class="txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</div>
                            </label>
                          </div>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                      <div class="blcbtn">
                           <a href="#" class="link" title="Ajouter">ajouter</a>
                           <a href="#" class="link" title="Modifier">modifier</a>
                           <a href="#" class="link" title="Supprimer">Supprimer</a>
                      </div>
                    </div>

                  </div>
              </div>
            </div>

            <div class="footer-pp">
                    <span>Des questions ? En savoir plus sur la création des cagnottes ?</span>
                    <a href="<?php echo get_permalink( get_page_by_path( 'creer-cagnotte' ) ) ?>" title="Créer une cagotte en ligne">Créer une cagotte en ligne</a> - <a href="#" title="Faire une simulation">Faire une simulation</a>
            </div>
        </div>
      </div>

    </div>
  </div>
</div> 
