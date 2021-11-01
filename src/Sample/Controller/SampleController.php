<?php

namespace Sample\Controller;

class SampleController
{
    public function __construct()
    {
    }

    public function show_home_page()
    {
        $introduction = 'Chào mừng đến với PHP Ninja Framework';

        return [
            'master' => 'master.html.php',
            'template' => 'index.html.php',
            'title' => 'Trang chủ',
            'variables' => [
                'intro_content' => $introduction
            ]
        ];
    }

    public function show_404_page()
    {
        return [
            'master' => 'master.html.php',
            'template' => '404.html.php',
            'title' => 'Không tìm thấy trang này'
        ];
    }
}
