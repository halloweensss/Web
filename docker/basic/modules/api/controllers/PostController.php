<?php
namespace app\modules\api\controllers;


use app\components\InstagramHelper;
use app\models\InstagramAccount;
use app\models\InstagramFollow;
use app\models\User;
use PHPMailer\PHPMailer\PHPMailer;
use yii\rest\Controller;

class PostController extends BaseController
{
    public function verbs()
    {
        return [
            'get' => ['POST', 'OPTIONS']
        ];
    }

    public function actionGet(){
        $data =\Yii::$app->getRequest()->getBodyParams();
        $loginData = \Yii::$app->request->getBodyParams();
        $model = new User();
        $model->load($loginData, '');
        $accessToken = $model->accessToken;
        $user = null;
        if($accessToken != '' && $accessToken != null) {
            $user = User::findIdentityByAccessToken($accessToken);
            if($user == null)
                return['status'=>'tokenInvalid'];
        }
        $follows = InstagramFollow::getFollowsUser($user->id);
        $names = [];
        foreach ($follows as $follow){
            $names[] = InstagramAccount::getInstagramAccountById($follow->instagramId)['name'];
        }
        $instHelper = new InstagramHelper();
        return $instHelper->getPostsFromFollowers($names);
    }
}