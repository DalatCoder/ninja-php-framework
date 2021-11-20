<?php

namespace Lab07\Controller;

use Ninja\DatabaseTable;
use Ninja\NJTrait\Jsonable;
use Ninja\Template;

class DepartmentController extends \Ninja\NJBaseController\NJBaseController implements \Ninja\NJInterface\IController
{
    use Jsonable;
    
    protected DatabaseTable $department_table;
    
    public function __construct(DatabaseTable $department_table)
    {
        $this->department_table = $department_table;
        
        parent::__construct();
    }

    public function index()
    {
        $departments = $this->department_table->findAll();
        
        Template::view('lab07/department/index.html.php', [
            'departments' => $departments
        ]);
    }

    public function show()
    {
        // TODO: Implement show() method.
    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function store()
    {
        $departmnet = $_POST['department'];
        $entity = $this->department_table->save($departmnet);
        
        $this->response_json([
            'status' => 'success',
            'data' => [
                'id' => $entity->id,
                'title' => $_POST['department']['name']
            ]
        ], 201);
    }

    public function edit()
    {
        // TODO: Implement edit() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function destroy()
    {
        // TODO: Implement destroy() method.
    }
}
