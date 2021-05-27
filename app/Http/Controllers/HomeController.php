<?php

namespace App\Http\Controllers;

use App\Models\Producte;
use PHPMailer\PHPMailer;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*  public function __construct()
    {
        $this->middleware('auth');
    } */

    /**
     * Retorna la vista home amb 6 peoductes actius.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $productes = Producte::where('eliminat', 0)->take(6)->get();
        return view('home', ["productes" => $productes, "cont" => 0]);
    }

    /**
     * Funcio per enviar un correu solicitant acces a la pagina web
     *
     * @param Request $request
     * @return void
     */
    public function solicitar(Request $request)
    {

        $text = '<div style="background-color: #EFFEE7;border-radius: 15px;padding: 10px;"><h2 style="text-align:center" >' . $request->nom . ' ha solicitado accesso a Banyantree Service, sus datos son: </h2><hr style="display: block;height: 1px;border: 0;border-top: 2px solid #98CB3B;margin: 1em 0;padding: 0;"><p style="text-align:center"><b>Email: </b>' . $request->email . '</p> <p style="text-align:center"><b>Telefono: </b>' . $request->telefon . "</p>";
        if ($request->mensaje != "") {
            $text = $text . '<p style="text-align:center"><b>Mensaje: </b>' . $request->mensaje . "</p>";
        }
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
        $mail->Subject = "Solicitud de accesso";
        $mail->MsgHTML($text);

        $mail->addAddress("mmoral@cendrassos.net", "mmoral@cendrassos.net");
        $mail->send(); 
        // $mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";};


        // die('success');
        return response()->json("correct");
    }
}
