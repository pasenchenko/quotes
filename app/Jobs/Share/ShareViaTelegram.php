<?php

namespace App\Jobs\Share;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ShareViaTelegram extends AbstractQuoteShare implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $channel, Quote $quote, string $login)
    {
        parent::__construct($channel, $quote, $login);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sleep(rand(5, 20)); // Mock API call

        parent::handle();
    }
}