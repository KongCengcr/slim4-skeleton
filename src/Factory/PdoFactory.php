<?php

namespace App\Factory;

use App\Database\PdoConnection;
use App\Constants\Search\Types as T;
use Exception;

final class PdoFactory
{

    public PdoConnection $pdo;
    // public PdoConnection $pdoConnection;

    public function __construct(PdoConnection $pdoConnection)
    {
        $this->pdo = $pdoConnection;
    }

    /**
     * Get all data from the database
     * @param string  $table    Name of table
     * 
     */
    public function all(string $table)
    {
        try {
            $sql = $this->pdo->query("SELECT * FROM $table");
            $all = $sql->fetchAll(\PDO::FETCH_ASSOC);
            return $all;
        } catch (\PDOException $e) {
            throw new \DomainException($e->getMessage());
            // return ["error" => "fail", "message" => $e->getMessage()];
        }
    }

    /**
     * Get all the data from the database and return it with a pagination
     * 
     * @param string  $table    Name of table
     * @param int     $page     You place yourself on the page you want to display data, this depends on the amount per page to display.
     * @param int     $perPage  Designates the number of items to return
     */
    public function paginate(string $table, int $page, int $perPage)
    {
        try {
            $sqlCount = $this->pdo->query("SELECT COUNT(*) AS count FROM $table");
            $count = $sqlCount->fetch(\PDO::FETCH_ASSOC);

            $pages = ceil($count['count'] / $perPage);

            if ($page > $pages)
                throw new \DomainException('You entered a page number greater than available');

            $page = $page == 1 || $page == 0 ? 0 : $page;

            $offset = $page > 1 ? ($page - 1) * $perPage : $page * $perPage;

            $sql = $this->pdo->query(
                "SELECT * FROM $table 
                    LIMIT $perPage 
                    OFFSET $offset"
            );

            $all = $sql->fetchAll(\PDO::FETCH_ASSOC);
            $page = $page == 0 ? 1 : $page;
            $result = [
                'data' => $all,
                'page' => $page,
                'nextPage' => $pages == $page ? $page : $page + 1,
                'prevPage' => $page > 1 ? $page - 1 : 1,
                'maxPage' => $pages
            ];

            return $result;
        } catch (\PDOException $e) {
            throw new \DomainException($e->getMessage());
            // return ["error" => "fail", "message" => $e->getMessage()];
        }
    }

    /**
     * Get all the data from the database and return it with a pagination
     * 
     * @param string  $table    Name of table
     * @param string  $column   Column of the table you want to find a value(s)
     * @param mixed   $value    Value of the table you want to find a value(s)
     * @param int     $perPage  Designates the number of items to return
     * @param int     $page     You place yourself on the page you want to display data, this depends on the amount per page to display.
     */
    public function paginateAllBy(string $table, string $column, mixed $value, int $page, int $perPage)
    {
        try {
            $sqlCount = $this->pdo->query("SELECT COUNT(*) AS count FROM $table WHERE $column LIKE '$value'");
            $count = $sqlCount->fetch(\PDO::FETCH_ASSOC);

            $pages = ceil($count['count'] / $perPage);

            if ($page > $pages)
                throw new \DomainException('You entered a page number greater than available');

            $page = $page == 1 || $page == 0 ? 0 : $page;

            $offset = $page > 1 ? ($page - 1) * $perPage : $page * $perPage;

            $sql = $this->pdo->query(
                "SELECT * FROM $table
                    WHERE $column LIKE '$value' 
                    LIMIT $perPage 
                    OFFSET $offset"
            );

            $all = $sql->fetchAll(\PDO::FETCH_ASSOC);
            $page = $page == 0 ? 1 : $page;
            $result = [
                'data' => $all,
                'page' => $page,
                'nextPage' => $pages == $page ? $page : $page + 1,
                'prevPage' => $page > 1 ? $page - 1 : 1,
                'maxPage' => $pages
            ];

            return $result;
        } catch (\PDOException $e) {
            throw new \DomainException($e->getMessage());
            // return ["error" => "fail", "message" => $e->getMessage()];
        }
    }

    /**
     * Find a data from the database by id
     * @param string  $table    Name of table     
     * @param int     $id       Give a id for the search 
     */
    public function find(string $table, int $id)
    {
        try {
            $sql = $this->pdo->query("SELECT * FROM $table WHERE id = $id");
            $response = $sql->fetch(\PDO::FETCH_ASSOC);
            return $response;
        } catch (\PDOException $e) {
            throw new \DomainException($e->getMessage());
            // return ["error" => "fail", "message" => $e->getMessage()];
        }
    }

    /**
     * Find all data from the database by colunm and value of table
     * @param string  $table    Name of table   
     * @param string  $column   Column of the table you want to find a value(s)
     * @param mixed   $value    Value of the table you want to find a value(s)
     */
    public function findAllBy(string $table, string $column, mixed $value)
    {
        try {
            $sql = $this->pdo->query("SELECT * FROM $table WHERE $column LIKE '$value'");
            $response = $sql->fetchAll(\PDO::FETCH_ASSOC);
            return $response;
        } catch (\PDOException $e) {
            throw new \DomainException($e->getMessage());
            // return ["error" => "fail", "message" => $e->getMessage()];
        }
    }

