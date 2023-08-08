<?php

use App\Models\County\County;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('counties')->where('id', '>', 0)->delete();

        County::create([
            'id' => 1,
            'name' => 'Bucks',
            'state' => 'Pennsylvania',
            'state_abbr' => 'PA',
            'npdes_county_prefix' => '09',
            'timezone' => 'America/New_York',
            'phone' => '(215)345-7577',
            'address_1' => '1456 Ferry Road, Suite 704',
            'address_2' => 'Doylestown, PA 18901-5550',
            'county_code' => '42017',
            'fax' => '215-345-7584',
            'district' => 'BCCD',
            'manager' => 'Gretchen Schatschneider'
        ]);


        County::create([
            'id' => 2,
            'name' => 'Montgomery',
            'state' => 'Pennsylvania',
            'state_abbr' => 'PA',
            'npdes_county_prefix' => '46',
            'timezone' => 'America/New_York',
            'phone' => '610-489-4506',
            'address_1' => '143 Level Road',
            'address_2' => 'Collegeville, PA 19426-3313',
            'county_code' => '42091',
            'fax' => '610-489-9795',
            'district' => 'MCCD',
            'manager' => 'Jessica Buck'
        ]);


    }
}
