<?php

use App\Models\Project\Project;
use App\Models\Project\ProjectApplicant;
use App\Models\Project\ProjectDetail;
use App\Models\Project\ProjectDetailNasics;
use App\Models\Project\ProjectEngineer;
use App\Models\Project\ProjectFee;
use App\Models\Project\ProjectLocation;
use App\Models\Project\ProjectPermit;
use App\Models\Project\ProjectPermittee;
use App\Models\Project\ProjectReview;
use App\Models\Project\ProjectTime;
use App\ProjectFile;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Seed Reviewer Table
        (new  ReviewersSeeder())->run();

        //Seed Counties Table
        (new CountiesSeeder())->run();

        //seed states table
        (new StatesSeeder())->run();

        (new UsersSeeder())->run();

//        factory(User::class, 1)->create();


        return;
        $users = factory(User::class, 1)->create()
            ->each(function ($user) {

                $project = factory(Project::class, 20)->make();

                $projects = $user->projects()->saveMany($project);

                $projects->each(function ($project) {

                    //project Details Seeder
                    $project_details = factory(ProjectDetail::class, 1)->make();
                    $project_details = $project->projectDetails()->saveMany($project_details);


                    //Project Details Nasics
                    $project_details->each(function ($project_detail) {

                        $nasics = factory(ProjectDetailNasics::class, 3)->make();
                        $project_detail->nasics()->saveMany($nasics);
                    });

                    //Project Permittee
                    $project_permittee = factory(ProjectPermittee::class, 1)->make();
                    $project->permittee()->saveMany($project_permittee);

                    //project Time (Permit Info Tab)
                    $project_time = factory(ProjectTime::class, 1)->make();
                    $project->time()->saveMany($project_time);

                    //project Files
                    $project_file = factory(ProjectFile::class, 10)->make();
                    $project->files()->saveMany($project_file);


                    //Project Location
                    $project_location = factory(ProjectLocation::class, 1)->make();
                    $project->ProjectLocation()->saveMany($project_location);


                    //Project Applicants
                    $project_applicant = factory(ProjectApplicant::class, 3)->make();
                    $project->projectApplicants()->saveMany($project_applicant);

                    //Project Engineers
                    $project_engineer = factory(ProjectEngineer::class, 1)->make();
                    $project->projectEngineer()->saveMany($project_engineer);

                    $project_permit = factory(ProjectPermit::class, 1)->make();
                    $project->projectPermit()->saveMany($project_permit);

                    $project_fee = factory(ProjectFee::class, 1)->make();
                    $project->projectFee()->saveMany($project_fee);

                    $project_review = factory(ProjectReview::class, 1)->make();
                    $project->projectReview()->saveMany($project_review);

                });
            });
    }
}
