<div class="titre jaune">
  <span class="ico"><img src="<?= IMG_URL ?>ico-cagnotte1.png"></span>
  <span class="label"><?php _e('cagnotte Organisée par :','kotikota'); ?></span>
  <span class="nom">
    <?php 
      $user = get_user_meta( get_field('titulaire_de_la_cagnotte') );
      if ( $user['first_name'][0] != '' || $user['last_name'][0] != '' ){
        echo $user['first_name'][0].' '.$user['last_name'][0]; 
      }else{
        echo $user['nickname'][0];
      }
    ?>
   </span>
</div>
<div class="txt">
  <?php if ( get_field('description_de_la_cagnote') ) : ?>
    <p>
      <?php 
        if ( 
          $type_cagnotte == "solidaire" || 
          $isInvited ||
          get_field('titulaire_de_la_cagnotte')  == get_current_user_id() || 
          current_user_can('administrator') 
        ){
          echo get_field('description_de_la_cagnote');
        }
        // elseif ( $type_cagnotte == "perso"){
        //   echo substr(get_field('description_de_la_cagnote'), 0, 220 ).'...';
        // }
      ?>
    </p>
  <?php endif; ?>
</div> 