 <?php
    $banniere = get_field('banniere');

    if ($banniere) :
        $images = $banniere['banniere_image'];
        $video = $banniere['video_vignette']['lien_video'];
        $vignette = $banniere['video_vignette']['vignette'];
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

                                            <a href="<?php the_sub_field('lien_bouton_3') ?>" class="link" title="<?php the_sub_field('bouton_3') ?>"><?php the_sub_field('bouton_3') ?></a>


                                        </div>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </div>

                        </div>
                        <div class="blc-video">
                            <a class="cont-video fancybox" id="play-pop-up-video-home" data-fancybox href="https://www.youtube.com/watch?v=<?= $video ?>&autoplay=1&rel=0&loop=1&showinfo=0&playlist=<?= $video ?>">
                                <div>
                                    <i class="ico"></i>
                                    <img src="<?= $vignette ?>" alt="Kotikota">
                                </div>
                                <span><?php _e('Cliquez pour lire la vidéo','kotikota') ?></span>
                            </a>
                            <div class="social">
                                <div>
                                    <a href="<?= get_theme_mod('sn_fb_setting') ?>" class="fb" target="_blank"></a>
                                    <a href="<?= get_theme_mod('sn_insta_setting') ?>" class="insta" target="_blank"></a>
                                    <a href="<?= get_theme_mod('sn_tweet_setting') ?>" class="twitter" target="_blank"></a>
                                    <a href="<?= get_theme_mod('sn_yt_setting') ?>" class="youtube" target="_blank"></a>
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
