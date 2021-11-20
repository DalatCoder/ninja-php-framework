<?php

namespace Lab07\Entity;

use Ninja\DatabaseTable;

class EmployeeEntity
{
    const PRIMARY_KEY = 'id';
    const TABLE = 'employees';
    const CLASS_NAME = '\\Lab07\\Entity\\EmployeeEntity';
    
    public $id;
    public $name;
    public $surname;
    public $email;
    public $phone;
    public $department_id;
    
    protected DatabaseTable $department_table;
    
    protected $department;
    
    public function __construct(DatabaseTable $department_table)
    {
        $this->department_table = $department_table;
    }
    
    public function get_department()
    {
        if (!$this->department)
            $this->department = $this->department_table->findById($this->department_id);
        
        return $this->department;
    }
}
