<div class="pop-up-apropos " id="popup-apropos" style="display: none;">
    <div class="apropos-pp">
        <div class="content">
            <a href="#" class="logo-pp"><img src="<?= IMG_URL ?>logo.png" title="Kotikota"></a>
            <?php if(have_rows('element_a_propos')): ?>
                <?php while(have_rows('element_a_propos')): the_row(); ?>
                <h2><?php the_sub_field('grand_titre') ?></h2>
                <h3><?php the_sub_field('sous_titre') ?></h3>
                <p><?php the_sub_field('contenu') ?></p>
                <div class="wrap-categorie">
                      <div class="form-type clr">
                      <div class="lst-form-type clr">
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
                                                        $couleur = $visu['class_de_cette_categorie'];
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
                        </div>
                </div>
                <div class="btn">
                    <a href="#connecter" id="go-connected" class="link" title="<?php the_sub_field('bouton_1') ?>"><?php the_sub_field('bouton_1') ?></a>
                    <a href="mailto:hello@koti-kota.com" class="link" title="<?php the_sub_field('bouton_2') ?>"><?php the_sub_field('bouton_2') ?></a>
                </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>