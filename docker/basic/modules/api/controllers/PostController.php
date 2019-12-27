<?php
namespace app\modules\api\controllers;


use app\components\InstagramHelper;
use app\models\User;
use yii\rest\Controller;

class PostController extends BaseController
{
    public function verbs()
    {
        return [
            'get' => ['GET', 'OPTIONS']
        ];
    }

    public function actionGet(){
        $data =\Yii::$app->getRequest()->getBodyParams();
        return InstagramHelper::getPosts("wylsacom", null);
    }
}