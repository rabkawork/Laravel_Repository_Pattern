<?php

namespace App\Service;

use App\Models\Kost;
use App\Repositories\AsksessionRepository;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class AsksessionService
{
    /**
     * @var $AsksessionRepository
     */
    protected $asksessionRepository;

    /**
     * AsksessionService constructor.
     *
     * @param AsksessionRepository $asksessionRepository
     */
    public function __construct(AsksessionRepository $asksessionRepository)
    {
        $this->asksessionRepository = $asksessionRepository;
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
            $post = $this->asksessionRepository->delete($id);
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
        return $this->asksessionRepository->getAll();
    }

    /**
     * Get post by id.
     *
     * @param $id
     * @return String
     */
    public function getById($id)
    {
        return $this->asksessionRepository->getById($id);
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
        $post = $this->asksessionRepository->update($data, $id);
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
        $data['ticket_code'] = 'MKASK-'.time();
        $result = $this->asksessionRepository->save($data);
        return $result;
    }

}
