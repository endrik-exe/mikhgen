<?php
namespace app\models;

use app\components\AppHelper;
use Exception;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use const DELIMITER;

/**
 * User model
 *
 * @property string $id
 * @property string $server
 * @property string $name
 * @property string profileId
 * @property string profileName
 * @property string $password
 * @property string $comment
 * @property string $agenCode
 */
class HotspotUser extends Model
{
    public $id;
    public $server;
    public $name;
    public $password;
    public $profileId;
    public $profileName;
    public $comment;
    public $agenCode;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'server', 'name', 'password', 'profileId', 'profileName', 'comment', 'agenCode'], 'string']
        ];
    }
    
    public function getPrimaryKey()
    {
        return $this->id;
    }
    
    private $cacheProfile;
    public function getProfile()
    {
        if (!$this->cacheProfile)
        {
            $profiles = Voucher::getVoucher();
            $profileName = $this->profileName;
            $index = -1;
            if (array_find($profiles, $index, function($x) use ($profileName){
                return $x->name == $profileName;
            }))
            {
                $this->cacheProfile = $profiles[$index];
            }
        }
        
        return $this->cacheProfile;
    }
    
    static $queryCache = null;
    public static function getUsers($filter = [])
    {
        $api = AppHelper::getApi();
        if ($api)
        {
            if (count($filter) == 0)
            {
                if (!self::$queryCache) self::$queryCache = $api->comm("/ip/hotspot/user/print", $filter);
                
                $query = self::$queryCache;
            } else
            {
                $query = $api->comm("/ip/hotspot/user/print", $filter);
            }
            

            //return $query;
            
            $users = [];
            foreach ($query as $data)
            {
                $comment = $data['comment'] ?? '';
                $commentData = null;
                if (strpos($comment, 'vc.|.') === 0)
                    $commentData = explode(DELIMITER, $comment);
                
                $user = new self([
                    'id' => $data['.id'],
                    'server' => $data['server'] ?? '',
                    'name' => $data['name'],
                    'password' => $data['password'] ?? '',
                    'profileName' => $data['profile'] ?? '',
                    'comment' => $data['comment'] ?? '',
                    'agenCode' => $commentData ? $commentData[1] : '',
                ]);
                $user->getProfile();
                
                
                $users[] = $user;
            }
            
            return $users;
        }
        else
        {
            throw new Exception('Api not found, please configure your api username and password');
        }
    }
    
    public static function getList($filter = [])
    {
        return self::getUsers($filter);
    }
    
    public function search()
    {
        $filter = $this;
        $filterQuery = [
            '?limit-uptime' => '1s',
            '_' => '?#!'
        ];
        
        return array_filter(self::getUsers($filterQuery), function($x) use ($filter) {
            return (!$filter->name || strpos($x->name, $filter->name) !== false)
                && (!$filter->profileName || strpos($x->profileName, $filter->profileName) !== false)
                && (!$filter->comment || strpos($x->comment, $filter->comment) !== false)
                && (!$filter->agenCode || strpos($x->agenCode, $filter->agenCode) !== false);
        });
    }
    
    public function save()
    {
        $api = AppHelper::getApi();
        if (!$api) throw new Exception("Api not found, please configure your api username and password");
        
        $old = $api->comm("/ip/hotspot/user/print", [
            '?.id' => $this->id
        ]);
        
        $command = "/ip/hotspot/user/".($old ? 'set' : 'add');
        
        $attributes = [
            'name' => $this->name,
            'password' => $this->password,
        ];
        
        if ($this->server) $attributes['server'] = $this->server;
        if ($this->profileName) $attributes['profile'] = $this->profileName;
        if ($this->comment) $attributes['comment'] = $this->comment;
        
        $comm = $api->comm($command,
            ArrayHelper::merge(!$old ? [] : [ '.id' => $this->id ], $attributes));
        
        return true;
    }
}
