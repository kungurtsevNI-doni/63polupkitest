<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schedule".
 *
 * @property integer $id_schedule
 * @property integer $id_office
 * @property integer $id_weekday
 * @property string $start_time
 * @property string $end_time
 *
 * @property Offices $idOffice
 * @property Weekday $idWeekday
 */
class Schedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_office', 'id_weekday', 'start_time', 'end_time'], 'required'],
            [['id_office', 'id_weekday'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
            [['id_office'], 'exist', 'skipOnError' => true, 'targetClass' => Offices::className(), 'targetAttribute' => ['id_office' => 'id_office']],
            [['id_weekday'], 'exist', 'skipOnError' => true, 'targetClass' => Weekday::className(), 'targetAttribute' => ['id_weekday' => 'id_weekday']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_schedule' => 'id графика',
            'id_office' => 'id офиса',
            'id_weekday' => 'id дня недели',
            'start_time' => 'Время открытия офиса',
            'end_time' => 'Время закрытия офиса',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOffice()
    {
        return $this->hasOne(Offices::className(), ['id_office' => 'id_office']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdWeekday()
    {
        return $this->hasOne(Weekday::className(), ['id_weekday' => 'id_weekday']);
    }
}
