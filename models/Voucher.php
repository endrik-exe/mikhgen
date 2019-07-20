<?php
namespace app\models;

use app\components\AppHelper;
use \DateTime;
use yii\base\Model;

/**
 * User model
 *
 * @property string $name
 * @property string $uptime
 * @property string $gracePeriod
 * @property integer $sharedUsers
 * @property integer $price
 * @property string $rateLimit
 */
class Voucher extends Model
{
    public $name;
    public $alias;
    public $uptime;
    public $gracePeriod;
    public $sharedUsers;
    public $price;
    public $rateLimit;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name',], 'string', 'max' => 45],
            [['sharedUsers', 'price'], 'integer'],
            [['uptime', 'gracePeriod', 'rateLimit'], 'safe'],
        ];
    }
    
    public function getPrimaryKey()
    {
        return $this->name;
    }
    
    public static function getVoucher($name = null)
    {
        $api = AppHelper::getApi();
        if ($api)
        {
            $query = $api->comm("/ip/hotspot/user/profile/print");
            
            
            //return $query;
            
            $vouchers = [];
            foreach ($query as $data)
            {
                if ($name && $data['name'] != $name) continue;
                
                $alias = null;
                $price = 0;
                $uptime = null;
                $gracePeriod = null;
                if (isset($data['on-login']) && strpos($data['on-login'], ':put ("') === 0)
                {
                    $puts = explode(', ', substr($data['on-login'], 7, strpos($data['on-login'], '");') - 7));
                    
                    if (count($puts) != 4) continue;
                    
                    $alias = $puts[0];
                    $price = $puts[1];
                    $uptime = $puts[2];
                    $gracePeriod = $puts[3];
                }
                
                if (!$alias) continue;
                
                $vc = new Voucher([
                    'name' => $data['name'],
                    'alias' => $alias,
                    'price' => $price,
                    'uptime' => $uptime,
                    'gracePeriod' => $gracePeriod,
                    'sharedUsers' => $data['shared-users'],
                    'rateLimit' => $data['rate-limit'] ?? '' ,
                ]);
                
                if ($name) return $vc;
                
                $vouchers[] = $vc;
            }
            return $vouchers;
        }
        else
        {
            throw new \Exception('Api not found, please configure your api username and password');
        }
    }
}
