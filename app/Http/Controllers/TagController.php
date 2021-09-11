<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\TagResource;
use App\Models\Article;
use App\Models\User;
use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\TagRepositoryInterface;
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


class TagController extends Controller
{
    /**
     * @var TagRepositoryInterface
     */
    protected $tagRepository;

    /**
     * TagController constructor.
     * @param TagRepositoryInterface $tagRepository
     */
    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }


    /**
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getTags(Request $request)
    {
        $rules = $this->validateTagParams($request);
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => 'false', 'message' => $validator->messages()], 400);
        }

        return TagResource::collection($this->tagRepository->getData($request, []));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getTagArticles(Request $request, int $id)
    {
        $rules = $this->validateArticleParams($request);
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => 'false', 'message' => $validator->messages()], 400);
        }

        return ArticleResource::collection($this->tagRepository->getTagArticles($request, $id));

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


    /**
     * @param $request
     * @return array[]
     */
    public function validateTagParams($request)
    {
        $rules = [
            'sort' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if ($value !== 'article_count') {
                    $fail('The sort parameter is invalid.');
                }
            }],
            'order' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if ($value != 'asc' && $value != 'desc') {
                    $fail('The order parameter is invalid.');
                }
            }],
        ];

        return $rules;
    }


}
