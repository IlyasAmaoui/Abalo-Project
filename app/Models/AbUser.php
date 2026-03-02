<?php

namespace App\Models;

use Database\Factories\AbUserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AbUser extends Model
{
    /** @use HasFactory<AbUserFactory> */
    use HasFactory;
    protected $table = 'ab_user'; // unsere Tabelle aus der Datenbank

    public $timestamps = false;// Laravel erwartet standardmäßig, dass jede Tabelle 2 Spalten hat: created_at und updated_at

    protected $fillable = [ // das bedeutet nur diese Attributen dürfen massenweise gesetzt werden
        'ab_name',
        'ab_password',
        'ab_mail'
    ];
    protected $hidden=[
        'password'
    ];
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
    public function articles(): HasMany
    {
        return $this->hasMany(AbArticle::class);
    }
}
