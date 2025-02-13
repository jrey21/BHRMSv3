<?php

use Illuminate\Support\Facades\Route;
use App\Models\AuditLog;
use App\Http\Controllers\{
    AuthController, ComprehensiveSurveyController, ChildCareFormController, 
    VaccinationRecordController, VitaminASupplementationController, 
    BeneficiariesController, MedicineListController, DistributionController, 
    DistributedMedicineController, PNEAEnrollmentController, GrowthMonitoringController, 
    PregnancyPeriodController, EventController, ProfileController, SeniorEventController, 
    ClaimController, QRScanController, ScanController, ScannedCodeController, 
    UserController, AuditLogController
};
use App\Http\Middleware\{RefreshPageMiddleware, PositionMiddleware, AdminMiddleware};

// Authentication Routes
Route::inertia('/', 'Auth/Login')->name('Login');
Route::middleware(['guest', RefreshPageMiddleware::class])->group(function() { 
    Route::inertia('/register', 'Auth/Register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::inertia('/login', 'Auth/Login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);

});


// User Management Routes
// Route::middleware(['auth'])->group(function () {
//     Route::inertia('user-management', 'UserManagement/View')->name('user-management');
// });

// Profile Routes
Route::middleware(['auth', RefreshPageMiddleware::class])->group(function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::middleware([AdminMiddleware::class])->group(function() {
        Route::inertia('/dashboard', 'Dashboard')->name('dashboard');

        // User Management
        Route::inertia('user-management', 'Views/UserManagement')->name('user-management');

        //Confirm Users
        Route::inertia('confirm-users', 'Auth/AdminUsers')->name('confirm-users');

        //Delete functions
        Route::delete('/childcare-form-delete/{id}', [ChildCareFormController::class, 'destroy'])->name('childcare-form-delete');
        Route::delete('/pnea-enrollment-delete/{id}', [PNEAEnrollmentController::class, 'destroy'])->name('pnea-enrollment-delete');
        Route::delete('/survey-delete/{id}', [ComprehensiveSurveyController::class, 'destroy'])->name('survey-delete');
        Route::delete('/event-delete/{id}', [SeniorEventController::class, 'destroy'])->name('event-delete');
        
    });
    Route::inertia('/userDashboard', 'UserDashboard')->name('userDashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'updateInfo'])->name('profile.info');
    Route::put('/profile', [ProfileController::class, 'updatePassword'])->name('profile.password');
    
    Route::get('/redirect-dashboard', function() {
        if (auth()->user()->position == 'health worker') {
            return redirect()->route('userDashboard');
        }
        return redirect()->route('dashboard');
    })->name('redirect-dashboard');

    
    Route::get('/audit-logs', function () {
        return AuditLog::latest()->get();
    });
    
});

// Child Care Form Routes
Route::middleware(['auth', RefreshPageMiddleware::class])->group(function() {
    Route::inertia('childcare-form', 'ChildCareForm/Form')->name('childcare-form');
    Route::inertia('childcare-form-view', 'Views/ChildCareForm')->name('childcare-form-view');
    Route::post('/childcare-form', [ChildCareFormController::class, 'store']);
    Route::get('/childcare-data', [ChildCareFormController::class, 'retrieve'])->name('childcare-data');
    Route::get('/childcare-form-edit/{id}', [ChildCareFormController::class, 'edit'])->name('childcare-form-edit');
    Route::put('/childcare-form-update/{id}', [ChildCareFormController::class, 'update'])->name('childcare-form-update');

    Route::get('/child-zone-data', [ChildCareFormController::class, 'retrieveAndSortZones'])->name('child-zone-data');
    Route::get('/child/{id}', [ChildCareFormController::class, 'show'])->name('child.show');
    Route::post('/child/{id}/addVac', [ChildCareFormController::class, 'addVac'])->name('child.addVac');
    Route::post('/child/{id}/addVitA', [ChildCareFormController::class, 'addVitA'])->name('child.addVitA');
    Route::post('/child/{id}/addCounseling', [ChildCareFormController::class, 'addCounseling'])->name('child.addCounseling');
    Route::post('/child/{id}/addGrowthMonitoring', [ChildCareFormController::class, 'addGrowthMonitoring'])->name('child.addGrowthMonitoring');
    Route::post('/child/{id}/addDevelopmentalScreening', [ChildCareFormController::class, 'addDevelopmentalScreening'])->name('child.addDevelopmentalScreening');
    Route::post('/child/{id}/addDeworming', [ChildCareFormController::class, 'addDeworming'])->name('child.addDeworming');
    Route::post('/child/{id}/addDental', [ChildCareFormController::class, 'addDental'])->name('child.addDental');




});

