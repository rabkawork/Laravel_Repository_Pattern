<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseJson;
use App\Http\Requests\KostRequest;
use App\Models\Kost;
use App\Service\KostService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KostController extends Controller
{
     /**
     * @var KostService
     */
    protected $kostService;


     /**
     * PostController Constructor
     *
     * @param KostService $kostService
     *
     */
    public function __construct(KostService $kostService)
    {
        $this->kostService = $kostService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $search['name'] = $request->query('name');
            $search['price'] = $request->query('price');
            $search['location'] = $request->query('location');
            $search['sort'] = $request->query('sort');
            $data = $this->kostService->getAll($search);
            return ResponseJson::responseSuccess('Success showing kost data', $data);
        } catch (Exception $e) {
            return ResponseJson::responseBadOrError('Kost data error', $e->getMessage(), ResponseJson::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function listowner()
    {
        try {
            $user = Auth::user();
            $data = $this->kostService->getdataOwner($user->id);
            return ResponseJson::responseSuccess('Success showing kost data', $data);
        } catch (Exception $e) {
            return ResponseJson::responseBadOrError('Kost data error', $e->getMessage(), ResponseJson::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KostRequest $request)
    {
        try {
            $post = $request->all();
            $post['user_id'] = Auth::user()->id;
            $data = $this->kostService->saveKostData($post);
            return ResponseJson::responseSuccess('Kost has been saved', $data);
        } catch (Exception $e) {
            return ResponseJson::responseBadOrError('Save data error', $e->getMessage(), ResponseJson::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kost  $Kost
     * @return \Illuminate\Http\Response
     */
    public function show(Kost $kost): JsonResponse
    {
        try {
            if ( !empty($kost) )  {
                return ResponseJson::responseSuccess('Data has been saved', $kost);
            } else {
                return ResponseJson::responseBadOrError('Kost data not found', [], ResponseJson::HTTP_NOT_FOUND);
            }
        } catch (Exception $e) {
            return ResponseJson::responseBadOrError('Save data error', $e->getMessage(), ResponseJson::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kost  $Kost
     * @return \Illuminate\Http\Response
     */
    public function update(KostRequest $request, $id): JsonResponse
    {
        try {
            $user = Auth::user();
            $kost = Kost::find($id);
            if ($user->can('update', $kost)) {
                if ( !empty($kost) )  {
                    $post = $request->all();
                    $post['user_id'] = Auth::user()->id;
                    $data = $this->kostService->updateKost($post, $kost->id);
                    return ResponseJson::responseSuccess('Data has been updated', $data);
                } else {
                    return ResponseJson::responseBadOrError('Kost data not found', [], ResponseJson::HTTP_NOT_FOUND);
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
     * @param  \App\Models\Kost  $Kost
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        try {
            $user = Auth::user();
            $kost = Kost::find($id);
            if ($user->can('update', $kost)) {
                if ( !empty($kost) )  {
                    $data = $this->kostService->deleteById($kost->id);
                    return ResponseJson::responseSuccess('Kost data has been deleted', $data);
                } else {
                    return ResponseJson::responseBadOrError('Kost data not found', [], ResponseJson::HTTP_NOT_FOUND);
                }
            } else {
                return ResponseJson::responseBadOrError("You only can delete your own data", [], ResponseJson::HTTP_BAD_GATEWAY);
            }
        } catch (Exception $e) {
            return ResponseJson::responseBadOrError('Delete data error', $e->getMessage(), ResponseJson::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
