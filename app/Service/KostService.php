<?php

namespace App\Service;

use App\Models\Kost;
use App\Repositories\KostRepository;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class KostService
{
    /**
     * @var $kostRepository
     */
    protected $kostRepository;

    /**
     * KostService constructor.
     *
     * @param KostRepository $kostRepository
     */
    public function __construct(KostRepository $kostRepository)
    {
        $this->kostRepository = $kostRepository;
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
            $post = $this->kostRepository->delete($id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new InvalidArgumentException('Unable to delete Kost data');
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
        return $this->kostRepository->getAll();
    }

    /**
     * Get post by id.
     *
     * @param $id
     * @return String
     */
    public function getById($id)
    {
        return $this->kostRepository->getById($id);
    }

    /**
     * Update post data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function updateKost($data, $id)
    {
        DB::beginTransaction();
        $post = $this->kostRepository->update($data, $id);
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
    public function saveKostData($data)
    {
        $result = $this->kostRepository->save($data);
        return $result;
    }

}