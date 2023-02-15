<?php

namespace App\Domain\ValueObject;

enum PaymentPeriod
{
    case Monthly;
    case Annual;
}