<?php

class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $username;
    public $telephone;
    public $password;
    public $email;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function userExists($email) {
        $query = 'SELECT id FROM ' . $this->table . ' WHERE email = :email';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function register() {
        // Проверяем, существует ли пользователь с таким email
        $query = 'SELECT id FROM ' . $this->table . ' WHERE email = :email';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Пользователь с таким email уже существует
            return false;
        }

        // Продолжаем с регистрацией, так как пользователя с таким email нет в базе
        $query = 'INSERT INTO ' . $this->table . ' 
              SET username = :username, telephone = :telephone, email = :email, password = :password';
        $stmt = $this->conn->prepare($query);

        // Остальной код остается без изменений
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->telephone = htmlspecialchars(strip_tags($this->telephone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':telephone', $this->telephone);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }


    public function authenticate() {
        $query = 'SELECT id, username, password
              FROM ' . $this->table . '
              WHERE email = :email';

        $stmt = $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(':email', $this->email);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $stored_password = $row['password'];

            if (password_verify($this->password, $stored_password)) {
                $this->id = $row['id'];
                $this->username = $row['username'];

                return true;
            }
        }

        return false;
    }
}
