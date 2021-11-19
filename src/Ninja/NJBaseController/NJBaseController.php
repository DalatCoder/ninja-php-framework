<?php

namespace Ninja\NJBaseController;

use Ninja\ViewHandler;

class NJBaseController
{
    protected ViewHandler $view_handler;
    protected array $entrypoint_arguments;
    
    protected function __construct()
    {
        $this->view_handler = new ViewHandler();
    }
    
    protected function get_entrypoint_args(array $args)
    {
        $this->entrypoint_arguments = $args;
    }
    
    protected function handle_on_invalid_authentication(array $args)
    {
        $this->view_handler
            ->load_master_layout('nj_master.html.php')
            ->load_child_layout('401.html.php')
            ->render();
    }
    
    protected function handle_on_invalid_permission($args)
    {
        $this->view_handler
            ->load_master_layout('nj_master.html.php')
            ->load_child_layout('403.html.php')
            ->render();
    }
    
    protected function handle_on_page_not_found($args)
    {
        $this->view_handler
            ->load_master_layout('nj_master.html.php')
            ->load_child_layout('404.html.php')
            ->render();
    }
}
