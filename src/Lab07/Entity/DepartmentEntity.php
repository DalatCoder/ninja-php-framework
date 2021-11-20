<?php

namespace Lab07\Entity;

use Ninja\DatabaseTable;

class DepartmentEntity
{
    const PRIMARY_KEY = 'id';
    const TABLE = 'department';
    const CLASS_NAME = '\\Lab07\\Entity\\DepartmentEntity';
    
    public $id;
    public $name;
    
    private $employee_table;
    private $employees;
    
    public function __construct(DatabaseTable $employee_table)
    {
        $this->employee_table = $employee_table;
    }

    public function get_employees()
    {
        if (!$this->employees)
            $this->employees = $this->employee_table->find('department_id', $this->id) ?? [];
        return $this->employees;
    }
}
