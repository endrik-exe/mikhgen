<?php

use yii\helpers\Json;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function indexOf($array, $callback, $params  = [])
{
    for($i = 0; $i < count($array); $i++)
    {
        $args = [];
        $args[] = $array[$i];
        
        if ($params) $args = array_merge ($args, $params);
        if(call_user_func_array($callback, $args)) return $i;
    }
    
    return -1;
}

function array_find($array, &$index, $callback, $params  = [])
{
    
    for($i = 0; $i < count($array); $i++)
    {
        $args = [];
        $args[] = $array[$i];
        
        if ($params) $args = array_merge ($args, $params);
                
        $index = $i;
        if(call_user_func_array($callback, $args)) return true;
    }
    $index = -1;
    return false;
}

function str_replaces($subject, array $keyValue)
{
    foreach ($keyValue as $key => $value)
    {
        $subject = str_replace($key, $value, $subject);
    }
    
    return $subject;
}

function nbsp($count = 1)
{
    $result = '';
    for ($i = 0; $i < $count; $i++)
    {
        $result.='&nbsp;';
    }
    
    return $result;
}

function repeat($str, $count = 1)
{
    $result = '';
    for ($i = 0; $i < $count; $i++)
    {
        $result.=$str;
    }
    
    return $result;
}

function decimalToFloat($str)
{
    if ($str && count(explode(',', $str)) == 2 || strlen(explode('.', $str)[count(explode('.', $str)) - 1]) == 3)
    {
        return floatVal(str_replaces($str, [
            ' ' => '',
            '.' => '',
            ',' => '.'
        ]));
    }
    
    return floatVal($str);
}

function floatToDecimal($value, $digits = 0)
{
    if ($digits == 0)
    {
        $digits = count(explode('.', floatval($value))) == 2 ? strlen(explode('.', floatval($value))[1]) : 0;
    }

    return ' '.number_format(is_numeric($value) ? ($digits == 0 ? round($value) : $value) 
        : ($digits == 0 ? round(floatVal($value)) : floatVal($value)), $digits, ",",".");

}

function array_all_is($value, $array)
{
  return $array && (reset($array) == $value && count(array_unique($array)) == 1);
}

function debugObject($obj)
{
    Yii::$app->response->format = 'json';
    Yii::$app->response->content = Json::encode($obj);
    Yii::$app->response->send();
}

function mapFilter($model, array $map)
{
    $result = '';
    foreach ($map as $property => $filter)
    {
        $prefix = is_array($filter) ? $filter[0] : $filter;
        if ($model->{$property} || is_bool($model->{$property}) || $model->{$property} == "0")
        {
            $result .= $result ? ', ' : '';
            $result .= $prefix;
            $result .= is_array($filter) ? $filter[1]($model->{$property}) : $model->{$property};
        }
    }
    
    return $result;
}

function arrayKeyValue($array, $key)
{
    if (array_key_exists($key, $array)) return $array[$key];
    return null;
}

function ifNull($primary, $secondary)
{
    return $primary ? $primary :  $secondary;
}

function currentRef()
{
    return Yii::$app->request->absoluteUrl;
}

function referrer($default = null)
{
    if (!$default) $default = [Yii::$app->controller->id];
    
    $get = urldecode(Yii::$app->request->get('referrer'));
    $post = urldecode(Yii::$app->request->post('referrer'));
    $header = Yii::$app->request->referrer;
    
    if ($get) return $get;
    else if ($post) return $post;
    else if ($header) return $header;
    else return $default;
    
    //return $get ?? $post ?? $default; ?? $header;
}

function convertMonthToEn($str)
{
    return str_replaces($str, [
        'Januari' => 'January',
        'Februari' => 'February',
        'Maret' => 'March',
        'April' => 'April',
        'Mei' => 'May',
        'Juni' => 'June',
        'Juli' => 'July',
        'Agustus' => 'August',
        'September' => 'September',
        'Oktober' => 'October',
        'November' => 'November',
        'Desember' => 'December'
    ]);
}


function lastDay($date = null)
{
    if (!$date) $date = date('Y-m-01');
    
    return date('Y-m-t', strtotime($date));
}

function dashCase($str)
{
    $result = "";
    for ($i = 0; $i < strlen($str); $i++)
    {
        $char = $str[$i];
        if ($char == strtoupper($char))
        {
            if ($i != 0) $result .= "-";
            $result .= strtolower($char);
        } else
        {
            $result .= $char;
        }
    }

    return $result;
}

function formatTimespan($str)
{
    $mapping = [
        'w' => 'mg',
        'd' => 'hr',
        'h' => 'j',
        'm' => 'm',
        's' => 'd',
    ];

    for ($i = 0; $i < strlen($str); $i++)
    {
        $ch = $str[$i];
        if (in_array($ch, array_keys($mapping)))
        {
            $replace = "".$mapping[$ch]." ";
            $str = substr_replace($str, $replace, $i, 1);
            $i += strlen($replace);
        }
    }
    
    return $str;
}

function minifyRos($ros)
{
    return str_replace([" \\\r\n", "\r\n"], '', $ros);
}