    /**
     * Find exact data from the database by colunm and value of table
     * @param string  $table    Name of table  
     * @param $column Column of the table you want to find a value(s)
     * @param $value  Value of the table you want to find a value(s)
     */
    public function findExactBy(string $table, string $column, mixed $value)
    {
        try {
            $sql = $this->pdo->query("SELECT * FROM $table WHERE $column LIKE '$value'");
            $response = $sql->fetch(\PDO::FETCH_ASSOC);
            return $response;
        } catch (\PDOException $e) {
            throw new \DomainException($e->getMessage());
            // return ["error" => "fail", "message" => $e->getMessage()];
        }
    }

    /**
     * Creates a new data in the database
     * @param string  $table    Name of table  
     * @param array $data Give data to be able to insert in the database, example ['column' => value ]
     */
    public function create(string $table, array $data)
    {
        try {
            $columns = '';
            $values = '';

            foreach ($data as $key => $val) {
                $columns .= '`' . $key . '`,';
                $values .= ':' . $key . ',';
            }

            $columns = trim($columns, ',');
            $values = trim($values, ',');

            $sql = "INSERT INTO $table($columns) VALUE ($values)";
            $insert = $this->pdo->prepare($sql);
            $insert->execute($data);
            // $this->pdo->lastInsertId()
            return $this->pdo->lastInsertId();
        } catch (\PDOException $e) {
            throw new \DomainException($e->getMessage());
            // return ["error" => "fail", "message" => $e->getMessage()];
        }
    }

    /**
     * Update a data in the database
     * @param string  $table    Name of table  
     * @param int    $id    Give a id for the update
     * @param array  $data  Give data to be able to update in the database, example ['column' => value ]
     */
    public function update(string $table, int $id, array $data)
    {
        try {
            $columns = '';

            foreach ($data as $key => $val) {
                $columns .= "`$key` = :$key,";
            }
            $columns = trim($columns, ',');
            $sql = "UPDATE $table SET $columns WHERE id = $id;";
            $update = $this->pdo->prepare($sql);
            $update->execute($data);
        } catch (\PDOException $e) {
            throw new \DomainException($e->getMessage());
            // return ["error" => "fail", "message" => $e->getMessage()];
        }
    }

    /**
     * Update a data in the database
     * @param string  $table    Name of table  
     * @param $column Column of the table you want to find a value(s)
     * @param $value  Value of the table you want to find a value(s)
     * @param array  $data  Give data to be able to update in the database, example ['column' => value ]
     */
    public function updateBy(string $table, string $column, mixed $value, array $data)
    {
        try {
            $columns = '';

            foreach ($data as $key => $val) {
                $columns .= "`$key` = :$key,";
            }
            $columns = trim($columns, ',');
            $sql = "UPDATE $table SET $columns WHERE $column = '$value';";
            $update = $this->pdo->prepare($sql);
            $update->execute($data);
        } catch (\PDOException $e) {
            throw new \DomainException($e->getMessage());
            // return ["error" => "fail", "message" => $e->getMessage()];
        }
    }

    /**
     * Update a data in the database
     * @param string  $table    Name of table  
     * @param $columnFirst Column of the table you want to find a value(s)
     * @param $valueFirst  Value of the table you want to find a value(s)
     * @param $columnSecond Column of the table you want to find a value(s)
     * @param $valueSecond  Value of the table you want to find a value(s)
     * @param array  $data  Give data to be able to update in the database, example ['column' => value ]
     */
    public function updateByTwoCondition(string $table, string $columnFirst, mixed $valueFirst, string $columnSecond, mixed $valueSecond, array $data)
    {
        try {
            $columns = '';

            foreach ($data as $key => $val) {
                $columns .= "`$key` = :$key,";
            }
            $columns = trim($columns, ',');
            $sql = "UPDATE $table SET $columns WHERE $columnFirst = '$valueFirst' AND $columnSecond = '$valueSecond';";
            $update = $this->pdo->prepare($sql);
            $update->execute($data);
        } catch (\PDOException $e) {
            throw new \DomainException($e->getMessage());
            // return ["error" => "fail", "message" => $e->getMessage()];
        }
    }


    /**
     * Delete a data in the database
     * @param string  $table    Name of table  
     * @param int    $id    Give a id for delete
     */
    public function delete(string $table, int $id)
    {
        try {
            $sql = "DELETE FROM $table WHERE id=$id";
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            throw new \DomainException($e->getMessage());
            // return ["error" => "fail", "message" => $e->getMessage()];
        }
    }

    /**
     * Delete a data in the database
     * @param string  $table    Name of table  
     * @param string  $column   Column of the table you want to find a value(s)
     * @param mixed   $value    Value of the table you want to find a value(s)
     */
    public function deleteBy(string $table, string $column, mixed $value)
    {
        try {
            $sql = "DELETE FROM $table WHERE $column = '$value'";
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            throw new \DomainException($e->getMessage());
            // return ["error" => "fail", "message" => $e->getMessage()];
        }
    }
}
