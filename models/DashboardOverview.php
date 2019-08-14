<?php
namespace app\models;

use app\components\AppHelper;
use Exception;
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
    public $thisDaySaleAmount = 0;
    public $thisDaySaleCount = 0;
    public $thisDaySales = [];
    
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
        try {
            $sales = Sales::getSalesWith($this->agenCode, $this->year, $this->month, Sales::SOURCE_BOTH);
        } catch (Exception $ex) {
            $this->addError(null, $ex->getMessage());
            return [];
        }
        
        foreach($sales as $sale)
        {
            $this->thisMonthSale += $sale['price'];
            $this->thisMonthSaleCount++;
            if (date('Y-m-d') == $sale['saleDate'])
            {
                $commentData = explode('-', $sale['comment']);
                
                $this->thisDaySales[] = \yii\helpers\ArrayHelper::merge($sale, [
                    'agenCode' => $commentData[0] == 'vc' ? ($commentData[3] ?? '') : '',
                    'profileAlias' => $commentData[0] == 'vc' ? ($commentData[5] ?? '') : '',
                ]);
                
                $this->thisDaySaleAmount += $sale['price'];
                $this->thisDaySaleCount++;
            }
        }
        
        if ($this->thisMonthSale > 200000) $this->bonus = 8.0;
        if ($this->thisMonthSale > 300000) $this->bonus = 10.0;
        if ($this->thisMonthSale > 500000) $this->bonus = 15.0;
        
        return $sales;
    }
    
    private $_activeUsers = [];
    public function getActiveUsers()
    {
        if ($this->_activeUsers) return $this->_activeUsers;
        
        $api = AppHelper::getApi();
        if ($api)
        {
            $query = $api->comm("/ip/hotspot/active/print");
            //return $query;
            $result = [];
            foreach ($query as $data)
            {
                $comment = $data['comment'] ?? '';
                
                if ($this->agenCode && strpos($comment, $this->agenCode) === false) continue;
                
                $commentData = explode('-', $comment);
                
                $result[] = [
                    'user' => $data['user'],
                    'uptime' => $data['uptime'],
                    'agenCode' => $commentData[0] == 'vc' ? ($commentData[3] ?? '') : '',
                    'profileAlias' => $commentData[0] == 'vc' ? ($commentData[5] ?? '') : '',
                ];
            }
            
            $this->_activeUsers = $result;
            return $result;
        } else
        {
            $this->addError(null, 'Api not found, please configure your api username and password');
            return [];
        }
    }
    
}
