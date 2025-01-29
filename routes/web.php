<?php

use Illuminate\Support\Facades\Route;
use App\Models\ChildCareForm;
use App\Models\ComprehensiveSurvey;
use App\Models\PNEAEnrollment;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComprehensiveSurveyController;
use App\Http\Controllers\ChildCareFormController;
use App\Http\Controllers\VaccinationRecordController;
use App\Http\Controllers\VitaminASupplementationController;
use App\Http\Middleware\RefreshPageMiddleware;
use App\Http\Controllers\BeneficiariesController;
use App\Http\Controllers\MedicineListController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\DistributedMedicineController;
use App\Http\Controllers\PNEAEnrollmentController;
use App\Http\Controllers\GrowthMonitoringController;
use App\Http\Controllers\OptimumPracticeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserConfirmationController;

Route::inertia('/', 'Auth/Login' )->name('Login');
// Route::middleware(['auth', 'approved', 'admin'])->group(function () {
//     Route::get('/admin/pending-users', [AdminController::class, 'showPendingUsers'])->name('admin.pending-users');
//     Route::post('/admin/approve-user/{id}', [AdminController::class, 'approveUser'])->name('admin.approve-user');
//     Route::post('/admin/reject-user/{id}', [AdminController::class, 'rejectUser'])->name('admin.reject-user');
// });



