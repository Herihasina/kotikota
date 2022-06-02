<?php
/**
 * Template Name: Accueil
 */
//check browser
global $is_gecko;
global $is_chrome;
global $is_safari;
$popup_notif_class= "";
$popup_notif_image="chrome-trois-points.jpg";
if($is_gecko) $popup_notif_class="firefox";
if($is_chrome) $popup_notif_class="chrome";
if($is_safari) {
    $popup_notif_class="safari";
    $popup_notif_image="safari-share.jpg";
}

get_header(); ?>
    <main id="homepage">
        <?php include 'sections/content/parallax.php'; ?>
        <?php include 'sections/content/comment-ca-marche.php'; ?>
        <?php include 'sections/content/cagnotte-public.php'; ?>
        <?php //include 'sections/content/exemple-cagnotte.php'; ?>
        <?php include 'sections/content/pourquoi-kotikota.php'; ?>        
        <?php include 'sections/content/tarifs.php'; ?>
        <?php include 'sections/content/qui-sommes-nous.php'; ?>
        <?php include 'sections/content/securite-cagnotte.php'; ?>
        <?php include 'sections/content/foire-question.php'; ?>
        <?php include 'sections/content/compteur.php'; ?>
    </main>
    <a href="#popup-notif" class="fancybox hidden_link" data-fancybox=""></a>

     <!--  pop up notif mobile -->
    <?php if(wp_is_mobile()) : ?>
        <div class="popup-notif <?= $popup_notif_class ?>" id="popup-notif" style="display:none" >
            <div class="d-flex">
                <div class="content">
                    <span class="close close-fancy"></span>
                    <span class="logo-pop"><img  src="<?= IMG_URL ?>logo.png"/></span>
                    <div> <?php _e("Ajouter cette application web sur l'ecran d'accueil",'kotikota') ?></div>
                    <div><span><?php _e("Appuyez sur","kotikota") ?></span> <span class="img"><img  src="<?= IMG_URL.$popup_notif_image ?>"/></span></div>
                    <div><?php _e("sélectionnez <b>Ajouter à l'écran d'accueil","kotikota") ?></b></div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- end pop -->
     <!-- safari -->
     <!-- <div class="popup-notif safari" id="popup-notif" style="display:none" >
        <div class="d-flex">
            <div class="content">
                <span class="close close-fancy"></span>
                <span class="logo-pop"><img  src="<?= IMG_URL ?>logo.png"/></span>
                <div> Ajouter cette application web sur l'ecran d'accueil</div>
                <div><span>Appuyez sur</span> <span class="img" ><img src="<?= IMG_URL ?>safari-share.jpg"/></span></div>
                <div>sélectionnez <b>sur l'écran d'accueil</b></div>
            </div>
        </div>
    </div> -->
<?php get_footer(); ?>


 
 