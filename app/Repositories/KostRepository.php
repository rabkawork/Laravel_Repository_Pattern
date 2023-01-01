<?php

namespace App\Repositories;

use App\Models\Kost;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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
    public function getAll($search = array())
    {

        $kost = DB::table('kosts')
            ->leftJoin('rooms', 'kosts.id', '=', 'rooms.kost_id')
            ->select('kosts.*', 'rooms.room_type', 'rooms.name as room_name', 'rooms.price');

        if (!empty($search['name'])) {
            $kost->where('kosts.name','LIKE','%'.$search['name'].'%');
        }

        if (!empty($search['location'])) {
            $kost->where('kosts.location','LIKE','%'.$search['location'].'%');
        }

        if (!empty($search['price'])) {
            $kost->where('rooms.price',$search['price']);
        }

        if (!empty($search['sort'])) {
            $kost->orderBy('rooms.price',$search['sort']);
        }
        return $kost->get();
    }


     /**
     * Get all Kosts.
     *
     * @return Kost $kost
     */
    public function getOwner($id)
    {
        return $this->kost->with('room')->where('user_id',$id)->get();
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
