<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BaseModel extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;
    protected $guarded =[
        'id',
        'created_by',
        'modified_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',

    ];

    public static function getModelName(Model $model) : string
    {
        $class_parts = explode('\\', get_class($model));
        return end ($class_parts);
    }
}
