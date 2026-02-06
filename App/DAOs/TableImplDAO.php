<?php

namespace App\DAOs;

use config\database\database;

class TableImplDAO {
    private database $db;

    function __construct(database $db) {
        $this->db = $db;
    }

    function createTable(array $columnsInput, $tableName) {
        $this->db->transaction(function(\PDO $pdo) use ($columnsInput, $tableName) {
            $sqlLines = [];
            $constraints = [];
            foreach ($columnsInput as $col) {
                $name = preg_replace('/[^a-zA-Z0-9_]/', '', $col['name']);
                $type = preg_replace('/[^a-zA-Z0-9_]/', '', $col['type']);
                $length = filter_var($col['length'], FILTER_SANITIZE_NUMBER_INT);

                $colDefinition = "$name $type";

                if (!empty($length) && in_array($type, ['VARCHAR', 'CHAR', 'DECIMAL'])) {
                    $colDefinition .= "($length)";
                }

                if (isset($col['not_null']) && $col['not_null'] == '1') {
                    $colDefinition .= " NOT NULL";
                }

                if (isset($col['ai']) && $col['ai'] == '1') {
                    $colDefinition .= " GENERATED ALWAYS AS IDENTITY";
                }

                $keyType = $col['key'] ?? '';

                switch ($keyType) {
                    case 'PRIMARY':
                        $colDefinition .= " PRIMARY KEY";
                        break;
                    case 'UNIQUE':
                        $colDefinition .= " UNIQUE";
                        break;
                    case 'FOREIGN':
                        $fkTable = preg_replace('/[^a-zA-Z0-9_]/', '', $col['fk_table']);
                        $fkCol = preg_replace('/[^a-zA-Z0-9_]/', '', $col['fk_column']);

                        if ($fkTable && $fkCol) {
                            $constraints[] = "CONSTRAINT fk_{$tableName}_{$name} FOREIGN KEY ($name) REFERENCES $fkTable($fkCol)";
                        }
                        break;
                }

                $sqlLines[] = $colDefinition;
            }

            $allDefinitions = array_merge($sqlLines, $constraints);

            $body = implode(",\n    ", $allDefinitions);

            $sql = "CREATE TABLE $tableName (\n    $body\n);";

            echo "<pre>" . $sql . "</pre>";

        });
    }
}