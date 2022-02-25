 <?php
    $banniere = get_field('banniere');

    if ($banniere) :
        $images = $banniere['banniere_image'];
        if( is_array( $images )):
            foreach ( $images as $img ){
     ?>
                 <!-- image slider -->
                <div class="banner" style="background: url(<?php echo $img['image']; ?>) 50% no-repeat; background-size: cover">
                        <div class="wrapper">
                            <div class="txt-banner">
                                <?php if(have_rows('texte')): ?>
                                    <?php while(have_rows('texte')): the_row(); ?>
                                        <h2 class="wow fadeInLeft" data-wow-delay="800ms">
                                            <?php the_sub_field('titre_header') ?>
                                        </h2>
                                        <div class="btn-banner wow fadeIn" data-wow-delay="1000ms">
                                            <a href="#popup-apropos" class="link fancybox" title="<?php the_sub_field('bouton_1') ?>" data-fancybox><?php the_sub_field('bouton_1') ?></a>
                                             <?php if ( is_user_logged_in() ): ?>
                                                <a href="<?php echo get_permalink( get_page_by_path( 'creer-cagnotte' ) ) ?>" class="link" title="<?php the_sub_field('bouton_2') ?>"><?php the_sub_field('bouton_2') ?></a>
                                            <?php else: ?>
                                                <a href="#connecter" class="link fancybox" title="<?php the_sub_field('bouton_2') ?>"><?php the_sub_field('bouton_2') ?></a>
                                            <?php endif; ?>

                                            <a href="<?php the_sub_field('lien_bouton_2') ?>" class="link" title="<?php the_sub_field('bouton_2') ?>"><?php the_sub_field('bouton_2') ?></a>


                                        </div>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </div>

                        </div>  
                        <div class="blc-video">
                            <a href="#pp-video" class="cont-video fancybox">
                                <div>
                                    <i class="ico"></i>
                                    <img src="<?= IMG_URL ?>img-video.jpg" alt="Kotikota">
                                </div>
                                <span>Cliquez pour lire la vidéo</span>
                            </a>
                            <div class="pp-video" id="pp-video" style="display:none">
                                <div class="content">
                                     <div class="modal-body">
                                        <iframe width="870" height="489" src="https://www.youtube.com/embed/SvuoDerqNW0" frameborder="0" allowfullscreen=""></iframe></div>
                                </div>
                            </div>
                        </div>   
                 </div>
                <!-- /image slider -->
<?php 
             }
         endif;
endif;
?>
