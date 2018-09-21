<?php
namespace app\dao;

use core\dao\Dao;
use app\model\UserModel;
use core\dao\SqlObject;
use core\dao\Connection;


class UserDao extends Dao{

    const COL_ID = 'id_user';
    const COL_NAME = 'name_user';
    const COL_GENDER = 'gender_user';
    //const COL_LOGIN = 'login_user';
    const COL_PASSWD = 'password_user';
    const COL_STATUS = 'status_user';
    const COL_TYPE = 'type_user';
    const COL_EMAIL = 'email_user';
    const COL_CITY = 'id_city';

    public function __construct(UserModel $model = null)
    {
        $this->model = is_null($model) ? new UserModel() : $model;
        $this->tableName = 'users'; //..o nome da tabela
        $this->tableId = self::COL_ID; //..o campo id da tabela
        $this->setColumns(); //..método para ORM
    }

    public function setColumns(){
        $this->columns = array(
            self::COL_NAME => $this->model->getName(),
            self::COL_GENDER => $this->model->getGender(),
            //self::COL_LOGIN => $this->model->getLogin(),
            self::COL_PASSWD => $this->model->getPasswd(),
            self::COL_STATUS => $this->model->getStatus(),
            self::COL_TYPE => $this->model->getType(),
            self::COL_EMAIL => $this->model->getEmail(),
            //..pegar o id do objeto CityModel
            self::COL_CITY => $this->model->getCity()->getId()
        );
    }

    public function findById($id){
        $data = parent::findById($id);
        if($data){
            $city = (new CityDao())->findById($data[self::COL_CITY]);
            return new UserModel($id,$data[self::COL_NAME],        
                    $data[self::COL_GENDER],null,
                    $data[self::COL_STATUS],$data[self::COL_TYPE],
                    $data[self::COL_EMAIL],$city);
        } else{
            return NULL;
        }
    }

    public function selectAll($criteria = null, $orderBy = null, 
            $groupBy = null, $limit = null, $offSet = null)
    {
        $data = parent::selectAll($criteria,$orderBy,$groupBy,
                                  $limit,$offSet);
        if($data){
            $arrayList = null;
            foreach($data as $reg){
                $city = (new CityDao())->findById($reg[self::COL_CITY]);
                $user = new UserModel($reg[self::COL_ID],
                    $reg[self::COL_NAME],        
                    $reg[self::COL_GENDER],null,
                    $reg[self::COL_STATUS],$reg[self::COL_TYPE],
                    $reg[self::COL_EMAIL],$city
                );
                $arrayList[] = $user;
            }
            return $arrayList;
        } else {
            return NULL;
        }
    }

    /**
     * Faz o login do usuário
     * @param String $user O email do usuário
     * @param String $passwd A senha do usuário
     * @return model\UserModel|NULL Objeto UserModel ou NULL  
     */
    public function doLogin($user, $passwd){
        try{
            //..instanciar um objeto SQLObject para fazer uma consulta
            $sqlObj = new SqlObject(Connection::getConnection());
            $criteria  = UserDao::COL_EMAIL . " = '$user' and ";
            $criteria .= UserDao::COL_PASSWD . " = '" . md5($passwd) . "'";
            //..faz a consulta no BD
            $data = $sqlObj->select($this->tableName,'*',$criteria);
            if($data){
                $data = $data[0];
                $userModel = new UserModel($data[self::COL_ID],$data[self::COL_NAME],
                                    $data[self::COL_GENDER],null,
                                    $data[self::COL_STATUS],
                                    $data[self::COL_TYPE],
                                    $data[self::COL_EMAIL],
                                    (new CityDao())->findById($data[self::COL_CITY]));
                return $userModel;
            } else {
                return NULL;
            }
        } catch (\Exception $ex){
            throw $ex;
        }
    }

}
