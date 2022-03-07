

<div class="securite-cagnotte">
    <div class="wrapper">
        <h2 class="wow fadeInUp" data-wow-delay="900ms" style="visibility: visible; animation-delay: 900ms; animation-name: fadeInUp;"><?= get_field('securite_cacgnotte_titre') ?></h2>
        <div class="lst-securite">
            <?php
                $list_securite = get_field('securite_cacgnotte_liste');
                if($list_securite):
                foreach ($list_securite as $key => $securite) {
            ?>
                <div class="item">
                    <div class="titre"><?= $securite['securite_cacgnotte_liste_titre'] ?></div>
                    <div class="txt"><p><?= $securite['securite_cacgnotte_liste_texte'] ?></p></div>
                </div>
            <?php
                endif;
                }
            ?>
        </div>
    </div>
</div>
