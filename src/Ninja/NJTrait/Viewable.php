<?php

namespace Ninja\NJTrait;

use Ninja\NinjaException;

trait Viewable
{
    private string $master_layout_html_file_path;
    private $master_layout_args;
    
    private string $child_layout_html_file_path;
    private $child_layout_args;
    
    private string $child_placeholder_name;
    
    public function set_child_placeholder_name($placeholder_name)
    {
        $this->child_placeholder_name = $placeholder_name;
    }

    public function load_master_layout($master_layout_file_name, $master_args = []) 
    {
        $this->master_layout_html_file_path = $master_layout_file_name;
        $this->master_layout_args = $master_args;
        
        return $this;
    }

    public function load_child_layout($child_layout_file_name, $child_args = [])
    {
        $this->child_layout_html_file_path = $child_layout_file_name;
        $this->child_layout_args = $child_args;
        
        return $this;
    }
    
    public function render()
    {
        try {
            $this->tempate_validation();

            $child_content = $this->load_template($this->child_layout_html_file_path, $this->child_layout_args);
            
            $child_placeholder_name = $this->child_placeholder_name ?? 'child_content';
            
            $this->master_layout_args[$child_placeholder_name] = $child_content;
            $master_content = $this->load_template($this->master_layout_html_file_path, $this->master_layout_args);
            
            echo $master_content;
            exit();
        }
        catch (NinjaException $exception) {
            $template_args = [
                'title' => 'Lỗi từ lập trình viên',
                'error_message' => $exception->getMessage(),
                'error_stack_trace' => $exception->getTrace()
            ];
            $template_dir = ROOT_DIR . '/src/Ninja/NJViews/';
            $template_name = 'error.html.php';
            
            echo $this->load_template($template_name, $template_args, $template_dir);
            exit();
        }
        catch (\Exception $exception) {
            $template_args = [
                'title' => 'Lỗi hệ thống',
                'error_message' => $exception->getMessage(),
                'error_stack_trace' => $exception->getTrace()
            ];
            $template_dir = ROOT_DIR . '/src/Ninja/NJViews/';
            $template_name = 'error.html.php';

            echo $this->load_template($template_name, $template_args, $template_dir);
            exit();
        }
    }

    /**
     * @throws NinjaException
     */
    public function tempate_validation(): void
    {
        if (empty($this->master_layout_html_file_path))
            throw new NinjaException('Vui lòng chọn master layout');

        if (empty($this->child_layout_html_file_path))
            throw new NinjaException('Vui lòng chọn child layout');

        if (!$this->is_template_exists($this->master_layout_html_file_path))
            throw new NinjaException('Đường dẫn chứa tập tin master layout không tồn tại: ' . $this->master_layout_html_file_path);

        if (!$this->is_template_exists($this->child_layout_html_file_path))
            throw new NinjaException('Đường dẫn chứa tập tin child layout không tồn tại: ' . $this->child_layout_html_file_path);
    }

    private function load_template($template_file_name, $args = [], $template_directory = '')
    {
        extract($args);
        
        ob_start();
        
        if (empty($template_directory))
            $template_directory = ROOT_DIR . '/views/';
        
        include $template_directory . $template_file_name;
        
        return ob_get_clean();
    }
    
    private function is_template_exists($template_file_name, $template_directory = ''): bool
    {
        if (empty($template_directory))
            $template_directory = ROOT_DIR . '/views/';
            
        return file_exists($template_directory . $template_file_name);
    }
}
