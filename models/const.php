<?php
    //月份
    $_MONTH = [
        'Jan' => 1,
        'Feb' => 2,
        'Mar' => 3,
        'Apr' => 4,
        'May' => 5,
        'Jun' => 6,
        'Jul' => 7,
        'Aug' => 8,
        'Sep' => 9,
        'Oct' => 10,
        'Nov' => 11,
        'Dec' => 12,
    ];
    $_STATUS = [
        '000' => 'inline',
        '001' => 'crash',
        '002' => 'logout',
        '003' => 'down',
        '004' => 'gone', 
    ];
    $_LV = [
        'commen' => 5,
        'kernel' => 0,
        'rsyslogd-2007' => 1,
    ];
    $_SETTING_TYPE = [
        0 => 'delete-old',
        01 => 'filter-message',
        02 => 'filter-loginfo',
        03 => 'filter-authinfo',

        11 => 'select-message',
        12 => 'select-loginfo',
        '13' => 'select-authinfo',

    ];
?>
