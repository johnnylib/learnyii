<?php
/**
 * Created by PhpStorm.
 * User: mmssu
 * Date: 2016/7/14
 * Time: 17:24
 */

namespace app\models;
use yii\db\ActiveRecord;
use app\models\Country;

class City extends ActiveRecord{

    public function getCountry(){
        $countries = $this->hasOne(Country::className(),['id'=>'country_id'])->asArray()->one();
        return $countries;
    }


}