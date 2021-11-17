        <footer id="footer" <?php if ( is_home() ) echo("class='page'"); ?>>
            <div class="footer">
                <div class="wrapper clr">
                    <div class="footer-1">
                        <a href="<?php echo get_site_url() ?>" class="logo-f" title="Kotikota">
                            <img src="<?= IMG_URL ?>logo.png" alt="Kotikota">
                        </a>
                    </div>
                    <div class="footer-2">
                        <div class="col">
                            <div class="adresse">
                                <div class="titre"><?= __('Où nous trouver ?','kotikota') ?></div>
                                <?= get_theme_mod('ct_address') ?>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mail">
                                <div class="titre"><?= __('nous écrire à','kotikota') ?></div>
                                <?= get_theme_mod('ct_email') ?>
                            </div>
                        </div>
                    </div>
                    <div class="footer-3">
                        <div class="col">
                            <div class="tel">
                                <div class="titre"><?= __('Téléphone','kotikota') ?></div>
                                <?= get_theme_mod('ct_phone') ?>
                            </div>
                            <div class="Whatsapp">
                                <div class="titre">Whatsapp</div>
                                <?= get_theme_mod('ct_whatsapp') ?>
                            </div>
                        </div>
                    </div>
                    <div class="social">
                        <a href="<?= get_theme_mod('sn_fb_setting') ?>" class="fb" target="_blank"></a>
                        <a href="<?= get_theme_mod('sn_insta_setting') ?>" class="insta" target="_blank"></a>
                        <a href="<?= get_theme_mod('sn_tweet_setting') ?>" class="twitter" target="_blank"></a>
                        <a href="<?= get_theme_mod('sn_yt_setting') ?>" class="youtube" target="_blank"></a>
                    </div>
                </div>
                <div class="blcBottom clr">
                    <div class="wrapper">
                        <div class="blcMention">
                            &copy; Koti Kota <?= date('Y') ?> 
                            <a href="<?php echo get_permalink( get_page_by_path('cgu') ) ?>" title="CGU" target="_blank"> <?= __('CGU','kotikota') ?> </a> 
                            <a href="<?php echo get_permalink( get_page_by_path('politique-de-confidentialite') ) ?>" title="<?= __('Politique de confidentialité','kotikota') ?>" target="_blank"> <?= __('Politique de confidentialité','kotikota') ?> </a> 
                            <a href="<?php echo get_permalink( get_page_by_path('mentions-legales') ) ?>" title="<?= __('Mentions légales','kotikota') ?>" target="_blank"> <?= __('Mentions légales','kotikota') ?> </a> 
                            <a href="<?php echo site_url() ?>/sitemap" target="_blank" title="<?= __('Site map','kotikota') ?>"> <?= __('Site map','kotikota') ?> </a>
                        </div>

                        <div class="blcMaki">
                            <?php 
                                printf(__("Réalisé avec %s par %s & Propulsé %s par %s", 'kotikota'), 
                                    '<img src="'.IMG_URL.'icon-coeur.png" alt="">',
                                    '<a href="http://maki-agency.mg/" title="Réalisé par Maki Agency" target="_blank">Maki Agency</a>',
                                    '<img src="'.IMG_URL.'fuser.png" alt="">',
                                    '<a href="https://www.linkedin.com/company/sakalava-capital/?viewAsMember=true" target="_blank"><b>Sakalava Capital</b></a>'); 
                            ?>
                        </div>
                    </div>
                    <a href="header" class="scrooltop scroll"></a>
                </div>
            </div>
        </footer>

    </div>
    
    <a href="#popup_conf" id="open_conf" class="fancybox_conf" data-fancybox="" title="" style="display: none;">X</a>
    <div id="popup_conf" style="display: none">
        <div class="content">
            <div class="conf_titre"><?= __('Bravo','kotikota') ?></div>
            <div class="conf_text">Lorem ipsum sit amet dolor lorem ipusm sit amet dolor lorem ipsum sit met lorem ipsum</div>
        </div>
    </div>
    <?php wp_footer(); ?>

</body>
</html>

