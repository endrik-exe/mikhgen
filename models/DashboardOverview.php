<?php
namespace app\models;

use app\components\AppHelper;
use Exception;
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
    public $day;
    
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
            [['year', 'month', 'day'], 'integer'],
        ];
    }
    
    private static $sales = null;
    public function getSales()
    {
        if (!self::$sales)
        {
            try {
                self::$sales = Sales::getSalesWith($this->agenCode, $this->year, $this->month, $this->day, Sales::SOURCE_BOTH);
            } catch (Exception $ex) {
                $this->addError(null, $ex->getMessage());
                return null;
            }
        }
        
        $theYear = date('Y-m-d', strtotime(date('Y')));
        $theMonth = date('m');
        
        $today = ($this->day ? ($this->year ? $this->year : $theYear) : $theYear)
                .'-'.($this->day ? ($this->month ? $this->month : $theMonth) : $theMonth)
                .'-'.($this->day ? $this->day : date('d'));
        
        $today = date('Y-m-d', strtotime($today));
        
        Yii::trace($today, 'WKWK');
        
        foreach(self::$sales as $sale)
        {
            $this->thisMonthSale += $sale['price'];
            $this->thisMonthSaleCount++;
            if ($today == date('Y-m-d', strtotime($sale['saleDate'])))
            {
                //$commentData = explode('-', $sale['comment']);
                
                $this->thisDaySales[] = $sale;
                
                $this->thisDaySaleAmount += $sale['price'];
                $this->thisDaySaleCount++;
            }
        }
        
        if ($this->thisMonthSale > 200000) $this->bonus = 8.0;
        if ($this->thisMonthSale > 300000) $this->bonus = 10.0;
        if ($this->thisMonthSale > 500000) $this->bonus = 15.0;
        
        return self::$sales;
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
                $comment = $data['comment'] ?? null;
                
                if ($this->agenCode && strpos($comment, $this->agenCode) === false) continue;
                
                $agenCode = null;
                $profileAlias = null;
                if (strpos($comment, 'vc.|.') === 0)
                {
                    $commentData = explode('.|.', $comment);
                    
                    $agenCode = $commentData[1] ?? '';
                    $profileAlias = $commentData[2] ?? '';
                } else if (strpos($comment, 'vc-') === 0)
                {
                    $commentData = explode('-', $comment);
                    
                    $agenCode = $commentData[3] ?? '';
                    $profileAlias = $commentData[5] ?? '';
                }
                
                
                $result[] = [
                    'user' => $data['user'],
                    'uptime' => $data['uptime'],
                    'agenCode' => $agenCode,
                    'profileAlias' => $profileAlias,
                    'comment' => $comment
                ];
            }
            
            usort($result, function($a, $b) { return -1 * strcmp($a['agenCode'], $b['agenCode']); });
            $this->_activeUsers = $result;
            return $result;
        } else
        {
            $this->addError(null, 'Api not found, please configure your api username and password');
            return [];
        }
    }
    
    public function getDayList()
    {
        if (!$this->year || !$this->month) return [];
        
        $lastDay = intval(date('t', strtotime("$this->year-$this->month-1")));
        
        $result = [];
        for ($d = 1; $d <= $lastDay; $d++)
        {
            $dd = str_pad($d, 2, '0', STR_PAD_LEFT);
            $result[$d] = $dd;
        }
        
        return $result;
    }
}
