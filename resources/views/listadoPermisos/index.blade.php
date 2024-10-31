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
                    <th>Eliminar Rol</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->getRoleNames()->implode(', ') }}</td>
                        <td>
                            <button type="button" class="btn btn-success mt-2" onclick="showAssignRole(this, '{{ $user->id }}')">Asignar</button>
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

        <div id="assign-role-modal" class="assign-role-container" style="display: none;">
            <h3>Asignar Nuevo Rol</h3>
            <br>
            <form id="roleAssignForm" action="{{ route('roles.assign') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" id="user_id">
                <select name="role_id" class="form-control">
                    <option value="">Sin rol</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                <br>
                <br>
                <hr>
                <button type="submit" class="btn btn-success mt-2">Confirmar</button>
                <button type="button" class="btn btn-danger mt-2" onclick="hideAssignRole()">Cancelar</button>
            </form>
        </div>
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

    function showAssignRole(button, userId) {
        const modal = document.getElementById('assign-role-modal');
        modal.style.display = "block";
        document.getElementById('user_id').value = userId; // Establece el ID del usuario en el formulario
    }

    function hideAssignRole() {
        const modal = document.getElementById('assign-role-modal');
        modal.style.display = "none"; // Oculta el modal
    }
</script>

<style>
    .container {
        padding-right: 30px;
        padding-left: 30px;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        border-radius: 5px;
        padding: 5px;
        margin-left: 0px;
        color: #ffffff;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        border-radius: 5px;
        padding: 5px;
        margin-left: 110px;
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

    .assign-role-container {
        border: 1px solid #28a745; /* Bordes del recuadro */
        border-radius: 5px; /* Bordes redondeados */
        padding: 10px; /* Espaciado interno */
        background-color: #f8f9fa; /* Color de fondo */
        margin-top: 10px; /* Espacio superior */
        position: absolute; /* Posición absoluta */
        top: 190px; /* Ajusta la distancia del top según necesites */
        left: 50%; /* Centrado horizontal */
        transform: translateX(-50%); /* Alinear al centro */
        z-index: 1000; /* Asegúrate de que esté por encima */
        width: 300px; /* Ancho del recuadro */
        display: none; /* Oculto inicialmente */
        height: 200px;
        
    }

    table {
    width: 100%; /* Asegúrate de que la tabla ocupe todo el ancho del contenedor */
    table-layout: fixed; /* Para un mejor control sobre el ancho de las columnas */
}

th, td {
    text-align: center; /* Centrar el texto en las celdas */
    vertical-align: middle; /* Centrar verticalmente el contenido */
}

/* Estilo opcional para ajustar el ancho de las columnas */
th {
    width: 20%; /* Ajusta el ancho según tus necesidades */
}
</style>
