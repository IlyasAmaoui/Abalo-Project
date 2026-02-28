<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbShoppingCart extends Model
{
    protected $table = 'ab_shoppingcart';
    public $timestamps = false;

    protected $fillable = [
        'ab_creator_id',
        'ab_createdate',
    ];

    public function items()
    {
        return $this->hasMany(AbShoppingCartItem::class, 'ab_shoppingcart_id');
    }
}
