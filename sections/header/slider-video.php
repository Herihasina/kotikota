<?php
    $banniere = get_field('banniere');

    if ($banniere) :
        $video = $banniere['banniere_video'];
?>
    <!-- video -->
    <div class="banner">
        <div class="banner-video">
            <?php if(have_rows('banniere')): ?>
                <?php while(have_rows('banniere')): the_row(); ?>
                    <video playsinline autoplay="true" loop="true" muted="muted" controls>
                        <source type="video/mp4" src="<?php echo $video; ?>">
                    </video>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
        <div class="wrapper">
            <div class="txt-banner">
                <?php if(have_rows('texte')): ?>
                    <?php while(have_rows('texte')): the_row(); ?>
                        <h2 class="wow fadeInLeft" data-wow-delay="800ms">
                            <?php the_sub_field('titre_header') ?>
                        </h2>
                        <div class="btn-banner wow fadeInUp" data-wow-delay="1000ms">
                            <a href="#popup-apropos" class="link fancybox" title="<?php the_sub_field('bouton_1') ?>" data-fancybox><?php the_sub_field('bouton_1') ?></a><br>
                            <?php if ( is_user_logged_in() ): ?>
                                <a href="<?php echo get_permalink( get_page_by_path( 'creer-cagnotte' ) ) ?>" class="link" title="<?php the_sub_field('bouton_2') ?>"><?php the_sub_field('bouton_2') ?></a>
                            <?php else: ?>
                                <a href="#connecter" class="link fancybox" title="<?php the_sub_field('bouton_2') ?>"><?php the_sub_field('bouton_2') ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- /video -->
<?php endif; ?>