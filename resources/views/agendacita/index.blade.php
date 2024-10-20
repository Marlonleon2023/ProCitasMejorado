<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container" style="margin: 5px; font-family: Arial, sans-serif; background-color: #ffff; padding: 70px; border-radius: 10px;">
                    @if ($errors->any())
                        <div class="alert alert-danger" style="margin-bottom: 20px; padding: 10px; border-radius: 5px; background-color: #f8d7da; color: #721c24;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <script>
                            Swal.fire({
                                title: 'Éxito',
                                text: "{{ session('success') }}", // Use double quotes for JavaScript
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        </script>
                    @endif

                    <form action="{{ route('agendacita.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-2 form-group">
                                <label for="nombres" class="form-label">Nombres Completos</label>
                                <input type="text" id="nombres" placeholder="Nombre" name="nombres" value="{{ old('nombres') }}" class="form-input-nombre" required>
                                @error('nombres')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2 form-group">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="email" id="correo" placeholder="Correo" name="correo" value="{{ old('correo') }}" class="form-input" required>
                                @error('correo')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-2 form-group">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" id="telefono" placeholder="Teléfono" name="telefono" value="{{ old('telefono') }}" class="form-input" required>
                                @error('telefono')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2 form-group">
                                <label for="tiposervicio" class="form-label">Tipo Servicio</label>
                                <select id="tiposervicio" name="tiposervicio" class="form-select" required>
                                    <option value="">Seleccione un Servicio</option>
                                    <option value="Facial" {{ old('tiposervicio') == 'Facial' ? 'selected' : '' }}>Facial</option>
                                    <option value="Barba" {{ old('tiposervicio') == 'Barba' ? 'selected' : '' }}>Barba</option>
                                    <option value="Acondicionar" {{ old('tiposervicio') == 'Acondicionar' ? 'selected' : '' }}>Acondicionar</option>
                                    <option value="Alisar" {{ old('tiposervicio') == 'Alisar' ? 'selected' : '' }}>Alisar</option>
                                </select>
                                @error('tiposervicio')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-2 form-group">
                                <label for="empleado" class="form-label">Empleado</label>
                                <select id="empleado_id" name="empleado_id" class="form-select" required>
                                    <option value="" disabled selected>Seleccione un Empleado</option>
                                    @foreach ($lempleado as $empleado)
                                        <option value="{{ $empleado->id }}">{{ $empleado->nombres }}</option>
                                    @endforeach

                                </select>
                                @error('empleado_id')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-2 form-group">
                            <label for="fecha" class="form-label">Fecha y Hora de Cita</label>
                            <input type="datetime-local" id="fecha" name="fecha" value="{{ old('fecha') }}" class="form-input" required>
                            <div id="mensaje-error" class="error-message"></div>
                            @error('fecha')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>



            
                    <div class="justify">
                        <div class="tooltip">
                            <span class="color-disponible"></span>
                            <span class="tooltip-text">Esta línea indica las fechas disponibles para reservar</span>
                        </div>
                 <h3>Fechas Disponibles</h3>
                
                    <ul id="fechas-disponibles"></ul>
                </div>

                <div class="justify">
                    <h2>Empleado </h2>
                    <div id="empleado-nombre"></div>
                </div>

                <div id="mensaje-error" style="color: red;"></div>
                
                <div class="container mt-5">
                    <div id='calendar'></div>
                    <ul id="eventos-exteriores" style="list-style-type: none; padding: 0;">
                        <!-- Aquí se agregarán los eventos externos -->
                    </ul>
                </div>
                

                        <div class="row" style="margin-top: 20px;">
                            <div class="col-2" style="margin-bottom: 5px; margin: 15px;">
                                <button type="submit" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; background-color: #000000; color: #fff; cursor: pointer;">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



<link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>




<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>


<div class="row">
    <div class="col-2 form-group">
        <label for="fecha" class="form-label">Fecha y Hora de Cita</label>
        <input type="datetime-local" id="fecha" name="fecha" value="{{ old('fecha') }}" class="form-input" required>
        <div id="mensaje-error" class="error-message"></div>
        @error('fecha')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        let fechasDisponibles = [];

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            selectable: true,
            events: [],
            select: function(info) {
                const selectedDate = info.startStr.split("T")[0];
                const selectedTime = info.startStr.split("T")[1].substring(0, 5);
                const datetimeLocalFormat = `${selectedDate}T${selectedTime}`;
                document.getElementById('fecha').value = datetimeLocalFormat; // Asignar al input
                
                if (fechasDisponibles.includes(selectedDate)) {
                    document.getElementById('mensaje-error').innerHTML = "La cita ha sido asignada exitosamente.";
                    document.getElementById('mensaje-error').style.color = "green";

                    // Limpiar eventos anteriores
                    calendar.removeAllEvents();

                    // Agregar el nuevo evento
                    calendar.addEvent({
                        title: `Cita: ${selectedDate} a las ${selectedTime}`,
                        start: info.start,
                        end: info.end,
                        classNames: ['selected-event']
                    });

                    // Mover el calendario a la fecha del evento y ajustar el scrollTime
                    calendar.gotoDate(info.start); 
                    calendar.scrollToTime(selectedTime); 
                } else {
                    document.getElementById('mensaje-error').innerHTML = "Error: La fecha seleccionada no está disponible.";
                    document.getElementById('mensaje-error').style.color = "red";
                }

                calendar.unselect(); // Desmarcar la selección
            },
            eventDidMount: function(info) {
                // Obtener la fecha y hora en un formato legible
                const fecha = info.event.start.toLocaleDateString('es-CO', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                const horaInicio = info.event.start.toLocaleTimeString('es-CO', { hour: '2-digit', minute: '2-digit' });
                const horaFin = info.event.end.toLocaleTimeString('es-CO', { hour: '2-digit', minute: '2-digit' });
                
                tippy(info.el, {
                    content: `${info.event.title} : ${fecha} de ${horaInicio} a ${horaFin}`,
                    placement: 'top',
                    arrow: true
                });
            }
        });

        calendar.render();

        // Obtener fechas del empleado
        function obtenerFechaEmpleado(empleadoId) {
            if (empleadoId) {
                fetch(`/empleado/${empleadoId}/fechas`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la red');
                        }
                        return response.json();
                    })
                    .then(data => {
                        fechasDisponibles = data.datesemana;
                        const fechasDisponiblesList = document.getElementById('fechas-disponibles');
                        fechasDisponiblesList.innerHTML = '';

                        // Limpiar eventos del calendario
                        calendar.removeAllEvents();

                        const fragment = document.createDocumentFragment();
                        if (Array.isArray(data.datesemana)) {
                            data.datesemana.forEach(fecha => {
                                const li = document.createElement('li');
                                li.textContent = `${new Date(fecha).toLocaleDateString('es-CO', { weekday: 'long' })} ${fecha}`;
                                fragment.appendChild(li);

                                calendar.addEvent({
                                    title: 'Disponible',
                                    start: fecha,
                                    end: new Date(new Date(fecha).getTime() + 3600000),
                                    classNames: ['available-date']
                                });
                            });

                            // Mover el calendario a la primera fecha disponible
                            const primeraFecha = new Date(data.datesemana[0]);
                            calendar.gotoDate(primeraFecha); 
                        } else {
                            const li = document.createElement('li');
                            li.textContent = `${new Date(data.datesemana).toLocaleDateString('es-CO', { weekday: 'long' })} ${data.datesemana}`;
                            fragment.appendChild(li);

                            calendar.addEvent({
                                title: 'Disponible',
                                start: data.datesemana,
                                end: new Date(new Date(data.datesemana).getTime() + 3600000),
                                classNames: ['available-date']
                            });

                            calendar.gotoDate(new Date(data.datesemana));
                        }

                        fechasDisponiblesList.appendChild(fragment);
                        document.getElementById('empleado-nombre').innerHTML = `${data.nombres} ${data.apellidos}`;

                        // Limpiar el campo de fecha al cambiar de empleado
                        document.getElementById('fecha').value = '';
                        document.getElementById('mensaje-error').innerHTML = '';
                    })
                    .catch(error => {
                        console.error('Error al obtener los datos del empleado:', error);
                        document.getElementById('mensaje-error').innerHTML = "Error al cargar las fechas disponibles.";
                        document.getElementById('mensaje-error').style.color = "red";
                    });
            } else {
                document.getElementById('fechas-disponibles').innerHTML = '';
                document.getElementById('empleado-nombre').innerHTML = '';
                calendar.removeAllEvents();
                document.getElementById('fecha').value = '';
                document.getElementById('mensaje-error').innerHTML = '';
            }
        }

        // Cambio de empleado
        document.getElementById('empleado_id').addEventListener('change', function(event) {
            const empleadoId = event.target.value;
            obtenerFechaEmpleado(empleadoId);
        });
    });
