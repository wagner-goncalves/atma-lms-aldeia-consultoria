<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    public function planosHasEmpresas()
    {
        return $this->hasMany('App\Models\PlanosHasEmpresa', 'empresas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
