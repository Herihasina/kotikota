<div class="blc-liste-cagnote wow fadeIn" data-wow-delay="850ms">
    <div class="lst-cagnotte-publique wow fadeIn clr" data-wow-delay="900ms">
    <?php
        //$i=1;

        //foreach ( array_reverse($all_posts['post']) as $un_post):
        foreach ( $all_posts->post as $un_post):
            $id = $un_post->ID;
            $couleur = get_field('couleur',$id);
    ?>
            <div class="item <?php if ($couleur) echo $couleur ?>">
                <div class="content">
                    <a href="<?php echo get_the_permalink( $id) ?>" class="img">
                            <?php
                                $img_url = attachment_url_to_postid(get_field('illustration_pour_la_cagnotte',$id));
                            echo wp_get_attachment_image( $img_url, 'cagnotte-home' );

                            $terms = get_the_terms( $id, 'categ-cagnotte' );

                            if ($terms){
                                foreach ($terms as $term){
                                    $id_parent = $term->parent;
                                    if ( $id_parent != 0 ) {
                                       $t = get_field('picto_sous-categorie', 'categ-cagnotte_'.$term->term_id);
                                       echo '<span class="ico">'.wp_get_attachment_image( $t['picto_etat_normal'], 'cagnotte-picto' ).'</span>';
                                    }
                                }
                            }

                            $limited = get_field('fixer_un_objectif',$id);
                            $azo = (int)get_field('montant_recolte',$id);
                            $ilaina = (int)get_field('objectif_montant',$id);
                            $closed = get_field('cagnotte_cloturee',$id) == 'oui' ? true : false;
                            $devise = get_field('devise',$id);
                            $devise = is_array( $devise ) && array_key_exists('label', $devise) ? $devise['label'] : 'Ar';

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
                    <a href="<?php echo get_the_permalink( $id) ?>" class="txt">
                        <h3><?php echo get_field('nom_de_la_cagnotte',$id) ?></h3>
                        <p><?php
                            $type_cagnotte = get_field('visibilite_cagnotte',$id);
                            echo wp_strip_all_tags( get_field('description_de_la_cagnote',$id) ); ?>
                        </p>
                        <?php
                        if( get_field('fixer_un_objectif',$id) ): ?>
                            <div class="objectif">
                                <?php
                                    if($ilaina > 1) {
                                ?>
                                    <div><?php _e('objectif','kotikota'); ?></div>
                                    <span><?= number_format($ilaina, 0, '.', ' '). ' '. $devise; ?></span>
                                <?php
                                }
                                ?>

                            </div>
                        <?php endif; ?>
                    </a>

                    <div class="compteur">
                        <div class="jour">
                                <span>
                                    <?php echo get_nbr_de_jour_restant( get_field('deadline_cagnoote',$id) ) .' J'; ?>
                                </span>
                            </div>
                        <div class="user">
                             <?php
                                $part = get_field('tous_les_participants',$id);
                                if ( !$part ) $part = [];
                            ?>
                                <span>
                                    <?php
                                        echo count($part);
                                    ?>
                                </span>
                        </div>
                        <div class="amount">
                            <span>
                                <?php
                                    if (get_field('montant_recolte',$id) ){
                                        echo '<span class="format_chiffre">'.get_field('montant_recolte',$id).'</span> '. $devise;
                                    }else{
                                        echo "0 ".$devise;
                                    }
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        //$i++;
        endforeach;
    ?>
    </div>
    <?php
        $uri = $_SERVER['REQUEST_URI'];
        kotikota_pagination($uri);
    ?>
</div>
