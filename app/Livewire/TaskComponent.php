<?php

namespace App\Livewire;

use Illuminate\Container\Attributes\Auth;
use Livewire\Component;
use App\Models\Task;
use App\Models\User;

class TaskComponent extends Component
{
    public $tasks = [];
    public $data = '<script>Swal.fire({title: "¡Éxito!", text: "{{$sessionMessage}}", icon:"success", confirmButtonText: "Aceptar" });</script>';
    
    public $title;
    public $description;
    public $modal = false;
    public $edit = false;
    public $modalInfo = [];
    public $currentTaskId;
    public $errors ;
    public $valid = false;
    public $auxDelete = false;
    public $shareModal = false;
    public $users;
    public $selectedUser;
    public $selectedPermission ;
    public $sessionMessage = '';
    public function getUsersButnotMe()
    {
        return User::all()->except(auth()->id());
    }

    public function mount()
    {
        $this->users = $this->getUsersButnotMe();
        $this->tasks = $this->getTasks();
    }
    public function render()
    {
        return view('livewire.task-component');
    }
    public function getTasks()
    {
        $user = auth()->user();
        $misTareas =  Task::where('user_id', auth()->id())->get();
        $tareasCompartidas = $user->sharedTasks()->get();
        $this->tasks = $misTareas->merge($tareasCompartidas);

        return $misTareas->merge($tareasCompartidas);
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
        $this->getTasks();

    }
    public function closeModal()
    {
        $this->modal = false;
        $this->clearFields();
        $this->getTasks();

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
        $this->closeModal();
        // AQUI DEBERIA ESTAR EL MENSAJE DE SESION
        
        $this->getTasks();  
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
        $this->currentTaskId = $id;
        $this->getTasks();
    }

    public function cancelDelete()
    {
        $this->auxDelete = false;
        $this->currentTaskId = null;
        $this->getTasks();

    }

    public function deleteTask()
    {

        $task = Task::find($this->currentTaskId);
        $task->delete();
        $this->getTasks();
        $this->auxDelete = false;
        $this->clearFields();
    }

    /// COMPARTIR TAREAS ////////

    public function openShareModal(Int $id)
    {
        $this->currentTaskId = $id;
        $this->shareModal = true;
        $this->getTasks();

    }

    public function closeShareModal()
    {
        $this->shareModal = false;
        $this->selectedUser = '';
        $this->selectedPermission = '';
        $this->currentTaskId = null;
        $this->getTasks();

    }
    public function shareTask()
    {
        
        $task = Task::find($this->currentTaskId);
        $usertoshare = User::find($this->selectedUser);
        $usertoshare->sharedTasks()->attach($task->id, ['permission' => $this->selectedPermission]);
        $this->closeShareModal();
        session()->flash('message', 'Se ha compartido la tarea con éxito');
    }
    


}