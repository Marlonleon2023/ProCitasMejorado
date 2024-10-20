
1.scrip mejorado pro

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
            document.getElementById('fecha').value = datetimeLocalFormat;

            if (fechasDisponibles.includes(selectedDate)) {
                // Mensaje de éxito
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
                calendar.gotoDate(info.start); // Mueve el calendario a la fecha del evento
                calendar.scrollToTime(selectedTime); // Mueve a la hora específica
            } else {
                // Mensaje de error
                document.getElementById('mensaje-error').innerHTML = "Error: La fecha seleccionada no está disponible.";
                document.getElementById('mensaje-error').style.color = "red";
            }

            calendar.unselect();
        },
        eventDidMount: function(info) {
            tippy(info.el, {
                content: `${info.event.title} (${info.event.start.toLocaleString('es-CO', { weekday: 'long' })})`,
                placement: 'top',
                arrow: true
            });
        }
    });

    calendar.render();

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
                        calendar.gotoDate(primeraFecha); // Mueve el calendario a la primera fecha disponible
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

                        // Mover el calendario a la primera fecha disponible
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

    document.getElementById('empleado_id').addEventListener('change', function(event) {
        const empleadoId = event.target.value;
        obtenerFechaEmpleado(empleadoId);
    });
});

</script>