<?php

namespace Crater\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'location',
        'interests',
        'message',
        'language',
        'lead_source_id',
    ];

    public function leadSource()
    {
        return $this->belongsTo(LeadSource::class);
    }

    public function scopeApplyFilters ($query, array $filters)
    {
        $collectFilters = collect($filters);
        if ($collectFilters->get('orderByField') || $collectFilters->get('orderBy')) {
            $field = $collectFilters->get('orderByField') ? $collectFilters->get('orderByField') : 'created_date';
            $orderBy = $collectFilters->get('orderBy') ? $collectFilters->get('orderBy') : 'desc';
            $query->whereOrder($field, $orderBy);
        }
    }

    public function scopeWhereOrder($query, $orderByField, $orderBy)
    {
        $query->orderBy($orderByField, $orderBy);
    }

    public static function deleteLeads ($ids)
    {
        Lead::whereIn('id', $ids)->delete();
    }
}
