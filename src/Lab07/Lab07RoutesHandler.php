<?php

namespace Lab07;

use Lab07\Controller\DepartmentController;
use Lab07\Controller\EmployeeController;
use Lab07\Entity\DepartmentEntity;
use Lab07\Entity\EmployeeEntity;
use Ninja\DatabaseTable;

class Lab07RoutesHandler implements \Ninja\NJInterface\IRoutes
{
    protected $employee_table;
    protected $department_table;
    
    public function __construct()
    {
        $this->employee_table = new DatabaseTable(EmployeeEntity::TABLE, EmployeeEntity::PRIMARY_KEY, EmployeeEntity::CLASS_NAME, [
            &$this->department_table
        ]);
        $this->department_table = new DatabaseTable(DepartmentEntity::TABLE, DepartmentEntity::PRIMARY_KEY, DepartmentEntity::CLASS_NAME, [
            &$this->employee_table
        ]);
    }

    public function getRoutes(): array
    {
        $employee_controller = new EmployeeController($this->employee_table, $this->department_table);
        $department_controller = new DepartmentController($this->department_table);
        
        return [
            '/' => [
                'REDIRECT' => '/employee'
            ],
            '/employee' => [
                'GET' => [
                    'controller' => $employee_controller,
                    'action' => 'index'
                ]
            ],
            '/employee/show' => [
                'GET' => [
                    'controller' => $employee_controller,
                    'action' => 'show'
                ]
            ],
            '/employee/create' => [
                'GET' => [
                    'controller' => $employee_controller,
                    'action' => 'create'
                ],
                'POST' => [
                    'controller' => $employee_controller,
                    'action' => 'store'
                ]
            ],
            '/employee/edit' => [
                'GET' => [
                    'controller' => $employee_controller,
                    'action' => 'edit'
                ],
                'POST' => [
                    'controller' => $employee_controller,
                    'action' => 'update'
                ]
            ],
            '/employee/destroy' => [
                'POST' => [
                    'controller' => $employee_controller,
                    'action' => 'destroy'
                ]
            ],
            '/department' => [
                'GET' => [
                    'controller' => $department_controller,
                    'action' => 'index'
                ]
            ],
            '/department/create' => [
                'POST' => [
                    'controller' => $department_controller,
                    'action' => 'store'
                ]
            ]
        ];
    }

    public function getAuthentication(): ?\Ninja\Authentication
    {
        return null;
    }

    public function checkPermission($permission): ?bool
    {
        return null;
    }
}
