<?php
/**
 * Created by PhpStorm.
 * User: mmssu
 * Date: 2016/7/13
 * Time: 15:22
 */

namespace app\controllers;
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
}