<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer;

class UserController extends Controller
{
    /**
     * Retorna la vista amb els usuaris.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usuaris = User::all();
        return view('usuarios.index', ["usuarios" => $usuaris]);
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
     * Crea un nou usuari.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $usuari = User::where('email', $request['email'])->count();
        if ($usuari == 0) {
            if ($request['password'] == $request['passwordconfirm']) {


                User::create([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                ]);

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
                $mail->Password =  getenv("Gmail_password");
                $mail->setFrom("mmoral@cendrassos.net", "Marc Moral");
                $mail->Subject = "Datos de accesso";
                $mail->MsgHTML(
                    '<div style="background-color: #EFFEE7;border-radius: 15px;padding: 10px;"><h2 style="text-align:center" >Banyantree Services le envia sus datos de accesso:</h2><hr style="display: block;height: 1px;border: 0;border-top: 2px solid #98CB3B;margin: 1em 0;padding: 0;"><p style="text-align:center">Usuario: <b>' . $request['email'] . '</b></p><p style="text-align:center">Contrseña: <b>' . $request['password'] . '</b></p> </div>'
                );
                $mail->addAddress($request['email'], $request['email']);
                $mail->send();
                return response()->json($usuarios = User::all());
            } else {
                return response()->json("error2");
            }
        } else {
            return response()->json("error1");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Elimina un usuari.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $usuari = User::findOrFail($id);
        $usuari->delete();
        return response()->json($usuarios = User::all());
    }
}
