<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inspection extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = [];

    protected $appends = ['code'];

    public function Tipo(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (! $value) {
                    return '';
                }

                $decoded = json_decode($value, true);

                return is_array($decoded) ? implode(', ', $decoded) : $value;
            },
            set: function ($value) {
                return $value;
            }
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ayudante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ayudante_id');
    }

    public function ayudantes()
    {
        return $this->belongsToMany(User::class, 'inspection_ayudantes', 'inspection_id', 'ayudante_id');
    }

    public function getCodeAttribute()
    {
        $consecutive = $this->consecutive;

        return str_pad($consecutive, 3, '0', STR_PAD_LEFT).'-'.substr($this->gerencia, -3).'-'.date('Y');
    }

    public function prioridad(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                switch ($value) {
                    case 1:
                        return 'Alta';
                    case 2:
                        return 'Media';
                    case 3:
                        return 'Baja';
                }
            },
            set: function ($value) {
                return $value;
            }
        );
    }

    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'inspection_tools');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public static function booted()
    {
        static::creating(function (self $inspection) {
            $inspection->consecutive = Inspection::whereYear('created_at', date('Y'))->count() + 1;
        });
    }
}
