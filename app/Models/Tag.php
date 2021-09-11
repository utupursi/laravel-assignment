<?php

namespace App\Models;

use App\Traits\ScopeFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;


class Tag extends Model
{
    use HasFactory, ScopeFilter;

    /**
     * @var string
     */
    protected $table = 'tags';

//    /**
//     * @var string[]
//     */
//    protected $fillable = [
//        'category_id',
//        'slug',
//        'status',
//    ];
    protected $hidden = [
        'laravel_through_key'
    ];


    public function article()
    {
        return $this->hasMany(ArticleTag::class, 'tag_id');
    }


    public function articles(){
        return $this->hasManyThrough(
            Article::class,
            ArticleTag::class,
            'tag_id', // Foreign key on the environments table...
            'id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'article_id' // Local key on the environments table...
        );
    }


}
