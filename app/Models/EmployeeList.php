<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeList extends Model
{
    use HasFactory;
    protected $table = 'employees';

    protected $fillable = [
        'name', 'position','salary','boss','date','image'
    ];
}
