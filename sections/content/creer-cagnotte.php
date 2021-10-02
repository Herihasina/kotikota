<div class="blc-cagnotte">
                <div class="wrapper">
                     <div class="blc-slider-range">
                        <div class="slider-range wow fadeIn" data-wow-delay="900ms">
                             <p>
                              <label><?php _e('Création de cagnotte à','kotikota') ?></label>    
                            </p>        
                            <div id="slider-range-min"> 
                                 <span class="pourcentage" id="pourcentage">20%</span>
                            </div>
                        </div>

                     </div>
                    <div class="lst-type-cagnotte wow fadeInUp" data-wow-delay="900ms">
                        <form class="form-type clr">
                            <label><?php _e('Choisir un type de cagnotte','kotikota') ?> <span>*</span></label>
                            <div class="clear"></div>
                            <div class="lst-form-type clr jauge">
                            <?php 
                                $parents = get_terms( array(
                                    'taxonomy' => 'categ-cagnotte',
                                    'hide_empty' => false,
                                    'orderby' => 'tax_position',
                                    'order' => 'ASC',
                                    'meta_key' => 'tax_position',
                                    'parent' => 0
                                ) );

                                $i = 0;
                                foreach ( $parents as $parent ){
                                ?>
                                    <div class="col">
                                        <div class="offrir-cadeau">
                                            <h3 class="titre"><?php echo $parent->name; ?></h3>
                                            <div class="lst-type">
                                                <?php
                                                    $enfants = get_terms( array( 
                                                            'taxonomy' => 'categ-cagnotte',
                                                            'hide_empty' => false,
                                                            'orderby' => 'tax_position',
                                                            'order' => 'ASC',
                                                            'meta_key' => 'tax_position',
                                                            'child_of' => $parent->term_id
                                                        ));
                                                    foreach ( $enfants as $enfant ):
                                                        $visu = get_field('picto_sous-categorie', 'categ-cagnotte_'. $enfant->term_id);
                                                        $couleur = "";
                                                        if( is_array($visu) && array_key_exists( 'class_de_cette_categorie' , $visu ) ):
                                                            $couleur = $visu['class_de_cette_categorie'];
                                                        endif;
                                                ?>
                                                             <div class="item">
                                                                 <div class="content">
                                                                     <div class="inner <?php echo $couleur; ?>">
                                                                        <?php echo $enfant->name; ?>
                                                                        <span></span>
                                                                           <input type="hidden" name="sous-categ" value="<?php echo $enfant->term_id ?>"> 
                                                                           <input type="hidden" name="categ" value="<?php echo $parent->term_id ?>"> 
                                                                    </div>
                                                                 </div>
                                                             </div>
                                                <?php 
                                                        
                                                    endforeach;
                                                ?>
                                             </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                         </form>
                     </div>
                </div>
                <div id="formulaire" class="formulaire-cagnotte">
                <div class="wrapper">
                     <form>
                         <div class="chy-type clr wow fadeIn" data-wow-delay="900ms">
                         <!-- <div class="blc-chp wow fadeIn" data-wow-delay="900ms"> -->
                            <div class="row">
                                 <div class="col col53">
                                    <div class="blc-chp">
                                         <label><?php _e('Donnes un nom à ta cagnotte','kotikota'); ?> <span>*</span></label>
                                         <input type="text" name="" id="nom_cagnotte" class="chp jauge">
                                    </div>
                                 </div>
                                 <div class="col col47">
                                    <div class="blc-chp">
                                        <label><?php _e('Le nom du/des bénéficiaires','kotikota'); ?> <span>*</span></label>
                                         <input type="text" name="" id="nom_benef" class="chp jauge">
                                    </div>
                                 </div>
                             </div>
                         </div>
                         <div class="choix-photo clr wow fadeIn" data-wow-delay="900ms">
                             <div class="col-left">
                                <label><?php _e('Choisis la bonne photo ','kotikota'); ?> <span>*</span></label>
                                <div class="blc-img jauge">
                                    <div class="zone-img">
                                        <input name="file" id="fileImg" class="inputfile" type="text">
                                        <label for="fileImg"><?php _e('Ajouter  <br> votre photo','kotikota'); ?></label>
                                        <input type="hidden" value="" name="choix-photo" id="url_img_cagnotte">
                                    </div>
                                    <div class="lst-img clr scrollbar-inner">
                                        <div class="inner">
                                            <?php
                                                $query_images_args = array(
                                                    'post_type'      => 'attachment',
                                                    'post_mime_type' => 'image',
                                                    'post_status'    => 'inherit',
                                                    'posts_per_page' => 6,
                                                    'author__in'     => array( get_current_user_id() )
                                                );

                                                $query_images = new WP_Query( $query_images_args );

                                                if ( $query_images){
                                                    $user_media = [];
                                                    foreach(  $query_images->posts as $imageko ){
                                                        $user_media[] = $imageko->ID;
                                                    }
                                                }
                                                $imgs = get_field('images_proposees','option'); 
                                                if (is_array($imgs)):
                                                    foreach ( $imgs as $img ):// var_dump( getimagesize(wp_get_attachment_image_url( $img['image_prop'],'full')));
                                            ?>
                                                        <div class="img">
                                                           <a href="#" data-imgsrc="<?php echo wp_get_attachment_image_url( $img['image_prop'], 'full' ) ?>"><?php echo wp_get_attachment_image( $img['image_prop'], 'cagnotte-choix-upload' ) ?></a>
                                                        </div>
                                            <?php endforeach;
                                                endif;
                                                foreach( $user_media as $img ): ?>
                                                    <div class="img">
                                                       <a href="#" data-imgsrc="<?php echo wp_get_attachment_image_url( $img, 'full' ) ?>"><?php echo wp_get_attachment_image( $img, 'cagnotte-choix-upload' ) ?></a>
                                                    </div>
                                                <?php
                                                endforeach;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tip tip_creation"><?php printf( __('%s taille 8 Mo autorisée %s','kotikota'), '📸','😉' ) ?></div>
                             </div>
                             <div class="col-right">
                                 <div class="blc-chp">
                                    <label><?php _e('Il est temps d’en dire un peu plus aux participants','kotikota'); ?> <span>*</span> </label>
                                    <textarea class="txt-area jauge" placeholder="<?= __('Message','kotikota'); ?>" id="description_cagnotte"></textarea>
                                 </div>
                             </div>
                         </div>
                        <div class="chy-type clr wow fadeIn" data-wow-delay="950ms">
                            <div class="row">
                                <!-- <div class="col col53">
                                    <div class="blc-chp">
                                         <label><?php _e('Type de cagnotte','kotikota'); ?></label>
                                         <select id="type_cagnotte">
                                            <option value="perso"><?php _e('Cagnotte Privée','kotikota'); ?></option>
                                            <option value="solidaire"><?php _e('Cagnotte Publique','kotikota'); ?></option>
                                        </select>
                                    </div>
                                 </div> -->
                                 <input type="hidden" name="visi" value="solidaire" id="type_cagnotte">
                                 <div class="col col47 col-dates">
                                    <div class="chy-type clr">
                                        <div class="row">
                                            <div class="col col47">
                                                <div class="blc-chp">
                                                     <label><?php _e('Date de début','kotikota'); ?> <span>*</span></label>
                                                    <input type="text" name="" class="chp datepicker debut_cagnotte jauge filled" id="datepicker_debut" readonly>
                                                 </div>
                                            </div>
                                            <div class="col col47">
                                                <div class="blc-chp">
                                                     <label><?php _e('Date de fin','kotikota'); ?> <span>*</span></label>
                                                    <input type="text" name="" class="chp datepicker deadline_cagnotte jauge" id="datepicker" readonly>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                            <div class="row">
                                <div class="col col53">
                                    <div class="blc-chp">
                                         <label><?php _e('Objectif de montant à atteindre','kotikota'); ?> <span>*</span> </label>
                                         <select id="estLimite">
                                            <option value="true"><?php _e('Oui','kotikota'); ?></option>
                                            <option value="false"><?php _e('Non','kotikota'); ?></option>
                                        </select>
                                    </div>
                                 </div>
                                 <div class="col col47">
                                     <div class="blc-chp">
                                         <label><?php _e('Fixe un objectif de montant à atteindre','kotikota'); ?> <span>*</span></label>
                                        <input type="text" name="" class="chp montant jauge" id="limite_cagnotte">
                                        <select class="input-select appended-select" id="choix-devise">
                                          <option value="mga">Ar</option>
                                          <!-- <option value="eu">€</option> -->
                                          <!-- <option value="liv">£</option> -->
                                        </select>
                                     </div>
                                </div>
                             </div>
                         </div>
                        <div class="cond-part wow fadeIn" data-wow-delay="1000ms">
                             <label><?php _e('Reste plus qu’à fixer les conditions de participation','kotikota'); ?> <span>*</span></label>
                             <div class="lst-choix-cond-part ">
                                 <div class="item active">
                                    <div class="content custom-control custom-radio ">
                                         <input type="radio" name="participation_cagnotte"  id="montantlibre" class="radio" value="libre">
                                         <label for="montantlibre"> <?php _e('Montant libre','kotikota'); ?> <span></span></label>
                                        <input type="txt" name=""  placeholder="<?= __('chacun donne ce qu’il veut','kotikota'); ?>"  class="chp-txt" readonly="">
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content custom-radio">
                                        <input type="radio" name="participation_cagnotte" id="montantfixe" class="radio"  value="fixe">
                                        <label for="montantfixe"> <?php _e('Même montant pour tous','kotikota'); ?></label>
                                        <input type="text" name="" id="montant_fixe" placeholder="<?= __('chacun donne… ce que tu veux','kotikota'); ?>" class="chp-txt" >
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content custom-radio">
                                        <input type="radio" name="participation_cagnotte"  id="montantconseille" class="radio"  value="conseille"> 
                                        <label for="montantconseille"> <?php _e('Montant (minimum) conseillé','kotikota'); ?> </label>    
                                        <input type="text" name="" id="montant_conseille" placeholder="<?php _e('chacun donne ce qu’il veut…mais tu conseilles un montant','kotikota'); ?>" class="chp-txt">
                                    </div>
                                </div>
                             </div>
                        </div>
                        <div class="blcFormulaire fichier wow fadeIn" data-wow-delay="1000ms">
                            <label> <?php _e('Ajouter votre passeport ou carte identité (à fournir sous 48h )','kotikota'); ?></label>
                            <div class="chp">
                                <div class="cont-file">
                                    <span><?php _e('Aucun fichier sélectionné','kotikota'); ?></span>
                                    <input type="text" name="file[]" class="input-file" id="cin_btn">
                                    <input type="hidden" name="" value="" id="cin_value">
                                    <i> <?php _e('Parcourir','kotikota'); ?></i>
                                    <i class="reset" style="display: none"><?php _e('Supprimer','kotikota'); ?></i>
                                </div>
                                <div class="zone-img-cin"></div>
                            </div>
                        </div>
                        <div class="acc">
                                <div class="chp">
                                  <label><input type="checkbox" name="accord" id="accord"><?php printf( __('En participant à la cagnotte vous acceptez les %s et la %s','kotikota'), '<a href="'.get_site_url( 'cgu' ).'" title="">CGU</a>', '<a href="'. get_site_url('politique-de-confidentialite') .'">'.__('politique de confidentialité','kotikota').'</a>' ) ?>
                                  </label>
                                </div>
                        </div>
                        <ul id="response"></ul>
                        <div class="btn">
                            <a href="<?php echo home_url() ?>" class="link" title="<?php _e('annuler','kotikota'); ?>"><?php _e('annuler','kotikota'); ?></a>
                            <input type="submit" class="link submit" value="<?php _e('créer ma cagnotte','kotikota'); ?>" id="creer-cagnotte">
                        </div>
                     </form>
                 </div>
             </div>
             </div>