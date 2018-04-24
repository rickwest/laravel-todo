<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

/**
 * Class TaskController
 * @package App\Http\Controllers
 */
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();

        return view('task.index', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|min:10',
            'due' => 'required',
            'assignedUsers' => 'required',
        ]);

        $task = Task::create([
            'description' => $request->description,
            'due' => $request->due,
        ]);

        foreach($request->assignedUsers as $key => $userId) {
            $task->assignedUsers()->attach($userId);
        }
        $task->save();

        $request->session()->flash('status', 'Task Created Successfully');

        return redirect()->route('tasks.index');
    }

    /**
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index');
    }

    /**
     * Handle calls to missing methods on the controller.
     *
     * @param string $method
     * @param array $parameters
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function __call($method, $parameters)
    {
        return redirect()->route('tasks.index');
    }
}
