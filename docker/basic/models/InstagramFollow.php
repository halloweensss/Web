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
class InstagramFollow extends \yii\db\ActiveRecord
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
            [['userId', 'instagramId', 'createdAt'], 'required'],
            [['userId', 'instagramId'], 'integer'],
            [['createdAt'], 'safe'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
            [['instagramId'], 'exist', 'skipOnError' => true, 'targetClass' => InstagramAccount::className(), 'targetAttribute' => ['instagramId' => 'id']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstagram()
    {
        return $this->hasOne(InstagramAccount::className(), ['id' => 'instagramId']);
    }
}
