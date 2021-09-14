<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimezoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timezones')->delete();

        $items = [
            ['offset' => '-11:00', 'title' => '(GMT-11:00) Pago Pago', 'code' => 'Pacific/Pago_Pago'],
            ['offset' => '-10:00', 'title' => '(GMT-10:00) Hawaii Time', 'code' => 'Pacific/Honolulu'],
            ['offset' => '-10:00', 'title' => '(GMT-10:00) Tahiti', 'code' => 'Pacific/Tahiti'],
            ['offset' => '-09:00', 'title' => '(GMT-09:00) Alaska Time', 'code' => 'America/Anchorage'],
            ['offset' => '-08:00', 'title' => '(GMT-08:00) Pacific Time', 'code' => 'America/Los_Angeles'],
            ['offset' => '-07:00', 'title' => '(GMT-07:00) Mountain Time', 'code' => 'America/Denver'],
            ['offset' => '-06:00', 'title' => '(GMT-06:00) Central Time', 'code' => 'America/Chicago'],
            ['offset' => '-05:00', 'title' => '(GMT-05:00) Eastern Time', 'code' => 'America/New_York'],
            ['offset' => '-04:00', 'title' => '(GMT-04:00) Atlantic Time - Halifax', 'code' => 'America/Halifax'],
            ['offset' => '-03:00', 'title' => '(GMT-03:00) Buenos Aires', 'code' => 'America/Argentina/Buenos_Aires'],
            ['offset' => '-02:00', 'title' => '(GMT-02:00) Sao Paulo', 'code' => 'America/Sao_Paulo'],
            ['offset' => '-01:00', 'title' => '(GMT-01:00) Azores', 'code' => 'Atlantic/Azores'],
            ['offset' => '+00:00', 'title' => '(GMT+00:00) London', 'code' => 'Europe/London'],
            ['offset' => '+01:00', 'title' => '(GMT+01:00) Berlin', 'code' => 'Europe/Berlin'],
            ['offset' => '+02:00', 'title' => '(GMT+02:00) Helsinki', 'code' => 'Europe/Helsinki'],
            ['offset' => '+03:00', 'title' => '(GMT+03:00) Istanbul', 'code' => 'Europe/Istanbul'],
            ['offset' => '+04:00', 'title' => '(GMT+04:00) Dubai', 'code' => 'Asia/Dubai'],
            ['offset' => '+04:30', 'title' => '(GMT+04:30) Kabul', 'code' => 'Asia/Kabul'],
            ['offset' => '+05:00', 'title' => '(GMT+05:00) Maldives', 'code' => 'Indian/Maldives'],
            ['offset' => '+05:30', 'title' => '(GMT+05:30) India Standard Time', 'code' => 'Asia/Calcutta'],
            ['offset' => '+05:45', 'title' => '(GMT+05:45) Kathmandu', 'code' => 'Asia/Kathmandu'],
            ['offset' => '+06:00', 'title' => '(GMT+06:00) Dhaka', 'code' => 'Asia/Dhaka'],
            ['offset' => '+06:30', 'title' => '(GMT+06:30) Cocos', 'code' => 'Indian/Cocos'],
            ['offset' => '+07:00', 'title' => '(GMT+07:00) Bangkok', 'code' => 'Asia/Bangkok'],
            ['offset' => '+08:00', 'title' => '(GMT+08:00) Hong Kong', 'code' => 'Asia/Hong_Kong'],
            ['offset' => '+08:30', 'title' => '(GMT+08:30) Pyongyang', 'code' => 'Asia/Pyongyang'],
            ['offset' => '+09:00', 'title' => '(GMT+09:00) Tokyo', 'code' => 'Asia/Tokyo'],
            ['offset' => '+09:30', 'title' => '(GMT+09:30) Central Time - Darwin', 'code' => 'Australia/Darwin'],
            ['offset' => '+10:00', 'title' => '(GMT+10:00) Eastern Time - Brisbane', 'code' => 'Australia/Brisbane'],
            ['offset' => '+10:30', 'title' => '(GMT+10:30) Central Time - Adelaide', 'code' => 'Australia/Adelaide'],
            ['offset' => '+11:00', 'title' => '(GMT+11:00) Eastern Time - Melbourne, Sydney', 'code' => 'Australia/Sydney'],
            ['offset' => '+12:00', 'title' => '(GMT+12:00) Nauru', 'code' => 'Pacific/Nauru'],
            ['offset' => '+13:00', 'title' => '(GMT+13:00) Auckland', 'code' => 'Pacific/Auckland'],
            ['offset' => '+14:00', 'title' => '(GMT+14:00) Kiritimati', 'code' => 'Pacific/Kiritimati']            
        ];
        foreach($items as $item)
        DB::table('timezones')->insert($item);        
    }
}
