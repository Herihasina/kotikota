<?php
	// Template name: info description

	if ( array_key_exists("parametre", $_GET) )
    $idCagnotte = strip_tags($_GET['parametre']);

  if ( !is_cagnotte( $idCagnotte ) )
    die(__('Cette ID ne correspond à votre cagnotte :)','kotikota'));

	if ( (is_user_logged_in() && get_field('titulaire_de_la_cagnotte', $idCagnotte )  == get_current_user_id() ) || current_user_can('administrator') ):

		$active = "description";
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
            <h2><span><img src="<?php echo IMG_URL ?>ico-personalise.png"></span><?php _e('Je personnalise mes textes','kotikota'); ?></h2>
          </div>
          <div class="blc-apercu wow fadeIn" data-wow-delay="950ms">
            <?php echo get_field('description_de_la_cagnote', $idCagnotte) ?>
          </div>
          <div class="editeur-txt wow fadeIn" data-wow-delay="950ms">
              <div class="container">
                <textarea class="textEdit"></textarea>
              </div>
              <div style="text-align:center">
              	<a href="" title="" class="link submit" id="apercu-description"><?php _e('Aperçu','kotikota'); ?></a>
              </div>
          </div>
          <input type="hidden" id="idCagnotte" name="idCagnotte" value="<?php echo $idCagnotte ?>">
	        <div class="btn wow fadeIn" data-wow-delay="950ms">
	          <a href="<?php echo get_permalink( $idCagnotte ) ?>/parametre-fond/?parametre=<?= $idCagnotte ?>" class="link" title="<?php _e('revenir','kotikota') ?>"><?php _e('revenir','kotikota') ?></a>
	          <a href="#" class="link submit" title="<?php _e('Enregistrer','kotikota') ?>" id="submit-descr"><?php _e('Enregistrer','kotikota') ?></a>
	          <a href="<?php echo $url ?>/parametre-montant/?parametre=<?= $idCagnotte" class="link submit" title="<?php _e('éTAPE SUIVANTE','kotikota') ?>"><?php _e('éTAPE SUIVANTE','kotikota') ?></a>
	        </div>

				</div>
			</div>
			<div id="loader">
			  <img src="<?php echo IMG_URL.'loader.gif' ?>" alt="loader">
			</div>
		</main>
<?php
	get_footer();
	$tmp = get_field('description_de_la_cagnote', $idCagnotte);
	$tmp = preg_replace('/\r?\n|\r/', '', $tmp);
	$tmp = preg_replace('/\"|\'/', '\"', $tmp);
?>
	<script>
		var content = "<?php echo $tmp; ?>";

		$(".textEdit").summernote("code", content);
	</script>
<?php
	else:
		wp_redirect(get_permalink( get_page_by_path( 'toutes-les-cagnottes' ) ) );
		exit;
	endif;
?>
