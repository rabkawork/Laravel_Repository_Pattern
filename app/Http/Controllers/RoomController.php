<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseJson;
use App\Http\Requests\RoomRequest;
use App\Models\Room;
use App\Service\KostService;
use App\Service\RoomService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
     /**
     * @var RoomService
     */
    protected $roomService;


     /**
     * PostController Constructor
     *
     * @param RoomService $roomService
     *
     */
    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->roomService->getAll();
            return ResponseJson::responseSuccess('Success showing room data', $data);
        } catch (Exception $e) {
            return ResponseJson::responseBadOrError('Room data error', $e->getMessage(), ResponseJson::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        try {
            $post = $request->all();
            $post['user_id'] = Auth::user()->id;
            $data = $this->roomService->saveRoomData($post);
            return ResponseJson::responseSuccess('Room has been saved', $data);
        } catch (Exception $e) {
            return ResponseJson::responseBadOrError('Save data error', $e->getMessage(), ResponseJson::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kost  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room): JsonResponse
    {
        try {
            if ( !empty($room) )  {
                return ResponseJson::responseSuccess('Data has been saved', $room);
            } else {
                return ResponseJson::responseBadOrError('Room data not found', [], ResponseJson::HTTP_NOT_FOUND);
            }
        } catch (Exception $e) {
            return ResponseJson::responseBadOrError('Save data error', $e->getMessage(), ResponseJson::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kost  $room
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequest $request, $id): JsonResponse
    {
        try {
            $user = Auth::user();
            $room = Room::find($id);
            if ($user->can('update', $room)) {
                if ( !empty($room) )  {
                    $post = $request->all();
                    $post['user_id'] = Auth::user()->id;
                    $data = $this->roomService->updateRoom($post, $room->id);
                    return ResponseJson::responseSuccess('Data has been updated', $data);
                } else {
                    return ResponseJson::responseBadOrError('Room data not found', [], ResponseJson::HTTP_NOT_FOUND);
                }
            } else {
                return ResponseJson::responseBadOrError("You only can update your own data", [], ResponseJson::HTTP_BAD_GATEWAY);
            }
        } catch (Exception $e) {
            return ResponseJson::responseBadOrError('Update data error', $e->getMessage(), ResponseJson::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kost  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        try {
            $user = Auth::user();
            $room = Room::find($id);
            if ($user->can('delete', $room)) {
                if ( !empty($room) )  {
                    $data = $this->roomService->deleteById($room->id);
                    return ResponseJson::responseSuccess('Room data has been deleted', $data);
                } else {
                    return ResponseJson::responseBadOrError('Room data not found', [], ResponseJson::HTTP_NOT_FOUND);
                }
            } else {
                return ResponseJson::responseBadOrError("You only can delete your own data", [], ResponseJson::HTTP_BAD_GATEWAY);
            }
        } catch (Exception $e) {
            return ResponseJson::responseBadOrError('Delete data error', $e->getMessage(), ResponseJson::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
