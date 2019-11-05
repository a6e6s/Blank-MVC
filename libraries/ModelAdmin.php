<?php
class ModelAdmin
{
    protected $db;
    protected $table;
    /**
     * calling database object and setting table name
     */
    public function __construct($table)
    {
        $this->table = $table;
        $this->db = new Database;
    }

    /**
     * Delete one or more records by id
     * @param Array $ids
     * @param string colomn id
     * @return boolean or row count
     */
    public function deleteById($ids, $where)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($ids); $index++) {
            $id_num[] = ":id" . $index;
        }
        //setting the query
        $this->db->query('UPDATE ' . $this->table . ' SET status = 2 WHERE ' . $where . ' IN (' . implode(',', $id_num) . ')');
        //loop through the bind function to bind all the IDs
        foreach ($ids as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return false;
        }
    }

    /**
     * publish one or more records by id
     * @param Array $ids
     * @param string colomn id
     * @return boolean or row count
     */
    public function publishById($ids, $where)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($ids); $index++) {
            $id_num[] = ":id" . $index;
        }
        //setting the query
        $this->db->query('UPDATE ' . $this->table . ' SET status = 1 WHERE ' . $where . ' IN (' . implode(',', $id_num) . ')');
        //loop through the bind function to bind all the IDs
        foreach ($ids as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return false;
        }
    }

    /**
     * unpublish one or more records by id
     * @param Array $ids
     * @param string colomn id
     * @return boolean or row count
     */
    public function unpublishById($ids, $where)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($ids); $index++) {
            $id_num[] = ":id" . $index;
        }
        //setting the query
        $this->db->query('UPDATE ' . $this->table . ' SET status = 0 WHERE ' . $where . ' IN (' . implode(',', $id_num) . ')');
        //loop through the bind function to bind all the IDs
        foreach ($ids as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return false;
        }
    }

    /**
     * get By Id
     *
     * @param  mixed $id
     * @param  mixed $where
     *
     * @return void
     */
    public function getById($id, $where)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE ' . $where . '= :' . $where);
        $this->db->bind(':' . $where, $id);
        $row = $this->db->single();
        return $row;
    }
    
    /**
     * handling Search Condition, creating bind array and handling search session
     *
     * @param  array $searches
     * @return array of condation and bind array
     */
    public function handlingSearchCondition($searches)
    {
        //reset search session
        unset($_SESSION['search']);
        $cond = '';
        $bind = [];
        if (!empty($searches)) {
            foreach ($searches as $keyword) {
                $cond .= ' AND ' . $this->table . '.' . $keyword . ' LIKE :' . $keyword . ' ';
                $bind[':' . $keyword] = $_POST['search'][$keyword];
                $_SESSION['search'][$keyword] = $_POST['search'][$keyword];
            }
        }
        return $data = ['cond' => $cond, 'bind' => $bind];
    }

    /**
     * handling Search Condition on the stored session, creating bind array and handling search session
     *
     * @param  array $searches
     * @return array of condation and bind array
     */
    public function handlingSearchSessionCondition($searches)
    {
        $cond = '';
        $bind = [];
        foreach ($searches as $keyword) {
            if (isset($_SESSION['search'][$keyword])) {
                $cond .= ' AND ' . $this->table . '.' . $keyword . ' LIKE :' . $keyword;
                $bind[':' . $keyword] = $_SESSION['search'][$keyword];
            }
        }
        return $data = ['cond' => $cond, 'bind' => $bind];
    }
    /**
     * getAll data from database
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  array $bindLimit
     *
     * @return Object
     */
    public function getAll($query, $bind = '', $limit = '', $bindLimit = '')
    {
        $this->db->query($query . $limit);
        if (!empty($bind)) {
            foreach ($bind as $key => $value) {
                $this->db->bind($key, '%' . $value . '%');
            }
        }
        if (!empty($bindLimit)) {
            foreach ($bindLimit as $key => $value) {
                $this->db->bind($key, $value);
            }
        }
        $results = $this->db->resultSet();
        return $results;
    }

    /**
     * get count of all records
     * @param string $cond
     * @return array $bind
     */
    public function countAll($cond = '', $bind = '')
    {
        $this->db->query('SELECT count(*) as count FROM ' . $this->table . ' ' . $cond);
        if (!empty($bind)) {
            foreach ($bind as $key => $value) {
                $this->db->bind($key, '%' . $value . '%');
            }
        }
        $this->db->excute();
        return $this->db->single();
    }

}
