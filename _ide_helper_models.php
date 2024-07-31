<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $member_number
 * @property string $name
 * @property string $gender
 * @property string $identity_number
 * @property string|null $place_of_birth
 * @property \Illuminate\Support\Carbon|null $date_of_birth
 * @property string|null $address
 * @property string|null $work
 * @property string|null $work_description
 * @property string|null $source_of_income
 * @property string|null $mother_name
 * @property int|null $savings
 * @property int|null $rice_consumption
 * @property int|null $rice_price
 * @property int|null $kitchen_shop
 * @property int|null $electricity_bills
 * @property int|null $education
 * @property int|null $other_costs
 * @property int|null $total_expenses
 * @property string|null $house_status
 * @property int|null $yard_area
 * @property int|null $house_area
 * @property string|null $roof_type
 * @property string|null $house_wall
 * @property string|null $house_floor
 * @property string|null $type_of_lighting
 * @property string|null $latrine_type
 * @property string|null $source_of_drinking_water
 * @property int|null $total_house_index
 * @property int|null $total_household_income
 * @property int|null $total_household_members
 * @property int|null $income_per_capita
 * @property int|null $tenor
 * @property int|null $pokok
 * @property int|null $margin
 * @property int|null $installment
 * @property string|null $buyer
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic query()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereBuyer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereElectricityBills($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereHouseArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereHouseFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereHouseStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereHouseWall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereIdentityNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereIncomePerCapita($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereInstallment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereKitchenShop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereLatrineType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereMargin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereMemberNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereMotherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereOtherCosts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic wherePlaceOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic wherePokok($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereRiceConsumption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereRicePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereRoofType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereSavings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereSourceOfDrinkingWater($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereSourceOfIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereTenor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereTotalExpenses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereTotalHouseIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereTotalHouseholdIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereTotalHouseholdMembers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereTypeOfLighting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereWorkDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCharacteristic whereYardArea($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperMemberCharacteristic {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

