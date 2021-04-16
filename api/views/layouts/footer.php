<?php

use frontend\widgets\WStaticPage;
use frontend\widgets\WSocials;
use frontend\widgets\WCategory;

?>
<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <?= WStaticPage::widget(['key' => 'info']); ?>
            <?= WCategory::widget(['key' => 'footer']); ?>

            <div class="footer-top__block">
                <p class="footer-top__text">
                    <?=Yii::t('frontend', 'Bottom text')?>
                </p>
                <div class="footer-buttons">
                    <?=Yii::t('frontend', 'App Store')?>
                    <?=Yii::t('frontend', 'Google Play')?>

                    <div class="footer-top__block-soc">
                        <?= WSocials::widget(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p class="footer-bottom__copyright">
                © 2017-<?=date('Y')?> <?=Yii::t('common', 'copy')?>
            </p>
            <div class="footer-bottom__link-group">
                <?= WStaticPage::widget(['key' => 'copy']); ?>
            </div>
            <div class="footer-bottom__developer">
                <?=Yii::t('common', 'powered')?>
            </div>
        </div>
    </div>
</footer>