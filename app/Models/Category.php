<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Category extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->useLogName('sample_categories')
        ->logOnlyDirty()
        ->dontLogIfAttributesChangedOnly(['updated_at'])
        ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    public function categoryType()
    {
    	return $this->belongsTo(CategoryType::class);
    }
}
