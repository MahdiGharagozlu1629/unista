<?php

namespace App\Enums;

enum FollowStatusEnum: int
{
    case Pending = 1;
    case Accept = 2;
    case Reject = 3;

    public static function getTitle(int $value): string
    {
        foreach (self::cases() as $status) {
            if ($value === $status->value) {
                return match ($value) {
                    (int)FollowStatusEnum::Accept->value => "قبول شده",
                    (int)FollowStatusEnum::Reject->value => "رد شده",
                    (int)FollowStatusEnum::Pending->value => "در حال انتظار"
                };
            }
            throw new \ValueError("$value is not a valid backing value for enum " . self::class);
        }
    }
}
