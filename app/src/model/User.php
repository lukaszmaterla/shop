<?php

/**
 * Created by PhpStorm.
 * User: lukasz
 * Date: 22.05.17
 * Time: 18:29
 */
class User extends ActiveRecord
{
    private $username;
    private $email;
    private $passwordHash;

    public function __construct()
    {

        parent::__construct();
        $this->username = '';
        $this->email = '';
        $this->passwordHash = '';
    }

    public function save()
    {
        parent::save();
        if ($this->id == -1) {
            $sql = "INSERT INTO users (username, email, passwordHash) VALUES (:username, :email, :passwordHash)";
            $stmt = self::$db->conn->prepare($sql);

            if (User::loadByEmail($this->getEmail()) == null) {
                $result = $stmt->execute([
                    'username' => $this->username,
                    'email' => $this->email,
                    'passwordHash' => $this->passwordHash
                ]);
                if ($result == true) {
                    $this->id = self::$db->conn->lastInsertId();
                    return true;
                }
            }
            return null;
        } else {
            $this->update();
        }
        return null;
    }

    public function update()
    {
        $sql = "UPDATE users SET username = :username, email = :email, passwordHash = :passwordHash WHERE id = :id";
        $stmt = self::$db->conn->prepare($sql);
        $result = $stmt->execute([
            'username' => $this->username,
            'email' => $this->email,
            'passwordHash' => $this->passwordHash,
            'id' => $this->id
        ]);
        return $result;
    }

    /**
     *
     */
    public function delete()
    {
        self::connect();
        if ($this->id != -1) {
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = self::$db->conn->prepare($sql);
            $result = $stmt->execute(['id' => $this->id]);

        }
    }

    /**
     * @param $id
     * @return null
     */
    static public function loadById($id)
    {
        self::connect();
        $sql = "SELECT * FROM users WHERE id=:id";
        $stmt = self::$db->conn->prepare($sql);
        $result = $stmt->execute(['id' => $id]);
        $loadedUser = new User();
        if ($result && $stmt->rowCount() >= 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->username = $row['username'];
            $loadedUser->passwordHash = $row['passwordHash'];
            $loadedUser->email = $row['email'];
            return $loadedUser;
        }
        return null;
    }

    static public function loadAll()
    {
        self::connect();
        $sql = "SELECT * FROM users";
        $result = self::$db->conn->query($sql);

        $returnTable = [];
        if ($result !== false && $result->rowCount() > 0) {
            foreach ($result as $row) {
                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->username = $row['username'];
                $loadedUser->passwordHash = $row['passwordHash'];
                $loadedUser->email = $row['email'];
                $returnTable[] = $loadedUser;
            }
        }
        return $returnTable;
    }

    static public function loadByEmail($email)
    {
        self::connect();
        $sql = "SELECT * FROM users WHERE email=:email";
        $stmt = self::$db->conn->prepare($sql);
        $result = $stmt->execute(['email' => $email]);
        if ($result && $stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->username = $row['username'];
            $loadedUser->passwordHash = $row['passwordHash'];
            $loadedUser->email = $row['email'];
            return $loadedUser;
        }
        return null;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $passwordHash
     */
    public function setPasswordHash($password)
    {
        $this->passwordHash = User::createPasswordHashed($password);
        return $this;
    }
    public static function createPasswordHashed($password)
    {
        return md5($password);
    }

    /**
     * @return string
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }



}