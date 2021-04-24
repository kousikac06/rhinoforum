<?php

namespace App\Repositories\Post;

interface PostRepository
{
    public function addPost(array $data);

    public function editPost($id, array $data);

    public function deletePost($id);

    public function getPost($id);

    public function getPosts(array $data);

    public function getTotalPost(array $data);
}
