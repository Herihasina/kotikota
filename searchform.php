<div class="menu-liste-cagnotte">
  <form class="form-type clr">
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
                                $couleur = is_array( $visu ) && array_key_exists('class_de_cette_categorie', $visu) ? $visu['class_de_cette_categorie'] : '';
                        ?>
                                <a href="<?php echo get_term_link( $enfant, 'categ-cagnotte' ) ?>" title="">
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
                                 </a>
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
<?php echo do_shortcode('[wpdreams_ajaxsearchlite]') ?>