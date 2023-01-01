<?php

namespace App\Repositories;

use App\Models\Ask;

class AskRepository
{
    /**
     * @var Ask
     */
    protected $ask;

    /**
     * AskRepository constructor.
     *
     * @param Ask $ask
     */
    public function __construct(Ask $ask)
    {
        $this->ask = $ask;
    }

    /**
     * Get all Asks.
     *
     * @return Ask $ask
     */
    public function getAll()
    {
        return $this->ask
            ->get();
    }

    /**
     * Get Ask by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->ask
            ->where('id', $id)
            ->get();
    }

    /**
     * Save Ask
     *
     * @param $data
     * @return Ask
     */
    public function save($data)
    {
        $ask = new $this->ask;
        $ask->user_id = $data['user_id'];
        $ask->owner_id = $data['owner_id'];
        $ask->kost_id = $data['kost_id'];
        $ask->ask_session_id = $data['ask_session_id'];
        $ask->message = $data['message'];
        $ask->save();
        return $ask->fresh();
    }

    /**
     * Update Ask
     *
     * @param $data
     * @return Ask
     */
    public function update($data, $id)
    {
        $ask = $this->ask->find($id);
        $ask->user_id = $data['user_id'];
        $ask->owner_id = $data['owner_id'];
        $ask->kost_id = $data['kost_id'];
        $ask->ask_session_id = $data['ask_session_id'];
        $ask->message = $data['message'];
        $ask->update();
        return $ask;
    }

    /**
     * Update Ask
     *
     * @param $data
     * @return Ask
     */
    public function delete($id)
    {
        $ask = $this->ask->find($id);
        $ask->delete();
        return $ask;
    }

}