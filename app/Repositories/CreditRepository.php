<?php

namespace App\Repositories;

use App\Models\Credit;

class CreditRepository
{
    /**
     * @var Credit
     */
    protected $credit;

    /**
     * CreditRepository constructor.
     *
     * @param Credit $credit
     */
    public function __construct(Credit $credit)
    {
        $this->credit = $credit;
    }

    /**
     * Get all Credits.
     *
     * @return Credit $credit
     */
    public function getAll()
    {
        return $this->credit
            ->get();
    }

    /**
     * Get Credit by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->credit
            ->where('id', $id)
            ->get();
    }

    /**
     * Save Credit
     *
     * @param $data
     * @return Credit
     */
    public function save($data)
    {
        $credit = new $this->credit;
        $credit->user_id = $data['user_id'];
        $credit->credit_total = $data['credit_total'];
        if ( !empty($data['flag_monthly_reset']) ) {
            $credit->flag_monthly_reset = $data['flag_monthly_reset'];
        }
        $credit->save();
        return $credit->fresh();
    }

    /**
     * Update Credit
     *
     * @param $data
     * @return Credit
     */
    public function update($data, $id)
    {
        $credit = $this->credit->find($id);
        $credit->user_id = $data['user_id'];
        $credit->credit_total = $data['credit_total'];
        if ( !empty($data['flag_monthly_reset']) ) {
            $credit->flag_monthly_reset = $data['flag_monthly_reset'];
        }
        $credit->update();
        return $credit;
    }

    /**
     * Update Credit
     *
     * @param $data
     * @return Credit
     */
    public function delete($id)
    {
        $credit = $this->credit->find($id);
        $credit->delete();
        return $credit;
    }

}
