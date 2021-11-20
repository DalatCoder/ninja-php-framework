<?php

namespace Lab07\Controller;

use Ninja\DatabaseTable;
use Ninja\NJTrait\Jsonable;
use Ninja\Template;

class EmployeeController extends \Ninja\NJBaseController\NJBaseController implements \Ninja\NJInterface\IController
{
    use Jsonable;
    
    protected DatabaseTable $employee_table;
    protected DatabaseTable $department_table;
    
    public function __construct(DatabaseTable $employee_table, DatabaseTable $department_table)
    {
        parent::__construct();
        
        $this->employee_table = $employee_table;
        $this->department_table = $department_table;
    }

    public function index() 
    {
        $employees = $this->employee_table->findAll();
        
        Template::view('lab07/employee/index.html.php', [
            'employees' => $employees
        ]);
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;
        
        $employee = $this->employee_table->findById($id);
        
        Template::view('lab07/employee/show.html.php', [
            'employee' => $employee
        ]);
    }

    public function create()
    {
        $departments = $this->department_table->findAll();
        
        Template::view('lab07/employee/create.html.php', [
            'departments' => $departments
        ]);
    }

    public function store()
    {
        $employee = $_POST['employee'];
        $this->employee_table->save($employee);
        
        header('location: /employee');
    }

    public function edit()
    {
        $employee_id = $_GET['id'] ?? null;
        
        $employee = $this->employee_table->findById($employee_id);
        $departments = $this->department_table->findAll();
        
        Template::view('lab07/employee/edit.html.php', [
            'employee' => $employee,
            'departments' => $departments
        ]);
    }

    public function update()
    {
        $employee = $_POST['employee'];
        $this->employee_table->save($employee);

        header('location: /employee');
    }

    public function destroy()
    {
        $id = $_POST['id'] ?? null;
        
        $this->employee_table->delete($id);
        
        $this->response_json([
            'status' => 'success',
            'data' => null
        ]);
    }
}
