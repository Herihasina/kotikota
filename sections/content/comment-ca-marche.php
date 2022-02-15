<div class="comment-ca-marche clr" id="comment-ca-marche">
    <div class="wrapper">
        <div class="cont-left">
            <div class="txt wow fadeInLeft" data-wow-delay="800ms">
                <h2><?php the_field('titre') ?></h2>
            </div>
            <div class="img wow fadeInLeft" data-wow-delay="850ms">
                <img src="<?php the_field('icone') ?>" alt="Commentça marche ?">
            </div>
        </div>
        <div class="cont-right">
            <div class="lst-comment-ca-marche wrapAchat">
                <?php if(have_rows('etapes')): $i = 1; ?>
                <?php while(have_rows('etapes')): the_row(); ?>
                    <div class="item <?php the_sub_field('class_css') ?> wow fadeInRight" data-wow-delay="<?php the_sub_field('delai') ?>ms">
                        <span><?=$i?></span>
                        <div class="content">
                            <h3><a href="#"><?php the_sub_field('titre') ?></a></h3>
                            <p><?php the_sub_field('contenu') ?></p>
                            <div class="icon">
                                <img src="<?php the_sub_field('image') ?>">
                                <?php
                                    $css = '';
                                    switch ($i) {
                                        case '2':
                                           $css = "ico-camion";
                                            break;
                                        case '3':
                                            $css = "ico-hand-take";
                                            break;
                                        case '4':
                                             $css = "ico-hand-cart";
                                            break;
                                        default:
                                             $css = "ico-bluestar";
                                            break;
                                    }
                                ?>
                                <i><img class="<?=$css?>" src="<?php the_sub_field('image') ?>"></i>
                            </div>
                            
                        </div>
                    </div>
                <?php $i++ ?>
                <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>