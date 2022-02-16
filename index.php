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
        <?php include 'sections/content/foire-question.php'; ?>
        <?php include 'sections/content/compteur.php'; ?>
    </main>
<?php get_footer(); ?>