<?php
namespace app\dao;

use core\dao\Dao;
use app\model\CategoryModel;

final class CategoryDao extends Dao
{
    //.. colunas da tabela 

    const TBL_NAME = 'name_category';

    public function __construct(CategoryModel $model = null)
    {
        $this->model = is_null($model) ? new CategoryModel() : $model;
        $this->tableName = 'category'; //.. nome da tabela
        $this->tableId = 'id_category'; //.. nome do campo id da tabela 
        $this->setColumns();

    }

    ///.. mapeamento: campos da tabela --> métodos get do objeto model

    public function setColumns(){
         $this->columns = array(
             self :: TBL_NAME => $this->model->getName()
         );
    }
}