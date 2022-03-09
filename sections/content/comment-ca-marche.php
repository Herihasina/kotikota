<?php
                    // Avoir le dernier cagnottes du kotikoteur
                    if ( is_user_logged_in() ) {
                        $args = array(
                            'post_type' => array('cagnotte','cagnotte-perso'),
                            'post_status' => 'publish',
                            'posts_per_page' => 1,
                            'orderby' => 'ID',
                            'order' => 'DESC',
                            'meta_query' => array(
                                array(
                                    'key' => 'titulaire_de_la_cagnotte',
                                    'value' => get_current_user_id(),

                                )
                            )
                        );

                        $q = new WP_Query( $args );
                        while( $q->have_posts() ) {
                                $q->the_post();
                                //$ca_id = get_the_ID();
                                $url_invite = 'https://koti-kota.com/gestion-cagnotte-invite/?gest='. get_the_ID();
                                $url_class_invite = '';
                        }
                        wp_reset_postdata();
                    } else {
                        $url_invite = '#connecter';
                        $url_class_invite = 'class="link fancybox-home"';
                    }                    

?>

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
                            <h3>                               
                                <?php if ( $i == 2 ): ?>
                                    <a href="<?= $url_invite ?>" class="<?= $url_class_invite ?>"><?php the_sub_field('titre') ?></a>
                                <?php else: ?>
                                    <a href="<?php the_sub_field('lien') ?>"><?php the_sub_field('titre') ?></a>
                                <?php endif; ?>
                                
                            </h3>
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
                                <i><a href="<?php the_sub_field('lien') ?>"><img class="<?=$css?>" src="<?php the_sub_field('image') ?>"></a></i>
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
