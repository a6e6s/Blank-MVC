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

class Page {

    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    /**
     * get all pages from datatbase
     * @return object page data
     */
    public function getPages($cond = '', $bind = '', $limit = '', $bindLimit) {
        $this->db->query('SELECT page_id, title, image, meta_keywords, meta_description, hits, status, create_date, modified_date '
                . 'FROM pages ' . $cond . ' ORDER BY pages.create_date DESC ' . $limit);
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
     * get all pages from datatbase
     * @return object page data
     */
    public function getPagesTitle($cond = '') {
        $this->db->query('SELECT page_id, title FROM pages WHERE status =1 ORDER BY pages.create_date DESC ');        
        $results = $this->db->resultSet();
        return $results;
    }
    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allPagesCount($cond = '', $bind = '') {
        $this->db->query('SELECT count(*) as count FROM pages ' . $cond);
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
        $this->db->query('UPDATE pages SET status = 2 WHERE page_id IN (' . implode(',', $id_num) . ')');
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
        $this->db->query('UPDATE pages SET status = 1 WHERE page_id IN (' . implode(',', $id_num) . ')');
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
        $this->db->query('UPDATE pages SET status = 0 WHERE page_id IN (' . implode(',', $id_num) . ')');
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
     * insert new page 
     * @param array $data
     * @return boolean
     */
    public function addPage($data) {
        $this->db->query('INSERT INTO pages( title, content, image, meta_keywords, meta_description, status, modified_date, create_date)'
                . ' VALUES (:title, :content, :image, :meta_keywords, :meta_description, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':meta_keywords', $data['meta_keywords']);
        $this->db->bind(':meta_description', $data['meta_description']);
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

    public function updatePage($data) {
        $query = 'UPDATE pages SET title = :title, content = :content, meta_keywords = :meta_keywords,'
                . ' meta_description = :meta_description, status = :status, modified_date = :modified_date';
        (empty($data['image'])) ? null : $query.=', image = :image';
        $query .= ' WHERE page_id = :page_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':page_id', $data['page_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':meta_keywords', $data['meta_keywords']);
        $this->db->bind(':meta_description', $data['meta_description']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        empty($data['image']) ? NULL : $this->db->bind(':image', $data['image']);
        // excute
        if ($this->db->excute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * get page by id
     * @param integer $id
     * @return object page data
     */
    public function getPageById($id) {
        $this->db->query('SELECT * FROM pages WHERE page_id= :page_id');
        $this->db->bind(':page_id', $id);
        $row = $this->db->single();
        return $row;
    }

    /**
     * clear HTML string with html purifier
     * @param type $stringHTML
     * @return string HTML
     */
    public function cleanHTML($stringHTML) {
        if (!empty($stringHTML)) {
            require_once '../helpers/htmlpurifier/HTMLPurifier.auto.php';
            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);
            return $content = $purifier->purify($_POST['content']);
        } else {
            return NULL;
        }
    }

}
