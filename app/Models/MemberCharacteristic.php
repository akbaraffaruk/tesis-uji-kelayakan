<?php

namespace App\Models;

use App\Observers\MemberCharacteristicObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperMemberCharacteristic
 */
#[ObservedBy([MemberCharacteristicObserver::class])]
class MemberCharacteristic extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_number',

        'name',
        'gender',
        'identity_number',
        'place_of_birth',
        'date_of_birth',
        'address',

        'work',
        'work_description',
        'source_of_income',

        'mother_name',

        'marital_status',

        'savings',

        'rice_consumption',
        'rice_price',
        'kitchen_shop',
        'electricity_bills',
        'education',
        'other_costs',
        'total_expenses',

        'house_status',
        'yard_area',
        'house_area',
        'roof_type',
        'house_wall',
        'house_floor',
        'type_of_lighting',
        'latrine_type',
        'source_of_drinking_water',
        'total_house_index',

        'total_household_income',
        'total_household_members',
        'income_per_capita',
        'tenor',
        'pokok',
        'margin',
        'installment',
        'buyer',

        'kol_prediction',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];
}
