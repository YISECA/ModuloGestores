<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\ActividadGestor;
use App\DatosActividad;
use App\Persona;
use Validator;



class ConfiguracionActividadController extends Controller
{
    //
	public function buscarTematicas(Request $request, $id_eje)
	{
		$eje_model = app()->make('App\Eje');
		$eje = $eje_model->find($id_eje);

		return response()->json($eje->tematica);
	}

	//
	public function buscarActividades(Request $request, $id_tematica)
	{
		$tematica_model_ = app()->make('App\Tematica');
		$actividad = $tematica_model_->find($id_tematica);

		return response()->json($actividad->actividad);
	}

	public function buscarEje(Request $request, $id_eje)
	{
		$eje_model = app()->make('App\Eje');
		$eje = $eje_model->find($id_eje);

		return response()->json($eje);
	}

	public function buscarTematica(Request $request, $id_tematica)
	{
		$eje_model = app()->make('App\Tematica');
		$eje = $eje_model->find($id_tematica);

		return response()->json($eje);
	}

	public function buscarActividad(Request $request, $id_actividad)
	{
		$eje_model = app()->make('App\Actividad');
		$eje = $eje_model->find($id_actividad);

		return response()->json($eje);
	}

	 public function procesarValidacion(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
	           
				'Fecha_Ejecución' => 'required',
				'Id_Responsable' => 'required',
				'Hora_Inicio' => 'required',
				'Hora_Fin' => 'required',
				'Id_Localidad' => 'required',
				'Parque' => 'required',
				'Caracteristica_Lugar' => 'required',
				'Caracteristica_poblacion' => 'required',
				'Institucion_Grupo' => 'required',
				'Numero_Asistentes' => 'required|numeric',
				'Hora_Implementacion' => 'required',
				'Persona_Contacto' => 'required',
				'Roll_Comunidad' => 'required',
				'Telefono' => 'required',
        	]
        );

        if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
        else
        	$this->guardar($request->all());

        return response()->json(array('status' => 'ok'));
	}

	public function guardar($input)
	{
		$model_A = new ActividadGestor;
		return $this->crear_actividad($model_A, $input);

		
		/*
		$model_AC = new Acompanante;
		return $this->crear_acompanante_Actividad($model_AC, $input);*/
	}

	public function crear_actividad($model, $input)
	{
		$model['Id_Persona'] = $input['Id_Responsable'];
		$model['Id_Responsable'] = $input['Id_Responsable'];
		$model['Fecha_Ejecución'] = $input['Fecha_Ejecución'];
		$model['Hora_Incial'] = $input['Hora_Inicio'];
		$model['Hora_Final'] = $input['Hora_Fin'];
		$model['Localidad'] = $input['Id_Localidad'];
		$model['Parque'] = $input['Parque'];
		$model['Caracteristica_Lugar'] = $input['Caracteristica_Lugar'];
		$model['Instit_Grupo_Comun'] = $input['Institucion_Grupo'];
		$model['Caracteristica_Poblacion'] = $input['Caracteristica_poblacion'];
		$model['Numero_Asistente'] = $input['Numero_Asistentes'];
		$model['Hora_Implementacion'] = $input['Hora_Implementacion'];

		$model['Nombre_Contacto'] = $input['Persona_Contacto'];
		$model['Rool_Comunidad'] = $input['Roll_Comunidad'];
		$model['Telefono'] = $input['Telefono'];
		$model['Fecha_Registro'] = date("Y-m-d G:i:s");
		$model['Estado'] = '1';
		$model['Estado_Ejecucion'] = '1';

		$model->save();

		$model_P = new Persona;

		/*$data = json_decode($input['Dato_Actividad']);
		foreach($data as $obj){
			$datosAct[] = new DatosActividad([
				'Id_Eje' => 1,
				'Id_Tematica' => 1,
				'Id_Actividad_ET' => 1
			]);

			//var_dump($obj);
		}
		//var_dump($datosAct);
		$model->datosActividad()->saveMany($datosAct);
		//var_dump($tesmoddt);
		exit();*/


		$data1 = json_decode($input['Personas_Acompanates']);
		foreach($data1 as $obj){
			$model_P->actividadGestor()->attach(27,['persona_id'=>$obj->acompa]);
		}
		

		

		return $model;
	}

	
}
