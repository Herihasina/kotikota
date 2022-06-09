<?php
	/*
	Template Name: mon profil
	*/
  $user = get_user_meta( get_current_user_id());
  $userdata = wp_get_current_user();

	get_header();
?>
<main id="homepage">
<?php
	include 'sections/content/parallax.php';

  if( $user ):
?>

<div class="blc-cagnotte-participation">
  <div class="wrapper">
    <form class="participation" id="form-edit-profil">
        <div class="fom-participe">
            <div class="titre wow fadeIn" data-wow-delay="800ms">
               <h2><span><img src="<?php echo IMG_URL ?>identite.png"></span> <?php echo __('Editez votre profil', 'kotikota'); ?></h2>
            </div>
            <div class="choix-photo choix-photo-profil blc-chp">
                <?php
                  $bg = wp_get_attachment_image_src(get_field('photo', 'user_'.get_current_user_id()),'cagnotte-home' )[0];
                ?>
                    <div class="blc-img"><!-- desk-only -->
                      <div class="zone-img profil-img<?php if ($bg) echo " bg-user" ?>" <?php if ($bg): ?> style="background: center / auto no-repeat url(<?php echo $bg ?>)" <?php endif; ?>>
                            <input name="file" id="pdp-btn" class="inputfile" type="text">
                            <label for="pdp-btn"><?php _e('Ajouter  <br> votre photo','kotikota'); ?></label>
                            <input type="hidden" value="" name="choix-photo" id="pdp">
                        </div>
                    </div>

                    <!-- Mobile only -->
                    <div class="mobile-only illustration_cagnotte photo_profil_mobile">
                        <input type="file" capture="environment" accept="image/*" name="choix-photo_mobile" id="photo_profil_mobile" required>
                    </div>
                    <!-- /mobile only -->
            </div>
            <div class="formulaire clr wow fadeIn" data-wow-delay="900ms">
              <div class="col">
                  <div class=" blc-chp ">
                      <label for="fname"><?php echo __('Prénom','kotikota'); ?><span>*</span></label>
                      <div class="chp">
                        <input type="text" name="fname" id="fname" placeholder="<?php echo __('Indiquez votre prénom','kotikota'); ?>" value="<?php echo $user['first_name'][0] ?>" required>
                      </div>
                  </div>
              </div>
              <div class="col">
                  <div class=" blc-chp">
                      <label for="lname"><?php echo __('Nom', 'kotikota'); ?> <span>*</span></label>
                      <div class="chp">
                        <input type="text" name="lname" id="lname" placeholder="<?php echo __('Indiquez votre nom','kotikota'); ?>" value="<?php echo $user['last_name'][0] ?>" required>
                      </div>
                  </div>
              </div>
              <div class="col ">
                  <div class="blc-chp">
                      <label for="mail"><?php echo __('E-mail', 'kotikota'); ?> <span>*</span></label>
                      <div class="chp">
                        <input type="email" name="mail" id="mail" placeholder="<?php echo __('Indiquez votre adresse mail','kotikota'); ?>" value="<?php echo $userdata->data->user_email ?>" required>
                      </div>
                  </div>
              </div>
              <div class="col ">
                  <div class="blc-chp">
                    <input type="hidden" value="<?php echo get_field('code', 'user_'.get_current_user_id()) ?>" id="code" name="code">
                      <label for="tel"><?php echo __('Numéro de téléphone', 'kotikota'); ?> <span>*</span></label>
                      <!-- <div class="chp">
                        <input class="" type="tel" value="<?php echo get_field('numero_de_telephone', 'user_'.get_current_user_id()) ?>" name="tel" id="tel" />
                      </div> -->
                      <input type="tel" name="tel" id="tel" class="chp" required pattern="[0-9]{9}" value="<?php echo get_field('numero_de_telephone', 'user_'.get_current_user_id()) ?>">
                      <span id="valid-msg" class="hide">✓</span>
                      <span id="error-msg" class="hide">✗</span>
                  </div>
              </div>
              <div class="col">
                  <div class=" blc-chp">
                      <label for="newpwd"><?php echo __('Mot de passe', 'kotikota'); ?> <span>*</span></label>
                      <div class="chp">
                        <input type="text" name="newpwd" id="newpwd" value="">
                      </div>
                  </div>
              </div>
              <div class="col profilFile">
                <div class=" blc-chp">
                  <div class="blcFormulaire fichier">
                  <label for=""><?php echo __('Ajouter votre CIN, Passeport', 'kotikota'); ?></label>
                    <!-- visible seulement pour desk  -->
                    <div class="chp" style=""><!--desk-only-->
                        <div class="cont-file">
                          <?php
                            $cin = get_field('piece_didentite','user_'.get_current_user_id() );
                            if( !$cin ): ?>
                            <span><?php echo __('Aucun fichier sélectionné', 'kotikota'); ?></span>
                          <?php else: ?>
                            <span><?= basename ( get_attached_file( $cin ) ); ?></span>
                          <?php endif; ?>
                          <input type="text" class="input-file" id="cin_btn">
                          <input type="hidden" name="cin_value" value="" id="cin_value">
                          <i class="parcourir <?php if ($cin){ echo 'nonvide'; }else{ echo '';} ?>">
                            <?php
                            if($cin){
                              _e('Fichier ajouté','kotikota');
                            } else {
                              _e('Parcourir','kotikota');
                            }
                            ?>
                          </i>
                          <i class="reset" style="display: none"><?php echo __('Supprimer', 'kotikota'); ?></i>
                        </div>
                        <div class="zone-img-cin"></div>
                    </div>
                    <!-- /fin desk -->

                    <!-- visible seulement pour mobile -->
                    <div class="mobile-only">
                        <input type="file" name="cin_value_mobile" id="cin_value" capture="environment" accept="image/*">
                    </div>
                    <!-- /fin visible seulement pour mobile -->

                  </div>
                </div>
              </div>
            </div>
            </div>
        </div>

        <div class="btn">
          <a href="#" onclick="window.history.back();" class="link" title="<?php echo __('annuler', 'kotikota'); ?>"><?php echo __('annuler', 'kotikota'); ?></a>
          <input type="submit" name="submit_edit_profil" value="<?php echo __('valider', 'kotikota'); ?>" id="edit-profilz" class="link submit" >
        </div>


    </form>

  </div>
</div>
<div id="loader">
  <img src="<?php echo IMG_URL.'loader.gif' ?>" alt="loader">
</div>
<?php else: ?>
  <div class="blc-liste-cagnote force-login wow fadeIn" data-wow-delay="850ms">
                <div class="lst-cagnotte-publique wow fadeIn clr" data-wow-delay="900ms">
                    <h3 style="text-align:center">
                        <?php _e("Vous devez vous authentifier pour pouvoir modifier votre profil.", "kotikota"); ?>
                    </h3>
                </div>
            </div>
<?php endif; ?>
</main>
<?php get_footer();
?>