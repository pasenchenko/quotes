<?php

namespace App\Jobs\Share;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

abstract class AbstractQuoteShare implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $channel;
    protected Quote $quote;
    protected string $login;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $channel, Quote $quote, string $login)
    {
        $this->channel = $channel;
        $this->quote = $quote->withoutRelations();
        $this->login = $login;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->incrementQuoteSharedCount();
        // $this->logSuccess();
    }

    protected function incrementQuoteSharedCount(): void
    {
        $this->quote->shared_count += 1;
        $this->quote->save();
    }

    protected function logSuccess(): void
    {
        Log::debug("Quote {$this->quote->id} was shared via {$this->channel} {$this->login}");
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        return [new WithoutOverlapping($this->quote->id)];
    }
}