<?php
namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Service\TaskService;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    private $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('task.index' , [
            'tasks'     => $this->taskService->getMyTasks() ,
            'pageTitle' => 'Task List',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('task.create' , [
            'pageTitle' => __('Task Create') ,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(TaskStoreRequest $request)
    {
        $this->taskService->createTask($request);
        return redirect(route('task.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Task $task
     * @return Response
     */
    public function show(Task $task)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Task $task
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Task $task)
    {
        $this->authorize('update',$task);
        return view('task.edit' , [
            'task'      => $task ,
            'pageTitle' => __('Task Edit'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Task $task
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(TaskUpdateRequest $request , Task $task)
    {
        $this->authorize('update',$task);
        $this->taskService->updateTask($request , $task);
        return redirect(route('task.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Task $task
     * @return Response
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete',$task);
        $this->taskService->delete($task);
    }
}
