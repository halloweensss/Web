<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "instagramFollows".
 *
 * @property int $userId
 * @property int $instagramId
 * @property string $createdAt
 *
 * @property User $user
 * @property InstagramAccount $instagram
 */
class InstagramFollow extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'instagramFollows';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'instagramId'], 'required'],
            [['userId', 'instagramId'], 'integer'],
            [['createdAt'], 'safe'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
            [['instagramId'], 'exist', 'skipOnError' => true, 'targetClass' => InstagramAccount::className(), 'targetAttribute' => ['instagramId' => 'id']],
        ];
    }

    public static function primaryKey()
    {
        return [
            'userId',
            'instagramId',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'instagramId' => 'Instagram ID',
            'createdAt' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    public function getInstagramId(){
        return $this->instagramId;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstagram()
    {
        return $this->hasOne(InstagramAccount::className(), ['id' => 'instagramId']);
    }

    /**
     * @param $id
     * @return InstagramFollow[]
     */
    public static function getFollowsUser($id){
        $followers = InstagramFollow::findAll(['userId'=>$id]);
        return $followers;
    }

    /**
     * @param $idUser
     * @param $idInts
     * @return InstagramFollow|null
     */
    public static function getFollowsUserAndInstId($idUser, $idInts){
        $follower = InstagramFollow::findOne(['userId'=>$idUser, 'instagramId'=>$idInts]);
        return $follower;
    }
}
