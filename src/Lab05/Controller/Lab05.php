<?php

namespace Lab05\Controller;

use Ninja\NJTrait\Jsonable;
use Ninja\NinjaException;
use Ninja\NJTrait\Viewable;

class Lab05
{
    use Jsonable;
    use Viewable;

    public function __construct()
    {
    }

    public function index()
    {
        $this
            ->load_master_layout('lab5_1/master.html.php', [
                'title' => 'Máy tính AJAX'
            ])
            ->load_child_layout('lab5_1/index.html.php')
            ->render();
    }

    public function calculate()
    {
        try {
            $incoming_data = file_get_contents('php://input');
            $incoming_data = json_decode($incoming_data);

            $first_operand = $incoming_data->first_operand ?? null;
            $second_operand = $incoming_data->second_operand ?? null;
            $operator = $incoming_data->operator ?? null;

            if (is_null($first_operand) || is_null($second_operand) || is_null($operator))
                throw new NinjaException('Dữ liệu không hợp lệ', 400);

            $valid_opertors = ['+', '-', '*', '/'];

            if (!in_array($operator, $valid_opertors))
                throw new NinjaException('Toán tử không hợp lệ', 400);
            
            if ($operator == '/' && $second_operand == 0)
                throw new NinjaException('Không thể chia cho 0', 400);

            $result = $this->process_calculate($first_operand, $second_operand, $operator);

            $response_data = [
                'status' => 'success',
                'data' => [
                    'result' => $result
                ]
            ];
            $status_code = 200;
        } catch (NinjaException $exception) {
            $response_data = [
                'status' => 'fail',
                'data' => 'null',
                'error' => $exception->getMessage()
            ];

            $status_code = $exception->get_status_code();
        } catch (\Exception $exception) {
            $response_data = [
                'status' => 'error',
                'data' => 'null',
                'error' => 'Server Error'
            ];

            $status_code = 500;
        } finally {
            $this->response_json($response_data, $status_code);
        }
    }

    private function process_calculate($first_operand, $second_operand, $operator)
    {
        if ($operator == '+') return $first_operand + $second_operand;
        else if ($operator == '-') return $first_operand - $second_operand;
        else if ($operator == '*') return $first_operand * $second_operand;
        else return $first_operand / $second_operand;
    }
}
