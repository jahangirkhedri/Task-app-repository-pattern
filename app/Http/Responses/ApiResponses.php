<?php

namespace App\Http\Responses;


use Illuminate\Http\Response;

class ApiResponses
{


    public function baseResponse($msg, $statusCode)
    {
        return response()->json([
            'msg' => $msg,
            'status' => $statusCode
        ], $statusCode);
    }

    public function getData($data)
    {
        return response()->json([
            'data' => $data,
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function taskCreated()
    {
        return $this->baseResponse(
            'Task created successfully.',
            Response::HTTP_OK
        );
    }

    public function taskUpdated()
    {
        return $this->baseResponse(
            'Task updated successfully.',
            Response::HTTP_OK
        );
    }
    public function taskStatusUpdated()
    {
        return $this->baseResponse(
            'Task status updated successfully.',
            Response::HTTP_OK
        );
    }

    public function taskDeleted()
    {
        return $this->baseResponse(
            'Task deleted successfully.',
            Response::HTTP_OK
        );
    }

    public function userCreated()
    {
        return $this->baseResponse(
            'User created successfully.',
            Response::HTTP_OK
        );
    }

    public function userUpdated()
    {
        return $this->baseResponse(
            'User updated successfully.',
            Response::HTTP_OK
        );

    }

    public function userDeleted()
    {
        return $this->baseResponse(
            'User deleted successfully.',
            Response::HTTP_OK
        );
    }


    public function taskMustBelongsToUSer()
    {
        return $this->baseResponse(
            'This task does not belong to you.',
            Response::HTTP_NOT_FOUND
        );
    }


}
