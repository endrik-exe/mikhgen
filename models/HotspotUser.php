<?php
namespace app\models;

use app\components\AppHelper;
use Exception;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use const DELIMITER;

/**
 * User model
 *
 * @property string $id
 * @property string $server
 * @property string $name
 * @property string profile
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
    public $profile;
    public $comment;
    public $agenCode;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'server', 'name', 'password', 'profile', 'comment', 'agenCode'], 'string']
        ];
    }
    
    public function getPrimaryKey()
    {
        return $this->userName;
    }
    
    public static function getUsers($filter = [])
    {
        $api = AppHelper::getApi();
        if ($api)
        {
            $query = $api->comm("/ip/hotspot/user/print", $filter);

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
                    'profile' => $data['profile'] ?? '',
                    'comment' => $data['comment'] ?? '',
                    'agenCode' => $commentData ? $commentData[1] : '',
                ]);
                
                
                $users[] = $user;
            }
            
            return $users;
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
        
        $old = $api->comm("/ip/hotspot/user/print", [
            '?.id' => $this->id
        ]);
        
        $command = "/ip/hotspot/user/".($old ? 'set' : 'add');
        
        $attributes = [
            'name' => $this->name,
            'password' => $this->password,
        ];
        
        if ($this->server) $attributes['server'] = $this->server;
        if ($this->profile) $attributes['profile'] = $this->profile;
        if ($this->comment) $attributes['comment'] = $this->comment;
        
        $comm = $api->comm($command,
            ArrayHelper::merge(!$old ? [] : [ '.id' => $this->id ], $attributes));
        
        return true;
    }
}
