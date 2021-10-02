<div class="exemple-cagnotte" id="cagnotte-en-ligne">
    <div class="wrapper">
        <?php if(have_rows('section_exemple')): ?>
            <?php while(have_rows('section_exemple')): the_row(); ?>

            <h2 class="wow fadeInUp" data-wow-delay="900ms"><?php the_sub_field('titre') ?></h2>
            <div class="lst-cagnotte wow fadeIn" data-wow-delay="950ms" id="lst-cagnotte">

                <?php if(have_rows('elements')): ?>
                    <?php while(have_rows('elements')): the_row(); ?>
                        <div class="item wow fadeInUp" data-wow-delay="950ms">
                            <div class="content">
                                <div class="img"><img src="<?php the_sub_field('image_element') ?>" alt="<?php the_sub_field('titre_element') ?>"></div>
                                <h3><?php the_sub_field('titre_element') ?></h3>
                                <p><?php the_sub_field('description_element') ?></p>
                            </div>
                        </div>        
                    <?php endwhile; ?>
                <?php endif; ?>

            </div>
            <a href="<?php echo get_permalink( get_page_by_path( 'creer-cagnotte' ) ); ?>" class="link" title="<?php the_sub_field('bouton_cagnotte') ?>"><?php the_sub_field('bouton_cagnotte') ?></a>

            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>