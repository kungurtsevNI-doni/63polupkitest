<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "weekday".
 *
 * @property integer $id_weekday
 * @property string $name_weekday
 *
 * @property Schedule[] $schedules
 */
class Weekday extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'weekday';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_weekday', 'name_weekday'], 'required'],
            [['id_weekday'], 'integer'],
            [['name_weekday'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_weekday' => 'Id Weekday',
            'name_weekday' => 'название дня недели',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['id_weekday' => 'id_weekday']);
    }
}
