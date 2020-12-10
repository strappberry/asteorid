<?php

namespace Crater\Http\Controllers\V1\Lead;

use Crater\Http\Controllers\Controller;
use Crater\Models\LeadSource;
use Illuminate\Http\Request;

class LeadSourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leadSources = LeadSource::all();

        return response()->json([
            'lead_sources' => $leadSources,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Crater\Models\LeadSource  $leadSource
     * @return \Illuminate\Http\Response
     */
    public function show(LeadSource $leadSource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Crater\Models\LeadSource  $leadSource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeadSource $leadSource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Crater\Models\LeadSource  $leadSource
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeadSource $leadSource)
    {
        //
    }
}
