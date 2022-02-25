

<div class="qui-sommes-nous" id="qui-sommes-nous" >
    <div class="wrapper">
        <h2 class="wow fadeInUp" data-wow-delay="900ms" style="visibility: visible; animation-delay: 900ms; animation-name: fadeInUp;"><?= get_field('qui_sommes_nous_titre') ?></h2>
        <div class="txt">
            <p><?= get_field('qui_sommes_nous_texte') ?></p>
        </div>
        <div class="slide-qui-sommes-nous" id="slide-qsn">
            <?php
                $slide_images = get_field('qui_sommes_nous_images');

                if ($slide_images) :                
                if( is_array( $slide_images )):
                foreach ( $slide_images as $slide_image ){
            ?>
            <div class="item">
                <div class="img">
                    <img src="<?= $slide_image['qui_sommes_nous_image'] ?>" alt="Kotikota">
                </div>
            </div>            
            <?php } ?>
            <?php endif; endif; ?>
        </div>
     
    </div>
</div>
