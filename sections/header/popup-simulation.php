
<div class="pop-up-simulation" id="simulation" style="display: none;">
    <div class="simulation-pp">
        <div class="titre">
            <h2>Réalisez une simulation</h2><?php the_sub_field('contenu') ?>
        </div>
        <div class="content">
            <div class="chp-check">
                <!-- <label for="cagnotte">Cagnotte attendue </label>
                <input type="text" name="cagnotte"> -->
                <div class="label clr">
                    <span>Cagnotte attendue</span>
                    <span>Somme perçue</span>
                </div>
                <div class="switch">
                    <div class="col active">
                        <div class="chp chpLeft">
                            <input type="txt" class="switch-input" placeholder="500 000" id="input-attendue">
                            <select class="input-select appended-select select-tarif" id="choix-devise-attendue">
                              <option value="mga">Ar</option>
                              <option value="eu">€</option>
                              <option value="liv">£</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="chp chpRight">
                            <input type="txt" class="switch-input" placeholder="489 000" id="input-percue" disabled>
                            <select class="input-select appended-select select-tarif" id="choix-devise-percue">
                              <option value="mga">Ar</option>
                              <option value="eu">€</option>
                              <option value="liv">£</option>
                            </select>                        
                        </div>                        
                    </div>
                    <input type="hidden" name="" id="change-mga-eu" value="<?php echo get_field('change_mga_eu','options'); ?>">
                    <input type="hidden" name="" id="change-mga-us" value="<?php echo get_field('change_mga_liv','options'); ?>">
                    <input type="hidden" name="" id="change-us-eu" value="<?php echo get_field('change_eu_liv','options'); ?>">
                </div>
            </div>
        </div>
        <?php 
            if(have_rows('section_tarifs')){
                while(have_rows('section_tarifs')){
                    the_row();

                    if(have_rows('presentation')){
                        while(have_rows('presentation')){
                            the_row();
                            if(have_rows('element_droite')){
                                while(have_rows('element_droite')){
                                    the_row();                            
        ?>
        <div class="txt-bottom">
            <a href="<?php the_sub_field('pdf_detail_frais') ?>" target="_blank" title="Voir détails des frais">Voir détails des frais</a>
        </div>
    <?php
                                }
                            }

                        }
                    }
                }
            }
    ?>
    </div>
</div>