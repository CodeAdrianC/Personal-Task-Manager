<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'due_date' => 'nullable|date',
        ]);

        Task::create($request->only([
            'task_name',
            'description',
            'status',
            'due_date',
        ]));

        return new RedirectResponse('/', 303);
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);

            return view('tasks.edit', compact('task'));
            }

            public function update(Request $request, $id)
            {
                $task = Task::findOrFail($id);
                $task->update($request->all());
                return new RedirectResponse('/', 303);
            }

    public function destroy($id)
    {
        Task::findOrFail($id)->delete();

        return new RedirectResponse('/', 303);
    }
}