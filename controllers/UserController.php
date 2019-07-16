<?php
namespace app\controllers;

use app\controllers\MainController;
use app\models\User;

/**
 * Site controller
 */
class UserController extends MainController
{
    /**
     * Displays list.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new User();
        
        return $this->render('index', [
            'model' => $model,
        ]);
    }
    
    
}