</script>

































































































































































































































<style>

.color-disponible {
            display: inline-block; /* Para que el span funcione como una línea */
            width: 100px; /* Ancho de la línea */
            height: 2px; /* Grosor de la línea */
            background-color: #00f7ff;
            margin: 5px 0; /* Espaciado vertical opcional */
        }

        .tooltip {
            position: relative; /* Posición relativa para el tooltip */
            display: inline-block; /* Para alinear el tooltip con la línea */
        }

        .tooltip-text {
            visibility: hidden; /* Oculto por defecto */
            width: 250px; /* Ancho del tooltip */
            background-color: rgb(42, 42, 42); /* Color de fondo */
            color: #fff; /* Color del texto */
            text-align: center; /* Centrar el texto */
            border-radius: 5px; /* Bordes redondeados */
            padding: 5px; /* Espaciado interno */
            position: absolute; /* Posicionamiento absoluto */
            z-index: 1; /* Asegurar que esté por encima */
            bottom: 125%; /* Ubicar encima de la línea */
            left: 50%; /* Centrar horizontalmente */
            margin-left: -100px; /* Ajustar para centrar el tooltip */
        }

        .tooltip:hover .tooltip-text {
            visibility: visible; /* Mostrar el tooltip al pasar el cursor */
        }

.fc-event {
    height: 8px; /* Cambia la altura del evento */
    font-size: 12px; /* Cambia el tamaño de la fuente */
    line-height: 20px; /* Alinea el texto verticalmente */
    background-color: #00f7ff;
}
    .form-group {
        margin: 15px 0;
    }
    
