<?php

namespace app\models;

use Yii;
use app\models\Address;
use app\models\Schedule;
use app\models\Weekday;
setlocale(LC_ALL, 'rus_Rus');

/**
 * This is the model class for table "offices".
 *
 * @property integer $id_office
 * @property string $title_office
 * @property integer $id_address
 *
 * @property Address $idAddress
 * @property Schedule[] $schedules
 */
class Offices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'offices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_office', 'id_address'], 'required'],
            [['id_address'], 'integer'],
            [['title_office'], 'string', 'max' => 120],
            [['id_address'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['id_address' => 'id_address']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_office' => 'id офиса',
            'title_office' => 'название офиса',
            'id_address' => 'id адреса ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAddress()
    {
        return $this->hasOne(Address::className(), ['id_address' => 'id_address']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['id_office' => 'id_office']);
    }


    /** Функция формирует два массива для вывода в таблицу index
     * @return array
     */
    public function getAllOffices()
    {
        $arrayOfOfficeAndTime = Offices::findBySql("SELECT of.title_office, CONCAT('г.',ad.city,', ','ул.',ad.street,', ',ad.house_number) AS address, week.name_weekday, CONCAT(sc.start_time,' - ', sc.end_time) AS time,sc.start_time, sc.end_time
                                   FROM offices AS of
                                   INNER JOIN address AS ad
                                   ON of.id_address = ad.id_address
                                   INNER JOIN schedule AS sc
                                   ON sc.id_office = of.id_office
                                   INNER JOIN weekday AS week
                                   ON week.id_weekday = sc.id_weekday
                                   ORDER BY ad.city,of.id_office,week.id_weekday")
            ->asArray()
            ->all();
        $arrayOnlyOffice = Offices::findBySql("SELECT DISTINCT of.title_office, CONCAT('г.',ad.city,', ','ул.',ad.street,', ',ad.house_number) AS address, ad.city, ad.street, ad.house_number
                                   FROM offices AS of
                                   INNER JOIN address AS ad
                                   ON of.id_address = ad.id_address
                                   INNER JOIN schedule AS sc
                                   ON sc.id_office = of.id_office
                                   INNER JOIN weekday AS week
                                   ON week.id_weekday = sc.id_weekday
                                   ORDER BY ad.city,of.id_office,week.id_weekday")
            ->asArray()
            ->all();

        return [
            'office'=> $arrayOnlyOffice,
            'officeAndTime'=> $arrayOfOfficeAndTime
        ];
    }

    /** Возвращает массив офисов, которые открыты сейчас
     * @return array
     */
    public function getOpenOffices()
    {
        $weekday = $this -> getWeekday();
        $arrayOfAll = $this -> getAllOffices();
        $arrayWithTime = $arrayOfAll['officeAndTime'];
        $dateNow = date('H:m:s');
        $result = array();
        foreach ($arrayWithTime as $key => $value) {
            if ($value['start_time'] < $dateNow AND $value['end_time'] > $dateNow AND $value['start_time'] != '00:00:00' AND $value['start_time'] != $value['end_time'] AND $value['name_weekday'] == $weekday) {
                $result[] = [
                    'title_office'=>$value['title_office'],
                    'address'=>$value['address'],
                    'jobtime'=>$value['end_time']-$dateNow
                    ];
            }
        }
        return $result;
    }

    public function getWeekday()
    {
        $date = date('d-m-Y');
        $weekdayLow = iconv('CP1251','UTF-8',strftime("%a", strtotime($date)));
        switch ($weekdayLow) {
            case 'Пн':
                $weekday = 'Понедельник';
                break;
            case 'Вт':
                $weekday = 'Вторник';
                break;
            case 'Ср':
                $weekday = 'Среда';
                break;
            case 'Чт':
                $weekday = 'Четверг';
                break;
            case 'Пт':
                $weekday = 'Пятница';
                break;
            case 'Суббота':
                $weekday = 'Суббота';
                break;
            case 'Вс':
                $weekday = 'Воскресенье';
                break;
        }
        return $weekday;
    }


    /**
     * @param $title
     * @param $id_address
     * @return bool
     */
    public function addOffice($title, $id_address)
    {
        $newOf = new Offices();
        $newOf->title_office = $title;
        $newOf->id_address = $id_address;
        if ($newOf->save()) {
            return true;
        } else {
            return false;
        }
    }
}

