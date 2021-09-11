<?php

namespace App\Repositories\Eloquent;

use App\Http\Request\LoginRequest;
use App\Http\Request\RegisterRequest;
use App\Models\Article;
use App\Models\User;
use App\Models\UserToken;
use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\Eloquent\Base\BaseRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ArticleRepository extends BaseRepository implements ArticleRepositoryInterface
{

    public function __construct(Article $model)
    {
        parent::__construct($model);
    }

    public function getData($request, array $relation = [])
    {

        $data = $this->model->filter($request);

        $sort = 'created_at';
        $order = 'desc';
        $limit = 10;

        $data->with('tags')->withCount('comment');

        if ($request['sort'] == 'comment_count' && $request['order']) {
            $data->orderBy('comment_count', $request['order']);
        } elseif ($request['sort'] == 'comment_count' && !$request['order']) {
            $data->orderBy('comment_count', $order);
        }

//        if ($request['sort'] === 'view_count' && $request['order']) {
//            $data->withCount('comment')->orderBy('');
//        }

        if ($request['sort'] === "created_at" && $request['order']) {
            $data->orderBy('created_at', $request['order']);
        } elseif ($request['sort'] == 'created_at' && !$request['order']) {
            $data->orderBy('created_at', $order);
        }

        if (!$request['sort'] && !$request['order']) {
            $data->orderBy($sort, $order);
        }

        $data->take($request['limit']?:$limit);

        if($request['paginate']) {
            return $data->paginate($request['paginate'])->getCollection();
        }

        return $data->get();
    }


}
