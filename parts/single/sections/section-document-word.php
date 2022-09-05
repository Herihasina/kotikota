<div class="item">
<?php if($curr_userdata->ID == $titulaire_id) :?>
    <input type="checkbox" name="doc_files" class="document document-check" id="doc-<?= $doc['id'] ?>" value="<?= $doc['id'] ?>">
    <label for="doc-<?= $doc['id'] ?>">
    <div class="ico"><img src="<?= IMG_URL ?>word.png" alt="Kotikota"></div>
    <div class="txt"><?= $doc['name'] ?></div>
    </label>
<?php else: ?>
    <a href="<?= $doc['url'] ?>" class="doc-item-link">
        <div class="ico"><img src="<?= IMG_URL ?>word.png" alt="Kotikota"></div>
        <div class="txt"><?= $doc['name'] ?></div>
    </a>
<?php endif; ?>
</div>