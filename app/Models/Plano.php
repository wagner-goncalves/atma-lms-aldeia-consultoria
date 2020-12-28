<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


/**
 * @property integer $id
 * @property string $nome
 * @property string $descricao
 * @property float $valor
 * @property boolean $is_active
 * @property PlanosHasCurso[] $planosHasCursos
 * @property PlanosHasEmpresa[] $planosHasEmpresas
 */
class Plano extends Model
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
    protected $fillable = ['nome', 'descricao', 'valor', 'is_active'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planosHasCursos()
    {
        return $this->hasMany('App\Models\PlanosHasCurso');
    }

    public function cursos()
    {
        return $this->belongsToMany(\App\Models\Curso::class, 'planos_has_cursos', 'plano_id', 'curso_id')->withPivot('usuarios', 'tempo_acesso');
    } 
    
    public function empresas()
    {
        return $this->belongsToMany(\App\Models\Empresa::class, 'planos_has_empresas', 'plano_id', 'empresa_id');
    }     

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planosHasEmpresas()
    {
        return $this->hasMany('App\Models\PlanosHasEmpresa');
    }
}
