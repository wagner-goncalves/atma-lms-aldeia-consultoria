<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $curso_id
 * @property string $created_at
 * @property boolean $is_active
 * @property int $tempo_acesso
 * @property string $data_limite
 * @property Curso $curso
 * @property User $user
 */
class Matricula extends Model
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
    protected $fillable = ['user_id', 'curso_id', 'empresa_id', 'plano_id', 'created_at', 'is_active', 'tempo_acesso', 'data_limite', 'data_conclusao'];

    protected $casts = [
        'data_limite'  => 'datetime:d/m/Y',
    ];    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function curso()
    {
        return $this->belongsTo('App\Models\Curso');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }
    
    public function plano()
    {
        return $this->belongsTo('App\Models\Plano');
    }    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }   

    public function alunoMatriculado(){
        $user = auth()->user();
        $matricula = $this->where('curso_id', '=', $this->curso_id)
        ->where('user_id', '=', $user->id)->first();
        return $matricula ? $matricula : false;
    }

}
