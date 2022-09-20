<div class="item">
<?php if($curr_userdata->ID == $titulaire_id) :?>
    <input type="checkbox" name="doc_files" class="document document-check" id="pdf-<?= $doc['id'] ?>" value="<?= $doc['id'] ?>">
    <label for="pdf-<?= $doc['id'] ?>">
    <div class="ico"><img src="<?= IMG_URL ?>005-pdf.png" alt="Kotikota"></div>
    <div class="txt"><?= $doc['name'] ?></div>
    </label>
<?php else: ?>
    <a href="<?= $doc['url'] ?>" class="doc-item-link" target="_blank">
        <div class="ico"><img src="<?= IMG_URL ?>005-pdf.png" alt="Kotikota"></div>
        <div class="txt"><?= $doc['name'] ?></div>
    </a>
<?php endif; ?>
</div>