<?php

namespace App\Lib;

trait ResponseTemplate
{
    protected $data = [];
    protected $errors = [];
    protected $status = 200;

    protected $variables = [];

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setVariable($key,$value) {
        $this->variables[$key] = $value;
    }

    public function setErrors($errors)
    {
        $errorsArray = [];
        foreach ($errors as $key => $error) {
            foreach ($error as $value) {
                array_push($errorsArray, [
                    'key' => $key,
                    'value' => $value,
                ]);
            }
        }
        $this->errors = $errorsArray;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function response()
    {
        return response()->json([
            'data' => $this->data,
             ...$this->variables,
            'status' => ['code' => $this->status,'title' => 'TEST'],
            'errors' => $this->errors],$this->status);
    }
}
