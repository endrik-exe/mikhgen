<?php
namespace app\models;

use app\components\AppHelper;
use DateTime;
use Exception;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception as Exception2;

/**
* This is the model class for table "sales".
*
* @property string $id
* @property string $idStamp
* @property string $saleDate
* @property string $name
* @property int $price
* @property string $agenCode
* @property string $profileName
* @property string $profileAlias
* @property string $duration
* @property string $ip
* @property string $mac
* @property string $comment
* @property string $sampleName
* @property string $smsSentDate
*/
class Sales extends ActiveRecord
{
    const SOURCE_DB = 1;
    const SOURCE_API = 2;
    const SOURCE_BOTH = 3;
    
    
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
    public static function tableName()
    {
        return 'sales';
    }

    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year', 'month'], 'safe'],
            [['id'], 'required'],
            [['saleDate', 'smsSentDate'], 'safe'],
            [['price'], 'integer'],
            [['id'], 'string', 'max' => 8],
            [['idStamp'], 'string', 'max' => 20],
            [['name', 'agenCode', 'profileName', 'profileAlias', 'duration', 'ip', 'mac'], 'string', 'max' => 45],
            [['comment'], 'string', 'max' => 100],
            [['sampleName'], 'string', 'max' => 500],
            [['id'], 'unique'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'saleDate' => 'Sale Date',
            'name' => 'Name',
            'price' => 'Price',
            'agenCode' => 'Agen Code',
            'profileName' => 'Profile Name',
            'profileAlias' => 'Profile Alias',
            'duration' => 'Duration',
            'ip' => 'Ip',
            'mac' => 'Mac',
            'comment' => 'Comment',
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
     * @throws Exception2
     */
    public static function getSalesWith($agenCode = null, $year = null, $month = null, $source = Sales::SOURCE_BOTH)
    {
        $missingMDR = 'vc-251-08.03.19-MDR-AUG-V2J-x1-q18'; //missing
        //$sales = [];
        
        $allAgenCodes = array_map(function($x) { return $x->agenCode; }, User::getAllAgen());
        
        if (!$year) $year = intval(date('Y'));
        if (!$month) $month = intval(date('m'));
        
        $sales = self::find()
            ->where(['=', 'YEAR(saleDate)', $year])
            ->andWhere(['=', 'MONTH(saleDate)', $month])
            ->andWhere(['in', 'agenCode', $allAgenCodes])
            ->andFilterWhere(['=', 'agenCode', $agenCode])
            ->all();
        
        if ($source >= self::SOURCE_API)
        {
            $api = AppHelper::getApi();
            if ($api)
            {
                //$monthCode = $month ? self::$monthCodes[intval($month)] : strtolower(date('M'));
                //$monthCode .= $year ? $year : date('Y');
                $monthCode = self::$monthCodes[intval($month)].$year;

                //SALEDATE-|-SELLTIME-|-NAME-|-PRICE-|-IP-|-MAC-|-DURATION-|-VCNAME-|-COMMENT
                $query = $api->comm("/system/script/print", [
                    '?comment' => 'mikhmon',
                    '?owner' => $monthCode,
                ]);

                //return $query;

                foreach ($query as $str)
                {
                    $data = explode( '-|-', $str['name']);
                    $commentData = explode('-', $data[8]);

                    $saleDate = DateTime::createFromFormat('M/d/Y', $data[0])->format('Y-m-d').' '.$data[1];
                    $sale = new self([
                        'id' => $str['.id'],
                        'saleDate' => $saleDate,
                        'name' => $data[2],
                        'price' => floatVal($data[3]),
                        'ip' => $data[4],
                        'mac' => $data[5],
                        'duration' => $data[6],
                        'profileName' => $data[7],
                        'profileAlias' => $commentData[0] == 'vc' ? ($commentData[5] ?? '') : '',
                        'agenCode' => $commentData[0] == 'vc' ? ($commentData[3] ?? '') : '',
                        'comment' => $data[8],
                        'sampleName' => $str['name'],
                    ]);

                    if ($agenCode && strpos($sale['comment'], $agenCode) === false) continue;
                    if ($agenCode == 'MDR' && strpos($sale['comment'], $missingMDR) !== false) continue;
                    $sale->idStamp = $sale->name.'-'.strtotime($saleDate);
                    //$ex = self::findOne($sale->id);

                    if ($sale->save())
                    {
                        $api->comm("/system/script/remove", [
                            ".id" => "$sale->id",
                        ]);
                    }

                    if (in_array($sale->agenCode, $allAgenCodes))
                        $sales[] = $sale;
                }
            } else
            {
                throw new Exception('Api not found, please configure your api username and password');
            }
        }
        
        return $sales;
    }
    
    public function getAgen()
    {
        return $this->hasOne(User::class, ['agenCode' => 'agenCode']);
    }
    
}
