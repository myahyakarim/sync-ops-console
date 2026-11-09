<?php

namespace Database\Seeders;

use App\Models\SyncJob;
use Illuminate\Database\Seeder;

class SyncJobSeeder extends Seeder
{
    public function run(): void
    {
        SyncJob::query()->insert([
            [
                'reference' => 'ord_7001',
                'job_type' => 'erp.vendor_bill',
                'status' => SyncJob::STATUS_SUCCEEDED,
                'attempts' => 1,
                'last_error' => null,
                'payload' => json_encode(['amount_cents' => 12000]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reference' => 'ord_7002',
                'job_type' => 'erp.vendor_bill',
                'status' => SyncJob::STATUS_FAILED,
                'attempts' => 3,
                'last_error' => 'remote_timeout after 3 attempts',
                'payload' => json_encode(['amount_cents' => 8900]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reference' => 'ord_7003',
                'job_type' => 'partner.push',
                'status' => SyncJob::STATUS_QUEUED,
                'attempts' => 0,
                'last_error' => null,
                'payload' => json_encode(['partner' => 'harborpos']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