// PNEA Enrollment Routes
Route::middleware(['auth', RefreshPageMiddleware::class])->group(function() {
    Route::inertia('pnea-enrollment', 'PNEA/Form')->name('pnea-enrollment');
    Route::inertia('pnea-enrollment-view', 'Views/PNEA')->name('pnea-enrollment-view');
    Route::post('/pnea-enrollment-store', [PNEAEnrollmentController::class, 'store'])->name('pnea-enrollment-store');
    Route::get('/pnea-enrollment-data', [PNEAEnrollmentController::class, 'retrieve'])->name('pnea-enrollment-data');
    Route::get('/pnea-zone-data', [PNEAEnrollmentController::class, 'retrieveAndSortZones'])->name('pnea-zone-data');
    Route::get('/pnea-enrollment-edit/{id}', [PNEAEnrollmentController::class, 'edit'])->name('pnea-enrollment-edit');
    Route::put('/pnea-enrollment-update/{id}', [PNEAEnrollmentController::class, 'update'])->name('pnea-enrollment-update');

    Route::get('/pnea/{id}', [PNEAEnrollmentController::class, 'show'])->name('pnea.show');
    Route::post('/pnea/{id}/addPregnancyPeriod', [PNEAEnrollmentController::class, 'addPregnancyPeriod'])->name('pnea.addPregnancyPeriod');
    Route::post('/pnea/{id}/addLactatingPeriod', [PNEAEnrollmentController::class, 'addLactatingPeriod'])->name('pnea.addLactatingPeriod');
    
    Route::inertia('/financial-assistance', 'Views/FinancialAssistanceView')->name('financial-assistance');
});

// Comprehensive Survey Routes
Route::middleware(['auth', RefreshPageMiddleware::class])->group(function() {
    Route::inertia('/comprehensive-survey', 'ComprehensiveSurvey/Form')->name('comprehensive-survey');
    Route::inertia('/comprehensive-survey-view', 'Views/ComprehensiveSurvey')->name('comprehensive-survey-view');
    Route::post('/comprehensive-survey', [ComprehensiveSurveyController::class, 'survey']);
    Route::get('/comprehensive-survey-data', [ComprehensiveSurveyController::class, 'retrieve'])->name('comprehensive-survey-data');
    Route::get('/comprehensive-survey-data/{id}', [ComprehensiveSurveyController::class, 'show'])->name('comprehensive-survey-data.show');
    Route::put('/survey-update/{id}', [ComprehensiveSurveyController::class, 'update'])->name('survey-update');

    Route::get('/comprehensive-survey-zone-data', [ComprehensiveSurveyController::class, 'retrieveAndSortZones'])->name('comprehensive-survey-zone-data');
    Route::get('/comprehensive-survey-sex-data', [ComprehensiveSurveyController::class, 'retrieveSex'])->name('comprehensive-survey-sex-data');
    Route::inertia('/senior-citizen-view', 'Views/SeniorCitizen')->name('senior-citizen-view');
    Route::get('/senior-citizen-data', [ComprehensiveSurveyController::class, 'seniorCitizen'])->name('senior-citizen-data');
    Route::get('/senior-citizen-count', [ComprehensiveSurveyController::class, 'seniorCitizenCount'])->name('senior-citizen-count');
    Route::inertia('/four-ps-view', 'Views/FourPs')->name('four-ps-view');
    Route::get('/four-ps-data', [ComprehensiveSurveyController::class, 'fourPs'])->name('four-ps-data');
    Route::inertia('/pwd-view', 'Views/PWD')->name('pwd-view');
    Route::get('/pwd-data', [ComprehensiveSurveyController::class, 'pwd'])->name('pwd-data');
    Route::inertia('/age-grouping-view', 'Views/AgeGrouping')->name('age-grouping-view');
    Route::put('/comprehensive-survey-view/toggle-activation/{id}', [ComprehensiveSurveyController::class, 'toggleIsLiving'])->name('comprehensive-survey.toggle-activation');

});

// Monitoring Form Routes
Route::middleware(['auth', RefreshPageMiddleware::class])->group(function() {
    Route::inertia('monitoring-form', 'Views/MonitoringForm')->name('monitoring-form');
    Route::get('/monitoring-data', [PNEAEnrollmentController::class, 'displayPregnancyPeriodData'])->name('monitoring-data');
});

// Lactating Form Routes
Route::middleware(['auth', RefreshPageMiddleware::class])->group(function() {
    Route::inertia('lactating-form', 'Views/Lactating')->name('lactating-form');
    Route::get('/lactating-data', [PNEAEnrollmentController::class, 'displayLactatingPeriodData'])->name('lactating-data');
});

