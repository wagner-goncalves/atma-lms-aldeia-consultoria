<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use JsValidator;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{

    use \App\Traits\HandleSqlError;

    protected $validationRules = [
        'nome' => 'required',
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
            $plano_id = $request->query('plano_id');
            $empresas = "";

            $empresas = Empresa::sortable()
                ->join("planos_has_empresas", "empresas.id", "=", "planos_has_empresas.empresa_id")
                ->join("planos", "planos_has_empresas.plano_id", "=", "planos.id")
                ->orderBy('empresas.id', 'desc')
                ->select("empresas.*")
                ->distinct();

            if(intval($plano_id) > 0) $empresas->where('planos.id', '=', $plano_id);
    
            if (!empty($filter)) {
                $empresas = $empresas
                ->where(function($query) use ($filter) {
                    $query->where('empresas.nome', 'like', '%'.$filter.'%')
                    ->orWhere('planos.nome', 'like', '%'.$filter.'%');
                })
                ->orderBy('empresas.id', 'desc')->paginate(10);
            } else {
                $empresas = $empresas->paginate(10);
            }

            //Filtros
            $planos = \App\Models\Plano::all()->sortBy("nome");            
    
            return view('empresas.index',compact('empresas', 'planos', 'plano_id', 'filter'))
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

        $planos = \App\Models\Plano::pluck('nome', 'id')->all();
        $empresaPlanos = [];

        $empresa = new Empresa();
        return view('empresas.edit', compact('empresa', 'planos', 'empresaPlanos'))->with([
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
        
        $empresa = Empresa::create($requestData);
        $empresa->planos()->sync($requestData["plano_id"]);

        return redirect()->route('empresas.index')
                        ->with('success','Empresa criada com sucesso.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empresa = Empresa::find($id);
        return view('empresas.show',compact('empresa'));
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

        $empresa = Empresa::find($id);

        $planos = \App\Models\Plano::pluck('nome', 'id')->all();
        $empresaPlanos = $empresa->planos()->pluck('id')->all();       
        
        return view('empresas.edit', compact('empresa', 'planos', 'empresaPlanos'))->with([
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

        $this->validate($request, $this->validationRules);

        $empresa = Empresa::find($id);
        $requestData = $request->all();

        $empresa->update($requestData);
        $empresa->planos()->sync($requestData["plano_id"]);

        return redirect()->route('empresas.index')
                        ->with('success','Empresa alterada com sucesso.');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $empresa = Empresa::find($id);

        try{
            $empresa->delete();
        } catch(\Illuminate\Database\QueryException $e) {
            $mensagem = $this->formatSqlError($e->getPrevious()->getErrorCode(), $e->getMessage());
            return redirect()->route('empresas.index')->with('error', sprintf('Não foi possível excluir o registro. <br />%s', $mensagem));
        }
        
        return redirect()->route('empresas.index')
                        ->with('success','Empresa excluída com sucesso.');
    }

    

}