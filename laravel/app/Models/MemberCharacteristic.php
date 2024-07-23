<?php

namespace App\Models;

use App\Observers\MemberCharacteristicObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([MemberCharacteristicObserver::class])]
class MemberCharacteristic extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_number',
        'name',
        'identity_number',
        'mother_name',
        'father_name',
        'place_of_birth',
        'date_of_birth',
        'work',
        'work_description',
        'source_of_income',
        'address',
        'rice_consumption',
        'rice_price',
        'kitchen_shop',
        'electricity_bills',
        'education',
        'other_costs',
        'savings',
        'home_status',
        'yard_area',
        'roof_type',
        'house_wall',
        'type_of_lighting',
        'latrine_type',
        'source_of_drinking_water',
        'total_household_income',
        'total_household_members',
        'income_per_capita',
        'tenor',
        'pokok',
        'margin',
        'installment',
        'buyer',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];
}
