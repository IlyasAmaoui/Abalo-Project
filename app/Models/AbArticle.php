<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class AbArticle extends Model
{
    protected $table = 'ab_article';
    public $timestamps = false;
    protected $fillable = ['ab_name', 'ab_price',
                            'ab_description','image_path',
                            'ab_createdate'];
    public function abuser(): BelongsTo
    {
        return $this->belongsTo(AbUser::Class, 'ab_creator_id');
    }

    // The naming convention is the magic here:
    //```
    //get  ImageUrl  Attribute
    // ↑      ↑         ↑
    //prefix  name    suffix
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function (): ?string {
                // New uploads → use Storage
                if ($this->image_path) {
                    return Storage::url($this->image_path);
                }

                // Legacy images → your current public/articleImages/{id}.jpg
                $legacyPath = public_path("articleImages/{$this->id}.jpg");
                if (file_exists($legacyPath)) {
                    return asset("articleImages/{$this->id}.jpg");
                }

                return null;
            }
        );
    }

}
