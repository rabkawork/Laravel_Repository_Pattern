<?php

namespace App\Service;

use App\Models\Kost;
use App\Repositories\AskRepository;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class AskService
{
    /**
     * @var $AskRepository
     */
    protected $AskRepository;

    /**
     * AskService constructor.
     *
     * @param AskRepository $askRepository
     */
    public function __construct(AskRepository $askRepository)
    {
        $this->askRepository = $askRepository;
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
            $post = $this->askRepository->delete($id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new InvalidArgumentException('Unable to delete Ask Session data');
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
        return $this->askRepository->getAll();
    }

    /**
     * Get post by id.
     *
     * @param $id
     * @return String
     */
    public function getById($id)
    {
        return $this->askRepository->getById($id);
    }

    /**
     * Update post data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function updateAsksession($data, $id)
    {
        DB::beginTransaction();
        $post = $this->askRepository->update($data, $id);
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
    public function saveAsksessionData($data)
    {
        $result = $this->askRepository->save($data);
        return $result;
    }

}