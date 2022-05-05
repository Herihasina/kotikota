<?php
  $benef = get_beneficiaire_cagnotte( $post->ID );
  $nom_beneficiaire = get_beneficiaire_info( $benef->ID )->nom;
  $titulaire_id = get_field('titulaire_de_la_cagnotte') ;
  $user = get_user_meta( $titulaire_id);
  $profil_valide = get_field('profil_valide', 'user_'.$titulaire_id );

  $curr_userdata = wp_get_current_user();
  $document_fichiers = get_field('liste_document_fichiers_cagnotte');
  $photos = get_field('liste_images_cagnotte');
  $videos = get_field('liste_videos_cagnotte');
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
      <a href="#pp-document" class="link fancybox" title="Document"><?php _e('Document','kotikota') ?></a>
      <a href="#pp-photos" class="link fancybox" title="Photos et vidéos"><?php _e('Photos ','kotikota') ?></a>
      <a href="#pp-videos" class="link fancybox" title="Photos et vidéos"><?php _e('vidéos','kotikota') ?></a>

      <div class="pp-document" id="pp-document" style="display: none">
        <div class="Document cont-pp">
            <div class="titre">
                <h2><?php _e('Documents','kotikota') ?></h2>
            </div>
            <div class="inner-pp">
                <div class="lst-document scrollbar-inner">
                  <?php if($document_fichiers):
                    $word_doc=[];
                    $pdf_doc=[];
                    $key_field=1;
                    foreach($document_fichiers as $doc ):
                      $file_data=[];
                      $fichier_id = $doc['fichier'];
                      $fichier = get_attached_file( $fichier_id);
                      $file_data['id'] = $key_field;
                      $file_data['name'] = basename ( $fichier );
                      $file_data['url'] =wp_get_attachment_url( $fichier_id );;
                      $extension = pathinfo( $fichier )['extension'];
                      if($extension=='pdf'):
                          $pdf_doc[]=$file_data;
                      elseif($extension=='docx' || $extension=='docx'):
                          $word_doc[]=$file_data;
                      endif;
                      $key_field++;
                    endforeach;

                ?>
                    <div class="row">
                      <div class="col">
                        <h3>documents word</h3>
                        <?php if($word_doc):?>
                          <div class="lst-option">
                            <?php foreach($word_doc as $doc ): ?>
                              <div class="item">
                                <?php if($curr_userdata->ID == $titulaire_id) :?>
                                  <input type="checkbox" name="doc_files" class="document document-check" id="doc-<?= $doc['id'] ?>" value="<?= $doc['id'] ?>">
                                  <label for="doc-<?= $doc['id'] ?>">
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
                        <?php else: ?>
                          <div style="text-align:center">
                              <h4 style="text-align:center">
                                  <?php printf( __( 'Aucun document', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                              </h4>
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
                                  <input type="checkbox" name="doc_files" class="document document-check" id="pdf-<?= $doc['id'] ?>" value="<?= $doc['id'] ?>">
                                  <label for="pdf-<?= $doc['id'] ?>">
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
                        <?php else: ?>
                          <div style="text-align:center">
                              <h4 style="text-align:center">
                                  <?php printf( __( 'Aucun document', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                              </h4>
                          </div>
                        <?php endif; ?>
                      </div>
                      </div>
                    </div>
                  <?php else: ?>
                      <div style="text-align:center">
                          <h4 style="text-align:center">
                              <?php printf( __( 'Aucun document', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                          </h4>
                      </div>
                  <?php endif; ?>
                </div>
              <?php if($curr_userdata->ID == $titulaire_id) :?>
                <div class="blcbtn">
                  <a href="#" id="add_doc_btn" class="link" title="<?php _e('Ajouter','kotikota')?>" data-cagnotte-id="<?=  $post->ID ?>"><?php _e('ajouter','kotikota')?></a>
                  <a href="#" id="remove_doc_btn" class="link" title="Supprimer" data-cagnotte-id="<?=  $post->ID ?>"><?php _e('Supprimer','kotikota') ?></a>
                </div>
              <?php endif; ?>
            </div>
            <div class="footer-pp">
                    <span><?php _e('Des questions ? En savoir plus sur la création des cagnottes ?','kotikota') ?></span>
                    <a href="<?php echo get_permalink( get_page_by_path( 'creer-cagnotte' ) ) ?>" title="<?php _e('Créer une cagotte en ligne','kotikota') ?>"><?php _e('Créer une cagotte en ligne','kotikota') ?></a> <!-- - <a href="#" title="Faire une simulation">Faire une simulation</a> -->
            </div>
        </div>

      <div class="pp-document" id="pp-photos" style="display: none">
        <div class="Document cont-pp">
            <div class="titre">
                <h2><?php _e('Images','kotikota') ?></h2>
            </div>
            <div class="inner-pp">
              <div class="lst-document scrollbar-inner">
                  <div class="row">
                    <div class="col photo">
                      <h3><?php _e('images','kotikota') ?></h3>
                      <?php if($photos):
                            $key_image=1;
                        ?>
                        <div class="lst-option blcphotos">
                          <?php foreach($photos as $photo ):
                            $image = wp_get_attachment_url( $photo['image'] );
                          ?>
                            <div class="item">
                              <div class="inner">
                              <?php if($curr_userdata->ID == $titulaire_id) :?>
                                <input type="checkbox" class="ck-photo" name="ck-photo" id="img-<?= $key_image?>" value="<?= $key_image?>">
                                <label for="img-<?= $key_image?>"></label>
                              <?php endif; ?>
                                <a href="<?= $image ?>" class="img fancybox"><img src="<?= $image ?>" alt="Kotikota"></a>
                              </div>
                            </div>
                          <?php
                              $key_image++;
                          endforeach; ?>
                        </div>
                      <?php
                      else:
                      ?>
                            <div style="text-align:center">
                                <h4 style="text-align:center">
                                    <?php printf( __( 'Aucune image', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                                </h4>
                            </div>
                    <?php endif; ?>
                    </div>
                  <!--   <div class="col video">
                      <h3><?php _e('vidéos','kotikota') ?></h3>
                        <div class="lst-option blcvideos ">
                          <?php if($videos):
                              $key_video=1;
                              $count_correct_id=0;
                          ?>
                            <div class="lst-option">
                              <?php foreach($videos as $video ):
                                $video_id= $video['lien_youtube'];
                                $video_data = get_youtube_video_detail($video_id);
                                if($video_data): $count_correct_id++;
                              ?>
                                  <div class="item">
                                    <div class="contvideo">
                                      <a href="<?= $video_data['url'] ?>" target="_blank">
                                        <div class="video-img"><img src="<?= $video_data['vignette'] ?>" alt="Kotikota"><span class="heure"><?= $video_data['duration'] ?></span></div>
                                        <div class="txt">
                                          <h4><?= $video_data['title'] ?></h4>
                                          <p><?= $video_data['description'] ?></p>
                                        </div>
                                        <?php if($curr_userdata->ID == $titulaire_id) :?>
                                          <div class="check-video">
                                            <input type="checkbox" class="ck-photo" name="ck-video" id="video-<?= $key_video?>" value="<?= $key_video?>">
                                            <label for="video-<?= $key_video?>"></label>
                                          </div>
                                        <?php endif; ?>
                                      </a>
                                    </div>
                                  </div>

                              <?php
                                endif;
                                $key_video++;
                              endforeach; ?>
                            </div>
                            <?php
                        elseif($count_correct_id!=count($videos)):
                        ?>
                            <div style="text-align:center">
                                <h4 style="text-align:center">
                                    <?php printf( __( 'Aucune video', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                                </h4>
                            </div>

                        <?php   else: ?>
                            <div style="text-align:center">
                                <h4 style="text-align:center">
                                    <?php printf( __( 'Aucune video', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                                </h4>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div> -->
                  </div>
              </div>
              <?php if($curr_userdata->ID == $titulaire_id) :?>
                <div class="blcbtn">
                  <a href="#ajout-video-image" class="link fancybox" title="<?php _e('Ajouter','kotikota')?>"><?php _e('ajouter','kotikota')?></a>
                  <a href="#" class="link" id="remove_media_btn" title="Supprimer" data-cagnotte-id="<?=  $post->ID ?>"><?php _e('Supprimer','kotikota') ?></a>
                </div>
              <?php endif; ?>
            </div>
            <div class="footer-pp">
                    <span><?php _e('Des questions ? En savoir plus sur la création des cagnottes ?','kotikota') ?></span>
                    <a href="<?php echo get_permalink( get_page_by_path( 'creer-cagnotte' ) ) ?>" title="<?php _e('Créer une cagotte en ligne','kotikota') ?>"><?php _e('Créer une cagotte en ligne','kotikota') ?></a> <!-- - <a href="#" title="Faire une simulation">Faire une simulation</a> -->
            </div>
        </div>


      </div>

       <div class="pp-document" id="pp-videos" style="display: none">
        <div class="Document cont-pp">
            <div class="titre">
                <h2><?php _e('Images et vidéos','kotikota') ?></h2>
            </div>
            <div class="inner-pp">
              <div class="lst-document scrollbar-inner">
                  <div class="row">
                
                    <div class="col video">
                      <h3><?php _e('vidéos','kotikota') ?></h3>
                        <div class="lst-option blcvideos ">
                          <?php if($videos):
                              $key_video=1;
                              $count_correct_id=0;
                          ?>
                            <div class="lst-option">
                              <?php foreach($videos as $video ):
                                $video_id= $video['lien_youtube'];
                                $video_data = get_youtube_video_detail($video_id);
                                if($video_data): $count_correct_id++;
                              ?>
                                  <div class="item">
                                    <div class="contvideo">
                                      <a href="<?= $video_data['url'] ?>" target="_blank">
                                        <div class="video-img"><img src="<?= $video_data['vignette'] ?>" alt="Kotikota"><span class="heure"><?= $video_data['duration'] ?></span></div>
                                        <div class="txt">
                                          <h4><?= $video_data['title'] ?></h4>
                                          <p><?= $video_data['description'] ?></p>
                                        </div>
                                        <?php if($curr_userdata->ID == $titulaire_id) :?>
                                          <div class="check-video">
                                            <input type="checkbox" class="ck-photo" name="ck-video" id="video-<?= $key_video?>" value="<?= $key_video?>">
                                            <label for="video-<?= $key_video?>"></label>
                                          </div>
                                        <?php endif; ?>
                                      </a>
                                    </div>
                                  </div>

                              <?php
                                endif;
                                $key_video++;
                              endforeach; ?>
                            </div>
                            <?php
                        elseif($count_correct_id!=count($videos)):
                        ?>
                            <div style="text-align:center">
                                <h4 style="text-align:center">
                                    <?php printf( __( 'Aucune video', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                                </h4>
                            </div>

                        <?php   else: ?>
                            <div style="text-align:center">
                                <h4 style="text-align:center">
                                    <?php printf( __( 'Aucune video', 'kotikota' ), esc_html( get_search_query() ) ); ?>
                                </h4>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                  </div>
              </div>
              <?php if($curr_userdata->ID == $titulaire_id) :?>
                <div class="blcbtn">
                  <a href="#ajout-video-image" class="link fancybox" title="<?php _e('Ajouter','kotikota')?>"><?php _e('ajouter','kotikota')?></a>
                  <a href="#" class="link" id="remove_media_btn" title="Supprimer" data-cagnotte-id="<?=  $post->ID ?>"><?php _e('Supprimer','kotikota') ?></a>
                </div>
              <?php endif; ?>
            </div>
            <div class="footer-pp">
                    <span><?php _e('Des questions ? En savoir plus sur la création des cagnottes ?','kotikota') ?></span>
                    <a href="<?php echo get_permalink( get_page_by_path( 'creer-cagnotte' ) ) ?>" title="<?php _e('Créer une cagotte en ligne','kotikota') ?>"><?php _e('Créer une cagotte en ligne','kotikota') ?></a> <!-- - <a href="#" title="Faire une simulation">Faire une simulation</a> -->
            </div>
        </div>


      </div>
      <div id="ajout-video-image" style="display: none">
          <a id="add_image" class="link" title="Cliquez ici pour ajouter une photo" data-cagnotte-id="<?=  $post->ID ?>"><?php _e('Cliquez ici pour ajouter une photo','kotikota') ?></a>
          <div class="col">
              <div class=" blc-chp ">
                  <label for="fname"><?php echo __('ID de la nouvelle video','kotikota'); ?><span>*</span></label>
                  <div class="chp">
                    <input type="text" name="video_id" placeholder="<?php echo __('exemple: 9wNPug7h1gQ','kotikota'); ?>" >
                  </div>
              </div>
              <div id="add_video" class="link" title="<?php _e('Ajouter','kotikota') ?>" data-cagnotte-id="<?=  $post->ID ?>"><?php _e('Ajouter','kotikota') ?></div>
              <span class="error_video">

              </span>
          </div>
      </div>
    </div>


  </div>
</div>
