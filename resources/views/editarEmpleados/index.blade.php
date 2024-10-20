<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
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
                                text: '{{ session('success') }}',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        </script>
                    @endif

                    <form class="needs-validation" method="post" action="{{ route('updatempleado.update', $empleado->id) }}">
                        @method('PUT')
                        @csrf

                        <!-- Campos del formulario del empleado -->
                        <div class="row" style="margin-bottom: 0px;">
                            <div class="col-2" style="margin-bottom: 5px; margin: 15px;">
                                <label for="identificacion" style="font-weight: bold;">Identificación</label>
                                <input type="text" id="identificacion" placeholder="Identificación" name="identificacion" value="{{ $empleado->identificacion }}" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; margin-top: 5px;">
                                @error('identificacion')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 5px; display: flex; justify-content: space-between;">
                            <div class="col-2" style="width: 48%; margin-bottom: 5px; margin: 15px;">
                                <label for="nombres" style="font-weight: bold;">Nombres</label>
                                <input type="text" id="nombres" placeholder="Nombre" name="nombres" value="{{ $empleado->nombres }}" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; margin-top: 5px;">
                                @error('nombres')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2" style="width: 48%; margin-bottom: 5px; margin: 15px;">
                                <label for="apellidos" style="font-weight: bold;">Apellidos</label>
                                <input type="text" id="apellidos" placeholder="Apellido" name="apellidos" value="{{ $empleado->apellidos }}" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; margin-top: 5px;">
                                @error('apellidos')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 5px;">
                            <div class="col-2" style="margin-bottom: 5px; margin: 15px;">
                                <label for="correo" style="font-weight: bold;">Correo</label>
                                <input type="email" id="correo" placeholder="Correo" name="correo" value="{{ $empleado->correo }}" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; margin-top: 5px;">
                                @error('correo')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 5px; display: flex; justify-content: space-between;">
                            <div class="col-2" style="width: 48%; margin-bottom: 5px; margin: 15px;">
                                <label for="direccion" style="font-weight: bold;">Dirección</label>
                                <input type="text" id="direccion" placeholder="Dirección" name="direccion" value="{{ $empleado->direccion }}" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; margin-top: 5px;">
                                @error('direccion')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2" style="width: 48%; margin-bottom: 5px; margin: 15px;">
                                <label for="telefono" style="font-weight: bold;">Teléfono</label>
                                <input type="text" id="telefono" placeholder="Teléfono" name="telefono" value="{{ $empleado->telefono }}" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; margin-top: 5px;">
                                @error('telefono')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 5px;">
                            <div class="col-2" style="margin-bottom: 5px; margin: 15px;">
                                <label for="tipocontrato" style="font-weight: bold;">Tipo de Contrato</label>
                                <select class="form-select" name="tipocontrato" aria-label="Default select example">
                                    <option value="temporal" {{ $empleado->tipocontrato == 'temporal' ? 'selected' : '' }}>Temporal</option>
                                    <option value="indefinido" {{ $empleado->tipocontrato == 'indefinido' ? 'selected' : '' }}>Indefinido</option>
                                    <option value="tiempo_completo" {{ $empleado->tipocontrato == 'tiempo_completo' ? 'selected' : '' }}>Tiempo Completo</option>
                                    <option value="medio_tiempo" {{ $empleado->tipocontrato == 'medio_tiempo' ? 'selected' : '' }}>Medio Tiempo</option>
                                    <option value="por_horas" {{ $empleado->tipocontrato == 'por_horas' ? 'selected' : '' }}>Por Horas</option>
                                </select>   
                                @error('tipocontrato')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2" style="width: 48%; margin-bottom: 5px; margin: 15px;">
                                <label for="datesemana" style="font-weight: bold;">Fecha de Registro</label>
                                <input type="datetime-local" id="datesemana" name="datesemana" value="{{ $empleado->datesemana }}" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; margin-top: 5px;">
                                @error('datesemana')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                           <div class="container mt-5">
                            <div id='calendar'></div>

                            <!-- Modal para modificar fecha y hora -->
                            <div class="modal" id="editEventModal" data-animation="slideInOut">
                                <div class="modal-dialog">
                                    <header class="modal-header">
                                        <h5>Modificar Fecha y Hora  <button class="close-modal" aria-label="close modal" data-close>
                                            ✕  
                                        </button></h5>
                                        
                                    </header>
                                    <hr class="modal-header-hr">
                                    <section class="modal-content">
                                        <label for="modalDate" class="label-con">Fecha:</label>
                                        <br>
                                        <input type="date" id="modalDate" class="form-control" >
                                        <br>
                                        <label for="modalTime" class="label-con">Hora:</label>
                                        <br>
                                        <input type="time" id="modalTime" class="form-control" >
                                    </section>
                                    <hr class="hr-footer">
                                    <footer class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-close>Cancelar</button>
                                        <button type="button" class="btn btn-primary" id="saveChanges">Guardar</button>
                                        <button type="button" class="btn btn-danger" id="deleteEvent">Eliminar cita</button>
                                    </footer>
                                </div>
                            </div>

                            <!-- Campos ocultos para almacenar la fecha y hora -->
                            <input type="hidden" id="fechaSeleccionada" name="fecha" value="{{ date('Y-m-d', strtotime($empleado->datesemana)) }}">
                            <input type="hidden" id="horaSeleccionada" name="hora" value="{{ date('H:i', strtotime($empleado->datesemana)) }}">

                        </div>

                        <div class="row" style="margin-top: 20px;">
                            <div class="col-2">
                                <button type="submit" class="mt-2 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                                    Actualizar Datos
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




