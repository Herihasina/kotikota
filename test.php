<?php
/*
Template name: paiement 
*/
  if ( ( !isset($_GET['id']) && empty( $_GET['id'] ) ) || ( !isset($_GET['cl']) && empty( $_GET['cl'] ) ) ){
    wp_redirect( '/' );
    exit();
  }

  // $url = $_SERVER['HTTP_HOST'] == 'dev.kotikota' ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
  $url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

  $id_participation = strip_tags($_GET['id']);
  $email            = strip_tags($_GET['cl']);

  $participation = get_participation( $id_participation, $email );

	get_header();
  
?>
<main id="payment-page">

<div class="blc-cagnotte-liste wow fadeIn" data-wow-delay="850ms">
    <div class="wrapper">
        <div class="zone-search">
            <div class="blc-menu">           
            </div>
        </div>        
      	<div id="paypal-button-container">
          <?php
            if ( $participation != false ): 
              $devise = $participation->devise;
              $devise = $devise == 'liv' ? 'GBP' : 'EUR';
              $return_url = site_url()."/succes-paiement?mod=paypal&participation=$id_participation";
          ?>
        		<form action="<?= $url ?>" method="post">
              <div class="paypal-donations">
                <input type="hidden" name="cmd" value="_donations">
                <input type="hidden" name="bn" value="Koti Kota">
                <input type="hidden" name="business" value="sb-47v4hq3783899@business.example.com">
                <input type="hidden" name="item_name" value="<?= get_field('nom_de_la_cagnotte', $participation->id_cagnotte ) ?>">
                <input type="hidden" name="return" value="<?= $return_url ?>">
                <input type="hidden" name="amount" value="<?= $participation->donation ?>">
                <input type="hidden" name="rm" value="0">
                <input type="hidden" name="currency_code" value="<?= $devise ?>">
                <input type="hidden" name="lc" value="fr_FR">
                <input type="submit" style="cursor: pointer;" value="Donation via Paypal en cours" name="submit" alt="PayPal - The safer, easier way to pay online." id="go-paypal">
                <img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"> 
              </div>
            </form>
          <?php else: ?>
            <div class="blc-liste-cagnote resultat-recherche wow fadeIn" data-wow-delay="850ms">
                <div class="lst-cagnotte-publique wow fadeIn clr" data-wow-delay="900ms">
                    <div style="text-align:center">
                        <h3> <?= __("-- Cette transation a déjà été effectuée ou n'exsite pas ! --","kotikota") ?></h3>
                    </div>
                </div>
            </div>
            
          <?php endif; ?>
      	</div>
    </div>
 </div>
</main>

<?php get_footer(); ?>