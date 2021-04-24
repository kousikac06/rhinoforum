<?php

namespace App\Repositories\User;

interface UserRepository
{
    public function addUser(array $data);

    public function editUser($id, array $data);

    public function deleteUser($id);

    public function getUser($id);

    public function getUsers(array $data);

    public function getTotalUsers(array $data);
}
