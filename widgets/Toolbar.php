<?php
namespace app\widgets;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use function currentRef;


class Toolbar extends Widget
{
    public $model = null;
    public $buttons = [];
    public $customTools = [];
    
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $defaultTool = [
            'create' => function($model){
                return Html::a('<i class="plus icon"></i>', ['create', 'referrer' => currentRef()], [
                    'class' => 'ui right floated mini primary icon button'
                ]);
            },
            'filter' => function($model){
                return Html::a('<i class="filter icon"></i>', ['filter', 'referrer' => currentRef()], [
                    'class' => 'ui right floated mini icon button'
                ]);
            }
        ];
        
        $tools = ArrayHelper::merge($defaultTool, $this->customTools);
        
        foreach ($this->buttons as $button)
        {
            if (array_key_exists($button, $tools))
            {
                echo $tools[$button]($this->model);
            }
        }
    }
}
