<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $aula_id
 * @property string $titulo
 * @property string $descricao
 * @property string $arquivo
 * @property string $link
 * @property int $ordem
 * @property boolean $is_active
 * @property Aula $aula
 * @property Acesso[] $acessos
 */
class Material extends Model
{

    protected $table = 'materiais';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['aula_id', 'titulo', 'descricao', 'arquivo', 'link', 'ordem', 'is_active'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aula()
    {
        return $this->belongsTo('App\Models\Aula');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function acessos()
    {
        return $this->hasMany('App\Models\Acesso', 'material_id');
    }
}
