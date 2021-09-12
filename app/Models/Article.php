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


class Article extends Model
{
    use HasFactory, ScopeFilter;

    /**
     * @var string
     */
    protected $table = 'articles';

    /**
     * @var string[]
     */
    protected $fillable = [
        'category_id',
        'slug',
        'status',
    ];


    public function comment()
    {
        return $this->hasMany(ArticleComment::class, 'article_id');
    }

    public function comments()
    {
        return $this->hasManyThrough(
            Comment::class,
            ArticleComment::class,
            'article_id',
            'id',
            'id',
            'comment_id'
        );
    }

    public function tags()
    {
        return $this->hasManyThrough(
            Tag::class,
            ArticleTag::class,
            'article_id',
            'id',
            'id',
            'tag_id'
        );
    }


}
