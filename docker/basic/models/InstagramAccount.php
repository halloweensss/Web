<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "instagramAccounts".
 *
 * @property int $id
 * @property string $name
 * @property string $src
 *
 * @property InstagramFollow[] $instagramFollows
 */
class InstagramAccount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'instagramAccounts';
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
    public function getInstagramFollows()
    {
        return $this->hasMany(InstagramFollow::className(), ['instagramId' => 'id']);
    }
}
