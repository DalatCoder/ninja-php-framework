<?php

namespace Lab05\Controller;

class Lab05
{
    public function __construct()
    {
    }

    public function index()
    {
        return [
            'master' => 'lab5_1/master.html.php',
            'template' => 'lab5_1/index.html.php',
            'title' => 'Máy tính AJAX',
        ];
    }

    public function calculate()
    {
        $incoming_data = file_get_contents('php://input');
        $incoming_data = json_decode($incoming_data);

        $first_operand = $incoming_data->first_operand ?? null;
        $second_operand = $incoming_data->second_operand ?? null;
        $operator = $incoming_data->operator ?? null;

        if (!$first_operand || !$second_operand || !$operator) {
            return [
                'type' => 'json',
                'status' => 'error',
                'message' => 'Dữ liệu không hợp lệ'
            ];
        }

        $valid_opertors = ['+', '-', '*', '/'];

        if (!in_array($operator, $valid_opertors)) {
            return [
                'type' => 'json',
                'status' => 'error',
                'message' => 'Toán tử không hợp lệ'
            ];
        }

        $result = $this->process_calculate($first_operand, $second_operand, $operator);

        return [
            'type' => 'json',
            'status' => 'success',
            'data' => [
                'result' => $result
            ]
        ];
    }

    private function process_calculate($first_operand, $second_operand, $operator)
    {
        if ($operator == '+') return $first_operand + $second_operand;
        else if ($operator == '-') return $first_operand - $second_operand;
        else if ($operator == '*') return $first_operand * $second_operand;
        else return $first_operand / $second_operand;
    }
}
