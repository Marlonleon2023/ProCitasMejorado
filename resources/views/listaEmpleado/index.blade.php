
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Listado Empleados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <h2 class="mt-4 text-xl text-center text text-gray-800 font-semibold">Listado Empleados</h2>
                <div class="col-12">
                    <!-- -->
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead class="thead-dark">
                          <tr>

                            <th scope="col">Identificacion</th>
                            <th scope="col">Nombres</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Direccion</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Tipo contrato</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Acciones</th>
                            <th scope="col"></th>

                        </tr>
                        </thead>
                        <tbody>
                        @php $secuencia = 1; @endphp
                         @foreach ($lempleado as $empleado) 

                          <tr>
                            <th scope="row">{{ $empleado->identificacion }}</th>
                            <td>{{ $empleado->nombres }}</td>
                            <td>{{ $empleado->apellidos }}</td>
                            <td>{{ $empleado->correo }}</td>
                            <td>{{ $empleado->direccion }}</td>
                            <td>{{ $empleado->telefono }}</td>
                            <td>{{ $empleado->tipocontrato }}</td>
                            <td>{{ $empleado->datesemana }}</td>
                            
                           <td>
                        <a href="{{ route('editarEmpleados.index', $empleado->id) }}" class="btn btn-success editar-btn">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                    </td>
                    <td>
                        <a onclick="confirmDelete('{{ route('deleteEmpleado.destroy', $empleado->id) }}')" class="btn btn-danger eliminar-btn">
                            <i class="bi bi-pencil"></i> Eliminar
                        </a>
                    </td>
                          @endforeach
                        </tbody>
                      </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>




<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
    </script>


<script>
    function confirmDelete(deleteUrl) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Crear un formulario dinámicamente
                var form = document.createElement('form');
                form.action = deleteUrl;
                form.method = 'POST';

                // Agregar token CSRF
                var csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}'; // Usar Blade para obtener el token CSRF

                // Agregar input de método
                var methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodInput);

                // Agregar el formulario al cuerpo y enviarlo
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>











































































































































































































































































<style>
    .editar-btn {
    border: 2px solid green; /* Contorno verde */
    color: green; /* Color del texto */
    border-radius: 10px;
     padding: 5px;
}

.eliminar-btn {
    border: 2px solid red; /* Contorno rojo */
    color: red; /* Color del texto */
    border-radius: 10px;
     padding: 5px;
}

.editar-btn:hover {
    background-color: green; /* Fondo verde al pasar el ratón */
    color: white; /* Texto blanco al pasar el ratón */
}

.eliminar-btn:hover {
    background-color: red; /* Fondo rojo al pasar el ratón */
    color: white; /* Texto blanco al pasar el ratón */
}
</style>

