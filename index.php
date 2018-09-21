<?php


use core\Application;
use app\model\CategoryModel;
use app\dao\CategoryDao;
use app\view\category\CategoryView;


require_once('autoload.php');





/*
Application::start();

$catModel = new CategoryModel(null, 'Alimentação');

$catDao = new CategoryDao($catModel);

$catDao->insertUpdate();

*/

$model = (new CategoryDao())->findById(3);

$view = new CategoryView($model);

$view->show();


