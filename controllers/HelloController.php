<?php
/**
 * Created by PhpStorm.
 * User: mmssu
 * Date: 2016/7/13
 * Time: 15:22
 */

namespace app\controllers;
use app\models\City;
use app\models\Country;
use yii\web\Controller;
use yii\web\Cookie;

class HelloController extends Controller{

    public function actionIndex(){
        //获取get值
        $request = \Yii::$app->request;
        var_dump($request -> get('id',20));  //20->默认值
        var_dump($request -> post());
        //判断是否为get或post请求
        if($request->isGet){
            echo  "this is get method";
        }
        if($request->isPost)
            echo "this is post method";

        //更多request 使用方式，查询yii官方文档（请求处理--request章节）---------
        //视图加载
        $data = array();
        $data['id'] =  10;
        $data['name'] = 'JAVASCRIPT<script>alert(2)</script>';
        $data['arr'] = [1,2,4];


        return $this->renderPartial('index',$data);

    }

    public function actionIndex2(){
        //设置HTTP头的信息
        $resp =  \Yii::$app->response;

//        $resp->statusCode = '404';
//
//        $resp->headers->add('pragma','no-cache');
//        $resp->headers->set('pragma','max-age=5');
//        $resp->headers->remove('pragma');

        //跳转
        //$resp->headers->add('location','http://www.baidu.com');  //（header头的方式）
        //$this->redirect('http://www.baidu.com',302);   //（yii内部函数的方式）

        //文件下载
        $resp->headers->add('content-disposition','attachment;filename="a.jpg'); //（header头的方式）
        $resp->sendFile('./robots.txt');   //（yii内部函数的方式）
    }
    public function actionIndex3(){
        //session的相关操作
        $session = \Yii::$app->session;

        $session -> open();
        if($session->isActive){  //判断session是否开启
            //方式1
            $session ->set('user','Johnny');
            $session->remove('user');
            var_dump($session->get('user'));
            //方式2
            $session['sex'] = '男';
            //删除
            unset($session['sex']);

            echo  $session['sex'];
        }

        //cookie相关操作
        $cookie = \Yii::$app->response->cookies;

        $cookie_data = ['name'=>'user','value'=>'zhangsan'];
        $cookie->add(new Cookie($cookie_data));
        // $cookie->remove('id');

        //从请求cookie数据中，获取cookie信息
        $cookie = \Yii::$app->request->cookies;

        echo $cookie->getValue('user',20);  //如果user找不到，则使用默认值20，
    }

    //数据库的操作
    public function actionTest(){
        //1--原生sql操作[注意防止SQL注入]--------------
        $sql = "select * from uro_country WHERE id=:id"; //:id 占位符，防止SQL注入
        $res = Country::findBySql($sql,[':id'=>'1 or 1=1'])->all();
        //2--数组形式-------------------
        $res = Country::find()->where(['id'=>1])->all();  //id=1
        $res = Country::find()->where(['>','id',2])->all();   //id>2
        $res = Country::find()->where(['between','id',2,4])->all();  //id>=2, id<=4
        $res = Country::find()->where(['like','name','国'])->all();  //模糊查询like  %京%
//        var_dump($res);

        //--更多 数据库where操作，查询官方文档：http://www.yiichina.com/doc/guide/2.0/db-active-record

        //将查询结果的对象转化为数组，减少内存使用量
        $res = Country::find()->where(['like','name','京'])->asArray()->all();  //模糊查询like  %京%
        //var_dump($res);
        //批量查询。每次只取指定数量[batch]的数据，直到去出所有数据
        $batch = 2;
        foreach(Country::find()->asArray()->each($batch) as $v){
            var_dump($v);
            echo "<hr><hr>";
        }
//==============================================================================
        //删除数据
        $res = Country::find()->where(['id'=>1])->all();
        //$res[0]->delete();
        //删除[所有/指定条件下]的数据
       // Country::deleteAll('id>:id',[':id'=>5]);
//==============================================================================
        //添加数据
        $area_obj = new Country();
        $area_obj->name = '俄罗斯';
        //触发验证
        $area_obj->validate();
        if($area_obj->hasErrors()){  //获取验证自己的错误信息
            return "error...";
        }
      //  $area_obj->save();
//==============================================================================
        //更新数据
        $res = Country::find()->where(['id'=>25])->one();
        $res->name = '俄罗斯2';
        $res->save();





    }

    //数据表 关联查询
    public function actionTest2(){
        //获取国家
        $city_obj = City::find()->where(['id'=>1])->one();
        $country = $city_obj->getCountry();
        //var_dump($country);

        //获取城市
        $country_obj = Country::find()->where(['id'=>25])->one();
//        $city = $country_obj->getCity();
        $city = $country_obj->city;
        var_dump($city);


    }
}