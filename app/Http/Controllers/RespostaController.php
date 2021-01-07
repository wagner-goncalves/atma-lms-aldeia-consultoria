<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Resposta;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use JsValidator;
use Illuminate\Support\Facades\Storage;

class RespostaController extends Controller
{

    protected $validationRules = [
        'resposta' => 'required',
        'pergunta_id' => 'required',
        //'email' => 'required|email|unique:users,email',
        //'password' => 'required|same:confirm-password',
        'ordem' => 'required|size:1',
    ];

    public function __construct()
    {
        $this->middleware('role:Admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            $filter = $request->query('filter');
            $curso_id = $request->query('curso_id');
            $questionario_id = $request->query('questionario_id');    
            $pergunta_id = $request->query('pergunta_id');            
            $respostas = "";

            $respostas = Resposta::sortable()
                    ->join("perguntas", "perguntas.id", "=", "respostas.pergunta_id")
                    ->join("questionarios", "questionarios.id", "=", "perguntas.questionario_id")
                    ->join("cursos", "cursos.id", "=", "questionarios.curso_id")
                    ->orderBy('id', 'desc')
                    ->select("respostas.*", "cursos.nome as curso_nome");

            if(intval($pergunta_id) > 0) $respostas->where('respostas.pergunta_id', '=', $pergunta_id);
            if(intval($questionario_id) > 0) $respostas->where('perguntas.questionario_id', '=', $questionario_id);
            if(intval($curso_id) > 0) $respostas->where('questionarios.curso_id', '=', $curso_id);                    
    
            if (!empty($filter)) {
                $respostas = $respostas
                ->where(function($query) use ($filter) {
                    $query->where('respostas.resposta', 'like', '%'.$filter.'%')
                    ->orWhere('perguntas.pergunta', 'like', '%'.$filter.'%')
                    ->orWhere('questionarios.nome', 'like', '%'.$filter.'%')
                    ->orWhere('cursos.nome', 'like', '%'.$filter.'%');
                })
                ->orderBy('id', 'desc')->paginate(10);
            } else {
                $respostas = $respostas->paginate(10);
            }

            //Filtros
            $cursos = \App\Models\Curso::all()->sortBy("nome");
            $questionarios = intval($curso_id) > 0 ? \App\Models\Questionario::where("curso_id", "=", $curso_id)->orderBy("nome")->get() : [];
            $perguntas = intval($questionario_id) > 0 ? \App\Models\Pergunta::where("questionario_id", "=", $questionario_id)->orderBy("pergunta")->get() : [];

            return view('respostas.index',compact('respostas', 'cursos', 'curso_id', 'questionarios', 'questionario_id', 'perguntas', 'pergunta_id', 'filter'))
                ->with('i', (request()->input('page', 1) - 1) * 10);            
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        unset($this->validationRules["arquivo"]);
        $validator = JsValidator::make($this->validationRules);

        $cursos = \App\Models\Curso::all()
            ->sortBy("nome");

        $resposta = new Resposta();
        return view('respostas.edit', compact('resposta', 'cursos'))->with([
            'validator' => $validator,
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules);
        $requestData = $request->all();
        
        $user = Resposta::create($requestData);

        return redirect()->route('respostas.index')
                        ->with('success','Resposta criada com sucesso.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resposta = Resposta::find($id);
        return view('respostas.show',compact('resposta'));
    }

  
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        unset($this->validationRules["arquivo"]);
        $validator = JsValidator::make($this->validationRules);

        $cursos = \App\Models\Curso::all()
            ->sortBy("nome");

        $resposta = Resposta::find($id);
        return view('respostas.edit', compact('resposta', 'cursos'))->with([
            'validator' => $validator,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        unset($this->validationRules["arquivo"]);
        $this->validate($request, $this->validationRules);

        $resposta = Resposta::find($id);
        $requestData = $request->all();

        if(isset($requestData->arquivo)){
            $caminho = $request->file('arquivo')->store('respostas');
            $requestData["arquivo"] = $caminho;
        }else{
            $requestData["arquivo"] = $resposta->arquivo;
        }

        $resposta->update($requestData);

        return redirect()->route('respostas.index')
                        ->with('success','Resposta alterada com sucesso.');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resposta = Resposta::find($id);
        Storage::delete($resposta->arquivo);
        $resposta->delete();
        
        return redirect()->route('respostas.index')
                        ->with('success','Resposta excluída com sucesso.');
    }

    public function questionarios(Request $request){
        $curso_id = $request->input('depdrop_all_params.curso_id');

        $questionarios = \App\Models\Questionario::where('curso_id', $curso_id)
            ->select("id", "nome as name")
            ->orderBy("nome")
            ->get(['id', 'name']);

        $retorno["output"] = $questionarios->toArray();
        $retorno["selected"] = "";

        return response()->json($retorno);
    }

    public function perguntas(Request $request){
        $questionario_id = $request->input('depdrop_all_params.questionario_id');

        $perguntas = \App\Models\Pergunta::where('questionario_id', $questionario_id)
            ->select("id", "pergunta as name")
            ->orderBy("pergunta")
            ->get(['id', 'name']);

        $retorno["output"] = $perguntas->toArray();
        $retorno["selected"] = "";

        return response()->json($retorno);
    }    
}