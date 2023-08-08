<?php

use App\Models\Project\ProjectFile;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Project\Project;
use App\Models\Project\ProjectDetail;
use App\Models\Project\ProjectEngineer;
use App\Models\Project\ProjectLocation;
use App\Models\Project\ProjectPermit;
use App\Models\Transaction\Transaction;
use Illuminate\Support\Facades\Route;


/***
 * TMP Logs Routes
 */

Route::get('/audits/{id}', function ($projectId) {

    $location = ProjectLocation::where('project_id', $projectId)->first();

    $locationAudits = $location->audits ?? [];

    $project = Project::where('id', $projectId)->first();
    $projectAudits = $project->audits ?? [];

    $projectDetails = ProjectDetail::where('project_id', $projectId)->first();
    $detailsAudits = $projectDetails->audits ?? [];

    $project = ProjectEngineer::where('project_id', $projectId)->first();
    $engineerAudits = $project->audits ?? [];

    $project = ProjectPermit::where('project_id', $projectId)->first();
    $permitAudits = $project->audits ?? [];

    $project = Transaction::where('project_id', $projectId)->first();

    $feeAudits = $project->audits ?? [];


    /*    $project = ProjectFile::where('project_id', $projectId)->first();
        $fileAudits = $project->audits;*/


    return view('audits', compact('projectAudits', 'locationAudits', 'detailsAudits', 'engineerAudits', 'permitAudits', 'feeAudits'));

})->name('project.changelog');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

//image resources routes
Route::resource('images', 'Project\ProjectFilesController', ['only' => ['store', 'destroy']]);

//generates npdes number
Route::post('npdes', 'Project\ProjectController@generate_npdes_number');

//Get Coordinates for Project Location
Route::post('coordinates', 'Project\ProjectLocationsController@getCoordinates');

//get longitute and latitude for Map pins
Route::get('/long-lat/{type}', 'DashboardController@getLongLatInfo');

//Download Inspection report without login
Route::get('inspections/report/download/{project_id}/{auth_code}', 'Inspection\InspectionReportController@download')->name('inspection.report.download');

//Download letter report with auth and project id
Route::get('letters/download/{project_id}/{auth_code}', 'Letter\LetterController@download')->name('letters.download');

