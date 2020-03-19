<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestAPI extends Model
{
    protected $fillable = [
'reg_no',
'surname',
'first_name',
'middle_name',
'gender',
'date_of_birth',
'religion',
'residential_address',
'home_phone',
'state_of_origin',
'sponsor_name',
'sponsor_address',
'sponsor_phone',
'sponsor_email',
'proposed_class',
'school_attended',
'student_type',
'cbt_mode',
'cbt_day',
'image',
    ];
}
