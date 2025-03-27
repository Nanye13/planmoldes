<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bienvenido') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Plan de trabajo

                    <br>
                    <br>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Agregar
                    </button>
                    <br>
                    <table>
                        <thead class="table-dark">
                            <tr>
                                <th>Día</th>
                                <th>Tareas</th>
                                <th>Horas Ocupadas</th>
                                <th>Horas Disponibles</th>
                                <th>Límite Diario</th>
                            </tr>
                        </thead>
                        <tbody id="tablaHoras">
                            <!-- Datos dinámicos -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>Exceso Total</strong></td>
                                <td colspan="4" id="excesoHoras" class="exceso">0 hrs</td>
                            </tr>
                        </tfoot>
                    </table>



                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('guardarmolde') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <label for="">Molde:</label>
                            <select name="molde" id="molde" class="form-control">
                                @foreach ($moldes as $mol)
                                    <option value="{{ $mol->id }}">{{ $mol->nombre }}</option>
                                @endforeach
                            </select>
                            <label for="">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="nombre">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</x-app-layout>
