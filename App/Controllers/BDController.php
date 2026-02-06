<?php

namespace App\Controllers;

use App\Core\Response;
use App\Core\Request;
use App\DAOs\TableImplDAO;
use config\database\database;
class BDController{
    public function schemaBuilder (Response $response)
    {
        $response->view('bd/schemaBuilder')->send();
    }
    public function schemaBuilderGenerate (Request $request,Response $response, TableImplDAO $tableDAO) {
        $data = $request->getBody();
        $columns = $data['columns'];
        $tableName = $data['table_name'];

        $tableDAO->createTable($columns, $tableName);
    }
}