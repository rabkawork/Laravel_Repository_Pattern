<?php
namespace App\Helpers;
use App\Models\User;

class CreditHelper {
    public const DEFAULT_CREDIT_OWNER = 0;
    public const DEFAULT_CREDIT_USER = 20;
    public const DEFAULT_CREDIT_PREMIUM = 40;
    public const ASK_REDUCE_CREDIT = 5;

    public static function getDefaultCredit(int $permission): int{
        $credit = self::DEFAULT_CREDIT_OWNER;
        switch ($permission) {
            case 1:
                $credit = self::DEFAULT_CREDIT_OWNER;
                break;
            case 2:
                $credit = self::DEFAULT_CREDIT_USER;
                break;
            case 3:
                $credit = self::DEFAULT_CREDIT_PREMIUM;
                break;
        }
        return $credit;
    }

    public static function askOwnerKos($total) {
        return (int) ($total - self::ASK_REDUCE_CREDIT);
    }
}