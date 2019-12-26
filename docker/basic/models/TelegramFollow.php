<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "telegramFollows".
 *
 * @property int $userId
 * @property int $telegramId
 * @property string $createdAt
 *
 * @property User $user
 * @property TelegramAccount $telegram
 */
class TelegramFollow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegramFollows';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'telegramId', 'createdAt'], 'required'],
            [['userId', 'telegramId'], 'integer'],
            [['createdAt'], 'safe'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
            [['telegramId'], 'exist', 'skipOnError' => true, 'targetClass' => TelegramAccount::className(), 'targetAttribute' => ['telegramId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'telegramId' => 'Telegram ID',
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
    public function getTelegram()
    {
        return $this->hasOne(TelegramAccount::className(), ['id' => 'telegramId']);
    }
}
