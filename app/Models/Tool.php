<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Tool extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = [];

    public function inspections()
    {
        return $this->hasMany(Inspection::class, 'inspection_tools');
    }
}
