<?php

namespace App\Jobs;

use App\Services\StateOpenRequestService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Log\Logger;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendStateOpenRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $id, protected array $data, protected array $header)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = StateOpenRequestService::getInstance()->post('/api/course/activities-read/' . $this->id, $this->data, $this->header);
        $logger = new Logger(new \Symfony\Component\HttpKernel\Log\Logger());
        $logger->notice('【state open response】', $response);
    }

    public function tries(): int
    {
        return 3;
    }

    /**
     * 确定作业应当超时的时间。
     */
    public function retryUntil(): Carbon
    {
        return Carbon::now()->addMinutes(2);
    }
}
