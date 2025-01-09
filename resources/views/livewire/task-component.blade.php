<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

    <div class="max-w-4xl mx-auto bg-white p-4">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Gestión de Tareas</h1>
        <button wire:click="openCreateModal()" id="openModal" class="mb-2 bg-blue-500 text-white px-4 py-2 hover:bg-blue-600">
            Abrir Modal
        </button>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2 text-left">Tarea</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Descripcion</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>

                @foreach (Auth::user()->tasks as $task)
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">{{ $task->title }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $task->description }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <button wire:click.prevent="openUpdateModal({{ $task }})" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                Editar
                            </button>
                            <button wire:click.prevent="deleteTask({{ $task }})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <!-- Modal -->
    @if ($createModal==true)
        
    <div id="createModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-1/3">
            <!-- Header del modal -->
            <div class="flex justify-between items-center bg-blue-500 text-white px-4 py-2 rounded-t-lg">
                <h2 class="text-lg font-bold">Crea una tarea</h2>
                <button wire:click.prevent="closeCreateModal" id="closeModal" class="text-white font-bold text-xl">&times;</button>
            </div>
            <!-- Contenido del modal -->
            <div class="p-6">
                <form id="modalForm">
                    <!-- Campo Título -->
                    <div class="mb-4">
                        <label for="titulo" class="block text-gray-700 font-semibold mb-2">Título</label>
                        <input wire:model="title" type="text" id="titulo" name="titulo"
                            class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Ingresa el título" required>
                    </div>
                    <!-- Campo Descripción -->
                    <div class="mb-4">
                        <label for="descripcion" class="block text-gray-700 font-semibold mb-2">Descripción</label>
                        <textarea wire:model="description" id="descripcion" name="descripcion" rows="4"
                            class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Ingresa la descripción" required></textarea>
                    </div>
                    <!-- Botones -->
                    <div class="flex justify-end">
                        <button wire:click.prevent="closeCreateModal" type="button" id="cancelButton"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 mr-2">Cancelar</button>
                        <button wire:click.prevent="createTask"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    @if ($updateModal==true)
        
    <div id="updateModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-1/3">
            <!-- Header del modal -->
            <div class="flex justify-between items-center bg-blue-500 text-white px-4 py-2 rounded-t-lg">
                <h2 class="text-lg font-bold">Actualiza una tarea</h2>
                <button wire:click.prevent="closeUpdateModal" id="closeModal" class="text-white font-bold text-xl">&times;</button>
            </div>
            <!-- Contenido del modal -->
            <div class="p-6">
                <form id="modalForm">
                    <!-- Campo Título -->
                    <div class="mb-4">
                        <label for="titulo" class="block text-gray-700 font-semibold mb-2">Título</label>
                        <input wire:model="title" type="text" id="titulo" name="titulo"
                            class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Ingresa el título" value="{{ $title }}" required>
                    </div>
                    <!-- Campo Descripción -->
                    <div class="mb-4">
                        <label for="descripcion" class="block text-gray-700 font-semibold mb-2">Descripción</label>
                        <textarea wire:model="description" id="descripcion" name="descripcion" rows="4"
                            class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Ingresa la descripción" value="{{ $description }}" required></textarea>
                    </div>
                    <!-- Botones -->
                    <div class="flex justify-end">
                        <button wire:click.prevent="closeUpdateModal" type="button" id="cancelButton"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 mr-2">Cancelar</button>
                        <button wire:click.prevent="updateTask()"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

</div>
