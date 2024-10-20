<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{

    public function index()
    {
        return  view('empleado.index');
    }

    
    
   public function show(Request $request)
{
            $lempleado = Empleado::all();
        return  view('listaEmpleado.index',['lempleado' => $lempleado]);

}

public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();
        return to_route('listaEmpleado.index');

    }


public function mostrarEdit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('editarEmpleados.index',['empleado' => $empleado]);
    }
    
public function citaAsignada($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleado.index',['empleado' => $empleado]);
    }  




    


        public function update(Request $request, $id)
    {
       // Valida los datos enviados en el formulario
       $request->validate([
        'identificacion'=>'required',
        'nombres' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'correo' => 'required|string|max:255',
        'direccion' => 'required',
        'telefono' => 'required',
        'tipocontrato' => 'required',
         'datesemana'=> 'required|date|after:today'
    ]);

    // Busca el empleado por su ID
    $empleado = Empleado::findOrFail($id);

    // Actualiza los datos del empleado con los valores enviados en el formulario
    $empleado->update([
        'identificacion' => $request->input('identificacion'),
        'nombres' => $request->input('nombres'),
        'apellidos' => $request->input('apellidos'),
        'correo' => $request->input('correo'),
        'direccion' => $request->input('direccion'),
        'telefono' => $request->input('telefono'),
        'tipocontrato' => $request->input('tipocontrato'),
        'datesemana' => $request->input('datesemana'),
    ]);
        //mensaje
        session()->flash('success', 'Datos actualizados correctamente');
        //retornar a la ruta
         return to_route('listaEmpleado.index');


         

    }

    


    

    public function store(Request $request)
    {  
        $validatedData = $request->validate([
            'identificacion' => 'required|string|max:255|unique:empleados',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'tipocontrato' => 'required|string|max:50',
            'datesemana'=> 'required|date|after:today'

            

        ]);
        Empleado::create([
            'identificacion'=>request('identificacion'), 
            'nombres'=>request('nombres'),
            'apellidos'=>request('apellidos'),
            'correo'=>request('correo'),
            'direccion'=>request('direccion'),
            'telefono'=>request('telefono'),
            'tipocontrato'=>request('tipocontrato'),
            'datesemana'=> request('datesemana'),
            

        ]);
       
       
         session()->flash('success', 'Datos guardados con éxito.');

        


         return to_route('empleado.index');

    }

}
