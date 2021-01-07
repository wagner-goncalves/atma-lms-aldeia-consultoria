<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property integer $id
 * @property integer $curso_id
 * @property string $nome
 * @property Curso $curso
 * @property Pergunta[] $perguntas
 */
class Questionario extends Model
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
    protected $fillable = ['curso_id', 'nome'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function curso()
    {
        return $this->belongsTo('App\Models\Curso', 'curso_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function perguntas()
    {
        return $this->hasMany('App\Models\Pergunta');
    }


}
