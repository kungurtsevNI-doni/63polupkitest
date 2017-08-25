<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id_address
 * @property string $city
 * @property string $street
 * @property string $house_number
 *
 * @property Offices[] $offices
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city', 'street', 'house_number'], 'required'],
            [['city', 'street', 'house_number'], 'string', 'max' => 120],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_address' => 'id адреса ',
            'city' => 'город в котором расположен офис',
            'street' => 'улица на которой находится офис',
            'house_number' => 'дом',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffices()
    {
        return $this->hasMany(Offices::className(), ['id_address' => 'id_address']);
    }

    /**
     * @param $city
     * @param $street
     * @param $house_number
     * @return bool
     */
    public function addAddress($city, $street, $house_number)
    {
        $newAD = new Address();
        $newAD-> city = $city;
        $newAD-> street = $street;
        $newAD-> house_number = $house_number;
        if ($newAD->save()) {
            return true;
        } else {
            return false;
        }
    }
}
