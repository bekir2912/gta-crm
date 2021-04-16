<?php

use yii\helpers\Url;

if (!empty($menu)) { ?>
<ul class="footer-top__list">
    <?php for($i = 0; $i < count($menu); $i++) { ?>
        <li class="footer-top__item">
            <a href="<?=Url::to(['category/index', 'id' => $menu[$i]->url])?>" class="footer-top__link">
                <?=$menu[$i]->translate->name?>
            </a>
        </li>
    <?php } ?>
</ul>
<?php } ?>