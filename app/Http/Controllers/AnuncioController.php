<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Moneda;
use App\Models\Anuncio;
use App\Models\Categoria;
use App\Models\Condicion;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;
use App\Http\Requests\StoreAnuncioRequest;


class AnuncioController extends Controller
{

  public function __invoke()
  {
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $anuncios = Anuncio::all();
    return view('anuncios.index', compact('anuncios'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //$categorias = Categoria::all();
    //$categorias = Categoria::pluck('descripcion','id'); esto reconoce laravel colective

    /* $categorias = [
      "1" => "Vehículo",
      "2" => "Inmueble",
    ]; */

    /* $etiquetas = [
      "1" => "En promocion",
      "2" => "Negociable",
      "3" => "Nuevo",
      "4" => "Remato",
      "5" => "En Oferta",
      "6" => "Ocasión",
      "7" => "Liquidación",
      "8" => "Últimas Unidades",
    ]; */

    $categorias = Categoria::all();
    $monedas = Moneda::all();
    $condiciones = Condicion::all();
    //$estados = Estado::all();



    return view('anuncios.create', compact('categorias', 'monedas', 'condiciones'/* , 'estados' */));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {

    $anuncio = new Anuncio();
    $anuncio->titulo = $request->titulo;
    $anuncio->descripcion = $request->descripcion;
    $anuncio->precio = $request->precio;
    $anuncio->fecha_publicacion = Carbon::now();//obtener fecha actual al crear el anuncio
    $anuncio->fecha_expiracion = Carbon::now();//obtener fecha actual al crear el anuncio + los dias de duracion del anuncio
    $anuncio->visitas = 0;
    $anuncio->condicion_id = $request->condicion_id;
    $anuncio->categoria_id = $request->categoria_id;
    $anuncio->estado_id = 2;  //por defecto el anuncio estara en estado disponible o no vendido
    $anuncio->moneda_id = $request->moneda_id;
    $anuncio->user_id = auth()->user()->id;//id de usuario autentificado actual
    $anuncio->save();

    return redirect()->route('anuncios.index');
    //return redirect()->route('anuncios.show', $anuncio); para previsualizar el anuncio luego de que se haya creado
  }

  /**
   * Display the specified resource.
   */
  public function show(Anuncio $anuncio)
  {
    return view('anuncios.show', compact('anuncio'));
  }


  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Anuncio $anuncio)
  {
    return view('anuncios.edit', compact('anuncio'));
  }


  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Anuncio  $anuncio)
  {
    /* 
    $this->validate($request, [
      'name' => 'required',
      'email' => 'required|email|unique:users,email,' . $id,
      'password' => 'same:confirm-password',
    ]); */
    /* 
    $input = $request->all();
    if (!empty($input['password'])) {
      $input['password'] = Hash::make($input['password']);
    } else {
      $input = Arr::except($input, array('password'));
    } */

    $anuncio = Anuncio::find($anuncio->id);
    $anuncio->update($request->all());

    return redirect()->route('anuncios.index');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Anuncio $anuncio)
  {
    //
    $user = Anuncio::find($anuncio);

    date_default_timezone_set("America/La_Paz");
    //activity()->useLog('Usuarios')->log('Eliminó')->subject();
    /* $lastActivity = Activity::all()->last();
    $lastActivity->subject_id = auth()->user()->id;
    $lastActivity->save(); */

    $anuncio->delete();

    return redirect()->route('anuncios.index');
  }
}
