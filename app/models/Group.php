<?php

/*
 * Copyright (C) 2018 Easy CMS Framework Ahmed Elmahdy
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License
 * @license    https://opensource.org/licenses/GPL-3.0
 *
 * @package    Easy CMS MVC framework
 * @author     Ahmed Elmahdy
 * @link       https://ahmedx.com
 *
 * For more information about the author , see <http://www.ahmedx.com/>.
 */

class Group {

    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    /**
     * get all groups from datatbase
     * @return object group data
     */
    public function getGroups($cond = '', $bind = '', $limit = '', $bindLimit = '') {
        $query = 'SELECT group_id, name, description, permissions, status, create_date, modified_date '
                . 'FROM groups ' . $cond . ' ORDER BY groups.create_date DESC ';
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
     * @param type $cond
     * @return type
     */
    public function allGroupsCount($cond = '', $bind = '') {
        $this->db->query('SELECT count(*) as count FROM groups ' . $cond);
        if (!empty($bind)) {
            foreach ($bind as $key => $value) {
                $this->db->bind($key, '%' . $value . '%');
            }
        }
        $this->db->excute();
        return $this->db->single();
    }

    /**
     * Delete one or more records by id 
     * @param Array $ids
     * @return boolean or row count
     */
    public function deleteById($ids) {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($ids); $index++) {
            $id_num[] = ":id" . $index;
        }
        //setting the query
        $this->db->query('UPDATE groups SET status = 2 WHERE group_id IN (' . implode(',', $id_num) . ')');
        //loop through the bind function to bind all the IDs
        foreach ($ids as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return FALSE;
        }
    }

    /**
     * publish one or more records by id 
     * @param Array $ids
     * @return boolean or row count
     */
    public function publishById($ids) {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($ids); $index++) {
            $id_num[] = ":id" . $index;
        }
        //setting the query
        $this->db->query('UPDATE groups SET status = 1 WHERE group_id IN (' . implode(',', $id_num) . ')');
        //loop through the bind function to bind all the IDs
        foreach ($ids as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return FALSE;
        }
    }

    /**
     * unpublish one or more records by id 
     * @param Array $ids
     * @return boolean or row count
     */
    public function unpublishById($ids) {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($ids); $index++) {
            $id_num[] = ":id" . $index;
        }
        //setting the query
        $this->db->query('UPDATE groups SET status = 0 WHERE group_id IN (' . implode(',', $id_num) . ')');
        //loop through the bind function to bind all the IDs
        foreach ($ids as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return FALSE;
        }
    }

    /**
     * insert new group 
     * @param array $data
     * @return boolean
     */
    public function addGroup($data) {
        $this->db->query('INSERT INTO groups( name, description, permissions, status, create_date, modified_date)'
                . ' VALUES (:name, :description, :permissions, :status, :create_date, :modified_date)');
        // binding values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':permissions', $data['permissions']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());

        // excute
        if ($this->db->excute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateGroup($data) {
        $query = 'UPDATE groups SET name = :name, description = :description, permissions = :permissions,'
                . ' status = :status, modified_date = :modified_date  WHERE group_id = :group_id';
        $this->db->query($query);
        // binding values

        $this->db->bind(':group_id', $data['group_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':permissions', $data['permissions']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * get group by id
     * @param integer $id
     * @return object group data
     */
    public function getGroupById($id) {
        $this->db->query('SELECT * FROM groups WHERE group_id= :group_id');
        $this->db->bind(':group_id', $id);
        $row = $this->db->single();
        return $row;
    }


}
