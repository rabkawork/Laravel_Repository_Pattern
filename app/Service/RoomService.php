<?php

namespace App\Service;

use App\Models\Room;
use App\Repositories\RoomRepository;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class RoomService
{
    /**
     * @var $roomRepository
     */
    protected $roomRepository;

    /**
     * RoomService constructor.
     *
     * @param RoomRepository $roomRepository
     */
    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
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
            $post = $this->roomRepository->delete($id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new InvalidArgumentException('Unable to delete Room data');
        }
        DB::commit();
        return $post;
    }

    /**
     * Get all post.
     *
     * @return String
     */
    public function getAll($search = array())
    {
        return $this->roomRepository->getAll($search);
    }

    /**
     * Get post by id.
     *
     * @param $id
     * @return String
     */
    public function getById($id)
    {
        return $this->roomRepository->getById($id);
    }

    /**
     * Update post data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function updateRoom($data, $id)
    {
        DB::beginTransaction();
        $post = $this->roomRepository->update($data, $id);
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
    public function saveRoomData($data)
    {
        $result = $this->roomRepository->save($data);
        return $result;
    }

}
