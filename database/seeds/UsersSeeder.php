<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::where('id', '>', 1)->delete();


        User::create( [
            'id'=>'1',
            'county_id'=>1,
            'first_name'=>'Chris',
            'last_name'=>'Cook',
            'username'=>'ccook',
            'icis_username'=>'',
            'email'=>'ccook@bucksccd.org',
            'role'=>'programmer',
            'is_logged_in'=>1,
            'password'=> bcrypt('ellaBle29$'),
            'is_active'=>1
        ] );


        User::create( [
            'id'=>'2',
            'county_id'=>2,
            'first_name'=>'Janel',
            'last_name'=>'Fishpaw',
            'username'=>'JFishpaw',
            'icis_username'=>'',
            'email'=>'JFishpaw@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>1,
            'password'=> bcrypt('kuY&753'),
            'is_active'=>1
        ]);



        User::create( [
            'id'=>'10000',
            'county_id'=>2,
            'first_name'=>'Jessica',
            'last_name'=>'Buck',
            'username'=>'JBuck',
            'icis_username'=>'',
            'email'=>'jbuck@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>1,
            'password'=> bcrypt('modoSky789'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'10004',
            'county_id'=>2,
            'first_name'=>'Jeff',
            'last_name'=>'McKenna',
            'username'=>'JMcKenn',
            'icis_username'=>'',
            'email'=>'JMcKenna@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>1,
            'password'=> bcrypt('entr4nt#4'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'10005',
            'county_id'=>2,
            'first_name'=>'Gary',
            'last_name'=>'Kulp',
            'username'=>'GKulp',
            'icis_username'=>'',
            'email'=>'xrunrfmv@sharklasers.com',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('fro2t#9'),
            'is_active'=>1
        ] );


        User::create( [
            'id'=>'10010',
            'county_id'=>2,
            'first_name'=>'Dan',
            'last_name'=>'Oskiera',
            'username'=>'DOskie',
            'icis_username'=>'',
            'email'=>'DOskiera@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('ssssssssss'),
            'is_active'=>0
        ] );



        User::create( [
            'id'=>'10011',
            'county_id'=>2,
            'first_name'=>'Karen',
            'last_name'=>'Thompson',
            'username'=>'KThomps',
            'icis_username'=>'xkthomps',
            'email'=>'kthompson@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>1,
            'password'=> bcrypt('eag7e#2'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'10012',
            'county_id'=>2,
            'first_name'=>'Gus',
            'last_name'=>'Meyer',
            'username'=>'gmeyer',
            'icis_username'=>'',
            'email'=>'gmeyer@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('ssssssssss'),
            'is_active'=>0
        ] );



        User::create( [
            'id'=>'10013',
            'county_id'=>2,
            'first_name'=>'Eric',
            'last_name'=>'Konzelmann',
            'username'=>'EKonzelm',
            'icis_username'=>'',
            'email'=>'EKonzelmann@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('fa7coN#5'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'10014',
            'county_id'=>2,
            'first_name'=>'Cody',
            'last_name'=>'Schmoyer',
            'username'=>'CSchmoy',
            'icis_username'=>'xcschmoy',
            'email'=>'cschmoyer@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('ali3n#51'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'10015',
            'county_id'=>2,
            'first_name'=>'Cathy',
            'last_name'=>'Leonard',
            'username'=>'CLeonar',
            'icis_username'=>'',
            'email'=>'cleonard@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('ssssssssss'),
            'is_active'=>0
        ] );


        User::create( [
            'id'=>'11111',
            'county_id'=>2,
            'first_name'=>'Andrew',
            'last_name'=>'Fenstermacher',
            'username'=>'AFenstermacher',
            'icis_username'=>'',
            'email'=>'afenstermacher@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('dwq#951'),
            'is_active'=>1
        ] );


        User::create( [
            'id'=>'11689',
            'county_id'=>2,
            'first_name'=>'Gary',
            'last_name'=>'Kulp',
            'username'=>'GKulp',
            'icis_username'=>'',
            'email'=>'GKulp@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('tobedeletedasdup'),
            'is_active'=>0
        ] );



        User::create( [
            'id'=>'12160',
            'county_id'=>2,
            'first_name'=>'Eric',
            'last_name'=>'Miller',
            'username'=>'EMiller',
            'icis_username'=>'',
            'email'=>'emiller@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('ssssssssss'),
            'is_active'=>0
        ] );



        User::create( [
            'id'=>'12195',
            'county_id'=>2,
            'first_name'=>'Rachel',
            'last_name'=>'Hendricks',
            'username'=>'rhendricks',
            'icis_username'=>'',
            'email'=>'rhendricks@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>1,
            'password'=> bcrypt('skci#W337'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'12199',
            'county_id'=>2,
            'first_name'=>'Ruth',
            'last_name'=>'Heil',
            'username'=>'rheil',
            'icis_username'=>'xrheil',
            'email'=>'rheil@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('ssssssssss'),
            'is_active'=>0
        ] );



        User::create( [
            'id'=>'12214',
            'county_id'=>2,
            'first_name'=>'Shannon ',
            'last_name'=>'Healey',
            'username'=>'SHealey',
            'icis_username'=>'',
            'email'=>'shealey@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('heal21$CCD'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'31',
            'county_id'=>1,
            'first_name'=>'Gretchen',
            'last_name'=>'Schatschneider',
            'username'=>'sgretchen',
            'icis_username'=>'xgschats',
            'email'=>'gschatschneider@bucksccd.org',
            'role'=>'programmer',
            'is_logged_in'=>1,
            'password'=> bcrypt('iizz'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'35',
            'county_id'=>1,
            'first_name'=>'Rene',
            'last_name'=>'Moyer',
            'username'=>'mrene',
            'icis_username'=>'xgschats',
            'email'=>'rmoyer@bucksccd.org',
            'role'=>'programmer',
            'is_logged_in'=>1,
            'password'=> bcrypt('uuxx'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'36',
            'county_id'=>1,
            'first_name'=>'Rich',
            'last_name'=>'Krasselt',
            'username'=>'krich',
            'icis_username'=>'xgschats',
            'email'=>'Rkrasselt@bucksccd.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('qqbb'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'49',
            'county_id'=>1,
            'first_name'=>'Meghan',
            'last_name'=>'Rogalus',
            'username'=>'rmeghan',
            'icis_username'=>'xgschats',
            'email'=>'mrogalus@bucksccd.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('ffvv'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'444',
            'county_id'=>1,
            'first_name'=>'Tori',
            'last_name'=>'Jones Long',
            'username'=>'tjoneslong',
            'icis_username'=>'',
            'email'=>'tjoneslong@bucksccd.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('wqrU*#11'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'51',
            'county_id'=>1,
            'first_name'=>'Morgan',
            'last_name'=>'Schuster',
            'username'=>'smorgan',
            'icis_username'=>'xgschats',
            'email'=>'mschuster@bucksccd.org',
            'role'=>'programmer',
            'is_logged_in'=>1,
            'password'=> bcrypt('hhll'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'52',
            'county_id'=>1,
            'first_name'=>'Elaine',
            'last_name'=>'Crunkleton',
            'username'=>'celaine',
            'icis_username'=>'xgschats',
            'email'=>'yqltaxzd@sharklasers.com',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('000000001'),
            'is_active'=>0
        ] );



        User::create( [
            'id'=>'55',
            'county_id'=>1,
            'first_name'=>'Kelly',
            'last_name'=>'Steelman',
            'username'=>'skelly',
            'icis_username'=>'xgschats',
            'email'=>'ksteelman@bucksccd.org',
            'role'=>'programmer',
            'is_logged_in'=>1,
            'password'=> bcrypt('wwrr'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'60',
            'county_id'=>1,
            'first_name'=>'Jason',
            'last_name'=>'Maurer',
            'username'=>'JMaure',
            'icis_username'=>'xgschats',
            'email'=>'jmaurer@bucksccd.org',
            'role'=>'programmer',
            'is_logged_in'=>1,
            'password'=> bcrypt('g3sturE5@'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'61',
            'county_id'=>1,
            'first_name'=>'Olivia',
            'last_name'=>'Rush',
            'username'=>'orush',
            'icis_username'=>'xgschats',
            'email'=>'orush@bucksccd.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('0000000001'),
            'is_active'=>0
        ] );



        User::create( [
            'id'=>'62',
            'county_id'=>1,
            'first_name'=>'Gennie',
            'last_name'=>'Ferguson',
            'username'=>'fgennie',
            'icis_username'=>'',
            'email'=>'okfyrplc@sharklasers.com',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('ferG#22'),
            'is_active'=>0
        ] );



        User::create( [
            'id'=>'63',
            'county_id'=>1,
            'first_name'=>'Rachel',
            'last_name'=>'Onuska',
            'username'=>'ronuska',
            'icis_username'=>'xgschats',
            'email'=>'roniska@bucksccd.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('h@wkeyer!'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'64',
            'county_id'=>1,
            'first_name'=>'Sue',
            'last_name'=>'Seykot',
            'username'=>'sseykot',
            'icis_username'=>'xgschats',
            'email'=>'sseykot@bucksccd.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('tok!556'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'65',
            'county_id'=>1,
            'first_name'=>'Marilyn',
            'last_name'=>'Laurelli',
            'username'=>'lmarilyn',
            'icis_username'=>'',
            'email'=>'reception@bucksccd.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('elliD77'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'99996',
            'county_id'=>2,
            'first_name'=>'Carl',
            'last_name'=>'Hollenback',
            'username'=>'chollenback',
            'icis_username'=>'chollenback',
            'email'=>'chollenback@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>1,
            'password'=> bcrypt('Maja8306'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'99997',
            'county_id'=>2,
            'first_name'=>'Alyssa',
            'last_name'=>'Linker',
            'username'=>'alinker',
            'icis_username'=>'xalinker',
            'email'=>'alinker@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>1,
            'password'=> bcrypt('Cup00534?'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'99999',
            'county_id'=>2,
            'first_name'=>'Brian',
            'last_name'=>'Vadino',
            'username'=>'bvadino',
            'icis_username'=>'',
            'email'=>'bvadino@montgomeryconservation.org',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('Adi556!'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'999995',
            'county_id'=>2,
            'first_name'=>'CDIS',
            'last_name'=>'Admin_One',
            'username'=>'RTMCCD1',
            'icis_username'=>'',
            'email'=>'rprtzfqu@sharklasers.com',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('EvilNoses'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'999996',
            'county_id'=>1,
            'first_name'=>'CDIS',
            'last_name'=>'Admin_One',
            'username'=>'RTBCCD1',
            'icis_username'=>'xgschats',
            'email'=>'fkwxpuqd@sharklasers.com',
            'role'=>'programmer',
            'is_logged_in'=>1,
            'password'=> bcrypt('d3Y$oJ22K'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'999997',
            'county_id'=>2,
            'first_name'=>'CDIS',
            'last_name'=>'Admin_Two',
            'username'=>'RTBCCD2',
            'icis_username'=>'',
            'email'=>'fffqkmlh@sharklasers.com',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('EvilNose2'),
            'is_active'=>1
        ] );



        User::create( [
            'id'=>'999998',
            'county_id'=>1,
            'first_name'=>'John',
            'last_name'=>'Tester',
            'username'=>'JTester',
            'icis_username'=>'xgschats',
            'email'=>'jfpaztea@sharklasers.com',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('9922'),
            'is_active'=>0
        ] );



        User::create( [
            'id'=>'999999',
            'county_id'=>1,
            'first_name'=>'CDIS',
            'last_name'=>'Admin_Two',
            'username'=>'RTMCCD2',
            'icis_username'=>'',
            'email'=>'mljnrmim@sharklasers.com',
            'role'=>'programmer',
            'is_logged_in'=>0,
            'password'=> bcrypt('EvilNose2'),
            'is_active'=>1
        ] );


    }
}
