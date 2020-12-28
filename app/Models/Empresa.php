<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property integer $id
 * @property string $nome
 * @property string $descricao
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $is_active
 * @property PlanosHasEmpresa[] $planosHasEmpresas
 * @property User[] $users
 */
class Empresa extends Model
{
    use Sortable;
    
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['nome', 'descricao', 'created_at', 'updated_at', 'is_active'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planos()
    {
        return $this->belongsToMany(\App\Models\Plano::class, 'planos_has_empresas', 'empresa_id', 'plano_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public function maximoAlunosPlano($empresa_id, $plano_id, $curso_id){
        $empresa = \App\Models\Empresa::find(intval($empresa_id));
        $plano = $empresa->planos()->find($plano_id);
        $plano_cursos = $plano->cursos()->find($curso_id)->pivot;
        return $plano_cursos->usuarios;
    }

    public function quantidadeAlunosMatriculados($empresa_id, $plano_id, $curso_id){
        $quantidadeAlunosMatriculados = \App\Models\Matricula::where('empresa_id', '=', $empresa_id)
            ->where('plano_id', '=', $plano_id)
            ->where('curso_id', '=', $curso_id)
            ->count();
        return $quantidadeAlunosMatriculados;
    }
    
    public function atingiuMaximoContratado($empresa_id, $plano_id, $curso_id){
        return $this->quantidadeAlunosMatriculados($empresa_id, $plano_id, $curso_id) >= $this->maximoAlunosPlano($empresa_id, $plano_id, $curso_id);
    }
}
