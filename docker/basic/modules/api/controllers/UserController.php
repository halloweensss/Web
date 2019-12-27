<?php
namespace app\modules\api\controllers;


use app\components\ImageHelper;
use app\components\InstagramHelper;
use app\models\InstagramAccount;
use app\models\InstagramFollow;
use app\models\User;
use yii\rest\Controller;
use yii\web\UploadedFile;

class UserController extends BaseController
{

    public function verbs()
    {
        return [
            'add', 'login', 'update','getFollowersExist','getFollowersNotExist','follow','unfollow','instget', 'getProfile' => ['POST', 'OPTIONS'],
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

    public function actionGetProfile(){
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
        $item = [
            'username' => $user->login,
            'avatarUrl' => $user->avatarImage
        ];
        return['status'=>'success',
            'user' => $item];
    }
    public function actionLogin()
    {
        $loginData = \Yii::$app->request->getBodyParams();
        $model = new User();
        $model->load($loginData, '');

        $accessToken = $model->accessToken;
        if($accessToken != '' && $accessToken != null){
            $user = User::findIdentityByAccessToken($accessToken);

            if($user!=null) {

                return ['status' => 'tokenExists',
                    'accessToken'=>$user->accessToken];
            }
        }
        $email = $model->email;
        if($email != '' && $email != null){
            $user = User::findByEmail($email);
            if($user==null){
                return['status'=>'userNotCreated'];
            }
        }
        $user = User::findByEmail($email);
        $password = $model->password;
        if($user != null) {
            if (!$user->validatePassword($password)) {
                return ['status' => 'passwordIncorrect'];
            }
        }else{
            return['status'=>'userNotCreated'];
        }

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

    public function actionUpdate()
    {
        $loginData = \Yii::$app->request->getBodyParams();
        if($loginData==null)
            return ['status'=>'empty'];
        $model = new User();
        $model->load($loginData, '');

        $accessToken = $model->accessToken;
        $user = null;
        if($accessToken != '' && $accessToken != null){
            $user = User::findIdentityByAccessToken($accessToken);
            if($user==null) {
                return ['status' => 'invalidToken'];
            }
        }
        $user->login = $model->login;
        if($model->password != null) {
            $user->setPassword($model->password);
        }
        //TODO: добавить аватарку
        if(!$user->save())
            return ['status' => 'failed'];
        return ['status' => 'success'];
    }

    public function actionGetFollowersExist()
    {
        $data = \Yii::$app->getRequest()->getBodyParams();
        if($data==null)
            return ['status'=>'empty'];
        $accessToken = $data['accessToken'];
        $user = null;
        if($accessToken != '' && $accessToken != null){
            $user = User::findIdentityByAccessToken($accessToken);
            if($user==null) {
                return ['status' => 'failedToken'];
            }
        }
        $accountsInst = InstagramFollow::getFollowsUser($user->getId());

        if($accountsInst==null)
            return ['status' => 'null'];
        $users = [];
        foreach ($accountsInst as $acc){
            $user = InstagramAccount::getInstagramAccountById($acc->getInstagramId());
            $item =[
                'id'=>$user->id,
                'username'=>$user->name,
                'serviceName'=>"instagram",
                'follow'=>true,
                'profileUrl'=>"https://www.instagram.com/".$user->name."/"
            ];
            $users[] = $item;
        }

        return $users;
    }

    public function actionFollow()
    {
        $data = \Yii::$app->getRequest()->getBodyParams();
        if($data==null)
            return ['status'=>'empty'];
        $accessToken = $data['accessToken'];
        $user = null;
        if($accessToken != '' && $accessToken != null){
            $user = User::findIdentityByAccessToken($accessToken);
            if($user==null) {
                return ['status' => 'failedToken'];
            }
        }
        $service = $data['serviceName'];
        if($service == 'instagram'){
            $name = $data['username'];
            $instUser = InstagramHelper::getAccountByName($name);
            if($instUser == null){
                return ['status' => 'userNotFound'];
            }
            $id = $instUser['id'];
            $instAcc = InstagramAccount::getInstagramAccountById($id);
            if($instAcc == null){
                $instAcc = new InstagramAccount();
                $instAcc->id = $id;
                $instAcc->name = $instUser['username'];
                $instAcc->src = $instUser['profileUrl'];
                if(!$instAcc->save())
                    return ['status' => 'instagramAccountNotCreated'];
            }
            $follows = $user->getInstagramFollowById($id);
            if($follows == null){
                $follows = new InstagramFollow();
                $follows->userId = $user->id;
                $follows->instagramId = $instAcc->id;
                if(!$follows->save())
                    return ['status' => 'failedToFollow'];
            }
        }else{
            return ['status' => 'notInstagram'];
        }
        return ['status' => 'success'];
    }

    public function actionUnfollow()
    {
        $data = \Yii::$app->getRequest()->getBodyParams();
        if ($data == null)
            return ['status' => 'empty'];
        $accessToken = $data['accessToken'];
        $user = null;
        if ($accessToken != '' && $accessToken != null) {
            $user = User::findIdentityByAccessToken($accessToken);
            if ($user == null) {
                return ['status' => 'failedToken'];
            }
        }
        $service = $data['serviceName'];
        if ($service == 'instagram') {
            $id = $data['id'];
            $follow = InstagramFollow::getFollowsUserAndInstId($user->id, $id);
            if($follow == null)
                return ['status' => 'failedDelete'];
            $follow->delete();
        }

        return ['status' => 'success'];
    }

    public function actionGetFollowersNotExist()
    {
        $data = \Yii::$app->getRequest()->getBodyParams();
        if($data==null)
            return ['status'=>'empty'];
        $accessToken = $data['accessToken'];
        $user = null;
        if($accessToken != '' && $accessToken != null){
            $user = User::findIdentityByAccessToken($accessToken);
            if($user==null) {
                return ['status' => 'failedToken'];
            }
        }
        $name = $data['name'];
        $accounts = InstagramHelper::getAccountsByName($name);
        $result = [];
        foreach ($accounts as $account){
            $flag = false;
            if($user->getInstagramFollowById($account['id'])!=null)
                $flag = true;
            $item =[
                'id'=>$account['id'],
                'username'=>$account['username'],
                'serviceName'=>"instagram",
                'follow'=>$flag,
                'profileUrl'=>$account['profileUrl']
            ];
            $result[] = $item;
        }
        return $result;
    }
    //TODO:Удалить
    public function actionInstget(){
        $data = \Yii::$app->getRequest()->getBodyParams();
        $id = $data['username'];
        $instUser = InstagramHelper::getAccountByName($id);
        return $instUser;
    }

}