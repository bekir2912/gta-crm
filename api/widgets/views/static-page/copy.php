<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 19.09.2017
 * Time: 6:19
 */

use yii\helpers\Url;

?>
<?php if (!empty($static_page_cats)) { ?>
    <?php for ($i = 0; $i < count($static_page_cats); $i++) { ?>
        <?php if (empty($static_page_cats[$i]->activeStaticPages)) continue; ?>
        <?php for ($p = 0; $p < count($static_page_cats[$i]->activeStaticPages); $p++) { ?>
            <a href="<?= ($static_page_cats[$i]->activeStaticPages[$p]->external) ? $static_page_cats[$i]->activeStaticPages[$p]->url : Url::to(['site/page', 'id' => $static_page_cats[$i]->activeStaticPages[$p]->url]) ?>" class="footer-bottom__link" <?= ($static_page_cats[$i]->activeStaticPages[$p]->external) ? 'target="_blank"' : '' ?>>
                <?= $static_page_cats[$i]->activeStaticPages[$p]->translate->name ?>
            </a>
        <?php } ?>
    <?php } ?>
<?php } ?>
