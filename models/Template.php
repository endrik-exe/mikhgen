<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;

/**
 * User model
 *
 * @property string $userName
 */
class Template extends Model
{
    public $name;
    public $modifiedDate;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userName', 'modifedDate'], 'string'],
        ];
    }
    
    public function getPrimaryKey()
    {
        return $this->name;
    }
    
    public static function getTemplates()
    {
        $dirs = FileHelper::findDirectories(Yii::getAlias('@template'));
        
        $templates = [];
        foreach ($dirs as $dir)
        {
            $stat = stat($dir);
            
            $templates[] = new Template([
                'name' => basename($dir),
                'modifiedDate' => date('Y-m-d', $stat['mtime']),
            ]);
        }
        
        return $templates;
    }
}
