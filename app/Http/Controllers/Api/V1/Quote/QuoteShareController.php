<?php

namespace App\Http\Controllers\Api\V1\Quote;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuoteShareController extends Controller
{
    function send(Request $request, Quote $quote, string $channel)
    {
        $channelConfig = config('share.channels')[$channel];

        $requestClassName = $channelConfig['request'];
        $formRequest = $requestClassName::createFrom($request);

        $formFieldName = $channelConfig['formFieldName'];
        $login = $formRequest->validate($formRequest->rules())[$formFieldName];

        $jobClassName = $channelConfig['job'];
        $jobClassName::dispatch($channel, $quote, $login);

        return response()->noContent(Response::HTTP_CREATED);
    }
}