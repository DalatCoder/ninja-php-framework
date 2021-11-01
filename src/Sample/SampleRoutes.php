<?php

namespace Sample;

use Ninja\Authentication;

class SampleRoutes implements \Ninja\IRoutes
{
    public function __construct()
    {
    }

    public function getRoutes(): array
    {
        $sampleController = new \Sample\Controller\SampleController();

        return [
            '/' => [
                'GET' => [
                    'controller' => $sampleController,
                    'action' => 'show_home_page'
                ]
            ],
            '404' => [
                'controller' => $sampleController,
                'action' => 'show_404_page'
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
