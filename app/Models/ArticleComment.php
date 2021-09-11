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


class ArticleComment extends Model
{
    use HasFactory, ScopeFilter;

    /**
     * @var string
     */
    protected $table = 'article_comment';

//    /**
//     * @var string[]
//     */
//    protected $fillable = [
//        'category_id',
//        'slug',
//        'status',
//    ];






}
