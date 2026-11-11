<?php

namespace App\Console\Commands;

use App\Services\OrderExpirationService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('orders:expire-pending')]
#[Description('Expire pending orders whose payment window has ended')]
class ExpirePendingOrders extends Command
{
    public function handle(OrderExpirationService $orderExpirationService): int
    {
        $expiredCount = $orderExpirationService->expireDue();

        $this->info("Expired {$expiredCount} pending orders.");

        return self::SUCCESS;
    }
}
