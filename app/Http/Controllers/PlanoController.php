<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Plano;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use JsValidator;
use Illuminate\Support\Facades\Storage;

class PlanoController extends Controller
{

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
            $empresa_id = $request->query('empresa_id');
            $empresas = "";

            $planos = Plano::sortable()
                ->join("planos_has_empresas", "planos.id", "=", "planos_has_empresas.plano_id")
                ->join("empresas", "planos_has_empresas.empresa_id", "=", "empresas.id")
                ->orderBy('planos.id', 'desc')
                ->select("planos.*")
                ->distinct();

            if(intval($empresa_id) > 0) $planos->where('empresas.id', '=', $empresa_id);
    
            if (!empty($filter)) {
                $planos = $planos
                ->where(function($query) use ($filter) {
                    $query->where('planos.nome', 'like', '%'.$filter.'%')
                    ->orWhere('empresas.nome', 'like', '%'.$filter.'%');
                })
                ->orderBy('planos.id', 'desc')->paginate(10);
            } else {
                $planos = $planos->paginate(10);
            }

            //Filtros
            $empresas = \App\Models\Empresa::all()->sortBy("nome");            
    
            return view('planos.index',compact('planos', 'empresas', 'empresa_id', 'filter'))
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

        $empresas = \App\Models\Empresa::pluck('nome', 'id')->all();
        $planoEmpresas = [];

        $plano = new Plano();
        return view('planos.edit', compact('plano', 'empresas', 'planoEmpresas'))->with([
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
        
        $plano = Plano::create($requestData);
        $plano->empresas()->sync($requestData["empresa_id"]);

        return redirect()->route('planos.index')
                        ->with('success','Plano criado com sucesso.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plano = Plano::find($id);
        return view('planos.show',compact('plano'));
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

        $plano = Plano::find($id);

        $empresas = \App\Models\Empresa::pluck('nome', 'id')->all();
        $planoEmpresas = $plano->empresas()->pluck('id')->all();       
        
        return view('planos.edit', compact('plano', 'empresas', 'planoEmpresas'))->with([
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

        $plano = Plano::find($id);
        $requestData = $request->all();

        $plano->update($requestData);
        $plano->empresas()->sync($requestData["empresa_id"]);

        return redirect()->route('planos.index')
                        ->with('success','Plano alterado com sucesso.');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plano = Plano::find($id);

        try{
            $plano->delete();
        } catch(\Illuminate\Database\QueryException $e) {
            return redirect()->route('planos.index')
                        ->with('error', sprintf('Não foi possível excluir o registro. <br /><br />%s', $e->getMessage()));
        }

        
        
        
        return redirect()->route('planos.index')
                        ->with('success','Plano excluído com sucesso.');
    }

}