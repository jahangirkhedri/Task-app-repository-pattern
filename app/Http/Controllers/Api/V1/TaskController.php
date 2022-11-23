<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Facades\ResponseFacade;
use App\Http\Requests\ChangeTaskStatusRequest;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Repositories\TasksRepository;


class TaskController extends Controller
{
    public $task;

    public function __construct(Task $task)
    {
        $this->task = new TasksRepository($task);
    }

    public function index()
    {
        $data = $this->task->all();
        return ResponseFacade::getData($data);
    }

    public function show($id)
    {
        $data = $this->task->show($id);
        return ResponseFacade::getData($data);
    }

    public function store(TaskRequest $request)
    {
        $data = $request->only([
            'title', 'description'
        ]);

        $data['status'] = config('tasks.default_status');
        $data['user_id'] = $this->getLoggedUser()->id;

        $this->task->create($data);

        return ResponseFacade::taskCreated();

    }

    public function update(TaskRequest $request, $id)
    {
        $data = $request->only([
            'title', 'description', 'status'
        ]);
        if ($this->checkTaskBelongToUser($id)) {
            return ResponseFacade::taskMustBelongsToUSer();
        }
        $this->task->update($data, $id);

        return ResponseFacade::taskUpdated();

    }

    public function destroy($id)
    {
        if ($this->checkTaskBelongToUser($id)) {
            return ResponseFacade::taskMustBelongsToUSer();
        }
        $this->task->delete($id);
        return ResponseFacade::taskDeleted();
    }

    public function changeStatus(ChangeTaskStatusRequest $request, $id)
    {
        $data = $request->only([
            'status'
        ]);

        if ($this->checkTaskBelongToUser($id)) {
            return ResponseFacade::taskMustBelongsToUSer();
        }

        $this->task->update($data, $id);
        return ResponseFacade::taskStatusUpdated();
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
