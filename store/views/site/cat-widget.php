<?php if (!empty($all_cats)) { ?>
    <?php if($all_cats[0]->parent_id != null) { ?>
        <li data-id="<?=($all_cats[0]->parent->parent_id != null)? $all_cats[0]->parent->parent_id: 'null'?>" data-childs="<?=$all_cats[0]->parent_id?>" class="<?=$add?>cat-widget-li"><i class="fa fa-chevron-left"></i> Назад</li>
    <?php } ?>
        <?php foreach ($all_cats as $all_cat) { ?>
            <li data-id="<?=$all_cat->id?>" data-childs="<?=(!empty($all_cat->categories))?$all_cat->id:''?>" class="<?=$add?>cat-widget-li"><?=$all_cat->translate->name?></li>
        <?php } ?>
<?php } ?>