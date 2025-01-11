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
                            <button wire:click.prevent="openModal({{ $task->id }})"
                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                Editar
                            </button>
                            <button wire:click.prevent="confirmDelete({{ $task->id }})"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                Eliminar
                            </button>
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
    @if ($auxDelete == true)
        <div id="modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg w-96 p-6">
                <!-- Modal title -->
                <h2 class="text-lg font-semibold text-gray-800">Delete Task</h2>
                <p class="mt-2 text-gray-600">Are you sure you want to delete this task? This action
                    cannot be undone.</p>

                <!-- Buttons -->
                <div class="mt-6 flex justify-end space-x-3">
                    <button id="cancelButton" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                        Cancel
                    </button>
                    <button wire:click.prevent="deleteTask()" id="confirmButton"
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
