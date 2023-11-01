<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reservations')->insert([
            'Location' => 'Orly Aireport',
            'Destination' => 'Paris City',
            'Passengers' => '2',
            'price' => '36',
            'Date' => '2019-03-01',
            'time' => '01:57:00',
            'First_Name' => 'test 001',
            'Family_Name' => 'test 001',
            'Countr' => 'france',
            'codephone' => '+33',
            'Phone' => '0022114455',
            'Email' => 'test001@blog.com',
            'Comments' => 'hello',
            'paymethode' => 'Pay to the driver',
            'triptype' => 'Arrival',
        ]);

        DB::table('reservations')->insert([
            'Location' => 'Paris City',
            'Destination' => 'Paris City',
            'Passengers' => '8',
            'price' => '36',
            'Date' => '2019-03-01',
            'time' => '01:57:00',
            'First_Name' => 'test 002',
            'Family_Name' => 'test 002',
            'Countr' => 'france',
            'codephone' => '+33',
            'Phone' => '0022114455',
            'Email' => 'test002@blog.com',
            'Comments' => 'hello',
            'paymethode' => 'Pay to the driver',
            'triptype' => 'Round Trip',
        ]);

        DB::table('reservations')->insert([
            'Location' => 'Orly Aireport',
            'Destination' => 'Versailles',
            'Passengers' => '2',
            'price' => '65',
            'Date' => '2019-03-01',
            'time' => '01:57:00',
            'First_Name' => 'test 003',
            'Family_Name' => 'test 003',
            'Countr' => 'france',
            'codephone' => '+33',
            'Phone' => '0022114455',
            'Email' => 'test003@blog.com',
            'Comments' => 'hello',
            'paymethode' => 'Pay to the driver',
            'triptype' => 'Arrival',
        ]);
    }
}
