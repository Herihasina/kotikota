<div class="blc-apropos" id="apropos">
    <div class="wrapper">
        <?php if(have_rows('section_pourquoi')): ?>
            <?php while(have_rows('section_pourquoi')): the_row(); ?>
                <!-- <h2 class="wow fadeInUp" data-wow-delay="900ms"><?php the_sub_field('titre') ?>
                    <span><?php the_sub_field('sous_titre') ?></span>
                </h2> -->
                <div class="lst-apropos clr">
                    <div class="col-left">
                        <?php if(have_rows('element_gauche')): ?>
                            <?php while(have_rows('element_gauche')): the_row(); ?>
                                <div class="item gain clr wow fadeInLeft" data-wow-delay="<?php the_sub_field('delai') ?>ms">
                                    <div class="content">
                                        <div class="img"><img src="<?php the_sub_field('image_element') ?>"></div>
                                        <div class="txt">
                                            <h3><?php the_sub_field('titre_element') ?></h3>
                                            <p><?php the_sub_field('contenu_element') ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-right">
                        <?php if(have_rows('element_droite')): ?>
                            <?php while(have_rows('element_droite')): the_row(); ?>
                                <div class="item gain clr wow fadeInRight" data-wow-delay="<?php the_sub_field('delai') ?>ms">
                                    <div class="content">
                                        <div class="img"><img src="<?php the_sub_field('image_element') ?>"></div>
                                        <div class="txt">
                                            <h3><?php the_sub_field('titre_element') ?></h3>
                                            <p><?php the_sub_field('contenu_element') ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>