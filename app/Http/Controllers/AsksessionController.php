<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseJson;
use App\Helpers\UsecreditHelper;
use App\Http\Requests\AsksessionRequest;
use App\Service\AsksessionService;
use App\Service\CreditlogService;
use App\Service\CreditService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsksessionController extends Controller
{

    /**
     * @var AsksessionService
     */
    protected $asksessionService;


    /**
     * @var CreditService
     */
    protected $creditService;


        /**
     * @var CreditlogService
     */
    protected $creditlogService;


     /**
     * PostController Constructor
     *
     * @param AsksessionService $AsksessionService
     *
     */
    public function __construct(AsksessionService $asksessionService, CreditService $creditService, CreditlogService $creditlogService)
    {
        $this->asksessionService = $asksessionService;
        $this->creditService = $creditService;
        $this->creditlogService = $creditlogService;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AsksessionRequest $request)
    {

        try {
            $input = $request->all();


            $post['user_id'] = Auth::user()->id;
            $post['kost_id'] = $input['kost_id'];
            $getAmountCredit = $this->creditService->getByUserId();
            $data = $this->asksessionService->saveAsksessionData($post);

            $updateCredit['user_id'] = $post['user_id'];
            $updateCredit['credit_total'] = UsecreditHelper::askOwnerKos($getAmountCredit['credit_total']);
            $this->creditService->updateCredit($updateCredit, $getAmountCredit['id']);

            $creditlog['user_id']   = $post['user_id'];
            $creditlog['credit_id'] = $getAmountCredit['id'];
            $creditlog['amount']    = $updateCredit['credit_total'];
            $creditlog['description'] = 'Reduce credit -> Ask Owner : '.$updateCredit['credit_total'];
            $this->creditlogService->saveCreditlogData($creditlog);

            return ResponseJson::responseSuccess('Ask owner has been saved', $data);
        } catch (Exception $e) {
            return ResponseJson::responseBadOrError('Save data error', $e->getMessage(), ResponseJson::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
