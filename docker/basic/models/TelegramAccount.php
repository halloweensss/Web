<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "telegramAccounts".
 *
 * @property int $id
 * @property string $name
 * @property string $src
 *
 * @property TelegramFollow[] $telegramFollows
 */
class TelegramAccount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegramAccounts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'src'], 'required'],
            [['name', 'src'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'src' => 'Src',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTelegramFollows()
    {
        return $this->hasMany(TelegramFollow::className(), ['telegramId' => 'id']);
    }
}
