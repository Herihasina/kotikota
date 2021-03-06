<div class="popup-inscription popup" id="inscription" style="display: none;">
    <div class="inscription-pp">
        <div class="content">
            <div class="titre">
                <h2><?php _e('Inscrivez-vous','kotikota'); ?></h2>
            </div>
            <?php 
                echo do_shortcode( '[lrm_form default_tab="register" logged_in_message="You are currently logged in!" role="author" role_silent="yes"]' );
            ?>

            <div class="txt-bottom">
                <p class="success-register"></p>
                <p>
                <?php
                    printf( __('La société KOTI KOTA traite vos données afin de vous permettre de créer votre « cagnotte en ligne ». %s Les données portant une * sont obligatoires.','kotikota'),'<br />' ) 
                ?>
                </p></div>
        </div>
    </div>
</div>

<div class="popup-inscription popup" id="new_user" style="display: none;">
    <div class="inscription-pp">
        <div class="content">
            <div class="titre">
                <h2><?php _e('Une dernière étape','kotikota'); ?></h2>
            </div>

            <div class="txt-bottom">
                <p>
                <?php
                    printf( __('Un email vous a été envoyé pour confirmer votre identité','kotikota'),'<br />' ) 
                ?>
                </p></div>
        </div>
    </div>
</div>