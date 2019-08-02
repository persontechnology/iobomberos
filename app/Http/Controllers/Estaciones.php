<?php

namespace iobom\Http\Controllers;

use Illuminate\Http\Request;
use iobom\Models\Estacion;
use iobom\DataTables\EstacionDataTable;

class Estaciones extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

	public function index(EstacionDataTable $dataTable)
	{
		return  $dataTable->render('estaciones.index');
	 	
	}
}
