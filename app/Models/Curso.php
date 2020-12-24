<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $id
 * @property string $nome
 * @property string $descricao
 * @property string $certificado
 * @property boolean $is_active
 * @property Feedback[] $feedbacks
 * @property Matricula[] $matriculas
 * @property Modulo[] $modulos
 * @property Plano[] $planos
 */
class Curso extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['nome', 'descricao', 'certificado', 'base_certificado', 'is_active'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedbacks()
    {
        return $this->hasMany('App\Models\Feedback', 'curso_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matriculas()
    {
        return $this->hasMany('App\Models\Matricula');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modulos()
    {
        return $this->hasMany('App\Models\Modulo')->orderBy('ordem');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planos()
    {
        return $this->belongsToMany(\App\Models\Plano::class, 'planos_has_cursos', 'curso_id', 'plano_id')->withPivot('usuarios', 'tempo_acesso');;
    }


    public function cargaHoraria(){
        $carga = \App\Models\Aula::join("modulos", "aulas.modulo_id", "=", "modulos.id")
        ->where('modulos.curso_id', '=', $this->id)
        ->sum('aulas.carga_horaria');
        return $carga;
    }    

    public function tempoRestanteCurso(){
        $user = auth()->user();

        $matricula = \App\Models\Matricula::where('user_id', '=', $user->id)
            ->where('curso_id', '=', $this->id)->first();
        
        $dataFim = new \DateTime($matricula->data_limite);
        $dataAtual = new \DateTime();
        $intervalo = $dataAtual->diff($dataFim);
        return intval($intervalo->format('%R%a'));
    }    

    public function infoConclusao(){
        $user = auth()->user();
        $sql = "SELECT * FROM (
            SELECT COUNT(DISTINCT (v.aula_id)) AS visualizadas FROM visualizacoes v
            INNER JOIN aulas a ON a.id = v.aula_id
            INNER JOIN modulos m ON m.id = a.modulo_id
            WHERE m.curso_id = " . $this->id . " AND v.user_id = " . $user->id . " 
        ) AS visualizadas,(
        SELECT COUNT(a.id) AS total FROM aulas a
        INNER JOIN modulos m ON m.id = a.modulo_id
        WHERE m.curso_id = " . $this->id . ") AS total";

        return DB::select($sql)[0];
    }     
    
    public function percentualConclusao(){
        $info = $this->infoConclusao();
        $percentual = $info->visualizadas / $info->total * 100;
        return ceil($percentual);
    }

    public function ultimaAulaVisualizada(){
        $user = auth()->user();
        $aula = \App\Models\Aula::join('visualizacoes', 'visualizacoes.aula_id', '=', 'aulas.id')
        ->join('modulos', 'modulos.id', '=', 'aulas.modulo_id')
        ->where('modulos.curso_id', '=', $this->id)
        ->where('visualizacoes.user_id', '=', $user->id)
        ->select('aulas.ordem')
        ->orderBy('aulas.ordem','desc')
        ->first();
        return $aula;
    }

    public function matricula()
    {
        $user = auth()->user();
        $matricula = \App\Models\Matricula::where('curso_id', '=', $this->id)
        ->where('user_id', '=', $user->id)->first();
        return $matricula;
    }

    public function feedbackRespondido($curso_id = ""){
        $user = auth()->user();
        $feedbacks = \App\Models\Questionario::join('perguntas', 'perguntas.questionario_id', '=', 'questionarios.id')
            ->join('respostas', 'perguntas.id', '=', 'respostas.pergunta_id')
            ->join('feedbacks', 'respostas.id', '=', 'feedbacks.resposta_id')
            ->where('questionarios.curso_id', '=', $curso_id)
            ->where('feedbacks.user_id', '=', $this->id)
            ->select('feedbacks.*')
            ->get();

        return count($feedbacks) > 0;
    }    

    public function concluirCurso($curso_id){
        $user = auth()->user();
        $matricula = \App\Models\Matricula::where("user_id", "=" , $user->id)
            ->where("curso_id", "=" , $curso_id)->first();   
  
        $matricula->data_conclusao = now();
        $matricula->save();
    }


}
