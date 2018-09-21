<?php
namespace app\controller;

use core\mvc\Controller;
use app\model\CategoryModel;
use app\view\category\CategoryView;
use app\dao\CategoryDao;


final class CategoryCtr extends Controller{
    public function __construct()
    {
        parent :: __construct();

        //.. instanciar os objetos que o controller irá manipular
            $this->model = new CategoryModel();
            $this->view = new CategoryView();
            $this->dao = new CategoryDao();
            //.. faltou a view de listagem.
        
    }

    public function viewToModel()
    {
        if($this->post){
            $this->model->setId($this->post['id']);
            $this->model->setName($this->post['name']);
        }
    }
}