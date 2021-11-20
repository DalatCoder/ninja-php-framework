<?php

namespace Sample\Controller;

use Ninja\NJBaseController\NJBaseController;
use Ninja\TemplateBak;

class SampleController extends NJBaseController
{
    public function show_home_page()
    {
        $introduction = 'Chào mừng đến với PHP Ninja Framework';
        
        $this->view_handler
            ->load_master_layout('master.html.php', [
                'title' => 'Trang chủ',
                'custom_styles' => [
                    '/static/css/main.css'
                ]
            ])
            ->load_child_layout('index.html.php', [
                'intro_content' => $introduction
            ])
            ->render();
    }
    
    public function test_template()
    {
        TemplateBak::view('about.html.php', [
            'title' => 'Home Page',
            'colors' => ['rd','blue','green']
        ]);
    }
}
