<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MatriculasImport;
use Illuminate\Support\Facades\DB;
use Hash;

class MatriculaParser
{

    private $erros = [];
    private $alertas = [];
    private $sucessos = [];

    public function sucessos(){
        return $this->sucessos;
    }

    public function erros(){
        return $this->erros;
    }

    public function hasErros(){
        return count($this->erros) > 0;
    }  
    
    public function totalErros(){
        return count($this->erros);
    }      

    public function alertas(){
        return $this->alertas;
    }    

    public function hasAlertas(){
        return count($this->alertas) > 0;
    }   
    
    public function totalAlertas(){
        return count($this->alertas);
    }      
    
    private function validaCabecalhos($excel, $cabecalhosMatricula){
        $valid = true;
        foreach($excel as $headings){
            foreach($headings as $sheets){
                for($i = 0 ; $i < count($cabecalhosMatricula); $i++){
                    if(!in_array($sheets[$i], $cabecalhosMatricula)){
                        $valid = false;
                        break;
                    } 
                }
            }
        }
        return $valid;
    }

    public function parseArquivo($caminho, $cabecalhosMatricula){
        $excelHeadings = (new HeadingRowImport)->toArray($caminho);
        if($this->validaCabecalhos($excelHeadings, $cabecalhosMatricula)){
            return Excel::toArray(new MatriculasImport, $caminho);
        }else{
            return false;
        }
    }        

    public function parseConteudo($excel, $colunas, $curso_id, $empresa_id = 0){

        $linhas = $excel[0];
        $linhasOk = [];
        
        for($i = 0; $i < count($linhas); $i++){
            $parseOk = true; 
            $erro = new \stdClass;
            $alerta = new \stdClass;

            if(strlen($linhas[$i]["cpf"]) > 0 && strlen($linhas[$i]["name"]) > 0 && strlen($linhas[$i]["email"]) > 0){

                $erro->linha = $i+1;
                $alerta->linha = $i+1;

                //Verificar se colunas obrigatórias estão preenchidas corretamente
                foreach($colunas as $coluna){
                    if(trim($linhas[$i][$coluna]) == ""){
                        $parseOk = false;
                        $erro->mensagem = sprintf('A coluna %s possui valor inválido.', $coluna);
                        $this->erros[] = $erro;
                        break;
                    }
                }

                if($parseOk){
                    $user = \App\Models\User::where("cpf", "=", $linhas[$i]["cpf"])
                        ->orWhere("email", "=", $linhas[$i]["email"])->first();

                    //Verificar se email e cpf já existem
                    if(!empty($user)){
                        $alerta->mensagem = sprintf('O e-mail %s (CPF %s) já está cadastrado no banco de dados.', $linhas[$i]["email"], $linhas[$i]["cpf"]);
                        $this->alertas[] = $alerta;                

                        //Verificar se usuário já está matriculado no curso
                        $matricula = \App\Models\Matricula::where("user_id", "=", $user->id)
                            ->where("curso_id", "=", $curso_id);
                        if($empresa_id > 0) $matricula->where("empresa_id", "=", $empresa_id);
                        $matricula = $matricula->first();

                        if(!empty($matricula)){
                            $erro->mensagem = sprintf('O usuário %s (CPF %s) já está matriculado no curso.', $linhas[$i]["email"], $linhas[$i]["cpf"]);
                            $this->erros[] = $erro;
                            $parseOk = false; 
                        }
                    }
                }

                //Remove a linha da planilha para não ser processada
                if($parseOk) $linhasOk[$i] = $linhas[$i];
            }
        }

        return $excel[0] = [$linhasOk];
    }

    public function import($excelValidado, $requestData){
        

        $loggedUser = auth()->user();

        //Valida se já excedeu limite de matrículas
        $empresa = new \App\Models\Empresa();


        foreach($excelValidado[0] as $index => $linha){

            $sucesso = new \stdClass;
            $erro = new \stdClass;

            //Valida se já excedeu limite de matrículas
            $maximoAlunosPlano = $empresa->maximoAlunosPlano($requestData["empresa_id"], $requestData["plano_id"], $requestData["curso_id"]);
            $quantidadeAlunosMatriculados = $empresa->quantidadeAlunosMatriculados($requestData["empresa_id"], $requestData["plano_id"], $requestData["curso_id"]);                
            if($quantidadeAlunosMatriculados == $maximoAlunosPlano){
                $erro->linha = $index + 1;
                $erro->mensagem = sprintf("Usuário %s (CPF %s) não importado. Atingido limite de %s usuários do plano.", $linha["name"], $linha["cpf"], $maximoAlunosPlano);
                $this->erros[] = $erro;
            }else{

                DB::beginTransaction();
                $user = null;
                try{
                    //Validar de CPF já existe, email já existe
                    //Matricular (EMPRESA)
                    //Cria usuário
                    if($linha["cpf"] != "" && $linha["name"] != "" && $linha["email"] != ""){
                        $linha["password"] = Hash::make(substr(str_replace(".", "", $linha["cpf"]), 0, 6));

                        //Somente ADM está liberado para alterar todos as matrículas
                        //Gestor só altera matrículas e usuários da sua empresa
                        if($loggedUser->hasRole('Admin')) $linha["empresa_id"] = $requestData["empresa_id"]; //Administrador pode escolher quaquer empresa
                        else $linha["empresa_id"] =  $loggedUser->empresa_id;

                        $user = \App\Models\User::create($linha);
                        $user->assignRole("Aluno");

                        //Cria matrícula
                        $plano = \App\Models\Plano::find(intval($requestData["plano_id"]));
                        $requestData["user_id"] = $user->id;
                        $requestData["tempo_acesso"] = $plano->cursos()->find($requestData["curso_id"])->pivot->tempo_acesso;
                        $data_conclusao = new \Carbon\Carbon();
                        $requestData["data_limite"] = $data_conclusao->addDays(intval($requestData["tempo_acesso"]))->toDateTimeString();
                        $matricula = \App\Models\Matricula::create($requestData);      
                    }

                    DB::commit();

                    $sucesso->linha = $index + 1;
                    $sucesso->mensagem = sprintf("Usuário %s (CPF %s) matriculado com sucesso! Restam %s usuários em seu plano.", $user->name, $user->cpf, ($maximoAlunosPlano - ($quantidadeAlunosMatriculados + 1)));
                    $this->sucessos[] = $sucesso;

                }catch(\Exception $e){
                    //throw new \Exception($e);
                    DB::rollBack();
                    $erro = new \stdClass;
                    $erro->linha = $index + 1;
                    $erro->exception = $e;
                    $erro->mensagem = sprintf("Não foi possívei importar a linha %s. Mensagem de erro: %s.", $erro->linha, $e->getMessage());
                    $this->erros[] = $erro;
                }
            }
        }
    }


}
