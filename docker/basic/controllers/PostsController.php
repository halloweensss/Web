<?php


namespace app\controllers;


use yii\web\Controller;

class PostsController extends Controller
{
    function actionNews(){
        return $this->render("News");
    }
}