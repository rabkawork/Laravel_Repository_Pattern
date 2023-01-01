<?php

namespace App\Repositories;

use App\Models\Creditlog;
use Illuminate\Support\Facades\Auth;

class CreditlogRepository
{
    /**
     * @var Creditlog
     */
    protected $creditlog;

    /**
     * CreditlogRepository constructor.
     *
     * @param Creditlog $creditlog
     */
    public function __construct(Creditlog $creditlog)
    {
        $this->creditlog = $creditlog;
    }

    /**
     * Get all Creditlogs.
     *
     * @return Creditlog $creditlog
     */
    public function getAll()
    {
        $user = Auth::user();
        return $this->creditlog->where('user_id',$user->id)->get();
    }

    /**
     * Get Creditlog by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->creditlog
            ->where('id', $id)
            ->get();
    }

    /**
     * Save Creditlog
     *
     * @param $data
     * @return Creditlog
     */
    public function save($data)
    {
        $creditlog = new $this->creditlog;
        $creditlog->user_id = $data['user_id'];
        $creditlog->credit_id = $data['credit_id'];
        $creditlog->amount = $data['amount'];
        $creditlog->description = $data['description'];
        $creditlog->save();
        return $creditlog->fresh();
    }

    /**
     * Update Creditlog
     *
     * @param $data
     * @return Creditlog
     */
    public function update($data, $id)
    {
        $creditlog = $this->creditlog->find($id);
        $creditlog->user_id = $data['user_id'];
        $creditlog->credit_id = $data['credit_id'];
        $creditlog->amount = $data['amount'];
        $creditlog->description = $data['description'];
        $creditlog->update();
        return $creditlog;
    }

    /**
     * Update Creditlog
     *
     * @param $data
     * @return Creditlog
     */
    public function delete($id)
    {
        $creditlog = $this->creditlog->find($id);
        $creditlog->delete();
        return $creditlog;
    }

}
