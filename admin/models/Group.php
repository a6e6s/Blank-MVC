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

class Group extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('groups');
    }

    /**
     * get all groups from datatbase
     * @return object group data
     */
    public function getGroups($cond = '', $bind = '', $limit = '', $bindLimit = '')
    {
        $query = 'SELECT group_id, name, description, permissions, status, create_date, modified_date '
            . 'FROM groups ' . $cond . ' ORDER BY groups.create_date DESC ';
        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allGroupsCount($cond = '', $bind = '')
    {
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
     * insert new group
     * @param array $data
     * @return boolean
     */
    public function addGroup($data)
    {
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
            return true;
        } else {
            return false;
        }
    }

    public function updateGroup($data)
    {
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
            return true;
        } else {
            return false;
        }
    }

    /**
     * get group by id
     * @param integer $id
     * @return object group data
     */
    public function getGroupById($id)
    {
        return $this->getById($id, 'group_id');
    }

}
