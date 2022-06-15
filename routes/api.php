<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\FileUploaderController;
use App\Http\Controllers\InssuranceProviderController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MasterSubscriptionPackageController;
use App\Http\Controllers\MyHavIdsController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientOwnReportsFileController;
use App\Http\Controllers\PatientOwnReportsFolderController;
use App\Http\Controllers\PatientVitalsController;
use App\Http\Controllers\PatientInsuranceController;
use App\Http\Controllers\TestBokkingController;
use App\Http\Controllers\TestingCenterController;
use App\Http\Controllers\TestPanelController;
use App\Http\Controllers\pathologyDashboardController;
use App\Http\Controllers\PatientDataUsageController;
use App\Http\Controllers\SpecialistDashboardController;
use App\Http\Controllers\PatientPackageController;
use App\Http\Controllers\PatientShareReportsController;
use App\Http\Controllers\PatientSubscriptionController;
use App\Http\Controllers\PaymentDetailsController;
use App\Http\Controllers\SubscriptionPaymentsController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\LoginActivityController;
use App\Http\Controllers\PatientEventsController;
use App\Models\PatientShareReports;
use App\Models\TestBokking;
// use App\Models\TestingCenter;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ------------------------ Open API ----------------------------
//Route::post('login', 'UserController@login');
Route::post('login',[UserController::class, 'login']);
Route::post('register',[UserController::class, 'register']);


//----------------------- New API 01-02-2020 -----------------------------------------------
Route::get('user/getOneRecord',[UserController::class,'getOneRecord']);
Route::get('getPatientUseFileStorage',[PatientOwnReportsFileController::class, 'getPatientUseFileStorage']);




// OTP
Route::post('user/verifyOtp',[OTPController::class, 'verifyOtpAPI']);
Route::post('user/resendOtp',[OTPController::class, 'resendOtp']);
// Route::get('user/mail',[MailController::class, 'test']);
Route::post('user/resetPassword',[UserController::class, 'resetPassword']);
Route::put('user/updatePassword',[UserController::class, 'updatePassword']);


// help
Route::post('help/create',[HelpController::class, 'create']);

// File Uploader
Route::post('open/file/upload', [FileUploaderController::class, 'fileUploadPost'])->name('file.upload.post');
Route::get('file/get', [FileUploaderController::class, 'getFile']);
Route::post('file/upload', [FileUploaderController::class, 'fileUploadPost'])->name('file.upload.post');
Route::post('file/csvupload', [FileUploaderController::class, 'csvUploadPost'])->name('file.csvupload.post');

// ------------------------ Auth API ----------------------------
//Route::post('register', 'API/UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
//Route::post('details', 'API/UserController@details');
Route::post('details',[UserController::class, 'details']);

// login Activity
Route::post('loginActivity/create',[LoginActivityController::class, 'create']);
Route::get('loginActivity/list',[LoginActivityController::class, 'list']);
    
// Testing Center
Route::post('testingcenter/create',[TestingCenterController::class, 'create']);
Route::put('testingcenter/update',[TestingCenterController::class, 'edit']);
Route::get('testingcenter/list',[TestingCenterController::class, 'index']);
Route::get('testingcenter/getOne',[TestingCenterController::class, 'getOne']);
Route::get('testingcenter/patients',[TestingCenterController::class, 'getPatients']);
Route::get('testingcenter/testpanels',[TestingCenterController::class, 'getTestPanels']);
Route::get('testingcenter/users',[TestingCenterController::class, 'getUsers']);
//Route::get('testingcenter/bookings',[TestingCenterController::class, 'getBookings']);

// Test Panel
Route::post('testpanel/create',[TestPanelController::class, 'create']);
Route::put('testpanel/update',[TestPanelController::class, 'edit']);
Route::get('testpanel/getOne',[TestPanelController::class, 'getOne']);
Route::get('testpanel/list',[TestPanelController::class, 'index']);

//indivtual patient list
Route::get('individual/list',[PatientController::class, 'individualList']);

// Doctor 
Route::get('doctor/list',[DoctorController::class, 'list']);

// Patient
Route::post('patient/create',[PatientController::class, 'create']);
Route::put('patient/update',[PatientController::class, 'edit']);
Route::get('patient/list',[PatientController::class, 'index']);
Route::get('patient/getOne',[PatientController::class, 'getOne']);
//Route::get('testingcenter/patients',[TestingCenterController::class, 'getPatients']);

//patient share reports
Route::post('patient/share/report',[PatientShareReportsController::class, 'create']);
Route::get('patient/report',[PatientShareReportsController::class, 'getReports']);

//patient event
Route::post('patient/event',[PatientEventsController::class, 'create']);
Route::get('patient/events',[PatientEventsController::class, 'getEvents']);

//Patient Vital
Route::post('patient/vitals/create',[PatientVitalsController::class, 'create']);
Route::get('patient/vitals/get',[PatientVitalsController::class, 'index']);
Route::get('patient/vitals/history',[PatientVitalsController::class, 'vitalsHistory']);

//Patient Insurance
Route::post('patient/insurance/create',[PatientInsuranceController::class, 'create']);
Route::get('patient/insurance/list',[PatientInsuranceController::class, 'index']);
Route::put('patient/insurance/update',[PatientInsuranceController::class, 'edit']);
Route::get('patient/insurance/getOne',[PatientInsuranceController::class, 'getOne']);

