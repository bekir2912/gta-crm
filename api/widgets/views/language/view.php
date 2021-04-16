<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 18.09.2017
 * Time: 6:10
 */
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;

?>
<div class="dropdown lang-dropdown" >
    <a  type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
        <img src="/uploads/site/<?=$current->local?>.png" alt="." style="width: 16px;vertical-align: middle;margin-right: 5px;"> <span class="hidden-xs hidden-sm" style="vertical-align: middle">
                <?=$current->name?></span>
    </a>
    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2" style="min-width: 50px;">

        <?php foreach ($langs as $lang){ ?>
        <li>
            <a href="<?= '/' . $lang->url . Yii::$app->getRequest()->getLanguageUrl() ?>" >
                <img src="/uploads/site/<?=$lang->local?>.png" alt="." style="width: 16px;vertical-align: middle;margin-right: 5px;"> <span class="hidden-xs hidden-sm" style="vertical-align: middle">
                <?=$lang->name?></span>
            </a>
        </li>
        <?php } ?>
    </ul>
</div>