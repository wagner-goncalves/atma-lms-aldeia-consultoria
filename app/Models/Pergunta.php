<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property integer $id
 * @property integer $questionario_id
 * @property string $pergunta
 * @property integer $ordem
 * @property boolean $is_active
 * @property Questionario $questionario
 * @property Resposta[] $respostas
 */
class Pergunta extends Model
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
    protected $fillable = ['questionario_id', 'pergunta', 'ordem', 'is_active'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questionario()
    {
        return $this->belongsTo('App\Models\Questionario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function respostas()
    {
        return $this->hasMany('App\Models\Resposta');
    }
}
