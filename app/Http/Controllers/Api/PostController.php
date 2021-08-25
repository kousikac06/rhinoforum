<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Post\PostRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostRequest;
use Exception;

class PostController extends Controller
{
    /**
     * @var PostRepository123
     */
    protected $postRepository;

    /**
     * PostController constructor.
     *
     * @param  PostRepository  $postRepository
     */
    public function __construct(
        PostRepository $postRepository
    ) {
        $this->postRepository = $postRepository;
    }

    /**
     * method="Get"
     * path="/rhinoforum/api/posts"
     * summary="實作查詢貼文API"
     * Parameter(
     *      user_id=1,
     *      category="Tech",
     *      content="content",
     *      published_at_start="2021-04-24 13:10:10",
     *      published_at_end="2021-04-24 13:10:10",
     *      per_page=10
     *      current_page=1
     * )
     *
     * @param  PostRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPosts(PostRequest $request)
    {
        // TODO: 實作查詢貼文 API
        try {
            if (strlen($request->input('per_page')) == 0) {
                $request->merge(['per_page' => 100]);
            }

            if (strlen($request->input('current_page')) == 0) {
                $request->merge(['current_page' => 1]);
            }

            $formData = $request->only([
                'user_id',
                'category',
                'content',
                'published_at_start',
                'published_at_end',
                'per_page',
                'current_page',
            ]);

            $formData         = $this->getPaginationParameter($formData);
            $formData['with'] = 'user';

            $post_list = $this->postRepository->getPosts($formData)
                ->map(function ($post) {
                    $user = $post->user;

                    return [
                        'name'         => $user->name,
                        'email'        => $user->email,
                        'category'     => $post->category,
                        'content'      => $post->content,
                        'published_at' => $post->published_at,
                    ];
                })
                ->toArray();

            return response()->json([
                'result' => 'success',
                'data'   => $post_list,
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            return response()->json([
                'result'  => 'error',
                'message' => $e->getMessage(),
            ], 404, [], JSON_UNESCAPED_UNICODE);
        }
    }
}
