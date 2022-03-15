<div class="headerTop clr wow fadeInDown" data-wow-delay="800ms">
    <div class="wrapper">
        <div class="left">
            <a href="<?= home_url() ?>" class="logo" title="Kotikota"><img src="<?= IMG_URL ?>logo.png" alt="Kotikota"></a>
        </div>
        <div class="right">
            <div class="wrapMenuMobile">
                <div class="menuMobile">
                    <div></div>
                    <span></span></div>
            </div>
            <div class="menu">
                <?php
                    if ( is_home() || is_front_page() ){
                        wp_nav_menu( array(
                            'theme_location' => 'top_menu_home',
                            'menu_class'  => 'wp-menu test'
                        ) );
                    }else{
                         wp_nav_menu( array(
                            'theme_location' => 'top_menu',
                            'menu_class'  => 'wp-menu'
                        ) );
                    }
                   
                ?>
            </div>
            <div class="menu-flag clr">
                <?php $icones = get_field('icones_drapeaux','option');
                echo do_action('wpml_add_language_selector');
                ?>
                <!-- <ul>
                    <li><a href="#" id="fr"><img src="<?php echo $icones['francais'] ?>"></a></li>
                    <li><a href="#" id="en"><img src="<?php echo $icones['anglais'] ?>"></a></li>
                </ul> -->
            </div>
            
            <?php if ( !is_user_logged_in() ) :?>
            <div class="btn-head">
                <a href="#connecter" class="link fancybox-home " title="<?= __('s’enregistrer /se connecter','kotikota') ?>"><?= __('s’enregistrer /se connecter','kotikota') ?></a>
            </div>
            <?php 
                else:
                    $user = wp_get_current_user();
                    $user_data = get_user_meta($user->ID);
                
            ?>
                <div class="btn-head logged-in"> 
                    <a href="#" class="login link" >
                        <span class="profil">
                            <?php 
                                 $bg = wp_get_attachment_image_src(get_field('photo', 'user_'.get_current_user_id()),'cagnotte-picto' )[0];
                                if ( !$bg ) $bg = get_field('default_gravatar','option');
                            ?>
                            <img src="<?php echo $bg ?>" alt="<?php echo $user_data['first_name'][0]; ?>" style="width:50px;height:50px;">
                        </span>
                        <span class="nom"> <?php echo $user_data['first_name'][0]; ?></span>
                    </a>  
                    <div id="sous-menu-connecte">
                        <ul>
                            <li><a href="<?php echo get_permalink( get_page_by_path( 'mon-profil' ) ); ?>" title=""><?php _e('Mon profil','kotikota') ?></a></li>
                            <li><a href="<?php echo get_permalink( get_page_by_path( 'toutes-mes-cagnottes' ) ); ?>" title=""><?php _e('Mes cagnottes','kotikota') ?></a></li>
                            <li><a href="<?php echo get_permalink( get_page_by_path( 'toutes-mes-participations' ) ); ?>" title=""><?php _e('Mes participations','kotikota') ?></a></li>
                            <li><a href="<?php echo wp_logout_url() ?>" title=""><?php _e('Me déconnecter','kotikota') ?></a></li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<a class="scrollDown"></a>