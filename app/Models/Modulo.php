<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

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
    protected $fillable = ['curso_id', 'nome', 'descricao', 'ordem', 'modulo_padrao'];

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
        return $this->hasMany('App\Models\Aula', 'modulo_id')->orderBy('ordem');
    }

    public function materiais()
    {
        return $this->hasMany('App\Models\Material', 'modulo_id');
    }    

    public function cargaHoraria(){
        $carga = \App\Models\Aula::where('modulo_id', '=', $this->id)
        ->sum('carga_horaria');

        $carga = round($carga / 60, 2);

        return $carga;
    }
}
