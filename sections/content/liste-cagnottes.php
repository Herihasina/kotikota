<div class="blc-liste-cagnote wow fadeIn" data-wow-delay="850ms">
    <div class="lst-cagnotte-publique wow fadeIn clr" data-wow-delay="900ms">
    <?php
		while (have_posts()){ 
            the_post();
            $couleur = get_field('couleur');
    ?>
            <div class="item <?php if ($couleur) echo $couleur ?>">
                <div class="content">
                    <a href="<?php the_permalink(); ?>" class="img">
                    		<?php
                    			$img_url = attachment_url_to_postid(get_field('illustration_pour_la_cagnotte'));
                        	echo wp_get_attachment_image( $img_url, 'cagnotte-home' );

                        	$terms = get_the_terms( $post->ID, 'categ-cagnotte' );

                        	if ($terms){
                                foreach ($terms as $term){
                                    $id_parent = $term->parent; 
                                    if ( $id_parent != 0 ) { 
                                       $t = get_field('picto_sous-categorie', 'categ-cagnotte_'.$term->term_id);
                                       echo '<span class="ico">'.wp_get_attachment_image( $t['picto_etat_normal'], 'cagnotte-picto' ).'</span>';
                                    }
                                }
                            }
                    	
                            $limited = get_field('fixer_un_objectif');
                            $azo = (int)get_field('montant_recolte');
                            $ilaina = (int)get_field('objectif_montant');
                            $closed = get_field('cagnotte_cloturee') == 'oui' ? true : false;
                            $devise = get_field('devise');
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
                            </span>
                        <?php endif; ?>
                    </a>
                    <a href="<?php the_permalink(); ?>" class="txt">
                        <h3><?php echo get_field('nom_de_la_cagnotte') ?></h3>
                        <p><?php
                            $type_cagnotte = get_field('visibilite_cagnotte');
                            echo wp_strip_all_tags( get_field('description_de_la_cagnote') ); ?>
                        </p>
                        <?php 
                        if( get_field('fixer_un_objectif' ) ): ?>
                            <div class="objectif">
                                <div>objectif</div>
                                <span><?= number_format($ilaina, 0, '.', ' '). ' '. $devise; ?></span>
                            </div>
                        <?php endif; ?>
                    </a>
                    
                    <div class="compteur">
                        <div class="jour">
                                <span>
                                    <?php echo get_nbr_de_jour_restant( get_field('deadline_cagnoote' ) ) .' J'; ?>
                                </span>
                            </div>
                        <div class="user">
                             <?php 
                                $part = get_field('tous_les_participants');                            
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
                                if ( 
                                    $type_cagnotte == 'publique' || 
                                    get_field('titulaire_de_la_cagnotte')  == get_current_user_id() || 
                                    current_user_can('administrator') ){
                                    if( get_field('montant_recolte') ){ 
                                        echo '<span class="format_chiffre">'.get_field('montant_recolte').'</span> '.$devise;
                                    }else{
                                        echo "0 ". $devise;
                                    }
                                }else{
                                    echo '--';
                                } 
                            ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
    <?php 
        } 
    ?>
    </div>
    <?php
    	$uri = $_SERVER['REQUEST_URI'];
    	kotikota_pagination($uri);
    ?>            
</div>
