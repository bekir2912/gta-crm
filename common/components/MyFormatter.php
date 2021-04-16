<?php
namespace common\components;


use rmrevin\yii\fontawesome\FA;
use yii\i18n\Formatter;

class MyFormatter extends Formatter{


    public $publishedFormat;
    public $activeFormat;
    public $activeuserFormat;
    public $deliveryFormat;
    public $paytypeFormat;
    public $orderstatusFormat;
    public $productStatusFormat;

    public function asPublished($value)
    {
        if ($value === null) {
            return $this->nullDisplay;
        }
        if($value == 1) return $this->publishedFormat[1];
        if($value == -1) return $this->publishedFormat[2];
        return $this->publishedFormat[0];
    }
    public function asProductStatus($value)
    {
        if($value == 1) return $this->productStatusFormat[1];
        if($value == -1) return $this->productStatusFormat[2];
        return $this->productStatusFormat[0];
    }

    public function asDelivery($value)
    {
        if($value == 1) return $this->deliveryFormat[1];
        return $this->deliveryFormat[0];
    }

    public function asActive($value)
    {
        if($value == 1) return $this->activeFormat[1];
        return $this->activeFormat[0];
    }

    public function asActiveuser($value)
    {
        if($value == 10) return $this->activeuserFormat[1];
        return $this->activeuserFormat[0];
    }

    public function asOrderstatus($value)
    {

        if($value == 0) return $this->orderstatusFormat[0];
        if($value == 1) return $this->orderstatusFormat[2];
        return $this->orderstatusFormat[1];
    }

    public function asPaytype($value)
    {
        if($value == 1) return $this->paytypeFormat[1];
        return $this->paytypeFormat[0];
    }

    public function set_intlLoaded() {
        parent::_intlLoaded();
    }


    public function init()
    {
        if ($this->publishedFormat === null) {
            $this->publishedFormat = [
                '<span class="text-warning">'.FA::i('clock-o').' На модерации'.'</span>',
                '<span class="text-success">'.FA::i('check').' Опубликован'.'</span>',
                '<span class="text-danger">'.FA::i('remove').' Заблокирован'.'</span>',
            ];
        }
        if ($this->deliveryFormat === null) {
            $this->deliveryFormat = [
                '<span class="text-warning">'.FA::i('male').' Самовывоз'.'</span>',
                '<span class="text-success">'.FA::i('truck').' Доставка'.'</span>'
            ];
        }
        if ($this->paytypeFormat === null) {
            $this->paytypeFormat = [
                '<span class="text-info">'.FA::i('money').' Наличные'.'</span>',
                '<span class="text-success">'.FA::i('credit-card').' Онлайн'.'</span>'
            ];
        }
        if ($this->orderstatusFormat === null) {
            $this->orderstatusFormat = [
                '<span class="text-info">'.FA::i('info').' Не обработан'.'</span>',
                '<span class="text-danger">'.FA::i('remove').' Отменен'.'</span>',
                '<span class="text-success">'.FA::i('check').' Принят'.'</span>'
            ];
        }
        if ($this->productStatusFormat === null) {
            $this->productStatusFormat = [
                '<span class="text-warning">'.FA::i('info').' Нет в наличии'.'</span>',
                '<span class="text-success">'.FA::i('check').' Есть в наличии'.'</span>',
                '<span class="text-danger">'.FA::i('remove').' Заблокирован'.'</span>'
            ];
        }
        if ($this->activeFormat === null) {
            $this->activeFormat = [
                '<span class="text-danger">'.FA::i('remove').' Не активна'.'</span>',
                '<span class="text-success">'.FA::i('check').' Активна'.'</span>'
            ];
        }
        if ($this->activeuserFormat === null) {
            $this->activeuserFormat = [
                '<span class="text-danger">'.FA::i('remove').' Заблокирован'.'</span>',
                '<span class="text-success">'.FA::i('check').' Активен'.'</span>'
            ];
        }
        parent::init();

    }
}