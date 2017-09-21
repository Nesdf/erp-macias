<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Alerts;

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
        
        try{
            $enviado = \Mail::to('ing.nestor.sanz@gmail.com')->send( new Alerts() );
            return $enviado;
        } catch( Exception $ex ){
            dd($ex);
        }
    }
}
