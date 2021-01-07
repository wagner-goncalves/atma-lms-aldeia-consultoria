<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        //Percentual de conclusão do curso

        //Listar cursos do usuário
        $cursos = \App\Models\Curso::join('matriculas', 'matriculas.curso_id', '=', 'cursos.id')
            ->where('matriculas.user_id', '=', $user->id)
            ->orderBy('matriculas.created_at','desc')
            ->with(['modulos'])
            ->get("cursos.*");

            //dd($cursos);

        return view('home', compact('cursos'));


    }

}
