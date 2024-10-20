<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index()
    {
        // Obtiene todos los empleados para mostrarlos en la vista
        $lempleado = Empleado::all();
        return view('agendacita.index', ['lempleado' => $lempleado]);
    }

    public function getEmpleadoFecha($empleadoId)
    {
        // Obtén el empleado por ID
        $empleado = Empleado::findOrFail($empleadoId);
        
        // Aquí puedes definir tu lógica para obtener las fechas disponibles
        $fechasDisponibles = []; // Inicializa el array para almacenar las fechas

        // Lógica para llenar el array con fechas disponibles
        $agendas = Agenda::where('empleado_id', $empleadoId)
                         ->where('fecha', '>=', Carbon::now()) // Solo fechas futuras
                         ->get();

        foreach ($agendas as $agenda) {
            // Agrega la fecha de la agenda al array de fechas disponibles
            $fechasDisponibles[] = $agenda->fecha->format('Y-m-d H:i'); // Formato de fecha y hora
        }

        return response()->json([
            'datesemana' => $empleado->datesemana,
            'nombres' => $empleado->nombres,
            'apellidos' => $empleado->apellidos,
        ]);
    }

    // Método para mostrar todas las citas agendadas
    public function show(Request $request)
    {
        // Obtiene todas las citas de la tabla Agenda
        $lecitas = Agenda::all();
        return view('citasAgendadas.index', ['lecitas' => $lecitas]);
    }

    // Método para eliminar una cita agendada
    public function destroy($id)
    {
        // Busca la cita en la tabla Agenda
        $agenda = Agenda::findOrFail($id);
        
        // Elimina la cita encontrada
        $agenda->delete();
        
        // Redirige a la vista de citas agendadas
        return to_route('citasAgendadas.index');
    }

    public function update(Request $request, $id)
    {
        // Valida los datos enviados en el formulario
        $request->validate([
            'nombres' => 'required|string|max:255',
            'correo' => 'required|string|max:255',
            'telefono' => 'required',
            'tiposervicio' => 'required|string|max:255',
            'fecha' => 'required|date|after:today',
            'empleado_id' => 'required|exists:empleados,id',
        ]);

        // Busca la agenda por su ID
        $agenda = Agenda::findOrFail($id);

        // Actualiza los datos de la agenda
        $agenda->update([
            'nombres' => $request->input('nombres'),
            'correo' => $request->input('correo'),
            'telefono' => $request->input('telefono'),
            'tiposervicio' => $request->input('tiposervicio'),
            'fecha' => $request->input('fecha'),
            'empleado_id' => $request->input('empleado_id'),
        ]);

        // Mensaje de éxito
        session()->flash('success', 'Datos actualizados correctamente');

        // Retornar a la ruta de lista de empleados
        return to_route('editarAgendados.index', ['id' => $id]);
    }

    public function editAgendado($id)
    {
        // Busca la agenda por su ID
        $agenda = Agenda::findOrFail($id);

        // Obtén la lista de empleados
        $lempleado = Empleado::all();

        // Retorna la vista con la agenda y los empleados
        return view('editarAgendados.index', compact('agenda', 'lempleado'));
    }

    // Método para mostrar el formulario de creación de citas
    public function create()
    {
        $lempleado = Empleado::all(); // Obtén todos los empleados
        return view('agendacita.create', compact('lempleado'));
    }

    // Método para almacenar una nueva cita
    public function store(Request $request)
    {
        // Validación y captura de datos validados
        $validatedData = $request->validate([
            'nombres' => 'required|string|max:255',
            'correo' => 'required|email',
            'telefono' => 'required|string|max:15',
            'tiposervicio' => 'required|string|max:255',
            'empleado_id' => 'required|exists:empleados,id',
            'fecha' => 'required|date_format:Y-m-d\TH:i',
        ]);

        // Formateo de la fecha usando Carbon
        $fecha = Carbon::parse($validatedData['fecha'])->format('Y-m-d H:i:s');

        // Guardar la nueva cita en la base de datos
        Agenda::create([
            'nombres' => $validatedData['nombres'],
            'correo' => $validatedData['correo'],
            'telefono' => $validatedData['telefono'],
            'tiposervicio' => $validatedData['tiposervicio'],
            'fecha' => $fecha,
            'empleado_id' => $validatedData['empleado_id'],
        ]);

        // Mensaje de éxito y redirección
        session()->flash('success', 'Cita agendada correctamente');
        return redirect()->route('agendacita.index');
    }
}
