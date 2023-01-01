<?php

namespace App\Service;

use App\Models\Creditlog;
use App\Repositories\CreditlogRepository;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class CreditlogService
{
    /**
     * @var $creditlogRepository
     */
    protected $creditlogRepository;

    /**
     * CreditService constructor.
     *
     * @param CreditlogRepository $creditlogRepository
     */
    public function __construct(CreditlogRepository $creditlogRepository)
    {
        $this->creditlogRepository = $creditlogRepository;
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
            $post = $this->creditlogRepository->delete($id);
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
        return $this->creditlogRepository->getAll();
    }

    /**
     * Get post by id.
     *
     * @param $id
     * @return String
     */
    public function getById($id)
    {
        return $this->creditlogRepository->getById($id);
    }

    /**
     * Update post data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function updateCreditlog($data, $id)
    {
        DB::beginTransaction();
        $post = $this->creditlogRepository->update($data, $id);
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
    public function saveCreditlogData($data)
    {
        $result = $this->creditlogRepository->save($data);
        return $result;
    }

}