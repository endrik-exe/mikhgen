<?php

namespace app\components;

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
    
    public static function getApi()
    {
        $API = new RouterosAPI();
        //$API->debug = true;
        
        if ($API->connect('192.168.10.1', 'apicaller', 'nkingapicaller2019')) {
            return $API;
        }
        
        return null;
    }
}