<?php

namespace App\Controllers;

use App\Core\Response;
use App\Core\Request;

class BDController{
    public function schemaBuilder (Response $response)
    {
        $response->view('bd/schemaBuilder')->send();
    }
    public function schemaBuilderGenerate (Request $request,Response $response) {

        $data = $request->getBody();
        $tableName = $data['table_name'];
        echo "$tableName\n";
        $columns = $data['columns'];
        for ($i = 0; $i < count($columns); $i++) {
            $column = $columns[$i];
            $columnName = $column['name'];
            $columnType = $column['type'];
            $columnLenght = $column['length'];
            echo "Column: $columnName\n";
        }
    }
}