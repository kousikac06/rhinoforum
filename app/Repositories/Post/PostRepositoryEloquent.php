<?php

namespace App\Repositories\Post;

use App\Models\Post;

/**
 * Class PostRepositoryEloquent
 *
 * @package App\Repositories\Post
 */
class PostRepositoryEloquent implements PostRepository
{
    /**
     * @param  array  $data
     * @return mixed
     */
    public function addPost(array $data)
    {
        return Post::create($data);
    }

    /**
     * @param  $id
     * @param  array  $data
     * @return mixed
     */
    public function editPost($id, array $data)
    {
        return Post::findOrFail($id)
            ->fill($data)
            ->save();
    }

    /**
     * @param $id
     * @param  string  $type
     * @return mixed
     */
    public function deletePost($id)
    {
        return Post::findOrFail($id)->delete();
    }

    /**
     * @param  $id
     * @return mixed
     */
    public function getPost($id)
    {
        return Post::find($id);
    }

    /**
     * @param  array  $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getPosts(array $data)
    {
        $post = Post::query();

        if (isset($data['with'])) {
            $post->with($data['with']);
        }

        if (isset($data['user_id'])) {
            $post->where('user_id', (int) $data['user_id']);
        }

        if (isset($data['category'])) {
            $post->where('category', $data['category']);
        }

        if (isset($data['published_at_start']) && isset($data['published_at_end'])) {
            $post->whereBetween('published_at', [$data['published_at_start'], $data['published_at_end']]);
        }

        if (isset($data['published_at_start']) && !isset($data['published_at_end'])) {
            $post->where('published_at', '>=', $data['published_at_start']);
        }

        if (!isset($data['published_at_start']) && isset($data['published_at_end'])) {
            $post->where('published_at', '<=', $data['published_at_end']);
        }

        if (isset($data['content'])) {
            $post->where('content', 'like',
                '%'.$data['content'].'%');
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if (!isset($data['start']) || $data['start'] < 0) {
                $data['start'] = 0;
            }
            if (!isset($data['limit']) || $data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $post->offset($data['start'])->limit($data['limit']);
        }

        return $post->get();
    }

    /**
     * @param  array  $data
     * @return int
     */
    public function getTotalPost(array $data)
    {
        $post = Post::query();

        if (isset($data['user_id'])) {
            $post->where('user_id', (int) $data['user_id']);
        }

        if (isset($data['category'])) {
            $post->where('category', $data['category']);
        }

        if (isset($data['content'])) {
            $post->where('content', 'like',
                '%'.$data['content'].'%');
        }

        return $post->count();
    }
}
