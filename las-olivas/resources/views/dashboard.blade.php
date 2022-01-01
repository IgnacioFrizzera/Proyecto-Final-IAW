<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container-fluid">
                        <h3>
                            Sección 1
                        </h3>
                        <h4>Insertar gráfico</h4>
                    </div>
                    <hr>
                    <div class="container-fluid">
                        <h3>
                            Sección 2
                        </h3>
                        <h4>Insertar gráfico</h4>
                    </div>
                    <hr>
                    <div class="container-fluid">
                        <h3>
                            Sección 3
                        </h3>
                        <h4>Insertar gráfico</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
