<?php

namespace warhammerScoreBoard\core;

class QueryBuilder extends Manager
{
    private $query;
    private $where = "";
    private $order = "";
    private $limit = "";
    private $groupBy = "";
    private $selector = "";
    private $join = "";

    public function __construct($class,$table)
    {
        parent::__construct($class,$table);
    }

    public function querySelect($columns)
    {
        $this->selector .= "SELECT ";

        if (is_array($columns)) {
            $lastElement = count($columns);
            $i = 1;
            foreach ($columns as $column) {
                $this->selector .= $column;
                if ($i != $lastElement) {
                    $this->selector .= ", ";
                } else {
                    $this->selector .= " ";
                }
                $i++;
            }
        } else {
            $this->selector .= $columns . " ";
        }
        return $this;
    }
    public function queryFrom()
    {
        $this->selector .= "FROM ".$this->table . " ";
    }
    public function queryManyFrom($columns)
    {
        $this->selector .= "FROM ";
        if (is_array($columns)) {
            $lastElement = count($columns);
            $i = 1;
            foreach ($columns as $column) {
                $column = DB_PREFIXE.$column;
                $this->selector .= $column;
                if ($i != $lastElement) {
                    $this->selector .= ", ";
                } else {
                    $this->selector .= " ";
                }
                $i++;
            }
        } else {
            $this->selector .= DB_PREFIXE.$columns . " ";
        }
        return $this;
    }

    public function update($table)
    {
        $this->table = $table;
        $this->selector .= "UPDATE " . $table . " ";
        return $this;
    }

    public function queryFindAll($table)
    {
        $this->selector = "SELECT *";

        return $this;
    }

    public function queryCount($table)
    {
        $this->selector = "SELECT COUNT(*)";

        return $this;
    }

    public function queryWhere($column, $operator, $value = null)
    {
        if (!isset($value)) {
            $value = $operator;
            $operator = "=";
        }
        if(!empty($this->where))
        {
            $this->where.= " AND ";
        }
        $this->where .= " " . $column . " " . $operator;
        $this->where .= (is_int($value)) ? " " . $value : " '".$value."'";
        return $this;
    }



    public function queryLike($column, $value = null)
    {
        $this->where .= " " . $column . " LIKE CONCAT('%',:" . $value . ",'%') ";
        return $this;
    }

    public function queryOrderBy($column, $order)
    {
        $this->order .= " " . $column . " " . $order . " ";
        return $this;
    }

    public function queryGroupBy($group)
    {
        $this->groupBy .= " " . $group . " ";
        return $this;
    }

    public function queryLimit($limit)
    {
        $this->limit .= " ".$limit." ";
        return $this;
    }

    public function queryJoin(string $table1, string $table2, string $table1param, string $table2param )
    {
        return $this->join = " INNER JOIN ".DB_PREFIXE.$table2." ON ". DB_PREFIXE.$table1.".".$table1param." = " .DB_PREFIXE.$table2.".".$table2param;
    }


    private function queryGet()
    {
        if (!isset($this->selector) || !isset($this->table)) {
            return false;
        } else {
            $this->query =
                $this->selector
                . (!empty($this->join) ? $this->join : "")
                . (!empty($this->where) ? " WHERE" . $this->where : "")
                . (!empty($this->groupBy) ? " GROUP BY" . $this->groupBy : "")
                . (!empty($this->order) ? " ORDER BY" . $this->order : "")
                . (!empty($this->limit) ? " LIMIT" . $this->limit : "");
        }
        return $this->connection->query($this->query);
    }

    public function queryGetValue()
    {
        $result = $this->queryGet();
        //echo $this->query;
        return $result->getResult();
    }

    public function queryGetArray()
    {
        $result = $this->queryGet();
        //echo $this->query;
        return $result->getArrayResult();
    }


    public function querySave()
    {
        $propChild = get_object_vars($this);
        $propDB = get_class_vars(get_class());

        $columnsData = array_diff_key($propChild, $propDB);
        $columns = array_keys($columnsData);

        if (!is_numeric($this->id)) {

            //INSERT
            $sql = "INSERT INTO " . $this->table . " (" . implode(",", $columns) . ") VALUES (:" . implode(",:", $columns) . ");";
        } else {

            //UPDATE
            foreach ($columns as $column) {
                $sqlUpdate[] = $column . "=:" . $column;
            }

            $sql = "UPDATE " . $this->table . " SET " . implode(",", $sqlUpdate) . " WHERE id=:id;";
        }

        $queryPrepared = $this->pdo->prepare($sql);
        return $queryPrepared->execute($columnsData);
    }

    public function queryDelete($column, $comp, $val = null){
        if (!isset($this->table)) {
            return false;
        } else {
            $this->query =
                "DELETE FROM " . $this->table . " "
                . "WHERE " .
                $column . " " .
                ($val !== null) ? $comp . " " . $val: "= " . $comp ;
            $query = $this->pdo->prepare($this->query);
            return $query->execute();
        }
    }

    public function queryDeleteAll(){
        if(!isset($this->table)){
            return false;
        } else {
            $this->query = "DELETE FROM " . $this->table;
        }
        $query = $this->pdo->prepare($this->query);
        return $query->execute();
    }

    public function getQuery()
    {
        return $this->selector;
    }
}
