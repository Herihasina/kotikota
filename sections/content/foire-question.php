<?php 

$args = array(  
    'post_type' => 'FAQ',
    'post_status' => 'publish',
    'posts_per_page' => -1, 
    'orderby' => 'ID',
    'order' => 'ASC', 
);

$loop = new WP_Query( $args ); 
$data = [];
$all_faqs = 0;
    
while ( $loop->have_posts() ) : $loop->the_post(); 
    $data[] = [
        'title' => get_the_title(),
        'content' => get_the_content()
    ];
    $all_faqs++;
endwhile;

wp_reset_postdata(); 

?>


<div class="foire-question" data-all_faqs="<?= $all_faqs ?>">
    <div class="wrapper">
        <h2 class=" wow fadeInUp" data-wow-delay="900ms"><?php the_field('titre_faq') ?></h2>
        <div class="lst-questions  wow fadeInUp" data-wow-delay="950ms">
            <ul>
                <?php foreach($data as $key => $row): ?>
                    <li><a href="#pp-Faq" id="qst<?=$key?>" class="link fancybox-faq" title="<?= $row['title'] ?>" data-fancyboxa><?= $row['title'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<div class="pp-Faq" id="pp-Faq" style="display: none">
    <div class="Faq-pp">
        <div class="titre">
            <h2><?php the_field('titre_faq') ?></h2>
        </div>
        <div class="blc-faq">
            <div class="lst-faq scrollbar-inner">
                <div class="inner">
                    <?php foreach($data as $key => $row): ?>
                        <div class="item slide" id="faq<?=$key?>">
                            <div class="content">
                                <div class="s-titre">
                                    <h3><?=$row['title']?></h3>
                                </div>
                                <div class="txt">
                                    <?=$row['content']?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="footer-pp">
            <?php if(have_rows('section_footer')){
                while(have_rows('section_footer')){ the_row(); ?>
                <span><?php the_sub_field('texte') ?></span>
                <?php 
                    $tel = get_sub_field('phone');
                    $tel = str_replace(array(' ','(',')'),array('','',''), $tel);
                ?>
                <a href="tel:<?php echo $tel?>" title=""><?php the_sub_field('phone') ?></a> - <a href="mailto:<?php the_sub_field('e-mail') ?>" title=""><?php the_sub_field('e-mail') ?></a>
            <?php }} ?>
        </div>
    </div>

</div>