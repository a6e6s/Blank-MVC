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

class User extends ModelAdmin
{

    /**
     * setting table name
     */
    public function __construct()
    {
        parent::__construct('users');
    }

   
    /**
     * get all users from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object user data
     */
    public function getUsers($cond = '', $bind = '', $limit = '', $bindLimit = '')
    {
        $query = 'SELECT user_id, users.name, groups.name AS usergroup, email, mobile, image, users.group_id, users.status, users.create_date, users.modified_date '
            . 'FROM users INNER JOIN groups  ON users.group_id = groups.group_id  ' . $cond . ' ORDER BY users.create_date DESC ';
        return $this->getAll($query, $bind, $limit, $bindLimit);

    }

    /**
     * get list of user groups
     * @param string $cond
     * @return object group list
     */
    public function groupList($cond = '')
    {
        $query = 'SELECT group_id, groups.name FROM groups  ' . $cond . ' ORDER BY create_date DESC ';
        $this->db->query($query);
        $results = $this->db->resultSet();
        return $results;
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allUsersCount($cond = '', $bind = '')
    {
        return $this->countAll(' INNER JOIN groups  ON users.group_id = groups.group_id  ' . $cond, $bind);
    }

    /**
     * insert new user
     * @param array $data
     * @return boolean
     */
    public function addUser($data)
    {
        $this->db->query('INSERT INTO users( name, email, password, mobile, image, bio, group_id, status, create_date, modified_date)'
            . ' VALUES (:name, :email, :password, :mobile, :image, :bio, :group_id, :status, :create_date, :modified_date)');
        // binding values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':mobile', $data['mobile']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':bio', $data['bio']);
        $this->db->bind(':group_id', $data['group_id']);
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

    public function updateUser($data)
    {
        $query = 'UPDATE users SET name = :name, email = :email, mobile = :mobile, bio = :bio, group_id = :group_id';
        (!empty($data['password'])) ? $query .= ', password = :password ' : '';
        (!empty($data['image'])) ? $query .= ', image = :image ' : '';
        $query .= ', status = :status, modified_date = :modified_date  WHERE user_id = :user_id';

        $this->db->query($query);
        // binding values
        (!empty($data['password'])) ? $this->db->bind(':password', $data['password']) : '';
        (!empty($data['image'])) ? $this->db->bind(':image', $data['image']) : '';
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':mobile', $data['mobile']);
        $this->db->bind(':bio', $data['bio']);
        $this->db->bind(':group_id', $data['group_id']);
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
     * get user by id
     * @param integer $id
     * @return object user data
     */
    public function getUserById($id)
    {
        $this->db->query('SELECT *, groups.name AS usergroup '
            . 'FROM groups INNER JOIN users ON users.group_id = groups.group_id WHERE user_id= :user_id');

        $this->db->bind(':user_id', $id);
        $row = $this->db->single();
        return $row;
    }

    /**
     * Find user by email
     * @param string $email
     * @return boolean
     */
    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        // Bind value
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Login User
     * @param string $email
     * @param string $password
     * @return boolean or array of user and his group
     */
    public function login($email, $password)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $user = $this->db->single();

        $hashed_password = $user->password;
        if (password_verify($password, $hashed_password)) {
            unset($user->password);
            // if user exist get his group data
            $this->db->query('SELECT * FROM groups WHERE group_id = :group_id');
            $this->db->bind(':group_id', $user->group_id);
            $group = $this->db->single();
            // update login date
            $this->db->query('UPDATE users SET login_date = ' . time() . ' WHERE user_id = ' . $user->user_id);
            $this->db->excute();

            return ['user' => $user, 'group' => $group];
        } else {
            return false;
        }
    }

    /**
     * handling user session
     * @param array $userinfo
     */
    public function createUserSession($userinfo)
    {
        // adding user information to session
        $_SESSION['user'] = $userinfo['user'];
        $_SESSION['group'] = $userinfo['group'];
        // adding permission object to session
        $_SESSION['permissions'] = json_decode($userinfo['group']->permissions);
        // allow file manager
        $_SESSION['filemanager'] = true;
    }

    /**
     * request new password for user
     * @param type $email
     */
    public function forget($email)
    {
        //generate random code and store it in database
        $code = sha1(rand(99999, 999999));
        $this->db->query('UPDATE users SET activation_code = "' . $code . '",request_password_time ="' . time() . '" WHERE  email = :email ');
        $this->db->bind(':email', $email);
        $this->db->excute();
        // send email url to user
        $message = 'لقد طلبت إستعادة كلمة المرور الخاصة بك .
                    إذا كنت ترغب بتغيير كلمة المرور الخاصة بك يرجى الضغط على الرابط التالي:
                    ' . ADMINURL . '/users/reset/' . $code . '
                    إن لم تكن تتوقع وصول هذه الرسالة وتظن أنها وصلتك بالخطأ يمكنك تجاهلها.
                    أطيب التحيات، ';
        mail($email, 'تعليمات إعادة تعيين كلمة المرور‎', $message);
    }

    /**
     * check if code is valid and not expired
     * @param string hash $code
     * @return boolean
     */
    public function checkCodeValidation($code)
    {
        $this->db->query('SELECT * FROM users WHERE activation_code = :activation_code');
        $this->db->bind(':activation_code', $code);
        $user = $this->db->single();
        // Check row
        if ($this->db->rowCount() > 0) {
            if (($user->request_password_time + 86400) > time()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * reset Validation Code
     * reset password
     * @param string $email
     * @return boolean
     */
    public function updatePassword($password, $code)
    {
        $this->db->query('UPDATE users SET password = :password, activation_code = "' . rand(1212, 121222) . '",request_password_time ="0" WHERE  activation_code = :activation_code ');
        $this->db->bind(':password', $password);
        $this->db->bind(':activation_code', $code);
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

}
