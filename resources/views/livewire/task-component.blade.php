<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    

    <div class="max-w-4xl mx-auto bg-white p-4">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Gestión de Tareas</h1>
        <button wire:click="openModal(0)" id="openModal" class="mb-2 bg-blue-500 text-white px-4 py-2 hover:bg-blue-600">
            Abrir Modal
        </button>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2 text-left">Tarea</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Estado</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="{{ route('tasks.show', $task->id) }}">
                                {{ $task->title }}
                            </a>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ ucfirst($task->estado) }}
                            @switch($task->estado)
                                @case("en_curso")
                                    <i class="fa-solid fa-circle" style="color: #ebb112;"></i>
                                    
                                @break
                                @case("finalizada")
                                    <i class="fa-solid fa-circle" style="color: #eb1212;"></i>
                                    
                                @break
                            
                                @default
                                    <i class="fa-solid fa-circle" style="color: #4CAF50;"></i>
                                    
                            @endswitch
                        </td>
                        <td class="border border-gray-300 py-2 text-center">
                            @if ((isset($task->pivot->permission) && $task->pivot->permission == 'edit') || auth()->user()->id == $task->user_id)
                                <button wire:click.prevent="openModal({{ $task->id }})"
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                    Editar
                                </button>
                                <button wire:click.prevent="openShareModal({{ $task->id }})"
                                    class="bg-purple-500 text-white px-3 py-1 rounded hover:bg-purple-700 transition">
                                    Compartir
                                </button>
                                <button wire:click.prevent="confirmDelete({{ $task->id }})"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                    Eliminar
                                </button>
                            @elseif (isset($task->pivot->permission) && $task->pivot->permission == 'view')
                                Solo tienes permiso de visualización.
                            @else
                                {{-- @dd($task->pivot->permission) --}}
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    @if ($modal == true)

        <div id="updateModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg w-1/3">
                <!-- Header del modal -->
                <div class="flex justify-between items-center bg-blue-500 text-white px-4 py-2 rounded-t-lg">
                    <h2 class="text-lg font-bold">
                        @if ($edit == false)
                            Nueva Tarea
                        @else
                            Editar Tarea
                        @endif
                    </h2>
                    <button wire:click.prevent="closeModal" id="closeModal"
                        class="text-white font-bold text-xl">&times;</button>
                </div>
                <!-- Contenido del modal -->
                <div class="p-6">
                    <form id="modalForm">
                        @csrf
                        @if ($edit == false)
                            <div class="mb-4">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Tarea</label>
                                <input type="text" wire:model="title" name="title" id="title"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label for="description"
                                    class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
                                <textarea wire:model="description" name="description" id="description"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required></textarea>
                            </div>
                            <span class="text-red-600">{{ $errors }}</span>
                        @else
                            <div class="mb-4">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Tarea</label>
                                <input type="text" wire:model="title" name="title" id="title"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <span class="text-red-600">{{ $errors }}</span>
                            </div>
                            <div class="mb-4">
                                <label for="description"
                                    class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
                                <textarea wire:model="description" name="description" id="description"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                                <span class="text-red-600">{{ $errors }}</span>
                            </div>
                        @endif

                    </form>
                    <!== Botones del modal -->
                        <div class="flex justify-between mt-4">
                            <button wire:click.prevent="closeModal"
                                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">Cancelar</button>
                            <button
                                {{ $edit == false ? 'wire:click.prevent=validateFields()' : 'wire:click.prevent=updateTask()' }}
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Guardar</button>
                        </div>

                </div>
            </div>
        </div>
    @endif
    @if ($shareModal == true)
        <div id="updateModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg w-1/3">
                <!-- Header del modal -->
                <div class="flex justify-between items-center bg-purple-500 text-white px-4 py-2 rounded-t-lg">
                    <h2 class="text-lg font-bold">
                        Compartir tarea
                    </h2>
                    <button wire:click.prevent="closeShareModal" id="closeModal"
                        class="text-white font-bold text-xl">&times;</button>
                </div>
                <!-- Contenido del modal -->
                <div class="p-6">
                    <form id="modalForm">
                        @csrf
                        <div class="mb-4">
                            <label for="users" class="block text-gray-700 text-sm font-bold mb-2">Usuario para
                                compartir</label>
                            <select wire:model="selectedUser" name="user_id" id="user_id"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                                <option value="">Seleccione un usuario</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="permission">Seleccione los permisos</label>
                            <select wire:model="selectedPermission" name="permission" id="permission"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                                <option value="">Seleccione un permiso</option>
                                <option value="view">Ver</option>
                                <option value="edit">Editar</option>
                            </select>
                        </div>
                        <span class="text-red-600">{{ $errors }}</span>
                    </form>
                    <!== Botones del modal -->
                        <div class="flex justify-between mt-4">
                            <button wire:click.prevent="closeShareModal"
                                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">Cancelar</button>
                            <button wire:click.prevent="shareTask"
                                class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-700 transition">Compartir</button>
                        </div>

                </div>
            </div>
        </div>
    @elseif ($auxDelete == true)
        <div id="deleteModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg w-1/3">
                <!-- Header del modal -->
                <div class="flex justify-between items-center bg-red-500 text-white px-4 py-2 rounded-t-lg">
                    <h2 class="text-lg font-bold">
                        Eliminar tarea
                    </h2>
                    <button wire:click.prevent="cancelDelete" id="closeModal"
                        class="text-white font-bold text-xl">&times;</button>
                </div>
                <!-- Contenido del modal -->
                <div class="p-6">
                    <p>¿Estás seguro de eliminar la tarea?</p>
                    <div class="flex justify-between mt-4">
                        <button wire:click.prevent="cancelDelete"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Cancelar</button>
                        <button wire:click.prevent="deleteTask"
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif


</div>