// Medicine Routes
Route::middleware(['auth', RefreshPageMiddleware::class])->group(function() {
    Route::inertia('/medicine', 'Medicine')->name('medicine');
    Route::inertia('/beneficiaries-view', 'Medicine/Beneficiaries')->name('beneficiaries-view');
    Route::inertia('/beneficiaries-form', 'Medicine/BForm')->name('beneficiaries-form');
    Route::inertia('/medicine-list-view', 'Medicine/MedicineList')->name('medicine-list-view');
    Route::inertia('/medicine-list-form', 'Medicine/MedicineList')->name('medicine-list-form');
    Route::post('/beneficiaries-form', [BeneficiariesController::class, 'store']);
    Route::post('/medicine-list-form', [MedicineListController::class, 'store']);
    Route::post('/distribution-form', [DistributionController::class, 'store']);
    Route::get('/beneficiaries-data', [BeneficiariesController::class, 'retrieve'])->name('beneficiaries-data');
    Route::get('/medicine-list-data', [MedicineListController::class, 'retrieve'])->name('medicine-list-data');
    Route::get('/distribution-data', [DistributionController::class, 'retrieve'])->name('distribution-data');
    Route::get('/medicine-list-distributed-data', [DistributedMedicineController::class, 'retrieve'])->name('medicine-list-distributed-data');
    Route::get('/beneficiaries-edit/{id}', [BeneficiariesController::class, 'edit'])->name('beneficiaries-edit');
    Route::put('/beneficiaries/{id}', [BeneficiariesController::class, 'update'])->name('beneficiaries-update');
    Route::get('/medicine-list-edit/{id}', [MedicineListController::class, 'edit'])->name('medicine-list-edit');
    Route::put('/medicine-list/{id}', [MedicineListController::class, 'update'])->name('medicine-list-update');
    Route::get('/distribution-edit/{id}', [DistributionController::class, 'edit'])->name('distribution-edit');
    Route::put('/distribution/{id}', [DistributionController::class, 'update'])->name('distribution-update');
    Route::put('/medicine-list-distribute/{id}', [DistributedMedicineController::class, 'distribute'])->name('medicine-list-distribute');
    Route::delete('/beneficiaries-delete/{id}', [BeneficiariesController::class, 'destroy'])->name('beneficiaries-delete');
    Route::delete('/medicine-list-delete/{id}', [MedicineListController::class, 'destroy'])->name('medicine-list-delete');
});

// Growth Monitoring Routes
Route::middleware(['auth', RefreshPageMiddleware::class])->group(function() {
    Route::inertia('/growth-monitoring', 'Views/GrowthMonitoring')->name('growth-monitoring');
    Route::get('/growth-monitoring-data', [ChildCareFormController::class, 'showGrowthMonitoring'])->name('growth-monitoring-data');
    Route::get('/underweight', [GrowthMonitoringController::class, 'underweight'])->name('underweight');
});

// Vaccination Record Routes
Route::middleware(['auth', RefreshPageMiddleware::class])->group(function() {
    Route::inertia('/vaccination-record', 'Views/VaccinationRecords')->name('vaccination-record');
    Route::get('/vaccination-record-data', [ChildCareFormController::class, 'showVaccinationRecord'])->name('vaccination-record-data');
});

// Senior Events Routes
Route::middleware(['auth', RefreshPageMiddleware::class])->group(function() {
    Route::inertia('/senior-events', 'SeniorCitizen/Events')->name('senior-events');
    Route::get('/events-data', [SeniorEventController::class, 'retrieve'])->name('events-data');
    Route::get('/events-data/{id}', [SeniorEventController::class, 'show'])->name('events-data.show');
    Route::post('/events-create', [SeniorEventController::class, 'store'])->name('events-create');
    Route::post('/save-scanned-data', [ScannedCodeController::class, 'store'])->name('save-scanned-data');
    Route::post('/event/{id}/addScannedCode', [SeniorEventController::class, 'addScannedCode'])->name('event.addScannedCode');
    Route::get('event-scanned-data/{id}', [SeniorEventController::class,'showScannedCodes'])->name('event-scanned-data');
    Route::get('scanned-events', [ScannedCodeController::class, 'retrieveData'])->name('scanned-events');
});

// Admin Approval Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/pending-users', [AuthController::class, 'getPendingUsers'])->name('admin.pendingUsers');
    Route::post('/admin/approve/{id}', [AuthController::class, 'approveUser'])->name('admin.approveUser');
    Route::post('/admin/reject/{id}', [AuthController::class, 'rejectUser'])->name('admin.rejectUser');

    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.updateUser');
    Route::delete('/delete-users/{id}', [UserController::class, 'destroy'])->name('admin.deleteUser');
    Route::post('/admin/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('admin.resetPassword');
    Route::inertia('/list-of-users', 'Users/List')->name('list-of-users');
    Route::put('/users/{id}/toggle-activation', [UserController::class, 'toggleActivation'])->name('users.toggleActivation');
    Route::get('/users-data', [UserController::class, 'getUsers'])->name('admin.get-users');
});

// Audit Logs Routes
Route::middleware(['auth'])->group(function () {
    Route::inertia('logs', 'AuditLogs/Logs')->name('logs');
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit.logs');
    Route::get('/audit-logs/previous', [AuditLogController::class, 'getPreviousLogs']);
    Route::post('/audit-logs', [AuditLogController::class, 'store']);
});



