<?php
namespace Src\auth;

use Src\Crud\CRUD;

class Signup {
    private $crud;

    public $id;
    public $username;
    public $email;
    public $password_hash;
    public $profile_picture_url;

    public function __construct($db) {
        $this->crud = new CRUD($db, "users"); 
    }


    public function create() {
        $this->crud->fields = [
            'username' => $this->username,
            'email' => $this->email,
            'password_hash' => $this->password_hash,
            'profile_picture_url' => $this->profile_picture_url,
        ];
        return $this->crud->create();
    }

}

?>