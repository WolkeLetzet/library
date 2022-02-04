<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the Article
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function files(){
        return $this->hasMany(File::class,'article_id','id');
    }


    public function scopeTitle($query, $title)
    {
        return $query->where('title','LIKE', '%'.$title.'%')->orWhere('descrip','LIKE',"%$title%");
    }
}
