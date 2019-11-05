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

class Member {

    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    /**
     * get all members from datatbase
     * @return object member data
     */
    public function getMembers($cond = '', $bind = '', $limit = '', $bindLimit = '') {
        $query = 'SELECT * FROM members  ' . $cond . ' ORDER BY create_date DESC ';

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
     * get associations data
     * @return object
     */
    public function getAssociations($cond = '') {
        $this->db->query('SELECT association_id , association_name FROM associations ' . $cond . ' ORDER BY create_date DESC ');
        $results = $this->db->resultSet();
        return $results;
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allMembersCount($cond = '', $bind = '') {
        $this->db->query('SELECT count(*) as count FROM members   ' . $cond);
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
        $this->db->query('UPDATE members SET status = 2 WHERE member_id IN (' . implode(',', $id_num) . ')');
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
        $this->db->query('UPDATE members SET status = 1 WHERE member_id IN (' . implode(',', $id_num) . ')');
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
        $this->db->query('UPDATE members SET status = 0 WHERE member_id IN (' . implode(',', $id_num) . ')');
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
     * insert new member 
     * @param array $data
     * @return boolean
     */
    public function addMember($data) {
        $this->db->query('INSERT INTO members (national_id, birth_date, agreement, password, mobile, association_id, status, create_date, modified_date)'
                . ' VALUES ( :national_id, :birth_date, :agreement, :password, :mobile, :association_id, :status, :create_date, :modified_date)');
        // binding values
        $this->db->bind(':national_id', $data['national_id']);
        $this->db->bind(':birth_date', strtotime($data['birth_date']));
        $this->db->bind(':agreement', $data['agreement']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':mobile', $data['mobile']);
        $this->db->bind(':association_id', 1);
        $this->db->bind(':status', 0);
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());


        // excute
        if ($this->db->excute()) {
            return $this->db->lastId();
        } else {
            return FALSE;
        }
    }

    /**
     * Login Member
     * @param string $national_id
     * @param string $password
     * @return boolean or  member object
     */
    public function login($national_id, $password) {
        $this->db->query('SELECT * FROM members WHERE national_id = :national_id');
        $this->db->bind(':national_id', $national_id);
        $member = $this->db->single();

        $hashed_password = $member->password;
        if (password_verify($password, $hashed_password)) {
            unset($member->password);
            // update login date
            $this->db->query('UPDATE members SET login_date = ' . time() . ' WHERE member_id = ' . $member->member_id);
            $this->db->excute();
            return $member;
        } else {
            return false;
        }
    }

    /**
     * update member data step1
     * @param type $data
     * @return boolean
     */
    public function updateStep1($data) {
        $query = 'UPDATE members SET full_name = :full_name, 
                                    birth_date = :birth_date, 
                                    educational_level = :educational_level, 
                                    ability_to_work = :ability_to_work, 
                                    social_status = :social_status, 
                                    health_status = :health_status,
                                    modified_date = :modified_date ';
        (!empty($data['password'])) ? $query .= ', password = :password ' : '';
        $query .= ' WHERE member_id = :member_id';

        $this->db->query($query);
        // binding values
        $this->db->bind(':member_id', $data['member_id']);
        $this->db->bind(':full_name', $data['full_name']);
        (!empty($data['password'])) ? $this->db->bind(':password', $data['password']) : '';
        $this->db->bind(':birth_date', strtotime($data['birth_date']));
        $this->db->bind(':educational_level', $data['educational_level']);
        $this->db->bind(':ability_to_work', $data['ability_to_work']);
        $this->db->bind(':social_status', $data['social_status']);
        $this->db->bind(':health_status', $data['health_status']);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return TRUE;
        } else {
            return $this->db->errorCode();
        }
    }

    /**
     * update member data step2
     * @param type $data
     * @return boolean
     */
    public function updateStep2($data) {
        $query = 'UPDATE members SET housing_status = :housing_status, 
                                    housing_type = :housing_type, 
                                    region = :region, 
                                    city = :city, 
                                    district = :district, 
                                    street_address = :street_address, 
                                    unit_number = :unit_number, 
                                    additional_number = :additional_number, 
                                    postal_code = :postal_code,
                                    mail_box = :mail_box, 
                                    email = :email, 
                                    phone = :phone, 
                                    modified_date = :modified_date ';
        $query .= ' WHERE member_id = :member_id';

        $this->db->query($query);
        // binding values
        $this->db->bind(':member_id', $data['member_id']);
        $this->db->bind(':housing_status', $data['housing_status']);
        $this->db->bind(':housing_type', $data['housing_type']);
        $this->db->bind(':region', $data['region']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':district', $data['district']);
        $this->db->bind(':street_address', $data['street_address']);
        $this->db->bind(':unit_number', $data['unit_number']);
        $this->db->bind(':additional_number', $data['additional_number']);
        $this->db->bind(':postal_code', $data['postal_code']);
        $this->db->bind(':mail_box', $data['mail_box']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return TRUE;
        } else {
            return $this->db->errorCode();
        }
    }

    /**
     * update member data step2
     * @param type $data
     * @return boolean
     */
    public function updateStep3($data) {
        $query = 'UPDATE members SET 
                                    bank_account = :bank_account, 
                                    bank_name = :bank_name, 
                                    modified_date = :modified_date ';
        $query .= ' WHERE member_id = :member_id';

        $this->db->query($query);
        // binding values
        $this->db->bind(':member_id', $data['member_id']);
        $this->db->bind(':bank_account', $data['bank_account']);
        $this->db->bind(':bank_name', $data['bank_name']);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return TRUE;
        } else {
            return $this->db->errorCode();
        }
    }

