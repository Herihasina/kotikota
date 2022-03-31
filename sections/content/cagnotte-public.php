<div class="cagnotte-publique">
    <div class="wrapper">
        <h2 class="wow fadeInUp" data-wow-delay="900ms"><?php _e('Toutes nos cagnottes','kotikota'); ?></h2>
        <div class="lst-cagnotte-publique wow fadeIn" data-wow-delay="900ms" id="cagnotte-publique">
        <?php
            $all_posts = [];
            $args = array(
                'post_type' => array('cagnotte','cagnotte-perso'),
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key' => 'visibilite_cagnotte',
                        'value' => 'publique',
                    ),
                )
            );

            //alaina daholo ny terms rehetra zay tsy manana zanaka == zanaka
            $terms = get_terms('categ-cagnotte', array(
                'hide_empty' => false,
                'childless' => true
                ));

            if ($terms): // d filtréna oe iza no tsy parent => ny enfant ihany no ilaina
                $i = 0;
                foreach ($terms as $term){
                    $args['posts_per_page'] = 1;
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'categ-cagnotte',
                            'field' => 'term_id',
                            'terms' => $term->term_id
                            )
                        );

                    $loop = new WP_Query( $args );

                    if ( $loop->have_posts() ){
                        while ( $loop->have_posts() ) : $loop->the_post();
                            $length = get_field('tous_les_participants');
                            if ( !$length ) $length = [];
                            $all_posts[ count($length).'-'.$i] = $post;

                        endwhile;
                        wp_reset_postdata();
                    }
                    $i++;
                }
            endif;

            ksort($all_posts);
            $nbr_elems = count($all_posts);

            $i=1;
            foreach ( array_reverse($all_posts) as $un_post):
                $id = $un_post->ID;
                $couleur = get_field('couleur', $id);
                $part = get_field('tous_les_participants', $id);
                $objectif = (int)get_field('objectif_montant', $id);
                $limited = get_field('fixer_un_objectif', $id);
                $devise = get_field('devise', $id);
                $devise = is_array( $devise ) && array_key_exists('label', $devise) ? $devise['label'] : 'Ar';

                if (!$objectif ) $objectif = 1;

                if ( !$part) $part = [];
        ?>
            <div class="item<?php if ($couleur) echo ' '.$couleur ?>">
                <div class="content">
                    <a href="<?php echo get_the_permalink( $id) ?>" title="<?php echo get_the_title( $id ) ?>" class="img">
                    <?php
                        $img_url = attachment_url_to_postid(get_field('illustration_pour_la_cagnotte', $id));
                        echo wp_get_attachment_image( $img_url, 'cagnotte-home' );

                        $terms = get_the_terms( $id, 'categ-cagnotte' );

                        foreach ($terms as $term){
                            $id_parent = $term->parent;
                            if ( $id_parent != 0 ) {
                               $t = get_field('picto_sous-categorie', 'categ-cagnotte_'.$term->term_id);
                               echo '<span class="ico">'.wp_get_attachment_image( $t['picto_etat_normal'], 'cagnotte-picto' ).'</span>';
                            }
                        }
                    ?>
                    </a>
                     <a href="<?php echo get_the_permalink( $id) ?>" title="<?php echo get_field('nom_de_la_cagnotte',$id) ?>" class="txt">
                        <h3><?php echo get_field('nom_de_la_cagnotte',$id) ?></h3>
                        <p><?php echo wp_strip_all_tags(get_field('description_de_la_cagnote', $id) )?> </p>
                        <div class="objectif">
                            <div><?php _e('objectif','kotikota'); ?></div>
                            <?php
                                if($objectif > 1) {
                            ?>
                            <span><?= number_format($objectif, 0, '.', ' '). ' '. $devise; ?></span>
                            <?php
                                } else {
                            ?>
                                <span><?php _e('pas d\'objectif','kotikota'); ?></span>
                            <?php
                                }
                            ?>
                        </div>
                    </a>
                    <div class="compteur">
                        <div class="jour">
                            <span>
                                <?php echo get_nbr_de_jour_restant( get_field('deadline_cagnoote', $id) ) .' J'; ?>
                            </span>
                        </div>
                        <div class="user">
                            <span><?php echo count($part);?></span>
                        </div>
                        <?php
                            $type_cagnotte = get_field('visibilite_cagnotte', $id);
                            $devise = get_field('devise', $id);
                            $devise = is_array( $devise ) && array_key_exists('label', $devise) ? $devise['label'] : $devise[0];
                        ?>
                                <div class="amount">
                                    <span>
                                        <?php
                                            if (get_field('montant_recolte', $id) ){
                                                echo '<span class="format_chiffre">'.get_field('montant_recolte', $id).'</span> '. $devise;
                                            }else{
                                                echo "0 ".$devise;
                                            }
                                        ?>
                                    </span>
                                </div>
                    </div>
                </div>
            </div> <!-- div item -->
        <?php
            if ( $i == 6 ) break;
            $i++;
            endforeach;
        ?>
        </div>
        <div class="btn">
            <a href="<?php site_url(); ?>/toutes-les-cagnottes" title="<?php _e('découvrir nos cagnottes publiques','kotikota'); ?>" class="link"><?php _e('découvrir nos cagnottes publiques','kotikota'); ?></a>
        </div>

    </div>
</div>
