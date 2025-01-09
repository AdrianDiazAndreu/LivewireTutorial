<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\User; 

class TaskComponent extends Component
{
    public $tasks = [];
    public $title;
    public $description;
    public $createModal = false;
    public $updateModal = false;
    public $currentTask;

    public function mount()
    {
        $this->tasks = $this->getTasks();
    }

    public function render()
    {
        return view('livewire.task-component');
    }

    public function getTasks()
    {
        return $this->tasks = Task::where('user_id', auth()->id())->get();
    }

    public function clearFields()
    {
        $this->title = '';
        $this->description = '';
        $this->reset(['title', 'description', 'updateModal']);
    }

    public function openCreateModal()
    {
        $this->createModal = true;
        $this->clearFields();
    }

    public function openUpdateModal(Task $task)
    {
        $this->clearFields();
        $this->fillForm($task);
        $this->currentTask = $task;
        $this->updateModal = true;
    }

    public function closeCreateModal()
    {
        $this->createModal = false;
    }

    public function closeUpdateModal()
    {
        // $this->clearFields();
        $this->updateModal = false;
    }

    public function createTask()
    {
        $newTask = new Task();
        $newTask->title = $this->title; 
        $newTask->description = $this->description;
        $newTask->user_id = auth()->id();
        $newTask->save();
        $this->getTasks();
        $this->closeCreateModal();
    }
    public function updateTask()
    {
        $task = Task::find($this->currentTask->id);
        $task->title = $this->title;
        $task->description = $this->description;
        $task->save();
        $this->getTasks();
        $this->closeUpdateModal();
    }

    // public function createorUpdateTask(Task $task)
    // {
    //     if($task)
    //     {
    //         $task->title = $this->title;
    //         $task->description = $this->description;
    //         $task->user_id = auth()->id();
    //         $task->save();
    //     }else
    //     {
    //         Task::updateOrCreate(["id" => $this->id],

    //         [
    //             "title" => $this->title, 
    //             "description" => $this->description, 
    //             "user_id" => auth()->user()->id()
            
    //         ]);
            
    //     }
    //     $this->clearFields();
    //     $this->modal = false;
    //     $this->tasks = $this->getTasks()->sortByDesc('id');
    // }


    public function deleteTask(Task $task)
    {
        $task->delete();
        $this->getTasks()->sortByDesc('id');
    }
        

    public function fillForm(Task $task)
    {
        $this->title = $task->title;
        $this->description = $task->description;
    }

}