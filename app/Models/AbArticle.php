<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbArticle extends Model
{
    protected $table = 'ab_article';
    public $timestamps = false;
    protected $fillable = ['ab_name', 'ab_price', 'ab_description', 'ab_createdate'];
    public function abuser(): BelongsTo
    {
        return $this->belongsTo(AbUser::Class, 'ab_creator_id');
    }

    // The naming convention is the magic here:
    //```
    //get  ImageUrl  Attribute
    // ↑      ↑         ↑
    //prefix  name    suffix
    protected function getImageUrlAttribute(): ?string
    {
        foreach (['jpg', 'png'] as $ext) {
            if (file_exists(public_path("articleImages/{$this->id}.{$ext}"))) {
                return asset("articleImages/{$this->id}.{$ext}");
            }
        }

        return null;
    }

}
