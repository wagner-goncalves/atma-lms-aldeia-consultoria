<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Questionario;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use JsValidator;
use Illuminate\Support\Facades\Storage;

class QuestionarioController extends Controller
{

    use \App\Traits\HandleSqlError;

    protected $validationRules = [
        'nome' => 'required',
        'curso_id' => 'required|integer'
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
            $questionarios = "";

            $questionarios = Questionario::sortable()
                    ->join("cursos", "cursos.id", "=", "questionarios.curso_id")
                    ->orderBy('id', 'desc')
                    ->select("questionarios.*", "cursos.nome as curso_nome");

            if(intval($curso_id) > 0) $questionarios->where('questionarios.curso_id', '=', $curso_id);
    
            if (!empty($filter)) {
                $questionarios = $questionarios
                ->where(function($query) use ($filter) {
                    $query->where('questionarios.nome', 'like', '%'.$filter.'%')
                    ->orWhere('cursos.nome', 'like', '%'.$filter.'%');
                })
                ->orderBy('id', 'desc')->paginate(10);
            } else {
                $questionarios = $questionarios->paginate(10);
            }

            //Filtros
            $cursos = \App\Models\Curso::all()->sortBy("nome");            
    
            return view('questionarios.index',compact('questionarios', 'cursos', 'curso_id', 'filter'))
                ->with('i', (request()->input('page', 1) - 1) * 10);            
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $validator = JsValidator::make($this->validationRules);

        $cursos = \App\Models\Curso::all()->sortBy("nome");

        $questionario = new Questionario();
        return view('questionarios.edit', compact('questionario', 'cursos'))->with([
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
        
        $user = Questionario::create($requestData);

        return redirect()->route('questionarios.index')
                        ->with('success','Questionário criado com sucesso.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $questionario = Questionario::find($id);
        return view('questionarios.show',compact('questionario'));
    }

  
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $validator = JsValidator::make($this->validationRules);

        $cursos = \App\Models\Curso::all()
            ->sortBy("nome");

        $questionario = Questionario::find($id);
        return view('questionarios.edit', compact('questionario', 'cursos'))->with([
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

        $questionario = Questionario::find($id);
        $requestData = $request->all();

        if(isset($requestData->arquivo)){
            $caminho = $request->file('arquivo')->store('questionarios');
            $requestData["arquivo"] = $caminho;
        }else{
            $requestData["arquivo"] = $questionario->arquivo;
        }

        $questionario->update($requestData);

        return redirect()->route('questionarios.index')
                        ->with('success','Questionário alterado com sucesso.');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $questionario = Questionario::find($id);

        try{
            $questionario->delete();
        } catch(\Illuminate\Database\QueryException $e) {
            $mensagem = $this->formatSqlError($e->getPrevious()->getErrorCode(), $e->getMessage());
            return redirect()->route('questionarios.index')->with('error', sprintf('Não foi possível excluir o registro. <br />%s', $mensagem));
        }
        
        return redirect()->route('questionarios.index')
                        ->with('success','Questionário excluído com sucesso.');
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