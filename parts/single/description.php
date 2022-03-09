<?php 
  $benef = get_beneficiaire_cagnotte( $post->ID );
  $nom_beneficiaire = get_beneficiaire_info( $benef->ID )->nom;
  $titulaire_id = get_field('titulaire_de_la_cagnotte') ;
  $user = get_user_meta( $titulaire_id);
  $profil_valide = get_field('profil_valide', 'user_'.$titulaire_id );

  $curr_userdata = wp_get_current_user();
  $liste_des_documents = get_field('liste_des_documents');
  $document_fichiers = $liste_des_documents['document_fichiers'];
  $photos_et_videos = $liste_des_documents['photos_et_videos'];
  $photos = $photos_et_videos['images'];
  $videos = $photos_et_videos['videos'];
?>

<div class="titre jaune">
  <span class="ico"><img src="<?= IMG_URL ?>ico-cagnotte1.png"></span>
   <div class="txt-beneficiaire">
    <div class="txt-inner">
      <div>
        <span class="label"><?php _e('cagnotte Organisée par :','kotikota'); ?></span>
        <span class="nom">
          <?php 
            if ( $user['first_name'][0] != '' || $user['last_name'][0] != '' ){
              echo $user['first_name'][0].' '.$user['last_name'][0]; 
            }else{
              echo $user['nickname'][0];
            }
          ?>
         </span>
      </div>
      <div>
         <span class="label"><?php _e('Bénéficiaire :','kotikota'); ?> </span> 
         <span class="nom"><?= $nom_beneficiaire ?></span>
      </div>
     </div>
   </div>
  <?php if($profil_valide) :?>
      <div class="profilverifi">
        <span><?php _e('Profil vérifié','kotikota'); ?></span>
      </div>
  <?php endif; ?>

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
              <?php if($document_fichiers): 
                  $word_doc=[];  
                  $pdf_doc=[];  
                  foreach($document_fichiers as $doc ): 
                    $file_data=[];
                    $fichier = $doc['fichier']; 
                    $file_data['name'] = $fichier['title'];
                    $file_data['url'] = $fichier['url'];
                    $extension = pathinfo(  $file_data['url'] )['extension'];
                    if($extension=='pdf'):
                        $pdf_doc[]=$file_data;
                    elseif($extension=='docx' || $extension=='docx'):
                        $word_doc[]=$file_data;
                    endif;
                  endforeach;
                
              ?>
                <div class="lst-document scrollbar-inner">
                    <div class="row">
                      <div class="col">
                        <h3>documents word</h3>
                        <?php if($word_doc):?>
                          <div class="lst-option">
                            <?php foreach($word_doc as $doc ): ?>        
                              <div class="item">
                                <?php if($curr_userdata->ID == $titulaire_id) :?>
                                  <input type="checkbox" class="document" id="doc1"> 
                                  <label for="doc1">
                                    <div class="ico"><img src="<?= IMG_URL ?>word.png" alt="Kotikota"></div>
                                    <div class="txt"><?= $doc['name'] ?></div>
                                  </label>
                                <?php else: ?>
                                  <a href="<?= $doc['url'] ?>" class="doc-item-link">
                                      <div class="ico"><img src="<?= IMG_URL ?>word.png" alt="Kotikota"></div>
                                      <div class="txt"><?= $doc['name'] ?></div>
                                  </a>
                                <?php endif; ?>
                              </div>
                            <?php endforeach; ?>
                          </div>
                        <?php endif; ?>
                      </div>
                      <div class="col">
                        <h3>documents pdf</h3>
                        <?php if($pdf_doc):?>
                          <div class="lst-option">       
                            <?php foreach($pdf_doc as $doc ): ?>   
                              <div class="item">
                                <?php if($curr_userdata->ID == $titulaire_id) :?>
                                  <input type="checkbox" class="document" id="pdf1"> 
                                  <label for="pdf1">
                                    <div class="ico"><img src="<?= IMG_URL ?>pdf.png" alt="Kotikota"></div>
                                    <div class="txt"><?= $doc['name'] ?></div>
                                  </label>
                                <?php else: ?>
                                  <a href="<?= $doc['url'] ?>" class="doc-item-link" target="_blank">
                                      <div class="ico"><img src="<?= IMG_URL ?>pdf.png" alt="Kotikota"></div>
                                      <div class="txt"><?= $doc['name'] ?></div>
                                  </a>
                                <?php endif; ?>
                              </div>
                            <?php endforeach; ?>
                          </div>
                        <?php endif; ?>
                      </div>
                      </div>
                    </div>
                    <div class="blcbtn">
                      <a href="#" class="link" title="Ajouter">ajouter</a>
                      <a href="#" class="link" title="Modifier">modifier</a>
                      <a href="#" class="link" title="Supprimer">Supprimer</a>
                    </div>
                </div>
              <?php endif; ?>
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
                      <?php if($photos): ?>
                        <div class="lst-option blcphotos">
                          <?php foreach($photos as $photo ): 
                            $image = $photo['image'] ;
                          ?>         
                            <div class="item">
                              <div class="inner">
                              <?php if($curr_userdata->ID == $titulaire_id) :?>
                                <input type="checkbox" class="ck-photo" id="img1"> 
                                <label for="img1"></label>
                              <?php endif; ?>
                                <a href="<?= $image['url'] ?>" class="img fancybox"><img src="<?= $image['url'] ?>" alt="Kotikota"></a>
                              </div> 
                            </div>
                          <?php endforeach; ?>

                        </div>
                      <?php endif; ?>
                    </div>
                    <div class="col video">
                      <h3>vidéos</h3>
                        <div class="lst-option blcvideos ">        
                          <div class="item">      
                            <div class="contvideo">
                              <a href="#" target="_blank">
                              <div class="video-img"><img src="<?= IMG_URL ?>video1.jpg" alt="Kotikota"><span class="heure">23:15</span></div>
                              <div class="txt">
                                <h4>Lorem ipsum dolor sit amet, consectetur ΔΩ </h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</p>
                              </div>
                              <div class="check-video">                            
                                 <input type="checkbox" class="ck-photo" id="video1"> 
                                 <label for="video1"></label>
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
                                <div class="check-video">                            
                                   <input type="checkbox" class="ck-photo" id="video2"> 
                                   <label for="video2"></label>
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
                               <div class="check-video">                            
                                 <input type="checkbox" class="ck-photo" id="video3"> 
                                 <label for="video3"></label>
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
                                 <div class="check-video">                            
                                   <input type="checkbox" class="ck-photo" id="video4"> 
                                   <label for="video4"></label>
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
