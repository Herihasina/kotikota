<div class="titre jaune">
  <span class="ico"><img src="<?= IMG_URL ?>ico-cagnotte1.png"></span>
   <div class="txt-beneficiaire">
    <div class="txt-inner">
      <div>
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
      <div>
         <span class="label">Bénéficiaire : </span> 
         <span class="nom">Sakalava capitale</span>
      </div>
     </div>
   </div>
   <div class="profilverifi">
     <span>Profil vérifié</span>
   </div>

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
      <a href="#pp-photos" class="link fancybox" title="Photos et vidéos">Photos et vidéos</a>
      
      <div class="pp-document" id="pp-document" style="display: none">
        <div class="Document cont-pp">
            <div class="titre">
                <h2>Documents</h2>
            </div>
            <div class="inner-pp">
              <div class="lst-document scrollbar-inner">
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
                       
                    
                        </div>
                    </div>
                    </div>
                  </div>
                  <div class="blcbtn">
                     <a href="#" class="link" title="Ajouter">ajouter</a>
                     <a href="#" class="link" title="Modifier">modifier</a>
                     <a href="#" class="link" title="Supprimer">Supprimer</a>
                  </div>
              </div>
            </div>
            <div class="footer-pp">
                    <span>Des questions ? En savoir plus sur la création des cagnottes ?</span>
                    <a href="<?php echo get_permalink( get_page_by_path( 'creer-cagnotte' ) ) ?>" title="Créer une cagotte en ligne">Créer une cagotte en ligne</a> <!-- - <a href="#" title="Faire une simulation">Faire une simulation</a> -->
            </div>
        </div>

      <div class="pp-document" id="pp-photos" style="display: none">
        <div class="Document cont-pp">
            <div class="titre">
                <h2>Images et vidéos</h2>
            </div>
            <div class="inner-pp">
              <div class="lst-document scrollbar-inner">
                  <div class="row">
                    <div class="col photo">
                      <h3>images</h3>
                      <div class="lst-option blcphotos">        
                        <div class="item">
                          <div class="inner">
                            <input type="checkbox" class="ck-photo" id="img1"> 
                            <label for="img1"></label>
                            <a href="<?= IMG_URL ?>photo1.jpg" class="img fancybox"><img src="<?= IMG_URL ?>photo1.jpg" alt="Kotikota"></a>
                          </div> 
                        </div>

                        <div class="item">
                          <div class="inner">
                            <input type="checkbox" class="ck-photo" id="img2"> 
                            <label for="img2"></label>
                            <a href="<?= IMG_URL ?>photo2.jpg"class="img fancybox"><img src="<?= IMG_URL ?>photo2.jpg" alt="Kotikota"></a>
                          </div>
                        </div>

                        <div class="item">
                          <div class="inner">
                            <input type="checkbox" class="ck-photo" id="img3"> 
                            <label for="img3">  </label>
                            <a href="<?= IMG_URL ?>photo3.jpg"  class="img fancybox"><img src="<?= IMG_URL ?>photo3.jpg" alt="Kotikota"></a>
                          </div>
                        </div>
                        <div class="item">
                          <div class="inner">
                            <input type="checkbox" class="ck-photo" id="img4"> 
                            <label for="img4"></label>
                            <a href="<?= IMG_URL ?>photo4.jpg" class="img fancybox"><img src="<?= IMG_URL ?>photo4.jpg" alt="Kotikota"></a>
                          </div>
                        </div>
                        <div class="item">
                          <div class="inner">
                            <input type="checkbox" class="ck-photo" id="img5"> 
                            <label for="img5">     
                            </label>
                            <a href="<?= IMG_URL ?>photo5.jpg" class="img fancybox"><img src="<?= IMG_URL ?>photo5.jpg" alt="Kotikota"></a> 
                          </div>
                        </div>
                        <div class="item">
                          <div class="inner">
                            <input type="checkbox" class="ck-photo" id="img6"> 
                            <label for="img6"> </label>
                            <a href="<?= IMG_URL ?>photo6.jpg" class="img fancybox"><img src="<?= IMG_URL ?>photo6.jpg" alt="Kotikota"></a> 
                          </div>
                        </div>
                        <div class="item">
                          <div class="inner">
                            <input type="checkbox" class="ck-photo" id="img7"> 
                            <label for="img7">   </label>
                            <a href="<?= IMG_URL ?>photo7.jpg" class="img fancybox"><img src="<?= IMG_URL ?>photo7.jpg" alt="Kotikota"></a> 
                          </div>
                        </div>

                        <div class="item">
                          <div class="inner">
                            <input type="checkbox" class="ck-photo" id="img8"> 
                            <label for="img8"> </label>
                            <a href="<?= IMG_URL ?>photo8.jpg" class="img fancybox"><img src="<?= IMG_URL ?>photo8.jpg" alt="Kotikota"></a> 
                          </div>
                        </div>

                      

                      </div>
                    </div>
                    <div class="col video">
                      <h3>vidéos</h3>
                        <div class="lst-option">        
                          <div class="item">      
                            <div class="contvideo">
                              <a href="#" target="_blank">
                              <div class="video-img"><img src="<?= IMG_URL ?>video1.jpg" alt="Kotikota"><span class="heure">23:15</span></div>
                              <div class="txt">
                                <h4>Lorem ipsum dolor sit amet, consectetur ΔΩ </h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</p>
                              </div>
                              </a>
                            </div>
                            
                          </div>
                          <div class="item">
                            <div class="contvideo">
                              <a href="#" target="_blank">
                                <div class="video-img"><img src="<?= IMG_URL ?>video2.jpg" alt="Kotikota"><span class="heure">12:37</span></div>
                                <div class="txt">
                                  <h4>Lorem ipsum dolor sit amet, consectetur ΔΩ </h4>
                                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</p>
                                </div>
                              </a>

                            </div>
                          </div>
                          <div class="item">
                            
                            <div class="contvideo">
                              <a href="#" target="_blank">
                              <div class="video-img"><img src="<?= IMG_URL ?>video3.jpg" alt="Kotikota"><span class="heure">18:10</span></div>
                              <div class="txt">
                                <h4>Lorem ipsum dolor sit amet, consectetur ΔΩ </h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</p>
                              </div>
                            </div>
                            </a>
                          </div>
                          <div class="item">
                            <div class="contvideo">
                              <a href="#" target="_blank">
                                <div class="video-img"><img src="<?= IMG_URL ?>video4.jpg" alt="Kotikota"><span class="heure">45:25</span></div>
                                <div class="txt">
                                  <h4>Lorem ipsum dolor sit amet, consectetur ΔΩ </h4>
                                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</p>
                                </div>
                              </a>
                            </div>
                          </div>
                        </div>
                    </div>
                    </div>
                  </div>
                  <div class="blcbtn">
                     <a href="#" class="link" title="Ajouter">ajouter</a>
                     <a href="#" class="link" title="Modifier">modifier</a>
                     <a href="#" class="link" title="Supprimer">Supprimer</a>
                  </div>
              </div>
            </div>
            <div class="footer-pp">
                    <span>Des questions ? En savoir plus sur la création des cagnottes ?</span>
                    <a href="<?php echo get_permalink( get_page_by_path( 'creer-cagnotte' ) ) ?>" title="Créer une cagotte en ligne">Créer une cagotte en ligne</a> <!-- - <a href="#" title="Faire une simulation">Faire une simulation</a> -->
            </div>
        </div>


      </div>
    </div>


  </div>
</div> 
