<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;


    protected $fillable = ['user_id', 'carry_over_hours', 'area_a_name', 'area_b_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
