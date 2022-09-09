<?php
    switch ( $ext ) {
        case 'doc':
            $ico = "003-word.png";
            break;

        case 'ppt':
            $ico = "004-powerpoint.png";
            break;

        case 'xls':
            $ico = "002-excel.png";
            break;
        
        default:
            $ico = "001-file.png";
            break;
    }
?>
<div class="item">
<?php if($curr_userdata->ID == $titulaire_id || current_user_can('administrator') ) :?>
    <input type="checkbox" name="doc_files" class="document document-check" id="doc-<?= $doc['id'] ?>" value="<?= $doc['id'] ?>">
    <label for="doc-<?= $doc['id'] ?>">
    <div class="ico"><img src="<?= IMG_URL . $ico ?>" alt="Kotikota"></div>
    <div class="txt"><?= $doc['name'] ?></div>
    </label>
<?php else: ?>
    <a href="<?= $doc['url'] ?>" class="doc-item-link">
        <div class="ico"><img src="<?= IMG_URLL . $ico  ?>" alt="Kotikota"></div>
        <div class="txt"><?= $doc['name'] ?></div>
    </a>
<?php endif; ?>

</div>