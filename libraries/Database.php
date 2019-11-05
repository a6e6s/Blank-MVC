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

/**
 * the PDO database class
 * connect to database
 * create prepered statment
 * return rows and results
 */
class Database {

    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    //database handler
    private $dbh;
    //hold statments
    private $stmt;
    //error
    private $error;

    /*
     * setup connection
     */

    function __construct() {

//set DSN
        $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8";
        $options = array(PDO::ATTR_PERSISTENT => TRUE, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        // create a PDO instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $exc) {
            $this->error = $exc->getMessage();
            echo $this->error;
        }
    }

    /**
     * prepare statment with query
     * @param string $sql
     */
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * bind values
     * @param string $param
     * @param string $value
     * @param string $type
     */
    public function bind($param, $value, $type = NULL) {
        if (is_null($type)) {
            switch (TRUE) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_string($value):
                    $type = PDO::PARAM_STR;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * execute the prepare statment
     * @return bool
     */
    public function excute() {
        return $this->stmt->execute();
    }

    /**
     * get result set as array of objects
     * @return array of objects
     */
    public function resultSet() {
        $this->excute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * get single record as object
     * @return record as object
     */
    public function single() {
        $this->excute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * get row count
     * @return int row count
     */
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    /**
     * return last inserted id
     * @return type
     */
    public function lastId() {
        return $this->dbh->lastInsertId();
    }
    /**
     * get error code
     * @return int
     */
    public function errorCode() {
        return $this->dbh->errorCode();
    }
}
