<?php
namespace app\controllers;

use app\controllers\MainController;
use app\models\HotspotUser;
use app\models\Template;
use app\models\User;
use Yii;
use function referrer;

/**
 * Site controller
 */
class TemplateManagerController extends MainController
{
    /**
     * Displays list.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        //return $this->asJson(Template::getTemplates());
        
        return $this->render('index', [
            
        ]);
    }

    
    public function actionUpdate($id)
    {
        $model = Template::getTemplate($id);
        
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                return $this->redirect(referrer());
            }
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
