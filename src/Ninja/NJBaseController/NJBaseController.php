<?php

namespace Ninja\NJBaseController;

use Ninja\ViewHandler;

class NJBaseController
{
    protected ViewHandler $view_handler;
    protected array $entrypoint_arguments;
    
    public function __construct()
    {
        $this->view_handler = new ViewHandler();
    }
    
    public function get_entrypoint_args(array $args)
    {
        $this->entrypoint_arguments = $args;
    }
    
    public function handle_on_invalid_authentication(array $args)
    {
        $this->view_handler
            ->load_master_layout('nj_master.html.php')
            ->load_child_layout('nj_401.html.php')
            ->render();
    }
    
    public function handle_on_invalid_permission($args)
    {
        $this->view_handler
            ->load_master_layout('nj_master.html.php')
            ->load_child_layout('nj_403.html.php')
            ->render();
    }
    
    public function handle_on_page_not_found($args)
    {
        $this->view_handler
            ->load_master_layout('nj_master.html.php')
            ->load_child_layout('nj_404.html.php')
            ->render();
    }
}
