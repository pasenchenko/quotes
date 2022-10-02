<?php

namespace App\Http\Controllers\Quote;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteShareController extends Controller
{
    function show(Quote $quote, string $channel)
    {
        return view('quotes.share.' . $channel, compact('quote', 'channel'));
    }

    function send(Request $request, Quote $quote, string $channel)
    {
        $channelConfig = config('share.channels')[$channel];

        $requestClassName = $channelConfig['request'];
        $formRequest = $requestClassName::createFrom($request);

        $formFieldName = $channelConfig['formFieldName'];
        $login = $formRequest->validate($formRequest->rules())[$formFieldName];

        $jobClassName = $channelConfig['job'];
        $jobClassName::dispatch($channel, $quote, $login);

        return redirect()->route('quotes.index');
    }
}