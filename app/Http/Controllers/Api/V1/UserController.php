<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Facades\ResponseFacade;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PHPUnit\Exception;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = new Repository($user);
    }

    public function index()
    {
        try {
            $data = $this->user->all();
            return ResponseFacade::getData($data);
        } catch (Exception $exception) {
            return ResponseFacade::failedResponse();
        }
    }

    public function show($id)
    {
        try {
            $data = $this->user->show($id);
            return ResponseFacade::getData($data);
        } catch (Exception $exception) {
            return ResponseFacade::failedResponse();
        }
    }

    public function store(UserRequest $request)
    {
        try {

            $data = $request->only([
                'name', 'password', 'email', 'password_confirmation',
            ]);
            $data['password'] = bcrypt($data['password']);
            $data['api_token'] = Str::random(30);

            $this->user->create($data);

            return ResponseFacade::UserCreated();

        } catch (Exception $exception) {
            return ResponseFacade::failedResponse();
        }
    }

    public function update(UserRequest $request, $id)
    {
        try {

            $data = $request->only([
                'name', 'email'
            ]);
            $this->user->update($data, $id);

            return ResponseFacade::userUpdated();

        } catch (Exception $exception) {
            return ResponseFacade::failedResponse();
        }

    }


}
