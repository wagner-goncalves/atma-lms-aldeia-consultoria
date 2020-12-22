<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property integer $id
 * @property integer $modulos_id
 * @property string $titulo
 * @property string $descricao
 * @property int $carga_horaria
 * @property string $link
 * @property boolean $ordem
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $is_active
 * @property Modulo $modulo
 * @property Materiai[] $materiais
 * @property Post[] $posts
 * @property Visualizaco[] $visualizacoes
 */
class Aula extends Model
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
    protected $fillable = ['modulo_id', 'titulo', 'descricao', 'carga_horaria', 'link', 'ordem', 'created_at', 'updated_at', 'is_active'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modulo()
    {
        return $this->belongsTo('App\Models\Modulo', 'modulo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materiais()
    {
        return $this->hasMany('App\Models\Material');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visualizacoes()
    {
        return $this->hasMany('App\Models\Visualizaco');
    }
    
}
