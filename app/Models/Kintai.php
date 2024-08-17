<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kintai extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'this_month',
        'work_start_01',
        'work_start_02',
        'work_start_03',
        'work_start_04',
        'work_start_05',
        'work_start_06',
        'work_start_07',
        'work_start_08',
        'work_start_09',
        'work_start_10',
        'work_start_11',
        'work_start_12',
        'work_start_13',
        'work_start_14',
        'work_start_15',
        'work_start_16',
        'work_start_17',
        'work_start_18',
        'work_start_19',
        'work_start_20',
        'work_start_21',
        'work_start_22',
        'work_start_23',
        'work_start_24',
        'work_start_25',
        'work_start_26',
        'work_start_27',
        'work_start_28',
        'work_start_29',
        'work_start_30',
        'work_start_31',
        'work_end_01',
        'work_end_02',
        'work_end_03',
        'work_end_04',
        'work_end_05',
        'work_end_06',
        'work_end_07',
        'work_end_08',
        'work_end_09',
        'work_end_10',
        'work_end_11',
        'work_end_12',
        'work_end_13',
        'work_end_14',
        'work_end_15',
        'work_end_16',
        'work_end_17',
        'work_end_18',
        'work_end_19',
        'work_end_20',
        'work_end_21',
        'work_end_22',
        'work_end_23',
        'work_end_24',
        'work_end_25',
        'work_end_26',
        'work_end_27',
        'work_end_28',
        'work_end_29',
        'work_end_30',
        'work_end_31',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
