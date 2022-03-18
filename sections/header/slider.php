<?php if(is_front_page()): ?>

    <div class="slider" id="slider">
        <?php
            // $jour = date('d');
            // $jour_dans_le_mois = cal_days_in_month(CAL_GREGORIAN, date('m'), date('y'));

            /* slider/image alternés par jour
            * pour les mois de 30j ou février => 1er slider, 2 video
            * pour les mois de 31j => 1er video, 2 slider
            */
            // if ( $jour_dans_le_mois == 31 ){
                // if ( $jour % 2 != 0 ){
                    // include 'slider-video.php';
                // }else{
                     include 'slider-image.php';
                // }
            // }else{
                // if ( $jour % 2 == 0 ){
                //     include 'slider-image.php';
                // }else{
                //      include 'slider-video.php';
                // }
            // }
        ?>



    </div>

<?php else: ?>

    <div class="banner-page cagnotte">
        <?php
            $bg = get_field('image_banniere');
            if ( is_single() || is_tax() ){
                    $terms = get_the_terms($post->ID, 'categ-cagnotte');
                    $souscateg = $terms[1];
                    $bg = get_field('image_banniere', 'categ-cagnotte_'.$souscateg->term_id);
            }elseif( is_search() || is_tax() ){
                $bg = get_field('banniere_image','option');
            }elseif ( basename(get_page_template()) == 'page-participer_cagnotte.php' ){
                $terms = get_the_terms($_GET['part'], 'categ-cagnotte');
                $souscateg = $terms[1];
                $bg = get_field('image_banniere', 'categ-cagnotte_'.$souscateg->term_id);
            }
            $bg = wp_get_attachment_image_src( $bg, 'banniere' )[0];

        ?>
        <div class="banner-inner"
            <?php
                if ($bg) : ?> style="background: center / cover no-repeat url('<?php echo $bg ?>);" <?php endif;

            ?>
        >
            <div class="titre">
                <h1>
                    <?php
                    if (is_single() ):
                        echo __('Détails de la cagnotte', 'kotikota');
                    elseif ( basename(get_page_template()) == 'page-creer_cagnotte.php'):
                        echo __('Créer une cagnotte', 'kotikota');
                    elseif ( basename(get_page_template()) == 'page.php'):
                        // echo __('Créer une cagnotte', 'kotikota');
                     elseif ( basename(get_page_template()) == 'page-lister_cagnotte.php'):
                        echo __('Toutes nos cagnottes', 'kotikota');
                    elseif ( basename(get_page_template()) == 'page-lister_mes_cagnotte.php'):
                        echo __('Toutes mes cagnottes', 'kotikota');
                    elseif ( basename(get_page_template()) == 'page-lister_mes_participations.php'):
                        echo __('Toutes mes participations', 'kotikota');
                    elseif ( basename(get_page_template()) == 'page-participer_cagnotte.php'):
                        $id = $_GET['part'];
                        $terms = get_the_terms($id, 'categ-cagnotte');
                        echo __('<span>Participer à la cagnotte : </span>', 'kotikota'). $terms[1]->name;
                    elseif ( basename(get_page_template()) == 'page-gestion_cagnotte.php'):
                        echo __('Invitez vos participants', 'kotikota');
                    elseif (  preg_match('/^\/parametre/', $_SERVER['REQUEST_URI']) || preg_match('/^\/mg\/parametre/', $_SERVER['REQUEST_URI']) ):
                        echo __('Je paramètre ma cagnotte', 'kotikota');
                     elseif (  preg_match('/^\/mon-profil/', $_SERVER['REQUEST_URI']) || preg_match('/^\/mg\/mon-profil/', $_SERVER['REQUEST_URI']) ):
                        echo __('J\'édite mon profil', 'kotikota');
                     elseif ( is_search() ):
                        echo __('Toutes nos cagnottes', 'kotikota');
                    elseif ( is_tax() ):
                        echo __('Toutes nos cagnottes : ', 'kotikota').get_queried_object()->name;
                    elseif (  is_page('gestion-cagnotte-participant') ):
                        echo __('Gérez vos participants', 'kotikota');
                    elseif (  is_page('gestion-cagnotte-invite') ):
                        echo __('Invitez vos participants', 'kotikota');
                    elseif (  is_page('gestion-cagnotte-mot-doux') ):
                        echo __('Mes messages', 'kotikota');
                    elseif ( is_page('don') ):
                        echo __('Paiement en cours', 'kotikota');
                    elseif ( is_page('paiement-orange-money' )):
                        echo __('Don par Mobile money','kotikota');
                    elseif ( is_page('virement-bancaire' )):
                        echo __('Don par virement bancaire','kotikota');
                    elseif ( is_page('paiement-airtel-money' )):
                        echo __('Don par Airtel Money','kotikota');
                    elseif ( is_page( array('payment-accepted','succes-paiement') ) ):
                        echo __('Don effectué :)', 'kotikota');
                    else:
                        echo "Erreur 404";
                    endif;
                    ?>
                </h1>
            </div>
        </div>
    </div>

<?php endif; ?>