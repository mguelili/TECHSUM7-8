<?php

namespace App\Http\Controllers;

use App\Mail\TaskCompleted;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    public function index() { return view('tasks.index', ['tasks' => Task::visible()->orderBy('task_date')->orderBy('id')->get()]); }
    public function create() { return view('tasks.form', ['task' => new Task(['status' => 'pending', 'task_date' => now()->toDateString()])]); }
    public function store(Request $request) { Task::create($this->validated($request)); return redirect()->route('tasks.index')->with('success', 'Task created.'); }
    public function edit(Task $task) { abort_if($task->is_archived, 404); return view('tasks.form', compact('task')); }
    public function update(Request $request, Task $task) {
        abort_if($task->is_archived, 404);
        $wasDone = $task->status === 'done';
        $task->update($this->validated($request));
        if (! $wasDone && $task->status === 'done') Mail::to(config('tasks.completed_recipient'))->send(new TaskCompleted($task));
        return redirect()->route('tasks.index')->with('success', 'Task updated.');
    }
    public function destroy(Task $task) { abort_if($task->is_archived, 404); $task->update(['is_archived' => true]); return redirect()->route('tasks.index')->with('success', 'Task archived.'); }
    private function validated(Request $request): array { return $request->validate(['title' => ['required','string','max:150'], 'task_date' => ['required','date'], 'status' => ['required','in:pending,in progress,done']]); }
}
