<?php

namespace App\Trait;

trait HasResponse
{
    public function response(int $status = 200, string $message, mixed $data = null)
    {
        if(($status >= 200) && ($status < 300)){
            $response = [
                "success" => true,
                "message" => $message,
                "data" => $data,
            ];
        }else{
            $response = [
                "success" => false,
                "message" => $message,
                "errors" => $data,
            ];
        }

        return response()->json($response, $status);
    }
}