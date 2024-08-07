<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use App\Models\Etiqueta;
use App\Models\Servicios;
use Illuminate\Http\Request;
/* use Illuminate\Support\Carbon; */
use Carbon\Carbon;
use App\Models\AnuncioEtiqueta;
use App\Models\ContenidoPromocional;
use App\Models\Membresia;
use Illuminate\Support\Facades\Auth;

class PersonalizarAnuncioController extends Controller
{
    // implementacion de destaque(descuento, posicionamiento, etiqueta) al anuncio

    public function index()
    {

        return view('anuncios.create_contenido_promocional', compact('etiquetas'));
    }

    public function store(Request $request)
    {
        date_default_timezone_set("America/La_Paz");
        /*  $request->validate([
      'titulo' => 'required',
      'descripcion' => 'required',
      'imagen' => 'required',
      'etiquetas' => 'required',
    ]); */

        $etiquetas = $request->etiquetas;


        /* $etiquetas = implode(",", $etiquetas); */ //convertir array en string, separado por comas, para guardar en la base de datos, si no se hace esto, se guarda como array

        $anuncio = Anuncio::findOrFail($request->id_anuncio);
        $anuncio->etiquetas()->sync($etiquetas/* , false */); //en false, no se borran las etiquetas anteriores, solo se agregan las nuevas //en true, se borran las etiquetas anteriores y se agregan las nuevas
        /* return $etiquetas; */

        /* --------------- para agregar el servicio a la tabla intermedia anuncio_servicio(incompleto) -------------- */
        $numero_dias = 0;
        if ($request->oferta1 !== null) {
            if ($request->oferta1 == 1) {
                $numero_dias = 7;
            } elseif ($request->oferta1 == 2) {
                $numero_dias = 14;
            } elseif ($request->oferta1 == 3) {
                $numero_dias = 21;
            } elseif ($request->oferta1 == 4) {
                $numero_dias = 30;
            }


            $anuncio->posicion_principal = 1;
            $anuncio->save();

            $servicio = Servicios::find(1);

            $anuncio->servicios()->attach($servicio, [
                'fecha_inicio' => Carbon::now(),
                'fecha_fin' => Carbon::now()->addDays($numero_dias),
            ]);

            /* $anuncio->servicios()->sync(1, false);
      $fecha_inicio_servicio = Carbon::now();
      $fecha_fin_servicio = Carbon::now(); */
        }

        $numero_dias = 0;
        if ($request->oferta2 !== null) {
            if ($request->oferta2 == 1) {
                $numero_dias = 7;
            } elseif ($request->oferta2 == 2) {
                $numero_dias = 14;
            } elseif ($request->oferta2 == 3) {
                $numero_dias = 21;
            } elseif ($request->oferta2 == 4) {
                $numero_dias = 30;
            }

            /* $anuncio->descuento = $anuncio->precio - ($anuncio->precio * ($request->descuento / 100)); */
            $anuncio->descuento = $request->descuento;
            $anuncio->save();
            $servicio = Servicios::find(2);

            $anuncio->servicios()->attach($servicio, [
                'fecha_inicio' => Carbon::now(),
                'fecha_fin' => Carbon::now()->addDays($numero_dias),
            ]);
        }




        /* $fecha_inicio_servicio = Carbon::now();
    $fecha_fin_servicio = Carbon::now();
 */
        //resolver: como guardar en la base de datos la fecha de inicio y la fecha de fin del servicio y el id del anuncio y el id del servicio en la tabla intermedia anuncio_servicio 🤔

        /* $anuncio->servicios()->attach($request->numero_semanas, ['fecha_inicio' => $request->fecha_inicio, 'fecha_fin' => $request->fecha_fin]); */
        /* $anuncio->servicios()->attach(['fecha_inicio' => $fecha_inicio_servicio, 'fecha_fin' => $fecha_fin_servicio->addDays($numero_dias)]); */

        /* --------------- para agregar el servicio a la tabla intermedia anuncio_servicio(incompleto) --------------- */

        return redirect()->route('anuncios.index');
        /* ->with('success', 'Contenido promocional creado exitosamente.'); */
    }

    public function show(Anuncio $anuncio)
    {
        $user = Auth::user();
        $membresia = $user->membresia;

        date_default_timezone_set("America/La_Paz");
        $etiquetas = Etiqueta::all();
        $servicios = Servicios::all();

        /* $fecha_actual = Carbon::now(); */
        $fecha_actual = Carbon::now()->format('d/m/Y');
        return view('anuncios.contenido_promocional_show', compact('anuncio', 'etiquetas', 'servicios', 'fecha_actual'));
    }
}
