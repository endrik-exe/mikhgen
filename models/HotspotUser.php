<?php
namespace app\models;

use app\components\AppHelper;
use Exception;
use Yii;
use yii\base\Model;
use function str_replaces;

/**
 * User model
 *
 * @property string $userName
 * @property string $password
 * @property string $comment
 * @property string $profileId
 * @property string $profileName
 * @property string $profileAlias
 * @property integer $price
 * @property string $uptime
 */
class HotspotUser extends Model
{
    public $userName;
    public $password;
    public $comment;
    
    public $profileId;
    public $profileName;
    public $profileAlias;
    public $price;
    public $uptime;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userName', 'password', 'comment', 'profileId', 'profileName'], 'string'],
            [['price'], 'integer'],
            [['uptime'], 'safe'],
        ];
    }
    
    public function getPrimaryKey()
    {
        return $this->userName;
    }
    
    public static function getVoucher($whereId = null)
    {
        $api = AppHelper::getApi();
        if ($api)
        {
            $query = $api->comm("/ip/hotspot/user/profile/print");

            $vouchers = [];
            foreach ($query as $data)
            {
                if ($whereId && $data['.id'] != $whereId) continue;
                
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
                    'id' => $data['.id'],
                    'name' => $data['name'],
                    'alias' => $alias,
                    'price' => $price,
                    'uptime' => $uptime,
                    'gracePeriod' => $gracePeriod,
                    'sharedUsers' => $data['shared-users'],
                    'rateLimit' => $data['rate-limit'] ?? '' ,
                ]);
                
                if ($whereId) return $vc;
                
                $vouchers[] = $vc;
            }
            return $vouchers;
        }
        else
        {
            throw new Exception('Api not found, please configure your api username and password');
        }
    }
    
    public function save()
    {
        $api = AppHelper::getApi();
        if (!$api) throw new Exception("Api not found, please configure your api username and password");
        
        $old = $api->comm("/ip/hotspot/user/profile/print", [
            '?.id' => $this->id
        ]);
        
        $command = "/ip/hotspot/user/profile/".($old ? 'set' : 'add');
        $onlogin = minifyRos(str_replaces(file_get_contents(Yii::getAlias('@app/ros/onlogin.ros')), [
            '{{VC_ALIAS}}' => $this->alias,
            '{{PRICE}}' => $this->price,
            '{{UPTIME}}' => $this->uptime,
            '{{GRACE_PERIOD}}' => $this->gracePeriod,
        ]));
        
        $comm = $api->comm($command, \yii\helpers\ArrayHelper::merge(
            !$old ? [] : 
            [
                '.id' => $this->id,
            ], [
                'name' => $this->name,
                'shared-users' => $this->sharedUsers,
                'rate-limit' => $this->rateLimit,
                'add-mac-cookie' => $this->addMacCookie,
                'on-login' => $onlogin
            ])
        );
        
        return true;
    }
}