Route::group(['middleware' => ['auth', 'inactive']], static function () {
    /***
     * Dashboard Routes
     */
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('long-lat', 'DashboardController@getLongLatInfo');

    /***
     *  Projects Routes
     */
    Route::group(['namespace' => 'Project', 'prefix' => 'projects'], function () {

        Route::get('search', 'ProjectSearchController@index')->name('projects.search.index');
        Route::post('search', 'ProjectSearchController@search')->name('projects.search');

        Route::get('create', 'ProjectController@index')->name('projects.show');
        Route::get('{id}/edit', 'ProjectController@index')->name('projects.edit');
        Route::post('/', 'ProjectController@store')->name('projects.store');
        Route::post('close', 'ProjectController@close')->name('projects.close');
        Route::get('activate/{id}', 'ProjectController@activate')->name('projects.activate');
        Route::get('npdes-number/{:projectId}', 'ProjectController@npdesNumber');

        Route::post('details/store', 'ProjectDetailsController@store')->name('projects.details.store');
        Route::get('permittee/{id}', 'ProjectPermitteeController@show')->name('projects.permittee.show');
        Route::post('permittee/store', 'ProjectPermitteeController@store')->name('projects.permittee.store');
        Route::post('permittee/{project_id}/{permittee_id}/update', 'ProjectPermitteeController@update')->name('projects.permittee.update');
        Route::post('location/store', 'ProjectLocationsController@store')->name('project.locations.store');
        Route::post('coordinates', 'ProjectLocationsController@getCoordinates')->name('coordinates');


        Route::post('applicant/store', 'ProjectApplicantsController@store')->name('project.applicants.store');
        Route::get('{project_id}/applicant/{applicant_id}/destroy', 'ProjectApplicantsController@destroy')->name('project.applicants.destroy');
        Route::post('engineer/store', 'ProjectEngineersController@store')->name('project.engineers.store');
        Route::post('permit/store', 'ProjectPermitsController@store')->name('project.permits.store');
        Route::get('time/{project_id}', 'ProjectTimesController@show')->name('projects.time.show');
        Route::get('time/single/{time_id}', 'ProjectTimesController@getSingleTimeDetails')->name('projects.time.single.show');
        Route::post('time/store', 'ProjectTimesController@store')->name('projects.time.store');
        Route::post('time/{time_id}/update', 'ProjectTimesController@update')->name('projects.time.update');
        Route::get('{project_id}/time/{time_id}/destroy', 'ProjectTimesController@destroy')->name('projects.time.destroy');


        Route::post('fees/store', 'TransactionsController@storeFee')->name('project.fees.store');
        Route::get('fees/{project_id}', 'TransactionsController@indexFees')->name('project.fees.index');
        Route::post('/{project_id}/fees/{fee_id}/update', 'TransactionsController@updateFee')->name('project.fees.update');
        Route::get('/{project_id}/fees/{fee_id}/destroy', 'TransactionsController@destroyFee')->name('project.fees.destroy');

        Route::post('reviews/store', 'TransactionsController@storeReview')->name('project.reviews.store');
        Route::get('reviews/{project_id}', 'TransactionsController@indexReviews')->name('project.reviews.index');
        Route::post('/{project_id}/reviews/{review_id}/update', 'TransactionsController@updateReview')->name('project.reviews.update');
        Route::get('/{project_id}/reviews/{review_id}/destroy', 'TransactionsController@destroyReview')->name('project.reviews.destroy');

        Route::get('file/{id}/download', 'ProjectFilesController@download')->name('project.file.download');
        Route::post('file/store', 'ProjectFilesController@store')->name('project.file.store');
        Route::post('memo/store', 'ProjectController@storeMemo')->name('projects.memo.store');
        Route::get('{projectId}/file/{fileId}/destroy', 'ProjectFilesController@destroy')->name('project.file.destroy');

    });

    /***
     * Contact Routes
     */
    Route::group(['namespace' => 'Contact'], function () {

        Route::get('contacts', 'ContactController@index')->name('contacts.search.index');
        Route::post('contacts/search', 'ContactController@search')->name('contacts.search');
        Route::get('contacts/{type}/{id}', 'ContactController@getContact')->name('contacts.get');
        Route::get('contacts/status/update/{id}', 'ContactController@updateStatus')->name('contacts.status.update');

        Route::post('contacts/create', 'ContactController@create')->name('contacts.create');
        Route::post('contacts/{id}/update', 'ContactController@update')->name('contacts.update');

    });

    /***
     * Reviewers Routes
     */
    Route::group(['namespace' => 'Reviewer'], function () {

        Route::get('reviewers/signatures', 'ReviewersController@index')->name('reviewers.signatures');
        Route::get('reviewers/{id}/show', 'ReviewersController@show')->name('reviewers.show');
        Route::post('reviewers/{id}/upload', 'ReviewersController@uploadSignature')->name('reviewers.sig.upload');
        Route::post('reviewers/{id}/update', 'ReviewersController@updateSignature')->name('reviewers.update');

    });


    /***
     * Letter Generation Routes
     */
    Route::group(['namespace' => 'Letter'], function () {

        Route::get('letters/{id?}', 'LetterController@index')->name('letter.show');
        Route::post('letters/generate', 'LetterController@generate')->name('letter.generate');
        Route::get('letters/download/{url}', 'LetterController@download')->where('url', '(.*)')
            ->name('letter.download');
    });

    /** Get letter template based on it's type **/
    Route::get('get-letter-template/{type?}', function ($type = 'adequate_indiv_npdes_authorization') {

        if ($type === 'adequate_close_to_1_acre') {
            return '';
        }
        return (string)View::make('letters.' . $type);
    });


    /***
     * Site Inspection Routes
     */
    Route::group(['namespace' => 'Inspection'], function () {

        Route::get('inspections/{id?}', 'InspectionController@index')->name('site.inspection');
        Route::post('inspections/store', 'InspectionController@store')->name('inspection.info.store');

        Route::post('inspections/permit/store', 'InspecPermitController@store')->name('inspection.permit.store');
        Route::post('inspections/findings/store', 'InspecFindingsController@store')->name('inspection.findings.store');

        Route::post('inspections/report/email', 'InspectionReportController@email')->name('inspection.report.email');

    });


    /***
     * Reports Routes
     */
    Route::group(['namespace' => 'Report'], function () {

        Route::get('reports', 'ReportsController@index')->name('reports');
        Route::post('reports/generate', 'ReportsController@generate')->name('reports.generate');
        Route::get('reports/{project_id}/time/xls/download', 'TimeReportController@downloadXLSReport')->name('reports.xls.download');
        Route::get('reports/{project_id}/time/pdf/download', 'TimeReportController@downloadPDFReport')->name('reports.pdf.download');

    });


    /***
     * User Settings & Admin controllers
     */

    Route::get('admin', 'Auth\UserController@admin')->name('admin');
    Route::get('settings', 'Auth\UserController@index')->name('settings');
    Route::post('settings', 'Auth\UserController@update')->name('user.update');
    Route::get('deactivate/{id}', 'Auth\UserController@deactivate')->name('user.deactivate');
    Route::get('activate/{id}', 'Auth\UserController@activate')->name('user.activate');

    /***
     * Settings Routes
     */
    Route::group(['prefix' => 'settings'], function () {

        Route::get('engineers', 'Engineer\EngineersController@index')->name('engineers.index');
//        Route::get('co-applicants', 'CoApplicant\CoApplicantsController@index')->name('co.applicants.index');

    });
});


Route::get('/logout', 'Auth\UserController@logout')->name('users.logout');

/***
 * User Authentication Routes
 * @description User Registration functionality disabled by using false
 * @description User Registration functionality disabled by using false
 */
Auth::routes(['register' => false, 'logout' => false]);
