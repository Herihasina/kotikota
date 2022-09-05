<div class="item">
    <div class="inner">
    <?php if($curr_userdata->ID == $titulaire_id) :?>
    <input type="checkbox" class="ck-photo" name="ck-photo" id="img-<?= $key_image?>" value="<?= $key_image?>">
    <label for="img-<?= $key_image?>"></label>
    <?php endif; ?>
    <a href="<?= $image ?>" class="img fancybox"><img src="<?= $image ?>" alt="Kotikota"></a>
    </div>
</div>