.form-input-nombre {
    width: 208%; 
    box-sizing: border-box; 
}


    .form-label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        color: #333;
    }
    
    .form-input, .form-select {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        transition: border-color 0.3s;
    }
    
    .form-input:focus, .form-select:focus {
        border-color: #007bff; /* Cambia el color según tu preferencia */
        outline: none;
    }
    
    .error-message {
        color: red;
        font-size: 0.875em;
        margin-top: 5px;
    }
    
    .row {
        display: flex;
        flex-wrap: wrap; /* Permite que los elementos se ajusten en pantallas pequeñas */
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .col-2 {
        flex: 0 0 48%; /* Ajusta el ancho de las columnas */
        box-sizing: border-box; /* Incluye padding y borde en el ancho total */
    }






    /* Estilos para el calendario */
#calendar {
    margin: 40px auto;
}


.selected-event {
   width: 100%;
   background-color: #00cdd4
}

/* Estilos para el modal */
.modal {
    z-index: 20000;
    display: none;
    background-color: rgba(0, 0, 0, 0.5);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    justify-content: center;
    align-items: center;
}

.modal.is-visible {
    display: flex;
}

.form-control {
    border-radius: 5px;
    margin-left: 20px;
    margin-top:10px;
    margin-bottom: 10px; 
    width: 80%;
}



