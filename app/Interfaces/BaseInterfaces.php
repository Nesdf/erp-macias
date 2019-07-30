<?php

    namespace App\Interfaces;

    use Illuminate\Http\Request;;

    interface BaseInterfaces {

        //Permite consultar la lista completa de valores
        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index();
        //Permite crear una fila 
        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create(Request $request);
        //Permite actualizar una fila
        /**
         * Update the specified resource in storage.
         * @param  Request $request
         * @return Response
         */
        public function update(Request $request);

    }
