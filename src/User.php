<?php
interface Authenticate {
    static function authenticate();
}

    class User implements Authenticate {
    protected string $username;
    protected string $email;
    protected bool $isAdmin;

    public function __constructor($username, $email) {
        $this->username = $username;
        $this->email = $email;
        $isAdmin = false;
        }

    public function getUsername($username) { //ingen parameter
        return $this->$username;
    } 

    public function setEmail($email) {
        $this->email = filter_var($email,FILTER_SANITIZE_EMAIL); //behövs ej
        if (filter_var($this->email, FILTER_VAlIDATE_EMAIL)) {
            return $this->email;
        } else {
            echo "invalid format";
        }
    }
    
    public function checkIsAdmin($IsAdmin) { //parameter behövs ej
        return $this->$IsAdmin;

    }
    static function authenticate() {
     echo "User authenticated";
    }
  
}
class GuestUser implements authenticate {
    private string $username;
    private bool $isAdmin;

    private function constructor($username) {
         $this->username = $username;
        $isAdmin = false;
    }

    public function getUsername($username) {
        return $this->$username;
    } 

    public function checkIsAdmin($IsAdmin) {
        return $this->$IsAdmin;

    }
    function authenticate() {
        echo "Guest access granted";
       }
}

class Admin extends User {
    public function __constructor($username, $email) {
        $this->username = $username; // parent::__construct($username, $email)
        $this->email = $email;
        $isAdmin = true;
        }
    private function getUsers() {
        return $users = [
            new User("Alice", "Alice@example.com"),
            new User("Bob", "Bob@example.com"),
            new User("Charlie", "Charlie@example.com"),
            new Admin("Anna", "Anna@example.com"),
            new Admin("Gary", "Gary@example.com")
        ];
    }
    public function deleteUser($user) {
        echo "User ". $user . " has been deleted"; // {$user->getUsername()}
}
    public function displayUser() {
        $userData = new getUsers();
        foreach ($userData as $i) {
            echo $userData[$i]."</br>";
        }
    }

    public function checkUserRole() {
        $checkUserData = new getUsers();

        foreach($checkUserData as $i) {

            if ($checkUserData[$i] = new Admin()) {
            echo $checkUserData[$i]." is admin";

            } else {
                echo $checkUserData[$i]." is User";
            }
        }
    } 

}
?>