<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Facades\ResponseFacade;
use App\Http\Requests\ChangeTaskStatusRequest;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Repositories\TasksRepository;
use PHPUnit\Exception;


class TaskController extends Controller
{
    public $task;

    public function __construct(Task $task)
    {
        $this->task = new TasksRepository($task);
    }

    public function index()
    {
        try {
            $data = $this->task->all();
            return ResponseFacade::getData($data);
        } catch (Exception $exception) {
            return ResponseFacade::failedResponse();
        }

    }

    public function show($id)
    {
        try {
            $data = $this->task->show($id);
            return ResponseFacade::getData($data);
        } catch (Exception $exception) {
            return ResponseFacade::failedResponse();
        }
    }

    public function store(TaskRequest $request)
    {
        try {
            $data = $request->only([
                'title', 'description'
            ]);

            $data['status'] = config('tasks.default_status');
            $data['user_id'] = $this->getLoggedUser()->id;

            $this->task->create($data);

            return ResponseFacade::taskCreated();

        } catch (Exception $exception) {
            return ResponseFacade::failedResponse();
        }
    }

    public function update(TaskRequest $request, $id)
    {
        try {
            $data = $request->only([
                'title', 'description', 'status'
            ]);
            if ($this->checkTaskBelongToUser($id)) {
                return ResponseFacade::taskMustBelongsToUSer();
            }
            $this->task->update($data, $id);

            return ResponseFacade::taskUpdated();
        } catch (Exception $exception) {
            return ResponseFacade::failedResponse();
        }

    }

    public function destroy($id)
    {
        try {
            if ($this->checkTaskBelongToUser($id)) {
                return ResponseFacade::taskMustBelongsToUSer();
            }
            $this->task->delete($id);
            return ResponseFacade::taskDeleted();
        } catch (Exception $exception) {
            return ResponseFacade::failedResponse();
        }
    }

    public function changeStatus(ChangeTaskStatusRequest $request, $id)
    {
        try {
            $data = $request->only([
                'status'
            ]);

            if ($this->checkTaskBelongToUser($id)) {
                return ResponseFacade::taskMustBelongsToUSer();
            }

            $this->task->update($data, $id);
            return ResponseFacade::taskStatusUpdated();
        } catch (Exception $exception) {
            return ResponseFacade::failedResponse();
        }
    }

    public function checkTaskBelongToUser($taskId)
    {
        $task = $this->task->show($taskId);
        $user = $this->getLoggedUser();
        return $task->user_id !== $user->id;
    }

    public function getLoggedUser()
    {
        return auth('api')->user();
    }
}
