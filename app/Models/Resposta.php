<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property integer $id
 * @property integer $pergunta_id
 * @property string $resposta
 * @property Pergunta $pergunta
 * @property Feedback[] $feedbacks
 */
class Resposta extends Model
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
    protected $fillable = ['pergunta_id', 'resposta', 'ordem'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pergunta()
    {
        return $this->belongsTo('App\Models\Pergunta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedbacks()
    {
        return $this->hasMany('App\Models\Feedback', 'resposta_id');
    }
}
