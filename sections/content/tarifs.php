<div class="tarifs clr">

    <?php if(have_rows('section_tarifs')){
        while(have_rows('section_tarifs')){
            the_row(); ?>

        <h2 class="wow fadeInUp" data-wow-delay="900ms"><?php the_sub_field('titre') ?></h2>
        <div class="lst-tarifs clr">

            <?php if(have_rows('presentation')){
                while(have_rows('presentation')){
                the_row(); ?>

            <div class="item clr">
                <div class="cont-left">
                    <div class="col ">
                        <?php if(have_rows('element_gauche')){
                            while(have_rows('element_gauche')){
                            the_row(); ?>

                            <div class="content wow fadeInLeft" data-wow-delay="<?php the_sub_field('delai') ?>ms">
                                <div class="picto"><img src="<?php the_sub_field('image') ?>"></div>
                                <div class="txt">
                                    <h4>
                                        <?php 
                                            $titre = get_sub_field('titre');
                                            $titre = preg_replace('/\_.*\_/', '<span>$0</span>', $titre);
                                            echo str_replace('_', '', $titre) ;
                                        ?>
                                    </h4>
                                    <div class="<?php the_sub_field('gratuite') ?>"><?php the_sub_field('gratuite') ?></div>
                                    <div class="info">*<?php _e('hors frais opérateurs','kotikota'); ?>  </div>
                                </div>
                            </div>


                        <?php }} ?>
                    </div>
                </div>
                <div class="cont-right">

                    <?php if(have_rows('element_droite')){
                        while(have_rows('element_droite')){
                        the_row(); ?>

                        <div class="content wow fadeInRight" data-wow-delay="<?php the_sub_field('delai') ?>ms">
                            <div class="txt titre1">
                                <h3><?php the_sub_field('titre') ?></h3>
                                <p><?php the_sub_field('contenu') ?></p>
                                <!-- <a href="#simulation" class="link fancybox" title="<?php the_sub_field('bouton_simulation') ?>" data-fancybox><?php the_sub_field('bouton_simulation') ?></a> -->
                            </div>
                        </div>
                    
                    <?php }} ?>

                </div>
            </div>

            <?php }} ?>

            <?php if(have_rows('mode_de_paiement')){
                while(have_rows('mode_de_paiement')){
                the_row(); ?>

            <div class="item clr">
                <div class="cont-left">

                    <?php if(have_rows('element_gauche')){
                        while(have_rows('element_gauche')){
                        the_row(); ?>

                    <div class="content mode-paiement wow fadeInLeft" data-wow-delay="<?php the_sub_field('delai') ?>ms">
                        <div class="txt titre2">
                            <h3><?php the_sub_field('titre') ?></h3>
                            <p><?php the_sub_field('contenu') ?></p>
                        </div>
                    </div>

                    <?php }} ?>

                </div>
                <div class="cont-right">

                    <?php if(have_rows('element_droite')){
                        while(have_rows('element_droite')){
                        the_row(); ?>

                        <div class="col payement ">
                            <div class="lst-payement wow fadeInRight" data-wow-delay="<?php the_sub_field('delai') ?>ms">
                                <ul>

                                    <?php $partenaires = get_sub_field('partenaires'); ?>
                                    <?php 
                                        $i = 1;
                                        foreach($partenaires as $p){ ?>

                                            <li><img src="<?=$p['url']?>"></li>

                                            <?php
                                            $i++;
                                            if( ($i%4 == 0) || ($i%6 == 0) ){ ?>

                                                <li class="clr"></li>

                                            <?php 
                                            }                             
                                        } 
                                    ?>
                                </ul>
                            </div>

                        </div>

                    <?php }} ?>

                </div>
            </div>

            <?php }} ?>

        </div>

    <?php }} ?>
</div>