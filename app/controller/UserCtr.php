<?php
namespace app\controller;

use core\mvc\Controller;
use app\view\user\UserView;
use app\dao\UserDao;
use app\model\UserModel;
use app\model\CityModel;
use app\dao\CityDao;
use app\view\user\UserList;

use core\mvc\view\Message;
use core\Application;


//..incluir a view de listagem.

final class UserCtr extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new UserModel();
        $this->dao = new UserDao();
        $this->view = new UserView();
        $this->viewList = new UserList();
    }

    public function viewToModel()
    {
        if ($this->post) {
            $this->model->setId($this->post['id']);
            $this->model->setName($this->post['name']);
            $this->model->setGender($this->post['gender']);
            $this->model->setEmail($this->post['email']);
            $this->model->setCity(new CityModel($this->post['city']));            
            $this->model->setPassword($this->post['password']);
            $this->model->setType('U');
            $this->model->setStatus('I');
        }
    }

    public function showView()
    {
        //..busca todas as cidades cadastradas.
        $cities = (new CityDao())->selectAll();
        //..seta as cidades na view para que possam ser exibidas
        $this->view->setCities($cities);
        //..invoca o método pai
        parent::showView();
    }

    public function showList()
    {
        if ($this->post) {
            $this->criteria = "upper (" . UserDao::COL_NAME . ") like upper('{$this->post['data'][0]}')  
             and " . UserDao::COL_STATUS . " = '{$this->post['data'][1]}'";
            $this->orderBy = UserDao::COL_NAME;
        }
        parent::showList();
    }






} 