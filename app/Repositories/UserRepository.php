<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * @var User
     */
    protected $user;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get all Users.
     *
     * @return User $user
     */
    public function getAll()
    {
        return $this->user
            ->get();
    }

    /**
     * Get User by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->user
            ->where('id', $id)
            ->get();
    }

    /**
     * Save User
     *
     * @param $data
     * @return User
     */
    public function save($data)
    {
        $user = new $this->user;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->permission = $data['permission'];
        $user->password = Hash::make($data['password']);
        $user->save();
        return $user;
    }

    /**
     * Update User
     *
     * @param $data
     * @return User
     */
    public function update($data, $id)
    {
        $user = $this->user->find($id);
        $user->name = $data['name'];
        $user->email = $data['email'];

        if ( !empty($data['permission']) ) {
            $user->permission = $data['permission'];
        }

        if ( !empty($data['password']) ) {
            $user->password = Hash::make($data['password']);
        }
        $user->update();
        return $user;
    }

    /**
     * Update User
     *
     * @param $data
     * @return User
     */
    public function delete($id)
    {
        $user = $this->user->find($id);
        $user->delete();
        return $user;
    }

}
