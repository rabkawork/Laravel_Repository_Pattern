<?php

namespace App\Repositories;

use App\Models\Kost;

class KostRepository
{
    /**
     * @var Kost
     */
    protected $kost;

    /**
     * KostRepository constructor.
     *
     * @param Kost $kost
     */
    public function __construct(Kost $kost)
    {
        $this->kost = $kost;
    }

    /**
     * Get all Kosts.
     *
     * @return Kost $kost
     */
    public function getAll()
    {
        return $this->kost
            ->get();
    }

    /**
     * Get Kost by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->kost
            ->where('id', $id)
            ->get();
    }

    /**
     * Save Kost
     *
     * @param $data
     * @return Kost
     */
    public function save($data)
    {
        $kost = new $this->kost;
        $kost->user_id = $data['user_id'];
        $kost->name = $data['name'];
        $kost->city = $data['city'];
        $kost->address = $data['address'];
        $kost->phone = $data['phone'];
        $kost->location = $data['location'];
        $kost->description = $data['description'];
        $kost->price = $data['price'];
        $kost->save();
        return $kost->fresh();
    }

    /**
     * Update Kost
     *
     * @param $data
     * @return Kost
     */
    public function update($data, $id)
    {
        $kost = $this->kost->find($id);
        $kost->user_id = $data['user_id'];
        $kost->name = $data['name'];
        $kost->city = $data['city'];
        $kost->address = $data['address'];
        $kost->phone = $data['phone'];
        $kost->location = $data['location'];
        $kost->description = $data['description'];
        $kost->price = $data['price'];
        $kost->update();
        return $kost;
    }

    /**
     * Update Kost
     *
     * @param $data
     * @return Kost
     */
    public function delete($id)
    {
        $kost = $this->kost->find($id);
        $kost->delete();
        return $kost;
    }

}