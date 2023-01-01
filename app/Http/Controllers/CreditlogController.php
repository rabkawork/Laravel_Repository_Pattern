<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseJson;
use App\Models\Creditlog;
use App\Service\CreditlogService;
use App\Service\CreditService;
use Exception;
use Illuminate\Http\Request;

class CreditlogController extends Controller
{

    /**
     * @var CreditlogService
     */
    protected $creditlogService;



    /**
     * @var CreditService
     */
    protected $creditService;


     /**
     * PostController Constructor
     *
     * @param CreditlogService $CreditlogService
     *
     */
    public function __construct(CreditlogService $creditlogService, CreditService $creditService)
    {
        $this->creditlogService = $creditlogService;
        $this->creditService = $creditService;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data['credit'] = $this->creditService->getAll();
            $data['history'] = $this->creditlogService->getAll();
            return ResponseJson::responseSuccess('Success creadit usage', $data);
        } catch (Exception $e) {
            return ResponseJson::responseBadOrError('Credit usage data error', $e->getMessage(), ResponseJson::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
