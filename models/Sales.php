<?php
namespace app\models;

use app\components\AppHelper;
use \DateTime;
use yii\base\Model;

/**
 * User model
 *
 * @property integer $id
 * @property string $userName
 * @property string $passwordHash
 * @property string $passwordResetToken
 * @property string $email
 * @property string $authKey
 * @property string $handphone
 */
class Sales extends Model
{
    const SOURCE_API = 1;
    const SOURCE_DB = 2;
    const SOURCE_BOTH = 3;
    
    
    public $agenCode;
    public $year;
    public $month;
    
    public static $monthCodes = [
        1 => 'jan',
        2 => 'feb',
        3 => 'mar',
        4 => 'apr',
        5 => 'may',
        6 => 'jun',
        7 => 'jul',
        8 => 'aug',
        9 => 'sep',
        10 => 'okt',
        11 => 'sep',
        12 => 'des'
    ];
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['agenCode',], 'string', 'max' => 45],
            [['year', 'month'], 'safe'],
        ];
    }
    
    /**
     * 
     * Get sales with some parameter
     * 
     * @param type $agenCode
     * @param type $year
     * @param type $month
     * @param type $source
     * @return array sales data
     * @throws Exception
     */
    public static function getSalesWith($agenCode = null, $year = null, $month = null, $source = Sales::SOURCE_BOTH)
    {
        $missingMDR = 'vc-251-08.03.19-MDR-AUG-V2J-x1-q18'; //missing
        $api = AppHelper::getApi();
        if ($api)
        {
            $monthCode = $month ? self::$monthCodes[intval($month)] : strtolower(date('M'));
            $monthCode .= $year ? $year : date('Y');
            
            //SALEDATE-|-SELLTIME-|-NAME-|-PRICE-|-IP-|-MAC-|-DURATION-|-VCNAME-|-COMMENT
            $query = $api->comm("/system/script/print", [
                '?comment' => 'mikhmon',
                '?owner' => $monthCode,
            ]);
            
            $sales = [];
            foreach ($query as $str)
            {
                $data = explode( '-|-', $str['name']);
                
                $saleDate = DateTime::createFromFormat('M/d/Y', $data[0])->format('Y-m-d');
                $sale = [
                    'saleDate' => $saleDate,
                    'saleTime' => DateTime::createFromFormat('Y-m-d H:i:s', "$saleDate ".$data[1])->format('Y-m-d H:i:s'),
                    'name' => $data[2],
                    'price' => floatVal($data[3]),
                    'ip' => $data[4],
                    'mac' => $data[5],
                    'duration' => $data[6],
                    'profile' => $data[7],
                    'comment' => $data[8]
                ];
                
                if ($agenCode && strpos($sale['comment'], $agenCode) === false) continue;
                
                if ($agenCode == 'MDR' && strpos($sale['comment'], $missingMDR) !== false) continue;
                
                $sales[] = $sale;
            }
            
            return $sales;
        } else
        {
            throw new \Exception('Api not found, please configure your api username and password');
        }
    }
    
}
