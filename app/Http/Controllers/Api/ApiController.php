<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    //
    protected $status_code = 200;

    public function getStatusCode()
    {
        return $this->status_code;
    }

    public  function setStatusCode($status_code)
    {
        $this->status_code = $status_code;

        return $this;
    }

    public function responseNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(404)->responseError($message);
    }

    public function responseError($message)
    {
        return $this->response([
            'status' => 'failed',
            'error' => [
                'status_code' =>$this->getStatusCode(),
                'message' => $message
            ]
        ]);
    }

    public function response($data)
    {
        return response()->json($data);
    }
}
