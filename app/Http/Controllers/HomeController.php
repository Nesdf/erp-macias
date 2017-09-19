<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Alertas;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function sendEmail()
    {
        $enviado = \Mail::to('nes64df@gmail.com')->send( new Alertas() );

        if($enviado){
            $respuesta = "Enviado";
        } else{
            $respuesta = "Fallido";
        }
        return $respuesta;
    }
}