<script>
    const openEls = document.querySelectorAll("[data-open]");
    const closeEls = document.querySelectorAll("[data-close]");
    const isVisible = "is-visible";

    // Abrir el modal y rellenar los campos de fecha y hora
    // Abrir el modal y rellenar los campos de fecha y hora
    for (const el of openEls) {
    el.addEventListener("click", function() {
        const modalId = this.dataset.open;
        const modal = document.getElementById(modalId);

        // Aquí puedes verificar si el modal se obtiene correctamente
        if (modal) {
            // Rellenar los campos de fecha y hora
            const fecha = document.getElementById('fechaSeleccionada').value; 
            const hora = document.getElementById('horaSeleccionada').value; 

            document.getElementById('modalDate').value = fecha || '';
            document.getElementById('modalTime').value = hora || '';

            modal.classList.add(isVisible);
        } else {
            console.error('Modal no encontrado: ', modalId);
        }
    });
}


    // Cerrar el modal
    for (const el of closeEls) {
        el.addEventListener("click", function() {
            this.closest('.modal').classList.remove(isVisible);
        });
    }

    document.addEventListener("click", e => {
        if (e.target.classList.contains("modal") && e.target.classList.contains("is-visible")) {
            e.target.classList.remove(isVisible);
        }
    });

    document.addEventListener("keyup", e => {
        if (e.key === "Escape" && document.querySelector(".modal.is-visible")) {
            document.querySelector(".modal.is-visible").classList.remove(isVisible);
        }
    });

    // Código para inicializar el calendario y gestionar eventos
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: [
                {
                    title: 'Cita Agendada',
                    start: '{{ $empleado->datesemana }}', // Asegúrate de que esta variable tenga el valor correcto
                    allDay: false // Cambiado a false para manejar datetime
                }
            ],
            dateClick: function(info) {
                const selectedDate = info.dateStr;
                document.getElementById('modalDate').value = selectedDate;
                document.getElementById('editEventModal').classList.add(isVisible);
            }
        });

        calendar.render();

        // Guardar cambios al pulsar el botón
        document.getElementById('saveChanges').addEventListener('click', function() {
            const newDate = document.getElementById('modalDate').value;
            const newTime = document.getElementById('modalTime').value;

            // Asegúrate de que la hora esté en el formato correcto
            const formattedTime = newTime.padStart(5, '0'); // Formatea la hora si es necesario (debe estar en formato HH:MM)

            // Combina la fecha y la hora en un solo valor datetime
            const combinedDateTime = `${newDate} ${formattedTime}`; // Usar espacio en lugar de 'T' para el formato correcto

            // Asigna el valor combinado al campo correspondiente
            document.getElementById('datesemana').value = combinedDateTime;

            // Limpiar eventos anteriores
            calendar.getEvents().forEach(event => {
                if (event.title === 'Cita Agendada') {
                    event.remove();
                }
            });

            // Agregar el nuevo evento
            calendar.addEvent({
                title: 'Cita Agendada',
                start: combinedDateTime,
                allDay: false // Cambiado a false ya que estás usando datetime
            });

            document.getElementById('editEventModal').classList.remove(isVisible);
        });

        // Eliminar el evento y limpiar campos
        document.getElementById('deleteEvent').addEventListener('click', function() {
            calendar.getEvents().forEach(event => {
                if (event.title === 'Cita Agendada') {
                    event.remove();
                }
            });

            document.getElementById('fechaSeleccionada').value = '';
            document.getElementById('horaSeleccionada').value = '';
            document.getElementById('datesemana').value = '';

            document.getElementById('editEventModal').classList.remove(isVisible);
        });
    });
</script>





<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>












































































































































































<style>
      /* Estilos para el calendario */
#calendar {
    margin: 40px auto;
}

/* Estilos para el modal */
.modal {
    z-index: 20000;
    display: none;
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
    url('{{ asset('images/barberia.png') }}');
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

</style>



