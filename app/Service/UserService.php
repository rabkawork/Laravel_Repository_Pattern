<?php

namespace App\Service;

use App\Models\Room;
use App\Repositories\UserRepository;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class UserService
{
    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * RoomService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Delete post by id.
     *
     * @param $id
     * @return String
     */
    public function deleteById($id)
    {
        DB::beginTransaction();
        try {
            $post = $this->userRepository->delete($id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new InvalidArgumentException('Unable to delete User data');
        }
        DB::commit();
        return $post;
    }

    /**
     * Get all post.
     *
     * @return String
     */
    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    /**
     * Get post by id.
     *
     * @param $id
     * @return String
     */
    public function getById($id)
    {
        return $this->userRepository->getById($id);
    }

    /**
     * Update post data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function updateUser($data, $id)
    {
        DB::beginTransaction();
        $post = $this->userRepository->update($data, $id);
        DB::commit();
        return $post;
    }

    /**
     * Validate post data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function saveUserData($data)
    {
        $result = $this->userRepository->save($data);
        return $result;
    }

}
