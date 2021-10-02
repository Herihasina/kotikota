
<div class="blc-compteur">
    <div class="wrapper">
        <div class="compteur">
            <div class="blcChiffre clr" id="slide-chiffre">
                <div class="item item1">
                    <div class="nombre counter">
                        <?php 
                            $cagnottes = query_posts( array(
                                'post_type' => array('cagnotte','cagnotte-perso'),
                                'post_status' => 'publish',
                                'posts_per_page' => -1,
                            ));
                            echo count($cagnottes);
                            wp_reset_postdata();
                        ?>
                    </div>
                    <div class="title"><?php _e('cagnottes','kotikota'); ?></div>
                </div>
                <div class="item item2">
                <?php 
                            $participants = query_posts( array(
                                'post_type' => 'participant',
                                'post_status' => 'any',
                                'posts_per_page' => -1,
                            )); 
                            wp_reset_postdata();
                        ?>
                    <div class="nombre counter">
                        <?php echo count($participants); ?>
                    </div>
                    <div class="title"><?php _e('participants','kotikota'); ?></div>
                </div>
                <div class="item item3">
                    <div class="nombre counter">
                        <?php 
                            $cagnottes_actif = query_posts( array(
                                'post_type' => array('cagnotte','cagnotte-perso'),
                                'post_status' => 'publish',
                                'posts_per_page' => -1,
                                'meta_query' => array(
                                    array(
                                        'key' => 'actif',
                                        'value' => true
                                    )
                                )
                            ));
                            echo count($cagnottes_actif);
                            wp_reset_postdata();
                        ?>
                    </div>
                    <div class="title"><?php _e('cagnottes en cours','kotikota'); ?></div>
                </div>
                <!-- <div class="item item4"> -->
                    <!-- <div class="nombre counter">820</div>
                    <div class="title">lorem ipsum dolor</div> -->
                <!-- </div> -->
            </div>

        </div>
    </div>
</div>