<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request\ArticleRequest;
use App\Http\Request\LoginRequest;
use App\Http\Request\RegisterRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CommentResource;
use App\Models\User;
use App\Models\UserToken;
use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\AuthRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Psy\Util\Json;


class ArticleController extends Controller
{
    /**
     * @var ArticleRepositoryInterface
     */
    protected $articleRepository;

    /**
     * ArticleController constructor.
     * @param ArticleRepositoryInterface $articleRepository
     */
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }


    /**
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getArticle(Request $request)
    {
        $rules = $this->validateArticleParams($request);
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => 'false', 'message' => $validator->messages()], 400);
        }

        return ArticleResource::collection($this->articleRepository->getData($request, []));
    }


    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getArticleComments(Request $request, int $id)
    {
        $rules = $this->validateCommentParams($request);
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => 'false', 'message' => $validator->messages()], 400);
        }

        return CommentResource::collection($this->articleRepository->getArticleComments($request, $id));

    }

    /**
     * @param $request
     * @return array
     */
    public function validateCommentParams($request)
    {
        $rules = [
            'sort' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if ($value !== 'created_at') {
                    $fail('The sort parameter is invalid.');
                }
            }],
            'order' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if ($value != 'asc' && $value != 'desc') {
                    $fail('The order parameter is invalid.');
                }
            }],
            'paginate' => 'nullable|numeric',
            'limit' => 'nullable|numeric',
            'page' => 'nullable|numeric'
        ];


        return $rules;
    }

    /**
     * @param $request
     * @return array
     */
    public function validateArticleParams($request)
    {
        $rules = [
            'sort' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if ($value !== 'created_at' && $value !== 'comment_count' && $value !== "view_count") {
                    $fail('The sort parameter is invalid.');
                }
            }],
            'order' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if ($value != 'asc' && $value != 'desc') {
                    $fail('The order parameter is invalid.');
                }
            }],
            'paginate' => 'nullable|numeric',
            'limit' => 'nullable|numeric',
            'page' => 'nullable|numeric'
        ];

        return $rules;
    }


}
