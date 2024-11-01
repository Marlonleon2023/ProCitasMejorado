<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Listado Roles') }}
        </h2>
        <!-- Formulario para crear un nuevo rol -->
        
        <form action="{{ route('roles.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="form-group">
                <!-- Botón que activa el contenedor de creación -->
                <button type="button" class="btn btn-primary mt-3" onclick="mostrarFormulario()">Crear Roles</button>
                
                <!-- Contenedor oculto para crear el rol (con clase de recuadro central) -->
                <div id="crearRol" class="edit-form-container">
                    <label for="role_name" class="mt-3">Nombre del Rol</label>
                    <br>
                    <input type="text" name="role_name" class="form-control underline-input" id="role_name" required>
                    <br>
                    <br>
                    <hr>
                    <button type="submit" class="btn btn-primaryo mt-3">Asignar</button>
                    <!-- Botón de Cerrar -->
                    <button type="button" class="btn btn-secondary mt-3" onclick="cerrarFormulario()">Cerrar</button>
                </div>
            </div>
        </form>


    </x-slot>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        

        <h2 class="mt-4">Lista de Roles</h2>
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td style="text-align: center;">{{ $role->id }}</td>
                        <td style="text-align: center;">{{ $role->name }}</td>
                        <td style="text-align: center;">
                            <!-- Botón para mostrar el formulario de edición -->
                            <button class="btn btn-warning" onclick="toggleEditForm('editForm{{ $role->id }}')">Editar</button>

                            <!-- Formulario para eliminar el rol -->
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <!-- Contenedor del formulario de edición -->
                    <div id="editForm{{ $role->id }}" class="edit-form-container" style="display: none;">
                        <form action="{{ route('roles.update', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="role_name">Editar Nombre del Rol</label>
                                <br>
                                <br>
                                <input type="text" name="role_name" value="{{ $role->name }}" required class="form-control">
                            </div>
                            <br>
                            <hr/>
                        <div class="group-button">
                            <button type="submit" class="btn btn-success">Actualizar</button>
                            <button type="button" class="btn btn-cancel" onclick="toggleEditForm('editForm{{ $role->id }}')">Cerrar</button>
                        </div>
                        </form>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Incluye jQuery, Bootstrap y DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
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


        function mostrarFormulario() {
        document.getElementById("crearRol").style.display = "block";
    }

    function cerrarFormulario() {
        document.getElementById("crearRol").style.display = "none";
    }

        function toggleEditForm(formId) {
            var form = document.getElementById(formId);
            if (form.style.display === "none") {
                form.style.display = "block"; // Mostrar el contenedor
            } else {
                form.style.display = "none"; // Ocultar el contenedor
            }
        }
    </script>

<style>

    .underline-input {
        margin-top: 40px;                   
        border-bottom: 1px solid #007bff; /* Solo el borde inferior */
        border-radius: 3px;              /* Bordes redondeados */
        outline: none;                   /* Sin borde al hacer clic */
        background-color: #f7f7f7;       /* Fondo gris claro */
        color: #333;                     /* Texto oscuro */
        padding: 5px;                    /* Espacio interno */
        padding-right: 250px;
        margin-left: 10px;
    }

    .underline-input::placeholder {
        color: #999;                     /* Placeholder gris medio */
    }

    .underline-input:focus {
        border-bottom-color: #0056b3;    /* Color del borde en foco */
        background-color: #eaeaea;       /* Fondo ligeramente más oscuro al enfocarse */
    }

            .container {
                padding-right: 30px;
                padding-left: 30px;
            }

            .edit-form-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.6);
            z-index: 1000;
            border-radius: 8px;
            width: 500px;        
            height: 200px;       
            display: none;       
        }

        /* Fondo de pantalla semi-transparente para el efecto de modal */
        .modal-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5); /* Fondo oscuro semi-transparente */
            z-index: 999;
            display: none;       /* Inicialmente oculto */
        }


        .btn-success {
            background-color: #28a745; /* Color verde */
            border-color: #28a745; /* Color del borde */
            border-radius: 5px;
            padding: 5px;
            color: #ffffff;
        }

        .btn-danger {
            background-color: #dc3545; /* Color rojo */
            border-color: #dc3545; /* Color del borde */
            border-radius: 5px;
            padding: 5px;
            color: #ffffff;
            margin-left: 20px;
        }

        .btn-warning {
            background-color: #ffc107; /* Color amarillo */
            border-color: #ffc107; /* Color del borde */
            border-radius: 5px;
            padding: 5px;
            color: #ffffff;            
        }

        .btn-secondary{
            background-color:  #dc3545; /* Color azul */
            border-color:  #dc3545; /* Color del borde */
            padding: 5px;
            border-radius: 5px;
            color: #ffffff;
            margin-left: 260px;
        }

        .btn-primaryo {
            background-color:#28a745; /* Color azul */
            border-color: #28a745; /* Color del borde */
            padding: 5px;
            border-radius: 5px;
            color: #ffffff;
            margin-left:30px;
        }

        .btn-primary {
            background-color: #007bff; /* Color azul */
            border-color: #007bff; /* Color del borde */
            padding: 5px;
            border-radius: 5px;
            color: #ffffff;
        }

        .btn-cancel{
            margin-left: 320px;
            background-color: #dc3545;
            padding: 5px;
            border-radius: 5px;
            color: #ffffff;

        }

        .btn-primary:hover {
            background-color: #0056b3; /* Color azul oscuro al pasar el mouse */
            border-color: #0056b3; /* Color del borde al pasar el mouse */
        }

        .group-button{
            margin-top: 20px
        }

        .btn-danger:hover {
            background-color: #c82333; 
            border-color: #dc3545; 
        }
    </style>
</x-app-layout>

