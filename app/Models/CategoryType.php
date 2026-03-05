<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CategoryType extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = []; // ['id', 'created_at', 'updated_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->useLogName('sample_category_types')
        ->logOnlyDirty()
        ->dontLogIfAttributesChangedOnly(['updated_at'])
        ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
