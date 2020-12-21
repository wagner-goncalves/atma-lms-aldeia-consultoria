<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $curso_id
 * @property string $nome
 * @property string $descricao
 * @property int $ordem
 * @property Curso $curso
 * @property Aula[] $aulas
 */
class Modulo extends Model
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
    protected $fillable = ['curso_id', 'nome', 'descricao', 'ordem'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function curso()
    {
        return $this->belongsTo('App\Models\Curso');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aulas()
    {
        return $this->hasMany('App\Models\Aula', 'modulo_id');
    }

    public function cargaHoraria(){
        $carga = \App\Models\Aula::where('modulo_id', '=', $this->id)
        ->sum('carga_horaria');
        return $carga;
    }
}
