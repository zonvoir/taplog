<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collections extends Model
{
    protected $fillable = [
        'beat_plans_id', 'lefting_date', 'selling_date','kwh_reading','kwh_reading_img','hmr_reading','hmr_reading_img','gcu_bef_fill_img','fuel_stock_bef_fill','gcu_aft_fill_img','fuel_stock_aft_fill','fuel_guage_bef_fill_img','fuel_guage_aft_fill_img','dip_stick_bef_fill_img','dip_stick_aft_fill_img','eb_meter_reading','eb_meter_reading_img','filling_qty','filling_date','remark'
    ];
}
