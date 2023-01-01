<?php

namespace App\Service;

use App\Models\Room;
use App\Repositories\CreditRepository;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class CreditService
{
    /**
     * @var $creditRepository
     */
    protected $creditRepository;

    /**
     * CreditService constructor.
     *
     * @param CreditRepository $creditRepository
     */
    public function __construct(CreditRepository $creditRepository)
    {
        $this->creditRepository = $creditRepository;
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
            $post = $this->creditRepository->delete($id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new InvalidArgumentException('Unable to delete Credit data');
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
        return $this->creditRepository->getAll();
    }

    /**
     * Get post by id.
     *
     * @param $id
     * @return String
     */
    public function getById($id)
    {
        return $this->creditRepository->getById($id);
    }

    /**
     * Update post data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function updateCredit($data, $id)
    {
        DB::beginTransaction();
        $post = $this->creditRepository->update($data, $id);
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
    public function saveCreditData($data)
    {
        $result = $this->creditRepository->save($data);
        return $result;
    }

}