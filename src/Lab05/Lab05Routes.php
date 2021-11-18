<?php

namespace Lab05;

use Lab05\Controller\Lab05;
use Ninja\Authentication;
use Ninja\NJInterface\IRoutes;

class Lab05Routes implements IRoutes
{
    public function __construct()
    {
    }

    public function getRoutes(): array
    {
        $lab05Controller = new Lab05();

        return [
            '/' => [
                'GET' => [
                    'controller' => $lab05Controller,
                    'action' => 'index'
                ],
                'POST' => [
                    'controller' => $lab05Controller,
                    'action' => 'calculate'
                ]
            ]
        ];
    }

    public function getAuthentication(): ?Authentication
    {
        return null;
    }

    public function checkPermission($permission): ?bool
    {
        return null;
    }
}
