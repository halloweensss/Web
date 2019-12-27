<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $login
 * @property string $email
 * @property string $password
 * @property string $accessToken
 * @property string $authKey
 * @property string $createdAt
 * @property string|null $updateAt
 * @property string|null $avatarImage
 *
 * @property InstagramFollow[] $instagramFollows
 * @property TelegramFollow[] $telegramFollows
 */
class User extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'email', 'password'], 'required'],
            [['createdAt', 'updateAt'], 'safe'],
            [['avatarImage'], 'string'],
            [['login'], 'string', 'max' => 20],
            [['email', 'password'], 'string', 'max' => 60],
            [['accessToken', 'authKey'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'email' => 'Email',
            'password' => 'Password',
            'accessToken' => 'Access Token',
            'authKey' => 'Auth Key',
            'createdAt' => 'Created At',
            'updateAt' => 'Update At',
            'avatarImage' => 'Avatar Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTelegramFollows()
    {
        return $this->hasMany(TelegramFollow::className(), ['userId' => 'id']);
    }

    public function getInstagramFollowById($id){
        return $this->hasMany(InstagramFollow::className(), ['userId' => 'id'])->where(['=','instagramId', $id])->all();
    }

    public function validateAuthKey($authKey)
    {
        $this->authKey===$authKey;
    }

    public function updateToken()
    {
        $this->accessToken = Yii::$app->security->generateRandomString();
    }

    public function setPassword($password){
        $this->password = $password;
       $this->password = Yii::$app->security->generatePasswordHash($this->password);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken'=>$token]);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email'=>$email]);
    }

    public static function getAll(){
        return User::find()->all();
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getId()
    {
        return $this->id;
    }

    public function beforeSave($insert)
    {
        if(!parent::beforeSave($insert)){
            return false;
        }

        if($insert){
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            $this->accessToken = Yii::$app->security->generateRandomString();
            $this->authKey = Yii::$app->security->generateRandomString();
        }
        return true;
    }
}
