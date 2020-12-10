<?php

namespace Crater\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
