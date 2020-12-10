<?php

namespace Crater\Http\Controllers\V1\Lead;

use Crater\Http\Controllers\Controller;
use Crater\Http\Requests\LeadsRequest;
use Crater\Models\Lead;
use Illuminate\Http\Request;

class LeadsWebHookController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LeadsRequest $request)
    {
        $lead = Lead::create($request->all());

        return response()->json([
            'success' => false,
            'lead' => $lead,
        ]);
    }
}
