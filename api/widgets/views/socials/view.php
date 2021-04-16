<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 19.09.2017
 * Time: 8:04
 */

$this->registerCss("
    .social-network__link {
        display: inline-block;
        width: 32px;
        text-align: center;
        font-size: 20px;
        color: #000;
        background: #fff;
        border-radius: 5px;
    }
    .social-network__link:hover {
        color: #000!impoartant;
    }
");
?>
<?php if(!empty($socials)) { ?>
    <ul class="social-network">
            <?php for ($i = 0; $i < count($socials); $i++) { ?>
                <li class="social-network__item">
                    <a href="<?=$socials[$i]->url?>" target="_blank" title="<?=$socials[$i]->name?>" class="social-network__link">
                        <i class="fa fa-<?=$socials[$i]->icon?>"></i>
                    </a>
                </li>
            <?php } ?>
        </ul>
<?php } ?>
