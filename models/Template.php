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
    public $source;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userName', 'modifedDate', 'source'], 'string'],
        ];
    }
    
    public function getPrimaryKey()
    {
        return $this->name;
    }
    
    public static function getTemplate($getName = null)
    {
        $dirs = FileHelper::findDirectories(Yii::getAlias('@template'));
        
        $templates = [];
        foreach ($dirs as $dir)
        {
            $name = basename($dir);
            
            if ($getName && $name != $getName) continue;
            
            $stat = stat($dir);
            
            $template = new Template([
                'name' => $name,
                'modifiedDate' => date('Y-m-d', $stat['mtime']),
                'source' => file_get_contents("$dir/index.php"),
            ]);
            
            if ($getName) return $template;
            
            $templates[] = $template;
        }
        
        return $templates;
    }
}
