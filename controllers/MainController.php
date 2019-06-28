<?php
namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class MainController extends Controller
{
    public $allowGuest = false;
    
    public function beforeAction($action) {
        if (!parent::beforeAction($action))
        {
            return false;
        }
        
        if ($this->allowGuest) return true;
        
        if (!Yii::$app->user->identity)
        {
            if ($action->id == 'login') return true;
            
            if (Yii::$app->request->isAjax)
            {
                $url = Url::to(['site/login']);
                Yii::$app->response->content = "SUDAH TIDAK LOGIN, AKAN ME REDIRECT DALAM <span class='redirectcountdown'>3</span> DETIK
                    <script>
                    var recursiveCall = function(count)
                    {
                        setTimeout(function() {
                            document.getElementsByClassName('redirectcountdown')[0].innerText = count.toString();
                            if (count > 0) recursiveCall(--count);
                        }, 1000);
                    };
                    
                    recursiveCall(2);
                    
                    setTimeout(function(){
                        window.location = '$url';
                    }, 3000);
                    </script>
                    ";
                Yii::$app->response->send();
                return false;
            }
            
            $this->redirect(['site/login']);
            return false;
        }
        
        return true;
    }
}