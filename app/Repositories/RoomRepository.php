<?php

namespace App\Repositories;

use App\Models\Room;

class RoomRepository
{
    /**
     * @var Room
     */
    protected $room;

    /**
     * RoomRepository constructor.
     *
     * @param Room $room
     */
    public function __construct(Room $room)
    {
        $this->room = $room;
    }

    /**
     * Get all Rooms.
     *
     * @return Room $room
     */
    public function getAll()
    {
        return $this->room
            ->get();
    }

    /**
     * Get Room by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->room
            ->where('id', $id)
            ->get();
    }

    /**
     * Save Room
     *
     * @param $data
     * @return Room
     */
    public function save($data)
    {
        $room = new $this->room;
        $room->user_id = $data['user_id'];
        $room->kost_id = $data['kost_id'];
        $room->room_type = $data['room_type'];
        $room->name = $data['name'];
        $room->price = $data['price'];
        $room->availability = $data['availability'];
        $room->save();
        return $room->fresh();
    }

    /**
     * Update Room
     *
     * @param $data
     * @return Room
     */
    public function update($data, $id)
    {
        $room = $this->room->find($id);
        $room->user_id = $data['user_id'];
        $room->kost_id = $data['kost_id'];
        $room->room_type = $data['room_type'];
        $room->name = $data['name'];
        $room->price = $data['price'];
        $room->availability = $data['availability'];
        $room->update();
        return $room;
    }

    /**
     * Update Room
     *
     * @param $data
     * @return Room
     */
    public function delete($id)
    {
        $room = $this->room->find($id);
        $room->delete();
        return $room;
    }

}
