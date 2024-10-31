<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Listado Permisos') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        <h2>Asignación de Roles</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table id="example" class="table table-striped table-bordered margin-sides">
            <thead>
                <tr>
                    <th>Nombre de Usuario</th>
                    <th>Email</th>
                    <th>Rol Actual</th>
                    <th>Asignar Nuevo Rol</th>
                    <th>Eliminar Rol</th> <!-- Nueva columna para eliminar rol -->
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->getRoleNames()->implode(', ') }}</td>
                        <td>
                            <form action="{{ route('roles.assign') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <select name="role_id" class="form-control">
                                    <option value="">Sin rol</option> <!-- Opción para eliminar rol -->
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-success mt-2">Asignar</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('roles.remove') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <button type="submit" class="btn btn-danger mt-2">Eliminar Rol</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-app-layout>

<!-- Incluye jQuery antes de DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>

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

<style>
    .container {
        padding-right: 30px;
        padding-left: 30px;
    }

    /* Estilo para el botón Asignar */
    .btn-success {
        background-color: #28a745; /* Color verde */
        border-color: #28a745; /* Color del borde */
        border-radius: 5px;
        padding: 5px;
        margin-left: 20px;
        color: #ffffff;
    }

    .btn-danger {
        background-color: #dc3545; /* Color rojo */
        border-color: #dc3545; /* Color del borde */
        border-radius: 5px;
        padding: 5px;
        margin-left: 20px;
        color: #ffffff;
    }

    .btn-success:hover {
        background-color: #1d8435; 
        border-color: #28a745; 
    }

    .btn-danger:hover {
        background-color: #c82333; 
        border-color: #dc3545; 
    }
</style>
