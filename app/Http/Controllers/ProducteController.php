<?php

namespace App\Http\Controllers;

use App\Models\Disponible;
use App\Models\Producte;
use App\Models\Imatge;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProducteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'], ['except' => ['index']]);
    }
    /**
     * Retorna la vista de productes/index amb els productes actius separats per categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $toallas = Producte::where('eliminat', 0)->where("categoria", "Toallas")->get();
        $sabanas = Producte::where('eliminat', 0)->where("categoria", "Sábanas")->get();
        $fundas = Producte::where('eliminat', 0)->where("categoria", "Fundas de nordico")->get();
        $textil = Producte::where('eliminat', 0)->where("categoria", "Textil para la limpieza")->get();
        $imatges = Imatge::whereHas('producte', function ($query) {
            $query->where('eliminat', 0);
        })->get();
        return view("productos.index", ["toallas" => $toallas, "sabanas" => $sabanas, "fundas" => $fundas, "textil" => $textil]);
    }

    /**
     * Envia l'usuari a la vista productes/create.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("productos.create");
    }

    /**
     * Guarda un nou producte.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productes = new Producte;
        $productes->nom = $request['nom'];
        $productes->mides = $request['mides'];
        $productes->descripcio = $request['descripcio'];
        $productes->preu = $request['preu'];
        $productes->unitat = $request['unitat'];
        $productes->categoria = $request['categoria'];
        $productes->save();
        $disponible = new Disponible();
        $disponible->quantitat_total = $request['quantitattotal'];
        $disponible->producte_id = $productes->id;
        $disponible->save();
        return response()->json(['success' => 'Ajax request submitted successfully']);
    }

    /**
     * Mostra un producte.
     *
     * @param  \App\Models\Producte  $producte
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $producte = Producte::find($id);
        return view("productos.show", ["producte" => $producte]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producte  $producte
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Actualitza un producte.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producte  $producte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $producte = Producte::findOrFail($id);
        $producte->nom = $request['nom'];
        $producte->mides = $request['mides'];
        $producte->descripcio = $request['descripcio'];
        $producte->preu = $request['preu'];
        $producte->unitat = $request['unitat'];
        $producte->categoria = $request['categoria'];
        $producte->save();
        $disponible = Disponible::where('producte_id', $id)->first();
        $disponible->quantitat_total = $request['quantitattotal'];
        $disponible->quantitat_venuda = $request['quantitatvenuda'];
        $disponible->save();
        $disponibles = Disponible::whereHas('producte', function ($query) {
            $query->where('eliminat', 0);
        })->with('producte')->get();

        return response()->json(["productes" => $disponibles]);
    }

    /**
     * Posa un producte com a eliminat.
     *
     * @param  \App\Models\Producte  $producte
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productes = Producte::findOrFail($id);
        $productes->eliminat = 1;
        $productes->save();
        $disponibles = Disponible::whereHas('producte', function ($query) {
            $query->where('eliminat', 0);
        })->with('producte')->get();

        return response()->json(["productes" => $disponibles]);
    }

     /**
     * Retorna la vista de productes/admin amb els productes actius.
     *
     * @return \Illuminate\Http\Response
     */
    public function gestioproductes()
    {
        $disponibles = Disponible::all();
        $productes = array();
        foreach ($disponibles as $disponible) {
            if ($disponible->producte->eliminat == 0) {
                array_push($productes, $disponible);
            }
        }

        return view("productos.admin", ["productes" => $productes]);
    }

     /**
     * Retorna la vista de productes/eliminados amb els productes eliminats.
     *
     * @return \Illuminate\Http\Response
     */
    public function eliminados()
    {
        //
        $disponibles = Disponible::whereHas('producte', function ($query) {
            $query->where('eliminat', 1);
        })->with('producte')->get();

        return view("productos.eliminados", ["productes" => $disponibles]);
    }

    /**
     * Torna activar un producte.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producte  $producte
     * @return \Illuminate\Http\Response
     */
    public function volveractivar(Request $request, $id)
    {
        //

        $productes = Producte::findOrFail($id);
        $productes->eliminat = 0;
        $productes->save();
        $disponibles = Disponible::whereHas('producte', function ($query) {
            $query->where('eliminat', 1);
        })->with('producte')->get();

        return response()->json(["productes" => $disponibles]);
    }

     /**
     * Retorna la vista de productes/imatges amb els productes actius i les imatges.
     *
     * @return \Illuminate\Http\Response
     */
    public function imagenes()
    {
        //
        $productes = Producte::where("eliminat", 0)->get();
        $imatges = Imatge::whereHas('producte', function ($query) {
            $query->where('eliminat', 0);
        })->get();
        return view("productos.imatges", ["imatges" => $imatges, "productes" => $productes]);
    }

    /**
     * Guarda una nova imatge.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function imagenescrear(Request $request)
    {
        $filename = "";
        $request->validate([
            'imatge' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        if ($request->file('imatge') != null) {
            $file = $request->file('imatge');
            $destinationPath = 'img/products';
            $originalFile = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move($destinationPath, $filename);
        }

        $path = 'img/products/' . $filename;

        $imatge = new Imatge;
        $imatge->url = $path;
        $imatge->producte_id = $request["producteid"];
        $imatge->save();
        return redirect("/gestionproductos/imagenes");
    }

    /**
     * Eliminar una imatge.
     *
     * @param  \App\Models\Producte  $producte
     * @return \Illuminate\Http\Response
     */
    public function imageneseliminar($id)
    {
        $productes = Imatge::findOrFail($id);
        $productes->delete();
        return redirect("/gestionproductos/imagenes");
    }
}
