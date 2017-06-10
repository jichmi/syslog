<?php
namespace app\models;

use Yii;

class AppConst{
    public $_STATUS = [
        '000' => 'inline',
        '001' => 'crash',
        '002' => 'logout',
        '003' => 'down',
        '004' => 'gone', 
    ];
    public $_LV = [
        'commen' => 5,
        'kernel' => 0,
        'rsyslogd-2007' => 1,
    ];
    public static $_SETTING_TYPE = [
        100 => 'delete-old',
        101 => 'filter-message',
        102 => 'filter-loginfo',
        103 => 'filter-authinfo',
        104 => 'filter-load',

        111 => 'select-message',
        112 => 'select-loginfo',
        113 => 'select-authinfo',

    ];
}
?>
