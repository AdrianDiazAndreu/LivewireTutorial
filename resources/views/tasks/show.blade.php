<x-app-layout class="">
    <div class="bg-white shadow-lg rounded-lg p-6 max-w-2xl w-full mx-auto mt-20 sm:mt-40">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Detalles de la Tarea</h1>
        <div class="space-y-4">
            {{-- <div>
                <p class="text-sm text-gray-500 font-medium">ID:</p>
                <p class="text-lg text-gray-700">{{ $tarea->id }}</p>
            </div> --}}
            <div>
                <p class="text-sm text-gray-500 font-medium">Título:</p>
                <p class="text-lg text-gray-700">{{ $tarea->title }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Descripción:</p>
                <p class="text-lg text-gray-700">{{ $tarea->description }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Creada por:</p>
                <p class="text-lg text-gray-700">{{ $user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Estado:</p>
                <p class="text-lg text-gray-700">
                    {{ ucfirst($tarea->estado) }}
                        @switch($tarea->estado)
                            @case("en_curso")
                                <i class="fa-solid fa-circle" style="color: #ebb112;"></i>
                                    
                            @break
                            @case("finalizada")
                                <i class="fa-solid fa-circle" style="color: #eb1212;"></i>
                                    
                            @break
                            
                            @default
                                <i class="fa-solid fa-circle" style="color: #4CAF50;"></i>
                                    
                        @endswitch
                </p>
            </div>
        </div>
        <div class="mt-6 flex justify-between">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline text-sm font-medium">
                Volver a la lista de tareas
            </a>
        </div>
    </div>
</x-app-layout>


