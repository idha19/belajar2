<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Employee extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'employees';
    protected $keyType = 'string'; // id berupa string bukan integer
    public $incrementing = false; // id bukan auto increment

    protected $fillable = [
        'name',
        'email',
        'phone',
        'position',
        'departement',
        'salary',
        'hire_date',
        'photo',
    ];

    //Auto generate uuid
    protected static function booted()
    {
        static::creating(function ($employee) {
            if (empty($employee->id)) {
                $employee->id = Str::uuid();
            }
        });
    }
}
