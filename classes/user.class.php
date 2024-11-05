<?php
include $_SERVER['DOCUMENT_ROOT'] . '/classes/database.class.php';
class user
{
    public function getData($tableName, $columns, $values)
    {
        $conn = database::getConnection();


        $conditions = array_map(function ($col) {
            return "`$col` = ?";
        }, $columns);
        $whereClause = implode(" AND ", $conditions);


        $stmt = $conn->prepare("SELECT * FROM `$tableName` WHERE $whereClause");


        $types = str_repeat("s", count($values));
        $stmt->bind_param($types, ...$values);


        $stmt->execute();
        $result = $stmt->get_result();


        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        $stmt->close();
        return $rows;
    }



    public function insertData($tableName, $columns, $values)
    {
        $conn = database::getConnection();


        $escapedColumns = array_map(function ($col) {
            return "`$col`";
        }, $columns);

        $columnsStr = implode(", ", $escapedColumns);
        $placeholders = implode(", ", array_fill(0, count($values), "?"));


        $sql = "INSERT INTO `$tableName` ($columnsStr) VALUES ($placeholders)";


        $stmt = $conn->prepare($sql);



        $types = str_repeat("s", count($values));
        $stmt->bind_param($types, ...$values);


        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            echo "Error: " . $stmt->error;
            $stmt->close();
            return false;
        }
    }
    public function updateData($tableName, $columns, $values, $whereClause)
    {
        $conn = database::getConnection();

        // Escape column names
        $escapedColumns = array_map(function ($col) {
            return "`$col` = ?"; // include the placeholder here
        }, $columns);

        $columnsStr = implode(", ", $escapedColumns); // This will now create `Column1` = ?, `Column2` = ?

        // Prepare the SQL statement
        $sql = "UPDATE `$tableName` SET $columnsStr WHERE $whereClause";

        $stmt = $conn->prepare($sql);

        // Bind the parameters
        $types = str_repeat("s", count($values)); // assuming all values are strings
        $stmt->bind_param($types, ...$values);

        // Execute the statement
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            echo "Error: " . $stmt->error;
            $stmt->close();
            return false;
        }
    }


    public function deleteData($tableName, $whereClause)
    {
        $conn = database::getConnection();


        $sql = "DELETE FROM `$tableName` WHERE $whereClause";


        $stmt = $conn->prepare($sql);


        $stmt->execute();
        $stmt->close();
        return true;
    }
}
