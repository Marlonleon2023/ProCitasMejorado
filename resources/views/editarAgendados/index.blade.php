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

                   <form class="needs-validation" method="post" action="{{ route('updateAgendado.update', $agenda->id) }}">
                        @method('PUT')
                        @csrf

                        <!-- Campos del formulario de la agenda -->
                        <div class="row" style="margin-bottom: 0px;">
                            <div class="col-2" style="margin-bottom: 5px; margin: px;">
                                <label for="nombres" style="font-weight: bold;">Nombre Completo</label>
                                <input type="text" id="nombres" placeholder="Nombre completo" name="nombres" value="{{ $agenda->nombres }}" style="width: 205%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; margin-top: 5px;">
                                @error('nombres')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2 form-group">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="email" id="correo" placeholder="Correo" name="correo" value="{{ $agenda->correo }}" class="form-input" required>
                                @error('correo')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-2 form-group">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" id="telefono" placeholder="Teléfono" name="telefono" value="{{ $agenda->telefono }}" class="form-input" required>
                                @error('telefono')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2 form-group">
                                <label for="tiposervicio" class="form-label">Tipo de Servicio</label>
                                <select id="tiposervicio" name="tiposervicio" class="form-select" required>
                                    <option value="">Seleccione un Servicio</option>
                                    <option value="Facial" {{ $agenda->tiposervicio == 'Facial' ? 'selected' : '' }}>Facial</option>
                                    <option value="Barba" {{ $agenda->tiposervicio == 'Barba' ? 'selected' : '' }}>Barba</option>
                                    <option value="Acondicionar" {{ $agenda->tiposervicio == 'Acondicionar' ? 'selected' : '' }}>Acondicionar</option>
                                    <option value="Alisar" {{ $agenda->tiposervicio == 'Alisar' ? 'selected' : '' }}>Alisar</option>
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
                                        <option value="{{ $empleado->id }}" {{ $empleado->id == $agenda->empleado_id ? 'selected' : '' }}>{{ $empleado->nombres }}</option>
                                    @endforeach
                                </select>
                                @error('empleado_id')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2 form-group">
                                <label for="fecha" class="form-label">Fecha y Hora de la Cita</label>
                                <input type="datetime-local" id="fecha" name="fecha" value="{{ $agenda->fecha }}" class="form-input" required>
                                @error('fecha')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="container mt-5">
                            <div id='calendar'></div>
                        </div>

                        <div class="row" style="margin-top: 20px;">
                            <div class="col-2">
                                <button type="submit" class="mt-2 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                                    Actualizar Agenda
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
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        selectable: true,
        events: [],
        select: function(info) {
            const selectedDate = info.startStr.split("T")[0];
            const selectedTime = info.startStr.split("T")[1].substring(0, 5);

            // Colocar los valores directamente en el input de fecha
            document.getElementById('fecha').value = `${selectedDate}T${selectedTime}`;

            // Limpiar eventos anteriores
            calendar.removeAllEvents(); // Eliminar todos los eventos antes de agregar uno nuevo

            // Agregar un evento al calendario
            calendar.addEvent({
                title: `Selec: ${selectedDate} a las ${selectedTime}`,
                start: info.start,
                end: info.end,
                classNames: ['selected-event'] // Añadir clase para estilo
            });

            // Desmarcar la selección
            calendar.unselect(); // Desmarca la selección para que no se vea el área seleccionada
        }
    });

    calendar.render();
});
</script>


<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>











<style>
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

</style>