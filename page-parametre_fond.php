<?php
	// Template name: info fond

  if ( array_key_exists("parametre", $_GET) )
    $idCagnotte = strip_tags($_GET['parametre']);

  if ( !is_cagnotte( $idCagnotte ) )
    die(__('Cette ID ne correspond à votre cagnotte :)','kotikota'));

	if ( (is_user_logged_in() && get_field('titulaire_de_la_cagnotte', $idCagnotte  )  == get_current_user_id() ) || current_user_can('administrator') ):

		$active = "fond";
		get_header(); ?>

		<main id="homepage">
<?php
		include 'sections/content/parallax.php';
?>
			<div class="parametreCagnotte">
        <div class="wrapper">
				<?php
						include 'sections/parametres/menu-parametre.php';
				?>

					<div class="titre wow fadeIn" data-wow-delay="950ms">
            <h2><span><img src="<?php echo IMG_URL ?>ico-images.png"></span><?php _e('Je personnalise mes images','kotikota') ?></h2>
          </div>
          <div class="input-image wow fadeIn" data-wow-delay="950ms">
          <?php
          	$bg = get_field('illustration_pour_la_cagnotte', $idCagnotte);
          ?>
            <div class="content">
              <div class="zone-img<?php if ($bg) echo " bg-user" ?>" style="background: center / cover no-repeat url(<?php echo $bg ?>)">
                  <input name="file" id="fileImg" class="inputfile" type="file">
                  <label for="fileImg" <?php if ($bg) echo "class='no-bg'" ?>> <span><?php _e('Sélectionner votre fond d’écran','kotikota') ?></span></label>
                  <em><?php _e('Ajouter','kotikota'); ?> <br> <?php _e('votre photo','kotikota'); ?></em>
                  <input type="hidden" value="<?php echo $bg ?>" name="choix-photo" id="url_img_cagnotte">
              </div>
            </div>
          </div>
          <div class="tip"><?php printf( __('%s taille 8 mo autorisée %s','kotikota'), '📸','😉' ) ?></div>
          <div class="slide-img wow fadeIn" data-wow-delay="950ms" id="slide-img">
          	<?php
                $imgs = get_field('images_proposees','option');
                if (count($imgs)):
                  foreach ( $imgs as $img ):
            ?>
          	<div class="item">
              <div class="content">
                <a href="#" data-imgsrc="<?php echo wp_get_attachment_image_url( $img['image_prop'], 'full' ) ?>"><?php echo wp_get_attachment_image( $img['image_prop'], 'cagnotte-choix-upload' ) ?></a>
              </div>
            </div>
          <?php
		          		endforeach;
		          	endif;
		          	$query_images_args = array(
                                          'post_type'      => 'attachment',
                                          'post_mime_type' => 'image',
                                          'post_status'    => 'inherit',
                                          'posts_per_page' => 6,
                                          'author__in'     => array( get_current_user_id() )
                                      );

                $query_images = new WP_Query( $query_images_args );

                if ( $query_images){
                    foreach(  $query_images->posts as $imageko ){
                    		$img = $imageko->ID;
                        ?>
                        <div class="item">
						              <div class="content">
						                <a href="#" data-imgsrc="<?php echo wp_get_attachment_image_url( $img, 'full' ) ?>"><?php echo wp_get_attachment_image( $img, 'cagnotte-choix-upload' ) ?></a>
						              </div>
						            </div>
                        <?php
                    }
                }
          ?>
          </div>
          <ul id="response"></ul>
          <input type="hidden" id="idCagnotte" name="idCagnotte" value="<?php echo $idCagnotte ?>">
	        <div class="btn wow fadeIn" data-wow-delay="950ms">
	          <a href="<?php echo get_permalink( $idCagnotte ) ?>/parametre-info-principale/?parametre=<?= $idCagnotte ?>" class="link" title="<?php _e('revenir','kotikota') ?>"><?php _e('revenir','kotikota') ?></a>
	           <a href="<?php echo $url ?>/parametre-description/" class="link submit" title="<?php _e('éTAPE SUIVANTE','kotikota') ?>" id="submit-fond"><?php _e('éTAPE SUIVANTE','kotikota') ?></a>
	        </div>

				</div>
			</div>

		<div id="loader">
					  <img src="<?php echo IMG_URL.'loader.gif' ?>" alt="loader">
					</div>
				</main>
<?php
	get_footer();
	else:
		wp_redirect(get_permalink( get_page_by_path( 'toutes-les-cagnottes' ) ) );
		exit;
	endif;
?>
