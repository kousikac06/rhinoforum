<?php

namespace App\Repositories\User;

use App\Models\User;

/**
 * Class UserRepositoryEloquent
 *
 * @package App\Repositories\User
 */
class UserRepositoryEloquent implements UserRepository
{
    /**
     * @param  array  $data
     * @return mixed
     */
    public function addUser(array $data)
    {
        return User::create($data);
    }

    /**
     * @param  $id
     * @param  array  $data
     * @return mixed
     */
    public function editUser($id, array $data)
    {
        return User::findOrFail($id)
            ->fill($data)
            ->save();
    }

    /**
     * @param $id
     * @param  string  $type
     * @return mixed
     */
    public function deleteUser($id)
    {
        return User::findOrFail($id)->delete();
    }

    /**
     * @param  $id
     * @return mixed
     */
    public function getUser($id)
    {
        return User::find($id);
    }

    /**
     * @param  array  $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUsers(array $data)
    {
        $user = User::query();

        if (isset($data['with'])) {
            $user->with($data['with']);
        }

        if (isset($data['name'])) {
            $user->where('name', $data['name']);
        }

        if (isset($data['email'])) {
            $user->where('email', $data['email']);
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if (!isset($data['start']) || $data['start'] < 0) {
                $data['start'] = 0;
            }
            if (!isset($data['limit']) || $data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $user->offset($data['start'])->limit($data['limit']);
        }

        return $user->get();
    }

    /**
     * @param  array  $data
     * @return int
     */
    public function getTotalUsers(array $data)
    {
        $user = User::query();

         if (isset($data['name'])) {
            $user->where('name', $data['name']);
        }

        if (isset($data['email'])) {
            $user->where('email', $data['email']);
        }

        return $user->count();
    }
}
