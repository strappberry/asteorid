<?php

namespace Crater\Http\Controllers\V1\Lead;

use Crater\Http\Controllers\Controller;
use Crater\Http\Requests\DeleteLeadsRequest;
use Crater\Http\Requests\LeadsRequest;
use Crater\Models\Lead;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->has('limit') ? $request->limit : 10;
        $leads = Lead::applyFilters(
            $request->only([
                'orderByField',
                'orderBy',
            ])
        )
        ->paginate($limit);

        return response()->json([
            'leads' => $leads,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeadsRequest $request)
    {
        $lead = Lead::create(
            $request->only([
                'name',
                'email',
                'phone',
                'location',
                'interests',
                'message',
                'language',
                'lead_source_id',
            ])
        );

        return response()->json([
            'success' => true,
            'lead' => $lead,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Crater\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function show(Lead $lead)
    {
        $lead->load('leadSource');
        return response()->json([
            'lead' => $lead,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Crater\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function update(LeadsRequest $request, Lead $lead)
    {
        $lead->update(
            $request->only([
                'name',
                'email',
                'phone',
                'location',
                'interests',
                'message',
                'language',
                'lead_source_id',
            ])
        );

        $lead->load('leadSource');
        
        return response()->json([
            'success' => true,
            'lead' => $lead
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Crater\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Remove the multiple resources from storage.
     *
     * @param  Crater\Http\Requests\DeleteLeadsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function delete(DeleteLeadsRequest $request)
    {
        Lead::deleteLeads($request->ids);

        return response()->json([
            'success' => true,
        ]);
    }
}
