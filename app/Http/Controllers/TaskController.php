<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    public function show($id)
    {
        // Encuentra la tarea por ID
        $tarea = Task::findOrFail($id);
        $user = User::findOrFail($tarea->user_id);

        // Retorna una vista con la tarea
        return view('tasks.show', compact(['tarea', 'user']));
    }
}
