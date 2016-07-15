<?php
/**
 * Created by PhpStorm.
 * User: mmssu
 * Date: 2016/7/14
 * Time: 14:24
 */

namespace app\models;
use yii\db\ActiveRecord;

class Country extends ActiveRecord{

    /**
     * 自动验证
     * 官方文档：http://www.yiichina.com/doc/guide/2.0/tutorial-core-validators
     * @return array
     */
//    public function rules(){
//        return [
//            ['id','integer'],
//            ['name','string','length'=>[0,3]]
//        ];
//    }


    public function getCity(){
        return $this->hasMany(City::className(),['country_id'=>'id'])->asArray()->all();

    }

}