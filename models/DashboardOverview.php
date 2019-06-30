<?php
namespace app\models;

use Yii;
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
class DashboardOverview extends Model
{
    
    public $agenCode;
    public $year;
    public $month;
    
    public $thisMonthSale = 0;
    public $thisMonthSaleCount = 0;
    public $thisDaySale = 0;
    public $thisDaySaleCount = 0;
    
    public $bonus = 0;
    public $bonusAdjustment = 0;
    
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
    
    public function getSales()
    {
        $sales = Sales::getSalesWith($this->agenCode, $this->year, $this->month, Sales::SOURCE_BOTH);
        Yii::trace($sales, 'WKWK');
        foreach($sales as $sale)
        {
            $this->thisMonthSale += $sale['price'];
            $this->thisMonthSaleCount++;
            if (date('Y-m-d') == $sale['saleDate'])
            {
                $this->thisDaySale += $sale['price'];
                $this->thisDaySaleCount++;
            }
        }
        
        if ($this->thisMonthSale > 200000) $this->bonus = 8.0;
        if ($this->thisMonthSale > 300000) $this->bonus = 10.0;
        if ($this->thisMonthSale > 500000) $this->bonus = 15.0;
        
        return $sales;
    }
}
