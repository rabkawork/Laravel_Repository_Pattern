<?php

namespace App\Repositories;

use App\Models\Asksession;

class AsksessionRepository
{
    /**
     * @var Asksession
     */
    protected $asksession;

    /**
     * AsksessionRepository constructor.
     *
     * @param Asksession $asksession
     */
    public function __construct(Asksession $asksession)
    {
        $this->asksession = $asksession;
    }

    /**
     * Get all Asksessions.
     *
     * @return Asksession $asksession
     */
    public function getAll()
    {
        return $this->asksession
            ->get();
    }

    /**
     * Get Asksession by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->asksession
            ->where('id', $id)
            ->get();
    }

    /**
     * Save Asksession
     *
     * @param $data
     * @return Asksession
     */
    public function save($data)
    {
        $asksession = new $this->asksession;
        $asksession->user_id = $data['user_id'];
        $asksession->ticket_code = $data['ticket_code'];
        $asksession->save();
        return $asksession->fresh();
    }

    /**
     * Update Asksession
     *
     * @param $data
     * @return Asksession
     */
    public function update($data, $id)
    {
        $asksession = $this->asksession->find($id);
        $asksession->user_id = $data['user_id'];
        $asksession->ticket_code = $data['ticket_code'];
        $asksession->update();
        return $asksession;
    }

    /**
     * Update Asksession
     *
     * @param $data
     * @return Asksession
     */
    public function delete($id)
    {
        $asksession = $this->asksession->find($id);
        $asksession->delete();
        return $asksession;
    }

}