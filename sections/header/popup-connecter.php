<div class="popup-connecter popup " id="connecter" style="display: none">
    <div class="connecter-pp clr">
        <a class="scrollDown"></a>
        <div class="cont-left">
            <div class="content">
                <h2><?php _e('Connectez vous à votre compte','kotikota'); ?></h2>
                <?php 
                    echo do_shortcode( '[lrm_form default_tab="login" logged_in_message="You are currently logged in!"]' );
                 ?>              
            </div>
        </div>
        <div class="cont-right">
            <div class="content">
                <h2><?php _e('Pas encore inscrit ?','kotikota'); ?></h2>
                <p><?php _e('Rejoignez la communauté des KotiKoteurs <br>et collectez immédiatement','kotikota'); ?></p>
                <div class="blc-img">
                    <img src="<?= IMG_URL ?>img-connect.jpg" alt="Photo">
                </div>
                <div class="btn">
                    <a href="#inscription" class="link fancybox-register open-register" title="<?php _e('Créer un compte','kotikota'); ?>"><?php _e('Créer un compte','kotikota'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>