    /**
     * get member by id
     * @param integer $id
     * @return object member data
     */
    public function getMemberById($id) {
        $this->db->query('SELECT * FROM members WHERE member_id= :member_id');

        $this->db->bind(':member_id', $id);
        $row = $this->db->single();
        return $row;
    }

    /**
     * get member by id
     * @param integer $id
     * @return object member data
     */
    public function getMemberByAssociation($id, $association_id) {
        $this->db->query('SELECT * FROM members WHERE member_id = :member_id AND association_id = :association_id');

        $this->db->bind(':association_id', $association_id);
        $this->db->bind(':member_id', $id);
        $row = $this->db->single();
        return $row;
    }

    /**
     * Find member by email
     * @param string $email
     * @return boolean 
     */
    public function findMemberByEmail($email, $id = '') {
        $query = 'SELECT * FROM members WHERE email = :email';
        if (!empty($id)) {
            $query .= ' AND member_id <> :member_id';
        }
        $this->db->query($query);
        // Bind value
        $this->db->bind(':email', $email);
        if (!empty($id)) {
            $this->db->bind(':member_id', $id);
        }
        $row = $this->db->single();
        // Check row
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *  Find member by phone
     * @param type $phone
     * @return boolean
     */
    public function findMemberByPhone($phone, $id = '') {
        $query = 'SELECT * FROM members WHERE phone = :phone';
        if (!empty($id)) {
            $query .= ' AND member_id <> :member_id';
        }
        $this->db->query($query);
        // Bind value
        $this->db->bind(':phone', $phone);
        if (!empty($id)) {
            $this->db->bind(':member_id', $id);
        }
        $row = $this->db->single();
        // Check row
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *  Find member by mobile
     * @param type $mobile
     * @return boolean
     */
    public function findMemberByMobile($mobile, $id = '') {
        $query = 'SELECT * FROM members WHERE mobile = :mobile';
        if (!empty($id)) {
            $query .= ' AND member_id <> :member_id';
        }
        $this->db->query($query);
        // Bind value
        $this->db->bind(':mobile', $mobile);
        if (!empty($id)) {
            $this->db->bind(':member_id', $id);
        }
        $row = $this->db->single();
        // Check row
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Find member by national_id
     * @param type $national_id
     * @return boolean
     */
    public function findMemberByNId($national_id, $id = '') {
        $query = 'SELECT * FROM members WHERE national_id = :national_id';
        if (!empty($id)) {
            $query .= ' AND member_id <> :member_id';
        }
        $this->db->query($query);
        // Bind value
        $this->db->bind(':national_id', $national_id);
        if (!empty($id)) {
            $this->db->bind(':member_id', $id);
        }
        $row = $this->db->single();
        // Check row
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * handling member session
     * @param array $memberinfo
     */
    public function createMemberSession($memberinfo) {
        // adding member information to session
        $_SESSION['member'] = $memberinfo;
        $_SESSION['memberLogged'] = TRUE;
    }

    /**
     * check if member is logged
     * @return boolean
     */
    public function isMemberLogged() {
        if (isset($_SESSION['memberLogged'])) {
            if ($_SESSION['memberLogged'] == TRUE) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * request new password for member
     * @param type $email
     */
    public function forget($email) {
        //generate random code and store it in database
        $code = sha1(rand(99999, 999999));
        $this->db->query('UPDATE members SET activation_code = "' . $code . '",request_password_time ="' . time() . '" WHERE  email = :email ');
        $this->db->bind(':email', $email);
        $this->db->excute();
        // send email url to member
        $message = 'لقد طلبت إستعادة كلمة المرور الخاصة بك .
                    إذا كنت ترغب بتغيير كلمة المرور الخاصة بك يرجى الضغط على الرابط التالي:
                    ' . ADMINURL . '/members/reset/' . $code . '
                    إن لم تكن تتوقع وصول هذه الرسالة وتظن أنها وصلتك بالخطأ يمكنك تجاهلها.
                    أطيب التحيات، ';
        mail($email, 'تعليمات إعادة تعيين كلمة المرور‎', $message);
    }

    /**
     * check if code is valid and not expired 
     * @param string hash $code
     * @return boolean
     */
    public function checkCodeValidation($code) {
        $this->db->query('SELECT * FROM members WHERE activation_code = :activation_code');
        $this->db->bind(':activation_code', $code);
        $member = $this->db->single();
        // Check row
        if ($this->db->rowCount() > 0) {
            if (($member->request_password_time + 86400) > time()) {
                return true;
            } else {
                return FALSE;
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
    public function updatePassword($password, $code) {
        $this->db->query('UPDATE members SET password = :password, activation_code = "' . rand(1212, 121222) . '",request_password_time ="0" WHERE  activation_code = :activation_code ');
        $this->db->bind(':password', $password);
        $this->db->bind(':activation_code', $code);
        if ($this->db->excute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * get cities list
     * @return array
     */
    public function getCities() {
        $cities = "الرياض,جدة,مكة المكرمة,المدينة المنورة,سلطانة,الدمام,الطائف,تبوك,الخرج,بريدة,خميس مشيط,الهفوف,المبرز,حفر الباطن
                ,حائل,نجران,الجبيل,أبها,ينبع,الخُبر,عنيزة,عرعر,سكاكا,جازان,القريات,الظهران,القطيف,الباحة,تاروت,البيشة,الرس,الشفا
                ,سيهات,المذنب,الخفجي,الدوادمي,صبيا,الزلفي,أبو العريش,الصفوى,رابغ,رحيمة,الطريف,عفيف,طبرجل,الدلم,أملج,العلا,بقيق,بدر حنين
                ,صامطة,الوجه,البكيرية,نماص,السليل,تربة,الجموم,ضباء,الطريف,القيصومة,البطالية,المنيزلة,المجاردة,تنومة,القرين,أم الساهك,ساجر
                ,الأوجام,فرسان,المندق,الأرطاوية,جبيل,القارة,مرات,الجفر,صوير,تمير,التوبي,الجرادية,المويه,السفانية,الهدا,المركز,المسلية
                ,المطير,المزهرة,الدرب,الجليجلة,مليجه,الفويلق,طابا";
        return explode(',', $cities);
    }

    /**
     * return region list
     * @return array
     */
    public function getregions() {
        $region = 'منطقة مكة المكرمة	, منطقة المدينة المنورة	, منطقة القصيم	, المنطقة الشرقية	, منطقة عسير	, منطقة تبوك	, منطقة حائل	,
                 منطقة الحدود الشمالية	, منطقة جازان	, منطقة نجران	, منطقة الباحة	, منطقة الجوف';
        return explode(',', $region);
    }

    /**
     * get relatives by member Id
     * @param type $id
     * @return type
     */
    public function getRelatives($id) {
        $this->db->query('SELECT * FROM relatives WHERE member_id = :member_id AND status <> 2 ORDER BY create_date DESC ');
        $this->db->bind(':member_id', $id);
        $results = $this->db->resultSet();
        return $results;
    }

    /**
     * Find member by national_id
     * @param type $national_id
     * @return boolean
     */
    public function findRelativeByNId($re_national_id) {
        $query = 'SELECT * FROM relatives WHERE re_national_id = :re_national_id';
        $this->db->query($query);
        // Bind value
        $this->db->bind(':re_national_id', $re_national_id);
        $row = $this->db->single();
        // Check row
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adding new relative 
     * @param array $data
     * @return boolean
     */
    public function addRelative($data) {
        $this->db->query('INSERT INTO relatives (member_id,re_full_name ,re_national_id ,re_birth_date ,re_job_status ,re_health_status,status, create_date, modified_date)'
                . ' VALUES (:member_id,:re_full_name ,:re_national_id ,:re_birth_date ,:re_job_status ,:re_health_status,:status, :create_date, :modified_date)');
        $this->db->bind(':member_id', $data['member_id']);
        $this->db->bind(':re_full_name', $data['re_full_name']);
        $this->db->bind(':re_national_id', $data['re_national_id']);
        $this->db->bind(':re_birth_date', strtotime($data['re_birth_date']));
        $this->db->bind(':re_job_status', $data['re_job_status']);
        $this->db->bind(':re_health_status', $data['re_health_status']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        $this->db->bind(':create_date', time());
        // excute
        if ($this->db->excute()) {
            return $this->db->lastId();
        } else {
            return FALSE;
        }
    }

    /**
     * get member income
     * @param type $id
     * @return object
     */
    public function getIncomes($id) {
        $this->db->query('SELECT * FROM incomes WHERE member_id = :member_id AND status <> 2 ORDER BY create_date DESC ');
        $this->db->bind(':member_id', $id);
        $results = $this->db->resultSet();
        return $results;
    }

    /**
     * insert member income
     * @param type $data
     * @return boolean
     */
    public function addIncome($data) {
        $this->db->query('INSERT INTO incomes (member_id,income_type,income_source,income_monthly,income_yearly,status, create_date, modified_date)'
                . ' VALUES (:member_id,:income_type,:income_source,:income_monthly,:income_yearly,:status, :create_date, :modified_date)');
        $this->db->bind(':member_id', $data['member_id']);
        $this->db->bind(':income_type', $data['income_type']);
        $this->db->bind(':income_source', $data['income_source']);
        $this->db->bind(':income_monthly', $data['income_monthly']);
        $this->db->bind(':income_yearly', $data['income_yearly']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        $this->db->bind(':create_date', time());
        // excute
        if ($this->db->excute()) {
            return $this->db->lastId();
        } else {
            return FALSE;
        }
    }

    /**
     * get member realstates
     * @param type $id
     * @return type
     */
    public function getRealstate($id) {
        $this->db->query('SELECT * FROM realstates WHERE member_id = :member_id AND status <> 2 ORDER BY create_date DESC ');
        $this->db->bind(':member_id', $id);
        $results = $this->db->resultSet();
        return $results;
    }

    /**
     * adding member realstate
     * @param type $data
     * @return boolean
     */
    public function addRealstate($data) {
        $this->db->query('INSERT INTO realstates (realstate_num, realstate_own_percint, realstate_region, realstate_city, realstate_aria, member_id, status, modified_date, create_date)'
                . ' VALUES (:realstate_num,:realstate_own_percint,:realstate_region,:realstate_city,:realstate_aria,:member_id,:status, :modified_date, :create_date)');
        $this->db->bind(':member_id', $data['member_id']);
        $this->db->bind(':realstate_num', $data['realstate_num']);
        $this->db->bind(':realstate_own_percint', $data['realstate_own_percint']);
        $this->db->bind(':realstate_region', $data['realstate_region']);
        $this->db->bind(':realstate_city', $data['realstate_city']);
        $this->db->bind(':realstate_aria', $data['realstate_aria']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        $this->db->bind(':create_date', time());
        // excute
        if ($this->db->excute()) {
            return $this->db->lastId();
        } else {
            return FALSE;
        }
    }

}
