<?php

namespace iobom\Http\Controllers;

use Illuminate\Http\Request;
use iobom\Models\Estacion;

class Estaciones extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

	public function index()
	{
	 	return view('estaciones.index');
	}
}
