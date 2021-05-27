<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Producte;
use App\Models\Cistella;
use App\Models\Comanda;
use App\Models\Disponible;
use App\Models\Comanda_Linia;
use Illuminate\Http\Request;

use PHPMailer\PHPMailer;

class CistellaController extends Controller
{
    /**
     * Retorna la vista cistella/index amb les linies de la cistella, els totals, els productes no disponibles i la cistella.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user_id = Auth::id();
        $crearcistella = Cistella::where('user_id', $user_id)->get();
        if (count($crearcistella) == 0) {
            $cistella = new Cistella;
            $cistella->user_id = $user_id;
            $cistella->save();
        }
        $cistella = Cistella::where("user_id", $user_id)->first();
        $linies_cistella = $cistella->liniesCistella;
        $alerts = array();
        $products_line = [];
        $class = [];
        $totals = array();
        $total_qty = 0;
        $total_preu = 0;
        for ($i = 0; $i < count($linies_cistella); $i++) {
            $product = $linies_cistella[$i];
            $preu = $product->preu * $product->pivot->quantitat;

            $products_line[$i]["producte_id"] = $product->id;
            $products_line[$i]["producte_nom"] = $product->nom;
            $products_line[$i]["producte_quantitat"] = $product->pivot->quantitat;
            $products_line[$i]["producte_preu"] = number_format($preu, 2, ',', '.') . " €";

            $class[$i] = "";

            if (!$linies_cistella[$i]->disponible($product->pivot->quantitat)) {
                array_push($alerts, $products_line[$i]["producte_id"]);
            }
            $total_qty = $total_qty + $product->pivot->quantitat;
            $total_preu = $total_preu + $preu;
        }
        array_push($totals, $total_qty);
        array_push($totals, number_format($total_preu, 2, ',', '.') . " €");
        return view("cestas.index", ['cistella' => $cistella, 'alerts' => $alerts, 'products_line' => $products_line, 'class' => $class, "totals" => $totals]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Afegeix un producte a la cistella.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user_id = Auth::id();
        $producte = Producte::findOrFail($request->id);
        $crearcistella = Cistella::where('user_id', $user_id)->get();


        if (count($crearcistella) == 0) {
            $cistella = new Cistella;
            $cistella->user_id = $user_id;
            $cistella->save();
        }
        $cistella = Cistella::where("user_id", $user_id)->first();
        $existeix = $cistella->liniesCistella()->wherePivot('cistella_id', $cistella->id)->wherePivot('producte_id', $request->id)->get();
        if ($request->quantitat > 0) {
            if (count($existeix)) {
                $quantitat = $request->quantitat + $existeix[0]->pivot->quantitat;
                $cistella->liniesCistella()->updateExistingPivot($request->id, ['quantitat' => $quantitat]);
            } else {
                $cistella->liniesCistella()->attach($request->id, ['quantitat' => $request->quantitat]);
            }
        }

        return response()->json($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cistella  $cistella
     * @return \Illuminate\Http\Response
     */
    public function show(Cistella $cistella)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cistella  $cistella
     * @return \Illuminate\Http\Response
     */
    public function edit(Cistella $cistella)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cistella  $cistella
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cistella $cistella)
    {
        //
    }

    /**
     * Elimina un producte de la cistella.
     *
     * @param  \App\Models\Cistella  $cistella
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user_id = Auth::id();
        $producte = Producte::findOrFail($id);
        $cistella = Cistella::where("user_id", $user_id)->first();
        $cistella->liniesCistella()->detach($id);
        return response()->json($id);
    }

    /**
     * Aqui crea una comanda i envia un correu amb la informacio de la comanda
     *
     * @return void
     */
    public function crearComanda()
    {
        $cistella = Cistella::where("user_id", Auth::id())->first();
        $cistella_lines = $cistella->liniesCistella;
        $buit = count($cistella_lines);
        if ($buit > 0) {
            $cont = 0;
            $total_preu = 0;
            for ($i = 0; $i < count($cistella_lines); $i++) {
                $product = $cistella_lines[$i];
                $preu = $product->preu * $product->pivot->quantitat;
                if (!$cistella_lines[$i]->disponible($product->pivot->quantitat)) {

                    $cont++;
                }
                $total_preu = $total_preu + $preu;
            }
        } else {
            //notificacio d'error
            return response()->json("error1");
        }
        $id = 0;
        if ($cont == 0 && $total_preu >= 100) {
            $comanda = new Comanda;
            $id = $comanda->id;
            $comanda->user_id = Auth::id();
            $comanda->save();
            $comanda_id = Comanda::where('user_id', Auth::id())->get()->last();
            foreach ($cistella_lines as $producte) {
                $comanda_linia = new Comanda_Linia;
                $comanda_linia->producte_nom = $producte->nom;
                $comanda_linia->producte_descripcio = $producte->descripcio;
                $comanda_linia->producte_mides = $producte->mides;
                $comanda_linia->producte_preu = $producte->preu * $producte->pivot->quantitat;
                $comanda_linia->quantitat = $producte->pivot->quantitat;
                $comanda_linia->unitat = $producte->unitat;
                $comanda_linia->comanda_id = $comanda_id->id;
                $comanda_linia->producte_id = $producte->id;
                $comanda_linia->save();
                $cistella->liniesCistella()->detach($producte->id);
                $disponible = Disponible::where('producte_id', $producte->id)->first();
                $disponible->quantitat_venuda = $disponible->quantitat_venuda + $producte->pivot->quantitat;
                $disponible->save();
            }
            $linias_comadas = Comanda_Linia::where("comanda_id", $comanda_id->id)->get();
            $totalpreu = 0;
            $totalproductes = 0;
            $table = '<table style="border-collapse: collapse;width:80%;margin-left:10%">
            <thead style="border-bottom:2px solid #98CB3B">
            <tr class="text-center">
                <th style="text-align: center; ">Producto</th>
                <th style="text-align: center; ">Descripcion</th>
                <th style="text-align: center; ">Midas</th>
                <th style="text-align: center; ">Tipo de venta</th>
                <th style="text-align: center; ">Quantitat</th>
                <th style="text-align: center; ">Preu</th>
            </tr>
            </thead>
            <tbody>';
            foreach ($linias_comadas as $linias_comada) {
                $table .= ' <tr class="text-center; ">
            <td style="text-align: center; ">' .
                    $linias_comada->producte_nom .
                    '</td>
           
            <td style="text-align: center; ">' .
                    $linias_comada->producte_descripcio .
                    '</td>
            <td style="text-align: center; ">' .
                    $linias_comada->producte_mides .
                    '</td>
            <td style="text-align: center; ">' .
                    $linias_comada->unitat .
                    '</td>  
            <td style="text-align: center; ">' .
                    $linias_comada->quantitat .
                    '</td>
                <td style="text-align: center; ">' .
                    $linias_comada->producte_preu .
                    ' </td>
        </tr>';
                $totalpreu = $totalpreu + $linias_comada->producte_preu;
                $totalproductes = $totalproductes + $linias_comada->quantitat;
            }
            $table .= '  </tbody>
                        <tfoot style="border-top:2px solid #98CB3B">
                            <tr class="text-center; ">
                                <th style="text-align: center; ">Totales:</th>
                                <th style="text-align: center; "></th>
                                <th style="text-align: center; "></th>
                                <th style="text-align: center; "></th>
                                <th style="text-align: center; ">' . $totalproductes . '</th>
                                <th style="text-align: center; ">' . $totalpreu . '€</th> 
                            </tr>
                        </tfoot>
                    </table>';
            $mail = new PHPMailer\PHPMailer(); // create a n
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->SMTPDebug = 0; //Alternative to above constant
            $mail->isSMTP(); // tell to use smtp
            $mail->CharSet = "utf-8"; // set charset to utf8
            $mail->SMTPAuth = true;  // use smpt auth
            $mail->SMTPSecure = "tls"; // or ssl
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587; // most likely something different for you. This is the mailtrap.io port i use for testing. 
            $mail->Username = "mmoral@cendrassos.net";
            $mail->Password = getenv("Gmail_password");;
            $mail->setFrom("mmoral@cendrassos.net", "Marc Moral");
            $mail->Subject = "Confirmacion de pedido ";
            $mail->MsgHTML('<div style="background-color: #EFFEE7;border-radius: 15px;padding: 10px;"><h2 style="text-align:center">Su pedido con id: ' . $comanda->id . ' ha sido realizado</h2><hr style="display: block;height: 1px;border: 0;border-top: 2px solid #98CB3B;margin: 1em 0;padding: 0;">' . $table . '</div>');
            $mail->addAddress(Auth::user()->email, Auth::user()->email);
            $mail->send();
            // $mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";};


            // die('success');
            return response()->json("/comandas/" . $id,);
        } else {
            //notificacio d'error
            if ($total_preu <= 100) {
                return response()->json("error2");
            } else if ($cont != 0) {
                return response()->json("error3");
            } else {
                return response()->json("error4");
            }
        }
    }
}
