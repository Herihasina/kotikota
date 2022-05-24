<?php
/**
 * Template Name: Accueil
 */

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

     <!--  chrome & firefox -->
    <!-- <div class="popup-notif chrome" id="popup-notif" style="display:none" >
        <div class="d-flex">
            <div class="content">
                <div> Ajouter cette application web sur l'ecran d'accueil</div>
                <div><span>Appuyez sur</span> <span class="img"><img  src="<?= IMG_URL ?>chrome-trois-points.jpg"/></span></div>
                <div>sélectionnez <b>Ajouter à l'écran d'accueil</b></div>
            </div>
        </div>
    </div> -->
     <!-- safari -->
     <div class="popup-notif safari" id="popup-notif" style="display:none" >
        <div class="d-flex">
            <div class="content">
                <div> Ajouter cette application web sur l'ecran d'accueil</div>
                <div><span>Appuyez sur</span> <span class="img" ><img src="<?= IMG_URL ?>safari-share.jpg"/></span></div>
                <div>sélectionnez <b>sur l'écran d'accueil</b></div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>


 
 