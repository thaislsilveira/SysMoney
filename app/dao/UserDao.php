<?php
namespace app\dao;

use core\dao\Dao;
use app\model\UserModel;
use app\model\CityModel;
use app\dao\CityDao;
use core\dao\SqlObject;
use core\dao\Connection;
use app\dao\UserDao;

final class UserDao extends Dao
{

    //..constantes para mapear colunas da tabela do bd
    const COL_NAME = 'name_user';
    const COL_GENDER = 'gender_user';
    const COL_PASSWD = 'password_user';
    const COL_STATUS = 'status_user';
    const COL_TYPE = 'type_user';
    const COL_EMAIL = 'email_user';
    const COL_CITY = 'id_city';

    public function __construct(UserModel $model = null)
    {
        $this->model = is_null($model) ? new UserModel() : $model;
        $this->tableName = 'users'; //..nome da tabela
        $this->tableId = 'id_user'; //..nome do campo de id
        $this->setColumns(); //..abstrato - deve ser codificado aqui!
    }

    //..pegar os dados do model (objeto) e criar um array...
    protected function setColumns()
    {
        $this->columns[self::COL_NAME] = $this->model->getName();
        $this->columns[self::COL_GENDER] = $this->model->getGender();
        //..cria um hash md5 para armazenar a senha
        $this->columns[self::COL_PASSWD] = \md5($this->model->getPassword());
        $this->columns[self::COL_STATUS] = $this->model->getStatus();
        $this->columns[self::COL_TYPE] = $this->model->getType();
        $this->columns[self::COL_EMAIL] = $this->model->getEmail();
        //..armazena o id da cidade
        $this->columns[self::COL_CITY] = $this->model->getCity()->getId();
    }

    public function findById($id)
    {
        try {
            $data = parent::findById($id);            
            if($data){
                $userModel = new UserModel(
                    $data[$this->tableId],
                    $data[self::COL_NAME],
                    $data[self::COL_GENDER],
                    null, $data[self::COL_STATUS],
                    $data[self::COL_TYPE], $data[self::COL_EMAIL],
                    (new CityDao())->findById($data[self::COL_CITY])
                );
                return $userModel;
            } else{
                return NULL;
            }
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function selectAll($criteria = null, $orderBy = null, 
        $groupBy = null, $limit = null, $offSet = null) {
        try{
            $data = parent::selectAll($criteria, $orderBy, $groupBy,
                    $limit, $offSet);
            if($data){
                $arrayList = null;
                foreach($data as $reg){
                    $userModel = new UserModel(
                        $reg[$this->tableId],
                        $reg[self::COL_NAME],
                        $reg[self::COL_GENDER],                        
                        null, $reg[self::COL_STATUS],
                        $reg[self::COL_TYPE], $reg[self::COL_EMAIL],
                        (new CityDao())->findById($reg[self::COL_CITY])
                    );
                    $arrayList[] = $userModel;
                }
                return $arrayList;                
            } else{
                return NULL;
            }
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    
}