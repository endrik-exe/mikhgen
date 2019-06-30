<?php

namespace app\components;

use Yii;

class AppHelper
{
    public static $monthCode = [
        1 => 'JUN',
        2 => 'FEB',
        3 => 'MAR',
        4 => 'APR',
        5 => 'MAY',
        6 => 'JUN',
        7 => 'JUL',
        8 => 'AUG',
        9 => 'SEP',
        10 => 'OCT',
        11 => 'NOV',
        12 => 'DES'
    ];
    
    private static $_api = null;
    public static function getApi()
    {
        if (!self::$_api)
        {
            $newApi = new RouterosAPI();
            //$API->debug = true;

            if ($newApi->connect('192.168.10.1', 
                Yii::$app->params['apiUserName'], 
                Yii::$app->params['apiUserPassword'])
            ) {
                $_api = $newApi;
            }
        }
        
        return $_api;
    }
}