// Booking
Route::post('booking/create',[TestBokkingController::class, 'create']);
Route::get('booking/list',[TestBokkingController::class, 'index']);
Route::post('booking/update',[TestBokkingController::class, 'edit']);
Route::get('testingcenter/bookings',[TestBokkingController::class, 'getBookingsByTestCenter']);
Route::get('patient/bookings',[TestBokkingController::class, 'getBookingsByPatientId']);

// Sepecialist Agent
Route::get('specialistagent/patients',[PatientController::class, 'patientBySpecialistSgent']);

// File Uploader
// Route::post('file/upload', [FileUploaderController::class, 'fileUploadPost'])->name('file.upload.post');
// Route::post('file/csvupload', [FileUploaderController::class, 'csvUploadPost'])->name('file.csvupload.post');
// Route::get('file/get', [FileUploaderController::class, 'getFile']);

// Patient Own reports
Route::get('user/files/recent',[PatientOwnReportsFileController::class, 'index']);
Route::post('user/files/add',[PatientOwnReportsFileController::class, 'create']);
Route::get('user/files/list',[PatientOwnReportsFileController::class, 'fileList']);
Route::get('user/all-files/list',[PatientOwnReportsFileController::class, 'allFileList']);
Route::get('user/folder/list',[PatientOwnReportsFileController::class, 'folderList']);
Route::post('user/profile/update',[UserController::class, 'updateProfile']);
Route::post('user/address/update',[UserController::class, 'updateAddress']);
Route::get('user/invitedInfo',[UserController::class, 'getInvitedUserInfo']);
Route::delete('user/file/delete',[PatientOwnReportsFileController::class, 'deleteReport']);

// User Test Reports in-direct Bookings
Route::get('user/test/reports',[TestBokkingController::class, 'myBookings']);

//Admin
Route::get('admin/dashboard',[AdminDashboardController::class, 'index']);
Route::get('pathology/admin/dashboard',[PathologyDashboardController::class, 'index']);
Route::get('specialist/admin/dashboard',[SpecialistDashboardController::class, 'index']);
Route::get('pathology/dashboard',[PathologyDashboardController::class, 'pathologyDashboardPatientCount']);
Route::get('specialist/dashboard',[SpecialistDashboardController::class, 'specialistDashboardPatientCount']);

// Patient Package
Route::post('package/create',[PatientPackageController::class, 'create']);
Route::get('package/list',[PatientPackageController::class, 'show']);
Route::get('package/getOne',[PatientPackageController::class, 'getOne']);
Route::put('package/update',[PatientPackageController::class, 'update']);

// Patient subscription
Route::post('subscription/create',[PatientSubscriptionController::class, 'create']);
// Route::get('subscription/list',[PatientSubscriptionController::class, 'show']);
Route::get('subscription/getOne',[PatientSubscriptionController::class, 'getOne']);
Route::put('subscription/update',[PatientSubscriptionController::class, 'update']);

// patient data usage
Route::get('patient/getDataUsage',[PatientDataUsageController::class, 'getDataUsage']);

// payment details
Route::post('paymentDetail/create',[PaymentDetailsController::class, 'create']);
Route::get('paymentDetails/list',[PaymentDetailsController::class, 'show']);
Route::get('paymentDetail/patient',[PaymentDetailsController::class, 'getPatientDetails']);

// Inssurance Provider
Route::post('inssuranceProviders/create',[InssuranceProviderController::class, 'create']);
Route::get('inssuranceProviders/list',[InssuranceProviderController::class, 'index']);
Route::put('inssuranceProviders/update',[InssuranceProviderController::class, 'edit']);
Route::get('inssuranceProviders/getOne',[InssuranceProviderController::class, 'getOne']);

// Master Subscription packages
Route::post('masterSubscriptionPackage/create',[MasterSubscriptionPackageController::class, 'create']);
Route::get('masterSubscriptionPackage/list',[MasterSubscriptionPackageController::class, 'index']);
Route::put('masterSubscriptionPackage/update',[MasterSubscriptionPackageController::class, 'edit']);
Route::get('masterSubscriptionPackage/getOne',[MasterSubscriptionPackageController::class, 'getOne']);

// Subscription Payments
Route::post('subscriptionPayments/create',[SubscriptionPaymentsController::class, 'create']);
Route::get('subscriptionPayments/list',[SubscriptionPaymentsController::class, 'index']);
Route::put('subscriptionPayments/update',[SubscriptionPaymentsController::class, 'edit']);
Route::get('subscriptionPayments/getOne',[SubscriptionPaymentsController::class, 'getOne']);
Route::get('subscriptionPayments/byUser',[SubscriptionPaymentsController::class, 'getByUser']);

// help
// Route::put('help/update',[HelpController::class, 'edit']);
Route::get('help/list',[HelpController::class, 'list']);
Route::get('help/getOne',[HelpController::class, 'getOne']);


Route::post('user/linkmyhavids',[MyHavIdsController::class, 'create']);
Route::get('user/myhavids',[MyHavIdsController::class, 'index']);
Route::get('user/byrole',[UserController::class, 'getUsesByRole']);


// user
Route::put('user/verify',[UserController::class, 'edit']);
Route::get('user/getOne',[UserController::class, 'getOne']);
   
   


});

// Route::get('reports/upload/folder/list',[PatientOwnReportsFolderController::class, 'index']);
// Route::post('reports/upload/file/create',[PatientOwnReportsFileController::class, 'create']);
// Route::get('reports/upload/file/list',[PatientOwnReportsFileController::class, 'index']);
// Route::get('reports/upload/file/listByFolder',[PatientOwnReportsFileController::class, 'getByFolderId']);

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
