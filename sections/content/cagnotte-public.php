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
                            $all_posts[count($length)] = $post;
                            //$all_posts[ count($length).'-'.$i] = $post;

                        endwhile;
                        wp_reset_postdata();
                    }
                    $i++;
                }
            endif;

            //ksort($all_posts);
            //print_r($all_posts);
            $sql = 'SELECT SQL_CALC_FOUND_ROWS ID, count_part
                FROM
                (SELECT wp_posts.ID, count_part, "id1" OrderKey
            FROM ((wp_posts
            INNER JOIN wp_postmeta mp3 ON (wp_posts.ID = mp3.post_id))
            INNER JOIN
            (SELECT mp2.post_id,SUBSTRING_INDEX(SUBSTRING_INDEX(meta_value, ":", 2), ":", -1) AS count_part
            FROM wp_postmeta mp2
            WHERE mp2.meta_key = "tous_les_participants") Subquery
            ON (wp_posts.ID = Subquery.post_id))
            INNER JOIN wp_postmeta mp1 ON (wp_posts.ID = mp1.post_id)
            WHERE 1=1
            AND ( (mp1.meta_key = "visibilite_cagnotte" AND mp1.meta_value = "publique")
            AND ( mp3.meta_key = "cagnotte_cloturee" AND mp3.meta_value = "non"))
            AND (wp_posts.post_type IN ("cagnotte", "cagnotte-perso")
            AND (wp_posts.post_status = "publish"))
            GROUP BY wp_posts.ID
            UNION ALL
            SELECT wp_posts.ID, count_part, "id2" OrderKey
            FROM ((wp_posts
            INNER JOIN wp_postmeta mp1 ON (wp_posts.ID = mp1.post_id))
            INNER JOIN wp_postmeta mp3 ON (wp_posts.ID = mp3.post_id))
            INNER JOIN
            (SELECT mp2.post_id,SUBSTRING_INDEX(SUBSTRING_INDEX(meta_value, ":", 2), ":", -1)
                  AS count_part
            FROM wp_postmeta mp2
            WHERE mp2.meta_key = "tous_les_participants") Subquery
            ON (wp_posts.ID = Subquery.post_id)
            WHERE 1=1
            AND ( CONVERT(Subquery.count_part,SIGNED INTEGER) > 0
            AND ( (mp1.meta_key = "visibilite_cagnotte" AND mp1.meta_value = "publique")
            AND ( mp3.meta_key = "cagnotte_cloturee" AND mp3.meta_value = "oui"))
            AND (wp_posts.post_type IN ("cagnotte", "cagnotte-perso")
            AND (wp_posts.post_status = "publish")))
            GROUP BY wp_posts.ID) AS m
                ORDER BY OrderKey, CONVERT(count_part,SIGNED INTEGER) DESC';
            $query_limit = $sql . " LIMIT 6";
            $all_posts = $wpdb->get_results($query_limit);

            //$nbr_elems = count($all_posts);

            //$i=1;
            foreach ( $all_posts as $un_post):
                $id = $un_post->ID;
                $couleur = get_field('couleur', $id);
                $part = get_field('tous_les_participants', $id);
                $objectif = (int)get_field('objectif_montant', $id);
                $limited = get_field('fixer_un_objectif', $id);
                $devise = get_field('devise', $id);
                $azo = (int)get_field('montant_recolte', $id);
                $ilaina = (int)get_field('objectif_montant', $id);
                $closed = get_field('cagnotte_cloturee', $id) == 'oui' ? true : false;
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

                        if (!$ilaina ) $ilaina = 1;

                        $statu = $azo*100/$ilaina;

                        if ( $statu >= 100 && $limited  && $ilaina > 1 ){
                        ?>
                                <span class="ico2">
                                    <img src="<?php echo IMG_URL ?>ok.png">
                                </span>
                        <?php
                            }elseif ( $statu < 100 && $limited ){ ?>
                                <span class="ico-percent">
                                    <div class="percent" style="width:50px;height:50px;">
                                      <p style="display:none;"><?php echo $statu ?>%</p>
                                    </div>
                                </span>

                        <?php
                            }

                            if( $closed ): ?>
                            <span class="ico-percent cloturer">
                                <div class="ckeckCloturer"></div>
                                <span>Clôturée</span>
                            </span>
                        <?php endif; ?>


                    </a>
                     <a href="<?php echo get_the_permalink( $id) ?>" title="<?php echo get_field('nom_de_la_cagnotte',$id) ?>" class="txt">
                        <h3><?php echo get_field('nom_de_la_cagnotte',$id) ?></h3>
                        <p><?php echo wp_strip_all_tags(get_field('description_de_la_cagnote', $id) )?> </p>
                        <div class="objectif">
                            <?php
                                if($objectif > 1) {
                            ?>
                                <div><?php _e('objectif','kotikota'); ?></div>
                                <span><?= number_format($objectif, 0, '.', ' '). ' '. $devise; ?></span>
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
            //if ( $i == 6 ) break;
            //$i++;
            endforeach;
        ?>
        </div>
        <div class="btn">
            <a href="<?php site_url(); ?>/toutes-les-cagnottes" title="<?php _e('découvrir nos cagnottes publiques','kotikota'); ?>" class="link"><?php _e('découvrir nos cagnottes publiques','kotikota'); ?></a>
        </div>

    </div>
</div>
