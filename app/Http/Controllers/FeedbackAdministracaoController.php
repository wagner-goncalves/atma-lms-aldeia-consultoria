<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MatriculaParser;
use App\Models\Matricula;
use App\Models\Empresa;
use App\Models\Feedback;
use App\Exports\FeedbackExport;
use App\Models\Curso;
use App\Notifications\AlunoCadastrado;
use Hash;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use JsValidator;
use Illuminate\Validation\Rule;
use App\Exports\PerformanceExport;
use Maatwebsite\Excel\Facades\Excel;

class FeedbackAdministracaoController extends Controller
{

    protected $validationRules = [
        'user_id' => 'required|integer',
        'curso_id' => 'required|integer',
        'empresa_id' => 'required|integer',
        'plano_id' => 'required|integer',
        'tempo_acesso' => 'required|integer',
        'data_limite' => 'required|regex:/\d{2}\/\d{2}\/\d{4}/',
        'cpf' => 'required|unique:users,cpf|regex:/(^\d{3}\x2E\d{3}\x2E\d{3}\x2D\d{2}$)/',
        'email' => 'required|email|unique:users,email',
        'name' => 'required',
        //'password' => 'required|same:confirm-password',
        'tempo_acesso' => 'required|integer',
        //'data_conclusao' => 'required',
    ];

    public function __construct()
    {
        $this->middleware('role:Admin|Gestor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $requestData = $request->all();

        $filter = $request->query('filter');
        $empresa_id = $request->query('empresa_id');
        $plano_id = $request->query('plano_id');
        $curso_id = $request->query('curso_id');
        $user_id = $request->query('user_id');
        $matriculas = "";    

        $feedbacks = Feedback::sortable()
            ->join("users", "users.id", "=", "feedbacks.user_id")
            ->join("cursos", "cursos.id", "=", "feedbacks.curso_id")
            ->join("respostas", "respostas.id", "=", "feedbacks.resposta_id")
            ->join("perguntas", "perguntas.id", "=", "feedbacks.pergunta_id")
            ->join("questionarios", "questionarios.id", "=", "perguntas.questionario_id")
            ->leftJoin("planos_has_cursos", "planos_has_cursos.curso_id", "=", "cursos.id")
            ->leftJoin("planos", "planos.id", "=", "planos_has_cursos.plano_id")
            ->leftJoin("planos_has_empresas", "planos_has_empresas.plano_id", "=", "planos.id")
            ->leftJoin("empresas", "empresas.id", "=", "planos_has_empresas.empresa_id")
            ->orderBy("users.name", "asc")
            ->orderBy("questionarios.nome", "asc")
            ->orderBy("perguntas.ordem", "asc")
            ->selectRaw("DISTINCT perguntas.questionario_id, perguntas.ordem, respostas.pergunta_id, respostas.ordem, cursos.nome as 'curso', users.name AS 'aluno', users.cpf, users.email, questionarios.nome AS 'questionario', CONCAT(perguntas.ordem, ' - ', perguntas.pergunta) AS pergunta, CONCAT(respostas.ordem, ' - ', respostas.resposta) AS 'resposta'")
            ;

        if(intval($empresa_id) > 0) $feedbacks->where('empresas.id', '=', intval($empresa_id));
        if(intval($plano_id) > 0) $feedbacks->where('planos.id', '=', intval($plano_id));
        if(intval($user_id) > 0) $feedbacks->where('users.id', '=', intval($user_id));
        if (!$user->hasRole('Admin') && $user->hasRole('Gestor')) $feedbacks->where('empresas.id', '=', $user->empresa_id);

        $feedbacks = $feedbacks->paginate(10);


        //Filtros
        $empresas = $this->empresasUsuario();
        $planos = intval($empresa_id) > 0 ? \App\Models\Empresa::find($empresa_id)->planos()->get() : [];
        $cursos = intval($plano_id) > 0 ? \App\Models\Plano::find($plano_id)->cursos()->get() : [];
        $users = intval($curso_id) > 0 ? \App\Models\User::join("matriculas", "matriculas.user_id", "=", "users.id")
        ->where("matriculas.curso_id", "=", $curso_id)
        ->where("matriculas.empresa_id", "=", $empresa_id)
        ->get() : [];

        return view('feedbacks.index', compact('feedbacks', 'cursos', 'curso_id', 'planos', 'plano_id', 'empresas', 'empresa_id', 'users', 'user_id'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    private function empresasUsuario(){
        $user = auth()->user();
        if($user->hasRole('Admin')) return \App\Models\Empresa::all()->sortBy("nome");
        elseif($user->hasRole('Gestor')){
            return \App\Models\Empresa::where("id", "=", $user->empresa_id)->get();
        }
    }

    public function alunos(Request $request)
    {
        $plano_id = $request->input('depdrop_all_params.plano_id');
        $empresa_id = $request->input('depdrop_all_params.empresa_id');
        $curso_id = $request->input('depdrop_all_params.curso_id');

        $users = \App\Models\User::join('matriculas', 'matriculas.user_id', '=', 'users.id')
            ->where('matriculas.curso_id', '=', $curso_id)
            ->where('matriculas.empresa_id', '=', $empresa_id)
            ->where('matriculas.plano_id', '=', $plano_id)
            ->orderBy('users.name')
            ->select("users.id", DB::raw('users.name'))
            ->get(['id', 'name']);

            $retorno["output"] = $users->toArray();
            $retorno["selected"] = "";
    
            return response()->json($retorno);
    }

    public function exportar(Request $request) 
    {
        $requestData = $request->all();
        $fileName = sprintf("Feedback %s.xlsx", date("d-m-Y"));
        return (new FeedbackExport)->filtro($requestData["empresa_id"], $requestData["plano_id"], $requestData["curso_id"], $requestData["user_id"])->download($fileName);
    }

}
