<?php
namespace common\components;


use yii\i18n\Formatter;

class __MyFormatter extends Formatter{


    public $user_statusFormat;
    public $is_linkedFormat;
    public $is_paidFormat;
    public $is_for_allFormat;
    public $is_confirmFormat;

    public function asUser_status($value)
    {
        if ($value === null) {
            return $this->nullDisplay;
        }

        if($value == 1) {
            return $this->user_statusFormat[0];
        }
        elseif($value == 5) {
            return $this->user_statusFormat[1];
        }
        elseif($value == 10) {
            return $this->user_statusFormat[2];
        }
        elseif($value == 15) {
            return $this->user_statusFormat[3];
        }
    }

    public function asIs_linked($value)
    {
        if ($value === null) {
            return $this->nullDisplay;
        }

        if($value == 1) {
            return $this->is_linkedFormat[1];
        }
        elseif($value == 2) {
            return $this->is_linkedFormat[2];
        }
        else return $this->is_linkedFormat[0];
    }

    public function asis_confirm($value)
    {
        if ($value === null) {
            return $this->nullDisplay;
        }

        if($value == 1) {
            return $this->is_confirmFormat[1];
        }
        elseif($value == 2) {
            return $this->is_confirmFormat[2];
        }
        elseif($value == 5) {
            return $this->is_confirmFormat[3];
        }
        else return $this->is_confirmFormat[0];
    }

    public function asIs_paid($value)
    {
        if ($value === null) {
            return $this->nullDisplay;
        }

        if($value >= mktime(0, 0, 0, date("m"), 01, date("Y"))) {
            return $this->booleanFormat[1];
        }
        else return $this->booleanFormat[0];
    }

    public function asIs_for_all($value)
    {
        if ($value === null) {
            return $this->nullDisplay;
        }

        if($value == 1) {
            return $this->is_for_allFormat[1];
        }
        elseif($value == 2) {
            return $this->is_for_allFormat[2];
        }
        else return $this->is_for_allFormat[0];
    }

    public function set_intlLoaded() {
        parent::_intlLoaded();
    }


    public function init()
    {
        if ($this->booleanFormat === null) {
            $this->booleanFormat = [
                '<span class="glyphicon glyphicon-remove text-danger text-center center-block"></span>',
                '<span class="glyphicon glyphicon-ok  text-success text-center center-block"></span>'
            ];
        }
        if ($this->is_paidFormat === null) {
            $this->booleanFormat = [
                '<span class="glyphicon glyphicon-remove text-danger text-center center-block"></span>',
                '<span class="glyphicon glyphicon-ok  text-success text-center center-block"></span>'
            ];
        }
        if ($this->is_linkedFormat === null) {
            $this->is_linkedFormat = [
                '<span class="glyphicon glyphicon-remove text-danger text-center center-block"></span>',
                '<span class="glyphicon glyphicon-ok text-success text-center center-block"></span>',
                '<span class="glyphicon glyphicon-info-sign pointer text-info text-center center-block" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Активно. Нет прямой ссылки на сайте"></span>'
            ];
        }
        if ($this->is_confirmFormat === null) {
            $this->is_confirmFormat = [
                '<span class="glyphicon glyphicon-pencil text-info text-center center-block"></span>',
                '<span class="glyphicon glyphicon-ok text-success text-center center-block"></span>',
                '<span class="glyphicon glyphicon-remove text-danger text-center center-block"></span>',
                '<span class="glyphicon glyphicon-trash text-danger text-center center-block"></span>',
            ];
        }
        if ($this->is_for_allFormat === null) {
            $this->is_for_allFormat = [
                '<span class="glyphicon glyphicon-remove text-danger text-center center-block"></span>',
                '<span class="glyphicon glyphicon-ok text-success text-center center-block"></span>',
                '<span class="glyphicon glyphicon-info-sign pointer text-info text-center center-block" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Активно только для зарегистрированных"></span>'
            ];
        }
        if ($this->user_statusFormat === null) {
            $this->user_statusFormat = [
                '<span class="glyphicon glyphicon-user text-danger text-center center-block" ></span>',
                '<span class="glyphicon glyphicon-ban-circle text-danger pointer text-center center-block" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Заблокирован"></span>',
                '<span class="glyphicon glyphicon-user text-success text-center center-block"></span>',
                '<span class="glyphicon glyphicon-info-sign text-info pointer text-center center-block"  data-container="body" data-toggle="popover" data-placement="bottom" data-content="Имеет доступ к Админ-панели"></span>',
            ];
        }
        parent::init();

    }
}