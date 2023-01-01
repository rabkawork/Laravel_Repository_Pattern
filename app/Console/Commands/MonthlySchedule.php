<?php

namespace App\Console\Commands;

use App\Helpers\UsecreditHelper;
use App\Models\Credit;
use App\Models\Creditlog;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MonthlySchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule to recharge credit';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        try {
            $users = User::whereIn('permission', [User::REGULAR_USER, User::PREMIUM_USER])
                ->orderBy('id', 'ASC')
                ->get();

            foreach ($users as $user) {
                $defaultCredit = UsecreditHelper::getDefaultCredit($user->permission);
                $credit = Credit::where('user_id',$user->id)->first();
                $currentCredit = $credit->credit_total + $defaultCredit;
                $updateCredit = Credit::find($credit->id);
                $updateCredit->credit_total = $currentCredit;
                $updateCredit->update();

                $creditlog = new Creditlog;
                $creditlog->user_id = $user->id;
                $creditlog->credit_id = $credit->id;
                $creditlog->amount = $currentCredit;
                $creditlog->description = 'Monthly Recharge - '.$currentCredit;
                $creditlog->save();
            }

            Log::info('Recharge credit done');
            return "success";
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return "failed";
        }

    }
}
