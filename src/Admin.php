<?php

use Src\categories\Categorie;

class Admin extends User {
    private $category;

    public function __construct($db) {
        parent::__construct($db); 
        $this->category = new Category($db);  
    }

    public function createCategory($category_name) {
        $this->category->name = $category_name;
        return $this->category->create();
    }

    public function updateCategory($category_id, $category_name) {
        $this->category->id = $category_id;
        $this->category->name = $category_name;
        return $this->category->update();
    }

    public function deleteCategory($category_id) {
        $this->category->id = $category_id;
        return $this->category->delete();
    }

    public function listCategories() {
        return $this->category->read();
    }
}

?>