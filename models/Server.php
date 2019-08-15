<?php
namespace app\models;

use app\components\AppHelper;
use Exception;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use function minifyRos;
use function str_replaces;

/**
 * User model
 *
 * @property integer $id
 * @property string $name
 */
class Server extends Model
{
    public $id;
    public $name;

    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['id'], 'integer'],
        ];
    }
    
    public function getPrimaryKey()
    {
        return $this->name;
    }
    
    static $cacheGet = null;
    public static function getServer($whereId = null)
    {
        $api = AppHelper::getApi();
        if ($api)
        {
            if (!self::$cacheGet) self::$cacheGet = $api->comm("/ip/hotspot/print");
            $query = self::$cacheGet;
            
            $servers = [];
            foreach ($query as $data)
            {
                if ($whereId && $data['.id'] != $whereId) continue;
                
                $server = new self([
                    'id' => $data['.id'],
                    'name' => $data['name']
                ]);
                
                if ($whereId) return $server;
                
                $servers[] = $server;
            }
            return $servers;
        }
        else
        {
            throw new Exception('Api not found, please configure your api username and password');
        }
    }
    
    public function save()
    {
        // N O T  I M P L E M E N T E D
        return false;
    }
    
    public static function getDropdownList($mapTo = 'name')
    {
        $models = self::getServer();
        
        return ArrayHelper::map($models, 'name', $mapTo);
    }
}
