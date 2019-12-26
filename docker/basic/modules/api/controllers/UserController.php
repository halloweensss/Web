<?php
namespace app\modules\api\controllers;


use app\models\User;
use yii\rest\Controller;

class UserController extends BaseController
{

    public function verbs()
    {
        return [
            'add', 'login', 'update' => ['POST', 'OPTIONS'],
            'get','getAll' => ['GET']
        ];
    }

    public function actionAdd()
    {
        $data =\Yii::$app->getRequest()->getBodyParams();
        if($data==null)
            return ['status'=>'empty'];

        $accessToken = $data['accessToken'];
        if($accessToken != '' && $accessToken != null){
            $user = User::findIdentityByAccessToken($accessToken);
            if($user!=null) {
                return ['status' => 'tokenExists',
                        'accessToken'=>$user->accessToken];
            }
        }
        $email = $data['email'];
        if($email != '' && $email != null){
            $user = User::findByEmail($email);
            if($user!=null){
                return['status'=>'userExists'];
            }
        }
        $user = new User();
        $user->login = $data['login'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        if(!$user->save())
            return ['status'=>'userNotCreated'];

        return ['status'=>'userCreated',
                'accessToken' => $user->getAccessToken()];
    }

    public function actionLogin()
    {
        $loginData = \Yii::$app->getRequest()->getBodyParams();
        if($loginData==null)
            return ['status'=>'empty'];
        $accessToken = $loginData['accessToken'];
        if($accessToken != '' && $accessToken != null){
            $user = User::findIdentityByAccessToken($accessToken);
            if($user!=null) {
                return ['status' => 'tokenExists',
                    'accessToken'=>$user->accessToken];
            }
        }
        $email = $loginData['email'];
        if($email != '' && $email != null){
            $user = User::findByEmail($email);
            if($user==null){
                return['status'=>'userNotCreated'];
            }
        }
        $user = User::findByEmail($email);
        $password = $loginData['password'];
        if(!$user->validatePassword($password))
        {
            return['status'=>'passwordIncorrect'];
        }
        $user->updateToken();
        $user->update();
        return['status'=>'success',
                'accessToken' => $user->accessToken];
    }

    public function actionGet()
    {
        $data =\Yii::$app->getRequest()->get();
        return User::findByEmail($data['email']);
    }

    public function actionGetAll()
    {
        return User::getAll();
    }

    public function actionUpdate(){
        $data = \Yii::$app->getRequest()->getBodyParams();
        if($data==null)
            return ['status'=>'empty'];
        $accessToken = $data['accessToken'];
        $user = null;
        if($accessToken != '' && $accessToken != null){
            $user = User::findIdentityByAccessToken($accessToken);
            if($user==null) {
                return ['status' => 'failed'];
            }
        }
        $user->login = $data['login'];
        $user->password = $data['password'];
        //Добавить обновление аватарки
        if(!$user->save())
            return ['status' => 'failed'];
        return ['status' => 'success'];
    }
}