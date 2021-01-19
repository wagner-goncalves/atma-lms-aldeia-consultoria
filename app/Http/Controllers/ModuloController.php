<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Modulo;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use JsValidator;
use Illuminate\Support\Facades\Storage;

class ModuloController extends Controller
{

    use \App\Traits\HandleSqlError;

    protected $validationRules = [
        'nome' => 'required',
        'curso_id' => 'required|integer',
        'ordem' => 'required',
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
            $modulos = "";

            $modulos = Modulo::sortable()
                    ->join("cursos", "cursos.id", "=", "modulos.curso_id")
                    ->orderBy('id', 'desc')
                    ->select("modulos.*", "cursos.nome as curso_nome");

            if(intval($curso_id) > 0) $aulas->where('modulos.curso_id', '=', $curso_id);
    
            if (!empty($filter)) {
                $modulos = $modulos
                ->where(function($query) use ($filter) {
                    $query->where('modulos.nome', 'like', '%'.$filter.'%')
                    ->orWhere('cursos.nome', 'like', '%'.$filter.'%');
                })
                ->orderBy('id', 'desc')->paginate(10);
            } else {
                $modulos = $modulos->paginate(10);
            }

            //Filtros
            $cursos = \App\Models\Curso::all()->sortBy("nome");            
    
            return view('modulos.index',compact('modulos', 'cursos', 'curso_id', 'filter'))
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

        $modulo = new Modulo();
        $modulo->modulo_padrao = 1;
        return view('modulos.edit', compact('modulo', 'cursos'))->with([
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
        
        $user = Modulo::create($requestData);

        return redirect()->route('modulos.index')
                        ->with('success','Módulo criado com sucesso.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modulo = Modulo::find($id);
        return view('modulos.show',compact('modulo'));
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

        $modulo = Modulo::find($id);
        return view('modulos.edit', compact('modulo', 'cursos'))->with([
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

        $modulo = Modulo::find($id);
        $requestData = $request->all();

        
        $modulo->update($requestData);

        return redirect()->route('modulos.index')
                        ->with('success','Módulo alterado com sucesso.');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $modulo = Modulo::find($id);

        try{
            $modulo->delete();
        } catch(\Illuminate\Database\QueryException $e) {
            $mensagem = $this->formatSqlError($e->getPrevious()->getErrorCode(), $e->getMessage());
            return redirect()->route('modulos.index')->with('error', sprintf('Não foi possível excluir o registro. <br />%s', $mensagem));
        }
        
        return redirect()->route('modulos.index')
                        ->with('success','Módulo excluído com sucesso.');
    }    

    public function download($id){
        $modulo = Modulo::find($id);
        return Storage::download($modulo->arquivo, ($modulo->titulo . "." . pathinfo($modulo->arquivo, PATHINFO_EXTENSION)));
    }

    public function modulos(Request $request){
        $curso_id = $request->input('depdrop_all_params.curso_id');

        $modulos = \App\Models\Modulo::where('curso_id', $curso_id)
            ->select("id", "nome as name")
            ->orderBy("nome")
            ->get(['id', 'name']);

        $retorno["output"] = $modulos->toArray();
        $retorno["selected"] = "";

        return response()->json($retorno);
    }

    public function aulas(Request $request){
        $modulo_id = $request->input('depdrop_all_params.modulo_id');

        $aulas = \App\Models\Aula::where('modulo_id', $modulo_id)
            ->select("id", "titulo as name")
            ->orderBy("titulo")
            ->get(['id', 'name']);

        $retorno["output"] = $aulas->toArray();
        $retorno["selected"] = "";

        return response()->json($retorno);
    }    
}