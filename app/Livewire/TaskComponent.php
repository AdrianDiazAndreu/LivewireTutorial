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
    public $modal = false;
    public $edit = false;
    public $modalInfo = [];
    public $currentTaskId;
    public $errors ;
    public $valid = false;
    public $auxDelete = false;

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

    /// MODAL ADMIN ///////////
    public function openModal(Int $id)
    {
        if($id == 0)
        {
            $this->modal = true;
        }else{
            $this->currentTaskId = $id;
            $this->fillForm();
        }
    }
    public function closeModal()
    {
        $this->modal = false;
        $this->clearFields();
    }
    public function clearFields()
    {
        $this->title = '';
        $this->description = '';
        $this->errors = '';
        $this->currentTaskId = '';
        $this->edit = false;
    }
    /// VALIDATE FIELDS ///////////////
    public function validateFields()
    {

        if (!empty($this->title)) {
            $this->valid = true;
        } else {
            $this->errors = '*Title or description are missing';
        }
        if ($this->valid==true){
            $this->storeTask();
        }
    }
    /// STORE TASKS ///////////
    
    public function storeTask()
    {
        $newTask = new Task();
        $newTask->title = $this->title;
        $newTask->description = $this->description;
        $newTask->user_id = auth()->id();
        $newTask->save();
        $this->clearFields();
        $this->getTasks();
        $this->closeModal();
    }
    /// UPDATE TASKS ///////////
    public function fillForm()
    {
        $task = Task::find($this->currentTaskId);
        $this->title = $task->title;
        $this->description = $task->description;
        $this->edit = true;
        $this->modal = true;
    }
    public function updateTask()
    {
        $task = Task::find($this->currentTaskId);
        $task->title = $this->title;
        $task->description = $this->description;
        $task->save();
        $this->clearFields();
        $this->getTasks();
        $this->closeModal();
    }
    /// DELETE TASKS ///////////
    public function confirmDelete(Int $id)
    {
        $this->auxDelete = true;
        // dd($this->auxDelete);
        $this->currentTaskId = $id;
    }

    public function deleteTask()
    {

        $task = Task::find($this->currentTaskId);
        $task->delete();
        $this->getTasks();
        $this->auxDelete = false;
        $this->clearFields();
    }
    


}