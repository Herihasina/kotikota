<div class="blc-img">
    <?php
      $img_url = attachment_url_to_postid(get_field('illustration_pour_la_cagnotte'));
      if ( $img_url )
        //echo wp_get_attachment_image( $img_url, 'banniere-single' );
      ?>
        <img class="attachment-banniere-single size-banniere-single" src="<?= $img_url ?>">
      <?php
        $limited = get_field('fixer_un_objectif');
        $azo = (int)get_field('montant_recolte');
        $ilaina = (int)get_field('objectif_montant');
        $closed = get_field('cagnotte_cloturee') == 'oui' ? true : false;

        if (!$ilaina ) $ilaina = 1;

        $statu = $azo*100/$ilaina;

        if ( $statu >= 100 && $limited && $ilaina > 1 ){
    ?>
          <span class="ico-percent percent-ok">
            <img src="<?php echo IMG_URL ?>ok.png">
          </span>
    <?php
        }elseif ( $statu < 100 && $limited ){ ?>
          <span class="ico-percent">
              <div class="percent" style="width:45px;height:45px;">
                <p style="display:none;"><?php echo $statu ?>%</p>
              </div>
          </span>
    <?php } ?>
    <?php if( $closed ): ?>
        <span class="ico-percent cloturer">
          <div class="ckeckCloturer"></div>
        </span>
        <span class="blocCloture">
          <?= __('Cette cagnotte est clôturée','kotikota') ?>
        </span>
    <?php endif; ?></div>


