<?php

namespace App\Models;

use App\Database\Mysqldbo;

class User {

    protected $mysqldbo;

    function __construct() {
       // needs to be initialised with dbo settings in constructor it will break.
            $this->mysqldbo = Mysqldbo::getInstance();
       }

    public function getUsers() {
        $r = array();
        $sql = "SELECT * FROM users";
        $stmt = $this->mysqldbo->dbo->prepare($sql);
        //$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $r = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            $r = 0;
        }
        return $r;
    }

    public function getUserById($id) {
        $r = array();
        $sql = "SELECT * FROM users WHERE name=$id";
        $stmt = $this->mysqldbo->dbo->prepare($sql);
        //$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $r = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            $r = 0;
        }
        return $r;
    }

    /**
     * @param Array $data
     * ['name','fullname','password']
     * @return string
     */
    public function insertUser($data)
    {
        $data['password']= password_hash($data['password'] , PASSWORD_DEFAULT);
        try {
            $sql = "INSERT INTO users (name, fullname, hash)"
                .  "VALUES (:name, :fullname, :password)";
            $stmt = $this->mysqldbo->dbo->prepare($sql);
            if ($stmt->execute($data)) {
                return $this->mysqldbo->dbo->lastInsertId();
            } else {
                return '0';
            }
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function updateUser($data)
    {
        $data['password']= password_hash($data['password'] , PASSWORD_DEFAULT);
        try {
            $sql = "UPDATE users SET name=:name, fullname=:fullname, hash=:password";
            $stmt = $this->mysqldbo->dbo->prepare($sql);
            return $stmt->execute($data);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}