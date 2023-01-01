<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Service\KostService;
use Exception;
use Illuminate\Http\Request;

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
    public function index()
    {
        try {
            $data = $this->kostService->getAll();
            return $this->successResponse($data, 'Kost has been loaded');
        } catch (Exception $e) {
            return $this->errorResponse('Kost has been loaded', $e->getMessage(), HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $user = Auth::user();
            if ($user->can('create', Kost::class)) {
                $data = $this->kostService->saveKostData($request);
                return $this->successResponse($data, 'Kost has been saved');
            } else {
                return $this->errorResponse("You don't have access to create Kost", null, HttpStatus::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $e) {
            return $this->errorResponse('Error', $e->getMessage(), HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kost  $Kost
     * @return \Illuminate\Http\Response
     */
    public function show(Kost $Kost)
    {
        try {
            $data = $this->kostService->getById($Kost->id);
            return $this->successResponse($data, 'Kost data');
        } catch (Exception $e) {
            return $this->errorResponse('Error', $e->getMessage(), HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kost  $Kost
     * @return \Illuminate\Http\Response
     */
    public function edit(Kost $Kost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kost  $Kost
     * @return \Illuminate\Http\Response
     */
    public function update(KostRequest $request, Kost $Kost): JsonResponse
    {
        try {
            $user = Auth::user();
            if ($user->can('update', $Kost)) {
                if ( !empty($Kost) ) {
                    $data = $this->kostService->updateKost($request, $Kost->id);
                    return $this->successResponse($data, 'Success updated Kost data');
                } else {
                    return $this->errorResponse('Data Invalid', null, HttpStatus::HTTP_NOT_FOUND);
                }
            } else {
                return $this->errorResponse("You don't have access to create Kost", null, HttpStatus::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $e) {
            return $this->errorResponse('Error', $e->getMessage(), HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kost  $Kost
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kost $Kost): JsonResponse
    {
        try {

            $user = Auth::user();
            if ($user->can('delete', $Kost)) {
                if ( !empty($Kost) ) {
                    $data = $this->kostService->deleteById($Kost->id);
                    return $this->successResponse($data, 'Success deleted Kost data');
                } else {
                    return $this->errorResponse('Data Invalid', null, HttpStatus::HTTP_NOT_FOUND);
                }
            } else {
                return $this->errorResponse("You don't have access to create Kost", null, HttpStatus::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $e) {
            return $this->errorResponse('Error', $e->getMessage(), HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