.modal-dialog {
    background-image: 
    linear-gradient(rgba(83, 78, 78, 0.534), rgba(65, 57, 57, 0.568)), 
    url('images/barberia.png');
    background-size: cover;
    background-repeat: no-repeat;
    padding: 15px;
    filter: brightness(1);
    
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 430px; /* Ancho ajustado del modal */
    height: 360px;
    display: flex; /* Cambiar a flex para controlar el espaciado */
    flex-direction: column; /* Organizar los elementos en columna */
    gap: 10px; /* Espacio uniforme entre elementos */
    box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.637);
 
}

.close-modal {
    background: none;
    border: none;
    font-size: 1.5rem;
    margin-left: 120px;
}

.close-modal:hover{
    color: #ff0019;
}

.modal-header-hr{
margin-bottom: 25px;
}

.modal-header h5 {
    margin: 0;
    font-weight: bold;
    margin-right: 20px;
    text-align: center;
    align-items: center;
    color: #fff;
    text-shadow: 1px 1px 10px rgba(2, 255, 234, 0.884);
}

.hr-footer{
margin-top: 20px;
}

.label-con{
    margin-left: 20px;
    color: #fff7f7;
    font-size: bold;
    font-weight: 700;
    text-shadow: 1px 1px 10px rgba(0, 255, 238, 0.959);
}

.modal-footer {
    display: flex;
    justify-content: space-between;
    
    gap: 10px; /* Espacio uniforme entre los botones */
}

.modal-footer .btn {
    flex: 1;
    margin: 0 5px; /* Asegúrate de que haya un margen uniforme */
}

.btn-primary {
    background-color: #007bff;
    border: 1px solid #4e4e4e;
    border-radius: 10px;
    color: white;
    padding: 5px; /* Añadir padding para aumentar el tamaño del botón */
    transition: background-color 0.3s, border-color 0.3s; /* Suaviza la transición */
}

.btn-primary:hover {
    background-color: #0056b3; /* Cambia el color de fondo al pasar el cursor */
    border-color: #003f7f; /* Cambia el color del borde al pasar el cursor */
     border-color: #00f7ff;
}

.btn-danger {
    background-color: #dc3545;
    border: 1px solid #4e4e4e;
    border-radius: 10px;
    color: white;
    padding: 5px; /* Asegúrate de que todos los botones tengan padding consistente */
    transition: background-color 0.3s, border-color 0.3s; /* Suaviza la transición */
    
}

.btn-danger:hover {
    background-color: #c82333; /* Cambia el color de fondo al pasar el cursor */
    border-color: #a71c1c; /* Cambia el color del borde al pasar el cursor */
     border-color: #00f7ff;
}

.btn-secondary {
    background-color: #6c757d;
    border: 1px solid #4e4e4e;
    border-radius: 10px;
    color: white;
    padding: 5px; /* Consistencia en el tamaño del botón */
    transition: background-color 0.3s, border-color 0.3s; /* Suaviza la transición */
}

.btn-secondary:hover {
    background-color: #5a6268; /* Cambia el color de fondo al pasar el cursor */
    border-color: #00f7ff; /* Cambia el color del borde al pasar el cursor */
}



.justify {
    display: inline-block; /* Para que se alineen uno al lado del otro */
    width: 45%; /* Ajusta el tamaño según lo necesario */
    vertical-align: top; /* Alinea los elementos en la parte superior */
    margin: 1%; /* Espaciado entre los divs */
}

ul {
    list-style-type: none; /* Quitar los puntos de la lista */
    padding: 0;
    margin: 0;
}

h3, h2 {
    margin-bottom: 10px; /* Añadir espacio debajo de los títulos */
}


</style>
