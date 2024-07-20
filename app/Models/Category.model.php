<?php

namespace Models;

use Core\Database;
use Core\Model;
use Helpers\FileUploadValidator;
use Helpers\StringValidator;

class Category extends CategoryValidation
{
    private string $categoryID;
    private string $name;
    private string $description;

    public function __construct(string $categoryID = '', string $name = '', string $description = '')
    {
        $this->categoryID = $categoryID;
        $this->name = $name;
        $this->description = $description;
    }

        public function getCategoryID(): string
        {
            return $this->categoryID;
        }
    
        public function setCategoryID(string $categoryID = ''): void
        {
            $this->categoryID = $categoryID;
        }
    
        public function getName(): string
        {
            return $this->name;
        }
    
        public function setName(string $name = ''): void
        {
            $this->name = $name;
        }
    
        public function getDescription(): string
        {
            return $this->description;
        }
    
        public function setDescription(string $description = ''): void
        {
            $this->description = $description;
        }

    public function fetchNumberOfCategories(): int
    {
        return Model::table('categories')->count();
    }
    public function fetchCategories($sort = 'DESC'): array
    {
        return Model::table('categories')->select('category_ID', 'name', 'description', 'image_url')->orderBy('create_date', $sort)->get();;
    }

    public function fetchCategoryDetails(string $categoryID = '') : array 
    {
        return Model::table('categories')->select()->where('category_ID', $categoryID)->get();
    }

    public function fetchCategoriesName() : array {
        $query = "SELECT `category_ID`, `name` FROM `categories`";
        return Database::executeQuery($query);
    }
}