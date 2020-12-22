<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AulaController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:Aluno|Admin');
        $this->middleware('auth');
    } 

    public function valida($curso, $pagina)
    {

        $user = auth()->user();
        $erros = [];

        $matricula = \App\Models\Matricula::where('curso_id' , '=' , $curso->id)->where('user_id' , '=' , $user->id)->first();
        is_object($matricula) ?: $erros["alunoMatriculado"] = "O usuário logado não está matriculado neste curso.";

        $curso->tempoRestanteCurso() >= 0 ?: $erros["cursoNoPrazo"] = "O prazo para realização do curso expirou.";

        $ultimaAulaVisualizada = $curso->ultimaAulaVisualizada();
        ($pagina) <= ($ultimaAulaVisualizada->ordem + 1) ?: $erros["aulaCorreta"] = "Você ainda não pode visualizar esta aula. Por favor, volte e siga a sequência correta.";

        return count($erros) > 0 ? $erros : false;
    }

    public function index($curso)
    {
        $aulas = [];
        $curso = \App\Models\Curso::find($curso);

        $erros = $this->valida($curso, request()->input('page', 1));

        if($erros) return view('aula.index',compact('aulas', 'curso'))->withErrors($erros);

        $user = auth()->user();
        
        $aulas = \App\Models\Aula::join('modulos', 'modulos.id', '=', 'aulas.modulo_id')
            ->where('modulos.curso_id', '=', $curso->id)
            ->where('aulas.is_active', '=', 1)
            ->orderBy('aulas.ordem', 'asc')
            ->with('modulo')
            ->with('materiais')
            ->select('aulas.modulo_id', 'aulas.id', 'aulas.titulo', 'aulas.descricao', 'aulas.carga_horaria', 'aulas.link', 'aulas.ordem')
            ->simplePaginate(1); 
//dd($aulas->items()[0]);
        $visualizacao = \App\Models\Visualizacao::create([
            'aula_id' => $aulas[0]->id,
            'user_id' => $user->id,
        ]);

        return view('aula.index',compact('aulas', 'curso'))
            ->with('i', (request()->input('page', 1) - 1) * 2);
    }


}