Route::middleware(['auth', RefreshPageMiddleware::class])->group(function() {
    Route::inertia('/dashboard', 'Dashboard' )->name('dashboard');
    Route::get('/profile',[ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile',[ProfileController::class, 'updateInfo'])->name('profile.info');
    Route::put('/profile',[ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/users', [UserConfirmationController::class, 'index'])->name('users.index');

    Route::inertia('/gm', 'ChildCareForm/Gm')->name('gm');
    // -- ----- -- - - - --  - - - - - -  -- -  -- - - - --  - - - - - - - -//
    //User Confirmation
    Route::inertia('/user-confirmation', 'UserConfirmation/View')->name('user-confirmation');
    
    //Medicine
    Route::inertia('/medicine', 'Medicine')->name('medicine');
    Route::inertia('/beneficiaries-view', 'Medicine/Beneficiaries')->name('beneficiaries-view');
    Route::inertia('/beneficiaries-form', 'Medicine/BForm')->name('beneficiaries-form');
    Route::inertia('/medicine-list-view', 'Medicine/MedicineList')->name('medicine-list-view');
    Route::inertia('/medicine-list-form', 'Medicine/MedicineList')->name('medicine-list-form');
   
    //Save new data
    Route::post('/beneficiaries-form', [BeneficiariesController::class, 'store']);
    Route::post('/medicine-list-form', [MedicineListController::class, 'store']);
    Route::post('/distribution-form', [DistributionController::class, 'store']);

    //Retrieve all data
    Route::get('/beneficiaries-data', [BeneficiariesController::class, 'retrieve'])->name('beneficiaries-data');
    Route::get('/medicine-list-data', [MedicineListController::class, 'retrieve'])->name('medicine-list-data');
    Route::get('/distribution-data', [DistributionController::class, 'retrieve'])->name('distribution-data');
    Route::get('/medicine-list-distributed-data', [DistributedMedicineController::class, 'retrieve'])->name('medicine-list-distributed-data');
    //Edit specific data
    Route::get('/beneficiaries-edit/{id}', [BeneficiariesController::class, 'edit'])->name('beneficiaries-edit');
    Route::put('/beneficiaries/{id}', [BeneficiariesController::class, 'update'])->name('beneficiaries-update');
    Route::get('/medicine-list-edit/{id}', [MedicineListController::class, 'edit'])->name('medicine-list-edit');
    Route::put('/medicine-list/{id}', [MedicineListController::class, 'update'])->name('medicine-list-update');
    Route::get('/distribution-edit/{id}', [DistributionController::class, 'edit'])->name('distribution-edit');
    Route::put('/distribution/{id}', [DistributionController::class, 'update'])->name('distribution-update');
    Route::put('/medicine-list-distribute/{id}', [DistributedMedicineController::class, 'distribute'])->name('medicine-list-distribute');
    Route::put('/comprehensive-survey/{id}', [ComprehensiveSurveyController::class, 'update'])->name('comprehensive-survey-update');

    //Delete specific data
    Route::delete('/beneficiaries-delete/{id}', [BeneficiariesController::class, 'destroy'])->name('beneficiaries-delete');
    Route::delete('/medicine-list-delete/{id}', [MedicineListController::class, 'destroy'])->name('medicine-list-delete');

    //Comprehensive Survey
    Route::inertia('/comprehensive-survey', 'ComprehensiveSurvey/Form')->name('comprehensive-survey');
    Route::inertia('/comprehensive-survey-view', 'ComprehensiveSurvey/View')->name('comprehensive-survey-view');
    // Route::inertia('/comprehensive-survey/senior-citizen-list', 'ComprehensiveSurvey/SeniorCitizenList')->name('senior-citizen-list');
    // Route::inertia('/age-grouping', 'ComprehensiveSurvey/AgeGrouping')->name('age-grouping');
    
    //Save new data
    Route::post('/comprehensive-survey', [ComprehensiveSurveyController::class, 'survey']);
    
    //Retrieve all data
    Route::get('/comprehensive-survey-data', [ComprehensiveSurveyController::class, 'retrieve'])->name('comprehensive-survey-data');
    Route::get('/comprehensive-survey-data/{id}', [ComprehensiveSurveyController::class, 'show'])->name('comprehensive-survey-data.show');
    
    Route::inertia('/senior-citizen-view', 'SeniorCitizen/View')->name('senior-citizen-view');
    Route::get('/senior-citizen-data', [ComprehensiveSurveyController::class, 'seniorCitizen'])->name('senior-citizen-data');
    Route::get('/senior-citizen-count', [ComprehensiveSurveyController::class, 'seniorCitizenCount'])->name('senior-citizen-count');
    Route::inertia('/four-ps-view', 'FourPs/View')->name('four-ps-view');
    Route::get('/four-ps-data', [ComprehensiveSurveyController::class, 'fourPs'])->name('four-ps-data');
    Route::inertia('/pwd-view', 'PWD/View')->name('pwd-view');
    Route::get('/pwd-data', [ComprehensiveSurveyController::class, 'pwd'])->name('pwd-data');
    Route::inertia('/age-grouping-view', 'AgeGrouping/View')->name('age-grouping-view');
    
    // -- ----- -- - - - --  - - - - - -  -- -  -- - - - --  - - - - - - - -//

    // Child Care Form
    Route::inertia('childcare-form', 'ChildCareForm/Form')->name('childcare-form');
    Route::inertia('childcare-form-view', 'ChildCareForm/View')->name('childcare-form-view');
    // Route::inertia('childcare-form-show', 'ChildCareForm/Show')->name('childcare-form-show');
    // Route::inertia('childcare-form-show', 'ChildCareForm/Show')->name('childcare-form-show');
    //Save new data
    Route::post('/childcare-form', [ChildCareFormController::class, 'store']);

    //Retrieve all data
    Route::get('/childcare-data', [ChildCareFormController::class, 'retrieve'])->name('childcare-data');

    //Edit specific data
    Route::get('/childcare-form-edit/{id}', [ChildCareFormController::class, 'edit'])->name('childcare-form-edit');
    Route::put('/childcare-form-update/{id}', [ChildCareFormController::class, 'update'])->name('childcare-form-update');
    Route::delete('/childcare-form-delete/{id}', [ChildCareFormController::class, 'destroy'])->name('childcare-form-delete');
    
    //Retrieve details of specific data from a child
    Route::get('/child/{id}', [ChildCareFormController::class, 'show'])->name('child.show');
    Route::post('/child/{id}/addVac', [ChildCareFormController::class, 'addVac'])->name('child.addVac');
    Route::post('/child/{id}/addVitA', [ChildCareFormController::class, 'addVitA'])->name('child.addVitA');
    Route::post('/child/{id}/addCounseling', [ChildCareFormController::class, 'addCounseling'])->name('child.addCounseling');
    Route::post('/child/{id}/addGrowthMonitoring', [ChildCareFormController::class, 'addGrowthMonitoring'])->name('child.addGrowthMonitoring');
    Route::post('/child/{id}/addDevelopmentalScreening', [ChildCareFormController::class, 'addDevelopmentalScreening'])->name('child.addDevelopmentalScreening');
    Route::post('/child/{id}/addDeworming', [ChildCareFormController::class, 'addDeworming'])->name('child.addDeworming');
    Route::post('/child/{id}/addDental', [ChildCareFormController::class, 'addDental'])->name('child.addDental');
    //Route::get('/child/{id}', [ChildCareFormController::class, 'showVitA'])->name('child.showVitA');
    

    Route::put('/medicine-list-distribute/{id}', [DistributedMedicineController::class, 'distribute'])->name('medicine-list-distribute');

     // -- ----- -- - - - --  - - - - - -  -- -  -- - - - --  - - - - - - - -//

     // PNEA Enrollment
    Route::inertia('pnea-enrollment', 'PNEA/Form')->name('pnea-enrollment');
    Route::inertia('pnea-enrollment-view', 'PNEA/View')->name('pnea-enrollment-view');
    Route::inertia('optimum-practice', 'PNEA/OptimumPractice')->name('optimum-practice');
    //Save new data
    Route::post('/pnea-enrollment', [PNEAEnrollmentController::class, 'store'])->name('pnea-enrollment');
    // Route::post('/optimum-practices-data', [OptimumPracticeController::class, 'store']);

    //Retrieve all data
    Route::get('/pnea-enrollment-data', [PNEAEnrollmentController::class, 'retrieve'])->name('pnea-enrollment-data');
    
    
    //Edit specific data
    // Route::get('/maternal-care/{id}', [PNEAEnrollmentController::class, 'show'])->name('maternal-care.show');
    Route::get('/pnea-enrollment-edit/{id}', [PNEAEnrollmentController::class, 'edit'])->name('pnea-enrollment-edit');
    Route::put('/pnea-enrollment-update/{id}', [PNEAEnrollmentController::class, 'update'])->name('pnea-enrollment-update');
    Route::delete('/pnea-enrollment-delete/{id}', [PNEAEnrollmentController::class, 'destroy'])->name('pnea-enrollment-delete');

    //Retrieve details of specific data from pnea
    Route::get('/pnea/{id}', [PNEAEnrollmentController::class, 'show'])->name('pnea.show');
    Route::post('/pnea/{id}/addOptimumPractice', [PNEAEnrollmentController::class, 'addOptimumPractices'])->name('pnea.addOptimumPractice');


    // -- ----- -- - - - --  - - - - - -  -- -  -- - - - --  - - - - - - - -//
    //Growth Monitoring
    Route::inertia('/growth-monitoring', 'GrowthMonitoring/View')->name('growth-monitoring');
    Route::get('/growth-monitoring-data', [ChildCareFormController::class, 'showGrowthMonitoring'])->name('growth-monitoring-data');
    Route::get('/underweight', [GrowthMonitoringController::class, 'underweight'])->name('underweight');
    // -- ----- -- - - - --  - - - - - -  -- -  -- - - - --  - - - - - - - -//
    //Vaccination Record
    Route::inertia('/vaccination-record', 'VaccinationRecords/View')->name('vaccination-record');
    Route::get('/vaccination-record-data', [ChildCareFormController::class, 'showVaccinationRecord'])->name('vaccination-record-data');


    // -- ----- -- - - - --  - - - - - -  -- -  -- - - - --  - - - - - - - -//
    //Optimum Practice
    // Route::inertia('/optimum-practice', 'OptimumPractice/View')->name('optimum-practice');
    Route::get('/optimum-practice-data', [PNEAEnrollmentController::class, 'retrieveWithOptimumPractices'])->name('optimum-practice-data');
    Route::inertia('another-form', 'PNEA/AnotherForm')->name('another-form');

    Route::inertia('/form-2', 'PNEA/EnrollmentAndOptimumPractice')->name('form-2');


    // -- ----- -- - - - --  - - - - - -  -- -  -- - - - --  - - - - - - - -//
    //Calendar
    
    // Fetch all events
    Route::get('/events-data', [EventController::class, 'index']);

    // Store a new event
    Route::post('/events', [EventController::class, 'store']);
});

// Guest routes
Route::middleware(['guest', RefreshPageMiddleware::class])->group(function() { 
    Route::inertia('/register', 'Auth/Register' )->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::inertia('/login', 'Auth/Login' )->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});



