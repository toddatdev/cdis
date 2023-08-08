<?php

use App\Models\Reviewer\Reviewer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reviewers')->truncate();
        Reviewer::create([
            'id' => 1,
            'name' => 'Jeff McKenna',
            'title' => 'Resource Conservationist',
            'email' => 'JMcKenna@montgomeryconservation.org',
            'initials' => 'JM',
            'district' => 'MCCD',
            'extension' => 16,
            'signature' => 'data:image/png;base64,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',
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 2,
            'name' => 'Dan Oskiera',
            'title' => 'Resource Conservationist',
            'email' => 'DOskiera@montgomeryconservation.org',
            'initials' => 'DO',
            'district' => 'MCCD',
            'extension' => 17,
            'signature' => '',
            'is_active' => 0
        ]);


        Reviewer::create([
            'id' => 3,
            'name' => 'Karen Thompson',
            'title' => 'Administrative Assistant',
            'email' => 'KThompson@montgomeryconservation.org',
            'initials' => 'KT',
            'district' => 'MCCD',
            'extension' => 10,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 4,
            'name' => 'Gus Meyer',
            'title' => 'District Manager',
            'email' => 'GMeyer@montgomeryconservation.org',
            'initials' => 'GM',
            'district' => 'MCCD',
            'extension' => 22,
            'is_active' => 0
        ]);


        Reviewer::create([
            'id' => 5,
            'name' => 'Eric Konzelmann',
            'title' => 'Assistant District Manager',
            'email' => 'EKonzelmann@montgomeryconservation.org',
            'initials' => 'EK',
            'district' => 'MCCD',
            'extension' => 21,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 6,
            'name' => 'Cody Schmoyer',
            'title' => 'Resource Conservationist',
            'email' => 'cschmoyer@montgomeryconservation.org',
            'initials' => 'CS',
            'district' => 'MCCD',
            'extension' => 19,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 7,
            'name' => 'Cathy Leonard',
            'title' => 'Resource Conservationist',
            'email' => 'cleonard@montgomeryconservation.org',
            'initials' => 'CL',
            'district' => 'MCCD',
            'extension' => 13,
            'is_active' => 0
        ]);


        Reviewer::create([
            'id' => 8,
            'name' => 'Gary Kulp',
            'title' => 'District Professional Engineer',
            'email' => 'GKulp@montgomeryconservation.org',
            'initials' => 'GK',
            'district' => 'MCCD',
            'extension' => 18,
            'is_active' => 0
        ]);


        Reviewer::create([
            'id' => 9,
            'name' => 'Jessica Buck',
            'title' => 'Acting District Manager',
            'email' => 'JBuck@montgomeryconservation.org',
            'initials' => 'JB',
            'district' => 'MCCD',
            'extension' => 14,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 10,
            'name' => 'Krista Scheirer',
            'title' => 'Watershed Specialist',
            'email' => 'KScheirer@montgomeryconservation.org',
            'initials' => 'KS',
            'district' => 'MCCD',
            'extension' => 0,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 11,
            'name' => 'Gretchen Schatschneider',
            'title' => 'District Manager',
            'email' => 'gschatschneider@bucksccd.org',
            'initials' => 'GS',
            'district' => 'BCCD',
            'extension' => 106,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 12,
            'name' => 'Rene Moyer',
            'title' => 'Chapter 102/NPDES Administrator',
            'email' => 'rmoyer@bucksccd.org',
            'initials' => 'RM',
            'district' => 'BCCD',
            'extension' => 110,
            'signature' => 'data:image/png;base64,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',
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 13,
            'name' => 'Rich Krasselt',
            'title' => 'Environmental Protection Specialist I',
            'email' => 'Rkrasselt@bucksccd.org',
            'initials' => 'RK',
            'district' => 'BCCD',
            'extension' => 109,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 25,
            'name' => 'Olivia Rush',
            'title' => 'Agricultural Conservation Technician\r\n',
            'email' => 'orush@bucksccd.org',
            'initials' => 'OR',
            'district' => 'BCCD',
            'extension' => 101,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 18,
            'name' => 'Meghan Rogalus',
            'title' => 'Watershed Specialist',
            'email' => 'mrogalus@bucksccd.org',
            'initials' => 'MR',
            'district' => 'BCCD',
            'extension' => 106,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 20,
            'name' => 'Morgan Schuster',
            'title' => 'Erosion and Sediment Control Technician ',
            'email' => 'mschuster@bucksccd.org',
            'initials' => 'MS',
            'district' => 'BCCD',
            'extension' => 108,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 21,
            'name' => 'Elaine Crunkleton',
            'title' => 'Receptionist',
            'email' => '',
            'initials' => 'EC',
            'district' => 'BCCD',
            'extension' => 100,
            'is_active' => 0
        ]);


        Reviewer::create([
            'id' => 22,
            'name' => 'Kelly Steelman',
            'title' => 'Erosion & Sediment Control Technician',
            'email' => 'ksteelman@bucksccd.org',
            'initials' => 'KS',
            'district' => 'BCCD',
            'extension' => 102,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 23,
            'name' => 'RTBCCD RTBCCD',
            'title' => 'Programmer & Tester',
            'email' => 'test@tester.com',
            'initials' => 'RR',
            'district' => 'BCCD',
            'extension' => 123,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 28,
            'name' => 'Eric Miller',
            'title' => 'District Manager',
            'email' => 'emiller@montgomeryconservation.org',
            'initials' => 'EM',
            'district' => 'MCCD',
            'extension' => 22,
            'is_active' => 0
        ]);


        Reviewer::create([
            'id' => 29,
            'name' => 'Shannon Healey',
            'title' => 'Resource Conservationist',
            'email' => 'shealey@montgomeryconservation.org',
            'initials' => 'SH',
            'district' => 'MCCD',
            'extension' => 13,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 30,
            'name' => 'Ruth Heil',
            'title' => 'Administrative Assistant',
            'email' => 'rheil@montgomeryconservation.org',
            'initials' => 'RH',
            'district' => 'MCCD',
            'extension' => 20,
            'is_active' => 0
        ]);


        Reviewer::create([
            'id' => 31,
            'name' => 'Rachel Hendricks',
            'title' => 'Resource Conservationist',
            'email' => 'rhendricks@montgomeryconservation.org',
            'initials' => 'RH',
            'district' => 'MCCD',
            'extension' => 17,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 33,
            'name' => 'Rachel Onuska',
            'title' => 'Receptionist',
            'email' => 'ronuska@bucksccd.org',
            'initials' => 'RO',
            'district' => 'BCCD',
            'extension' => 104,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 34,
            'name' => 'Carl Hollenback',
            'title' => 'Watershed Specialist',
            'email' => 'CHollenback@montgomeryconservation.org',
            'initials' => 'CH',
            'district' => 'MCCD',
            'extension' => 0,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 35,
            'name' => 'Brian Vadino',
            'title' => 'Watershed Specialist',
            'email' => 'bvadino@montgomeryconservation.org',
            'initials' => 'BV',
            'district' => 'MCCD',
            'extension' => 15,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 27,
            'name' => 'Jason Maurer',
            'title' => 'Erosion and Sediment Control Technician',
            'email' => 'jmaurer@bucksccd.org',
            'initials' => 'JM',
            'district' => 'BCCD',
            'extension' => 105,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 36,
            'name' => 'Sue Seykot',
            'title' => 'Clerical Assistant',
            'email' => 'sseykot@bucksccd.org',
            'initials' => 'SS',
            'district' => 'BCCD',
            'extension' => 101,
            'is_active' => 1
        ]);


        Reviewer::create([
            'id' => 37,
            'name' => 'Alyssa Linker',
            'title' => 'Administrative Assistant',
            'email' => 'alinker@montgomeryconservation.org',
            'initials' => 'AL',
            'district' => 'MCCD',
            'extension' => 20,
            'is_active' => 1
        ]);
    }
}
