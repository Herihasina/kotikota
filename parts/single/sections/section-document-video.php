<div class="item">
    <div class="contvideo">
        <a href="<?= $video_data['url'] ?>" target="_blank">
        <div class="video-img"><img src="<?= $video_data['vignette'] ?>" alt="Kotikota"><span class="heure"><?= $video_data['duration'] ?></span></div>
        <div class="txt">
            <h4><?= $video_data['title'] ?></h4>
            <p><?= $video_data['description'] ?></p>
        </div>
        <?php if($curr_userdata->ID == $titulaire_id) :?>
            <div class="check-video">
            <input type="checkbox" class="ck-photo" name="ck-video" id="video-<?= $key_video?>" value="<?= $key_video?>">
            <label for="video-<?= $key_video?>"></label>
            </div>
        <?php endif; ?>
        </a>
    </div>
</div>