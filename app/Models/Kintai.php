<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kintai extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
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
        'work_end___01',
        'work_end___02',
        'work_end___03',
        'work_end___04',
        'work_end___05',
        'work_end___06',
        'work_end___07',
        'work_end___08',
        'work_end___09',
        'work_end___10',
        'work_end___11',
        'work_end___12',
        'work_end___13',
        'work_end___14',
        'work_end___15',
        'work_end___16',
        'work_end___17',
        'work_end___18',
        'work_end___19',
        'work_end___20',
        'work_end___21',
        'work_end___22',
        'work_end___23',
        'work_end___24',
        'work_end___25',
        'work_end___26',
        'work_end___27',
        'work_end___28',
        'work_end___29',
        'work_end___30',
        'work_end___31',
        'break_start01',
        'break_start02',
        'break_start03',
        'break_start04',
        'break_start05',
        'break_start06',
        'break_start07',
        'break_start08',
        'break_start09',
        'break_start10',
        'break_start11',
        'break_start12',
        'break_start13',
        'break_start14',
        'break_start15',
        'break_start16',
        'break_start17',
        'break_start18',
        'break_start19',
        'break_start20',
        'break_start21',
        'break_start22',
        'break_start23',
        'break_start24',
        'break_start25',
        'break_start26',
        'break_start27',
        'break_start28',
        'break_start29',
        'break_start30',
        'break_start31',
        'break_end__01',
        'break_end__02',
        'break_end__03',
        'break_end__04',
        'break_end__05',
        'break_end__06',
        'break_end__07',
        'break_end__08',
        'break_end__09',
        'break_end__10',
        'break_end__11',
        'break_end__12',
        'break_end__13',
        'break_end__14',
        'break_end__15',
        'break_end__16',
        'break_end__17',
        'break_end__18',
        'break_end__19',
        'break_end__20',
        'break_end__21',
        'break_end__22',
        'break_end__23',
        'break_end__24',
        'break_end__25',
        'break_end__26',
        'break_end__27',
        'break_end__28',
        'break_end__29',
        'break_end__30',
        'break_end__31',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
