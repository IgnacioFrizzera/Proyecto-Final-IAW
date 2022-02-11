<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Actualización de datos de etiquetas') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(isset($message))
                        <div class="container-fluid">
                            <h2>
                                {{$message}}
                            </h2>
                        </div>
                    @else
                        @if(isset($label))
                            <div class="container-fluid">
                                <h2>
                                    Modificar {{$title}}
                                </h2>
                                @if(isset($errorMessage))
                                    <h4 style="color:red; text-decoration:underline">
                                        {{ $errorMessage }}
                                    </h4>
                                @endif
                                <hr>
                                @foreach ($label as $label_data)
                                    <form action="{{route('update-label')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-4">
                                            <input type="hidden" name="id" value="{{$label_data->id}}">
                                            <input type="hidden" name="label_type" value="{{$type}}">
                                            <h4 title="Requerido">Nombre actual</h4>
                                            <input type="string" class="form-control" name="old_name" id="old_name" value="{{ $label_data->name }}" readonly>
                                            <br>
                                            <h4 title="Requerido">Nombre nuevo</h4>
                                            <input type="string" class="form-control" name="new_name" id="new_name" required maxlength="50">
                                            <br>
                                            <button type="sumbit" class="btn btn-dark">
                                                Actualizar datos
                                            </button>
                                        </div>
                                    </form>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>