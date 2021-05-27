<?php

namespace App\Http\Controllers;

use App\Models\Comanda_Linia;
use Illuminate\Support\Facades\Auth;
use App\Models\Comanda;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer;

class ComandaController extends Controller
{
    /**
     * Retorna la vista comandes amb les comandes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::user()->esAdmin == 1) {
            $comandas = Comanda::where("estat", 0)->orwhere("estat", 1)->get();
        } else {
            $comandas = Comanda::where("user_id", Auth::id())->where("estat", 0)->orwhere("estat", 1)->get();
        }

        return view('comandas.index', ["comandas" => $comandas]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Mostra una comanda.
     *
     * @param  \App\Models\Comanda  $comanda
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user_id = Auth::id();
        
        $linies_cistella = Comanda_Linia::where("comanda_id", $id)->get();
        // dd($linies_cistella[0]->comanda->user_id);
         if($linies_cistella[0]->comanda->user_id==$user_id||$user_id==1){

        
        $products_line = [];
        $class = [];
        $totals = array();
        $total_qty = 0;
        $total_preu = 0;
        for ($i = 0; $i < count($linies_cistella); $i++) {
            $product = $linies_cistella[$i];

            $products_line[$i]["producte_id"] = $product->producte_id;
            $products_line[$i]["producte_descripcio"] = $product->producte_descripcio;
            $products_line[$i]["producte_nom"] = $product->producte_nom;
            $products_line[$i]["producte_mides"] = $product->producte_mides;
            $products_line[$i]["producte_unidad"] = $product->unitat;
            $products_line[$i]["producte_quantitat"] = $product->quantitat;
            $products_line[$i]["producte_preu"] = number_format($product->producte_preu, 2, ',', '.') . " €";

            $class[$i] = "";
            $total_qty = $total_qty + $product->quantitat;
            $total_preu = $total_preu + $product->producte_preu;
        }
        array_push($totals, $total_qty);
        array_push($totals, number_format($total_preu, 2, ',', '.') . " €");
        return view("comandas.show", ['comanda_id' => $id, 'products_line' => $products_line, 'class' => $class, "totals" => $totals]);
    } 
    else{
        return redirect("/home");
    }
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comanda  $comanda
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Cambia de estat a feta una comanda i envia un correu dient que la comanda esta feta.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comanda  $comanda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $comanda = Comanda::findOrFail($id);
        $comanda->estat = 1;
        $comanda->save();
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
        $mail->Password = getenv("Gmail_password");
        $mail->setFrom("mmoral@cendrassos.net", "Marc Moral");
        $mail->Subject = "Estado del pedido";
        $mail->MsgHTML('<div style="background-color: #EFFEE7;border-radius: 15px;padding: 10px;"><h2 style="text-align:center" >Su pedido con id: ' . $comanda->id . " esta preparado, lo recibira en d'entro de unos dias</h2></div>");
        $mail->addAddress($comanda->user->email, $comanda->user->email);
        $mail->send();
        //    dd(Comanda::with('user')->where("estat",0)->orwhere("estat",1)->get());
        return response()->json($comandas = Comanda::with('user')->where("estat", 0)->orwhere("estat", 1)->get());
    }

    /**
     * Posa una comanda com a entregada.
     *
     * @param  \App\Models\Comanda  $comanda
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $comanda = Comanda::findOrFail($id);
        $comanda->estat = 2;
        $comanda->save();
        $mail = new PHPMailer\PHPMailer(); // create a n

        $mail->SMTPDebug = 0; //Alternative to above constant
        $mail->isSMTP(); // tell to use smtp
        $mail->CharSet = "utf-8"; // set charset to utf8
        $mail->SMTPAuth = true;  // use smpt auth
        $mail->SMTPSecure = "tls"; // or ssl
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587; // most likely something different for you. This is the mailtrap.io port i use for testing. 
        $mail->Username = "mmoral@cendrassos.net";
        $mail->Password = getenv("Gmail_password");
        $mail->setFrom("mmoral@cendrassos.net", "Marc Moral");
        $mail->Subject = "Pedido entregado";
        $mail->MsgHTML('<div style="background-color: #EFFEE7;border-radius: 15px;padding: 10px;"><h2 style="text-align:center" >Su pedido con id: ' . $comanda->id . ' ha sido entregado</h2 ><hr style="display: block;height: 1px;border: 0;border-top: 2px solid #98CB3B;margin: 1em 0;padding: 0;"><p style="text-align:center">Si usted no lo ha recibido, pongase en contacto con nosotros.</div>');
        $mail->addAddress($comanda->user->email, $comanda->user->email);
        $mail->send();
        // $mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";};
        return response()->json($comandas = Comanda::with('user')->where("estat", 0)->orwhere("estat", 1)->get());
    }

    /**
     * Mostra les comandes entregadas
     *
     * @return void
     */
    public function entregadas()
    {
        //
        if(Auth::user()->esAdmin == 1){
            $comandas = Comanda::where("estat", 2)->get();

        }
        else{
            $comandas = Comanda::where("estat", 2)->where("user_id",Auth::id())->get();
        }

        return view('comandas.entregadas', ["comandas" => $comandas]);
    }

    /**
     * Posa a no entregada una comanda
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function noentregada(Request $request, $id)
    {
        //
        $comanda = Comanda::findOrFail($id);
        $comanda->estat = 0;
        $comanda->save();
        return response()->json($comandas = Comanda::with('user')->where("estat", 2)->get());
    }
}
