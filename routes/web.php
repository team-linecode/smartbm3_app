<?php

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use GuzzleHttp\Exception\RequestException;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Manage\BillController;
use App\Http\Controllers\Manage\CostController;
use App\Http\Controllers\Manage\RoleController;
use App\Http\Controllers\Manage\ReportController;
use App\Http\Controllers\Manage\DashboardController;
use App\Http\Controllers\Manage\DatatableController;
use App\Http\Controllers\Manage\PermissionController;
use App\Http\Controllers\Manage\User\StaffController;
use App\Http\Controllers\Manage\AchievementController;
use App\Http\Controllers\Manage\Osis\AbsentController;
use App\Http\Controllers\Manage\TransactionController;
use App\Http\Controllers\Landing\LandingPPDBController;
use App\Http\Controllers\Manage\Sarpras\RoomController;
use App\Http\Controllers\Manage\User\StudentController;
use App\Http\Controllers\Manage\User\TeacherController;
use App\Http\Controllers\Manage\Salary\SalaryController;
use App\Http\Controllers\Manage\LoanManage\LoanController;
use App\Http\Controllers\Manage\Operator\LetterController;
use App\Http\Controllers\Manage\Point\UserPointController;
use App\Http\Controllers\Manage\Salary\PositionController;
use App\Http\Controllers\Manage\Sarpras\ServiceController;
use App\Http\Controllers\Manage\Salary\AllowanceController;
use App\Http\Controllers\Manage\Salary\SalaryCutController;
use App\Http\Controllers\Manage\Sarpras\BuildingController;
use App\Http\Controllers\Manage\Sarpras\FacilityController;
use App\Http\Controllers\Manage\Point\ReportPointController;
use App\Http\Controllers\Manage\Salary\SalarySlipController;
use App\Http\Controllers\Manage\Point\PenaltyPointController;
use App\Http\Controllers\Manage\Sarpras\SubmissionController;
use App\Http\Controllers\Manage\StudentTransactionController;
use App\Http\Controllers\Manage\Picket\PicketAbsentController;
use App\Http\Controllers\Manage\Picket\PicketReportController;
use App\Http\Controllers\Manage\Picket\TeacherAbsentController;
use App\Http\Controllers\Manage\Salary\LastEducationController;
use App\Http\Controllers\Manage\LoanManage\LoanMemberController;
use App\Http\Controllers\Manage\Picket\PicketScheduleController;
use App\Http\Controllers\Manage\Point\PenaltyCategoryController;
use App\Http\Controllers\Manage\Operator\LetterCategoryController;
use App\Http\Controllers\Manage\Picket\StudentApprenticeshipController;
use App\Http\Controllers\Manage\ValueCriteriaController;
use App\Http\Controllers\Manage\WorkProgramCategoryController;
use App\Http\Controllers\Manage\WorkProgramController;
use App\Http\Controllers\Manage\WorkProgramDefaultController;
use App\Models\Position;
use App\Models\WorkProgramCategory;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// assign role
// Route::get('assign_role', function(){
//     $ps = Position::where('slug', '!=', 'wali-kelas')->get();
//     foreach ($ps as $p) {
//         foreach ($p->users as $u) {
//             $u->assignRole('staff');
//             echo $u->name . ' -> ' . $u->roles->pluck('name')->implode(', ') . '<br>';
//         }
//     }
// });

// update user
// Route::get('update_user', function () {
//     $users = User::where('role_id', 3)->where('nisn', '!=', null)->get();
//     foreach ($users as $user) {
//         $user->nip = null;
//         $user->update();
//     }
//     dd('ok');
// });

// Route::get('dates', function () {
//     $begin = new DateTime('2019-07-01');
//     $end = new DateTime('2020-07-01');

//     $begin2 = new DateTime('2020-07-01');
//     $end2 = new DateTime('2021-07-01');

//     $begin3 = new DateTime('2021-07-01');
//     $end3 = new DateTime('2022-07-01');

//     $interval = DateInterval::createFromDateString('1 months');
//     $period = new DatePeriod($begin, $interval, $end);
//     $period2 = new DatePeriod($begin2, $interval, $end2);
//     $period3 = new DatePeriod($begin3, $interval, $end3);

//     foreach ($period as $dt) {
//         echo $dt->format("F Y") . '<br />';
//     }
//     echo '===============================<br />';
//     foreach ($period2 as $dt2) {
//         echo $dt2->format("F Y") . '<br />';
//     }
//     echo '===============================<br />';
//     foreach ($period3 as $dt3) {
//         echo $dt3->format("F Y") . '<br />';
//     }
// });

// Route::get('apake', function(){
//     foreach (PenaltyPoint::all() as $pp) {
//         $pp->code = substr($pp->code, 0, 1) . '.' . substr($pp->code, 1, 1);
//         $pp->update();
//     }
// });

// Route::get('test', function() {
//     $users = User::take(10)->withCount('user_points')->orderByDesc('user_points_count')->get();
//     dd($users);
// });

// Route::get('/getkelas10', function(){
//     $reposenses = Http::get('https://elearning.smartbm3.com/api/getuser')->json();

//     foreach ($reposenses['users'] as $user) {
//         $expertise = '';

//         if ($user['expertise_id'] == '5') {
//             $expertise .= '4';
//         } else if ($user['expertise_id'] == '6') {
//             $expertise .= '5';
//         } else if ($user['expertise_id'] == '7') {
//             $expertise .= '6';
//         } else if ($user['expertise_id'] == '8') {
//             $expertise .= '7';
//         } else if ($user['expertise_id'] == '9') {
//             $expertise .= '8';
//         } else {
//             $expertise .= $user['expertise_id'];
//         }

//         $user = User::create([
//             'name' => $user['name'],
//             'nisn' => $user['nisn'],
//             'username' => $user['username'],
//             'password' => bcrypt($user['no_encrypt']),
//             'no_encrypt' => $user['no_encrypt'],
//             'role_id' => $user['role_id'],
//             'classroom_id' => $user['classroom_id'],
//             'expertise_id' => $expertise,
//             'schoolyear_id' => '7'
//         ]);
// $user->assignRole('student');
//     }
// });

Route::get('/cron/6cd6ba9b-8162-47df-b90b-c3aea03442fc', function () {
    Artisan::call('queue:work --daemon --stop-when-empty');
    Log::info("Cron dieksekusi dari server lain");
});

// PPDB
Route::get('/ppdb', [LandingPPDBController::class, 'index'])->name('landing.ppdb');
// Auth
Route::get('/', [AuthController::class, 'login'])->name('auth.login');
Route::get('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/login', [AuthController::class, 'post_login'])->name('auth.post_login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/forgot', [AuthController::class, 'forgot'])->name('auth.forgot');
Route::post('/forgot', [AuthController::class, 'post_forgot'])->name('auth.forgot.post');
Route::get('/reset_password/{token}', [AuthController::class, 'reset'])->name('auth.reset');
Route::post('/reset_password/{verify_token}', [AuthController::class, 'post_reset'])->name('auth.reset.post');

// Route [auth, master]
Route::middleware(['auth'])->prefix('app')->name('app.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    // User
    // Teacher
    Route::resource('/user/teacher', TeacherController::class);
    Route::get('/user/teacher/{teacher}/change_password', [TeacherController::class, 'change_password'])->name('teacher.change_password');
    Route::put('/user/teacher/{teacher}/save_password', [TeacherController::class, 'save_password'])->name('teacher.save_password');
    Route::post('/user/teacher/{teacher}/create_lesson', [TeacherController::class, 'create_lesson'])->name('teacher.create_lesson');
    Route::post('/user/teacher/{teacher}/{lesson_id}/destroy_lesson', [TeacherController::class, 'destroy_lesson'])->name('teacher.destroy_lesson');
    Route::post('/user/teacher/{teacher}/destroy_all_lesson', [TeacherController::class, 'destroy_all_lesson'])->name('teacher.destroy_all_lesson');
    // Session
    Route::post('/user/teacher/create_lesson_sess', [TeacherController::class, 'create_lesson_sess'])->name('teacher.create_lesson_sess');
    Route::post('/user/teacher/{lesson_id}/destroy_lesson_sess', [TeacherController::class, 'destroy_lesson_sess'])->name('teacher.destroy_lesson_sess');
    Route::post('/user/teacher/destroy_all_lesson_sess', [TeacherController::class, 'destroy_all_lesson_sess'])->name('teacher.destroy_all_lesson_sess');
    Route::get('/user/teacher/{teacher}/destroy_image', [TeacherController::class, 'destroy_image'])->name('teacher.destroy_image');
    // Student
    Route::resource('/user/student', StudentController::class)->except('show');
    Route::get('/user/student/{student}/change_password', [StudentController::class, 'change_password'])->name('student.change_password');
    Route::put('/user/student/{student}/save_password', [StudentController::class, 'save_password'])->name('student.save_password');
    Route::get('/user/student/{student}/destroy_image', [StudentController::class, 'destroy_image'])->name('student.destroy_image');

    Route::get('/user/student/graduate', [StudentController::class, 'alumni'])->name('student.alumni.index');
    // Staff
    Route::resource('/user/staff', StaffController::class);
    Route::get('/user/staff/{staff}/change_password', [StaffController::class, 'change_password'])->name('staff.change_password');
    Route::put('/user/staff/{staff}/save_password', [StaffController::class, 'save_password'])->name('staff.save_password');
    Route::get('/user/staff/{staff}/destroy_image', [StaffController::class, 'destroy_image'])->name('staff.destroy_image');

    // Salary
    Route::resource('/salaries', SalaryController::class);
    Route::get('/salaries/generatePDF/{salary_detail:uid}/{type}', [SalaryController::class, 'generatePDF'])->name('salaries.generate_pdf');
    // Salary Slip
    Route::resource('/salary_slip', SalarySlipController::class);
    // Salary Cut
    Route::resource('/salary/salary_cut', SalaryCutController::class)->except('show');
    // Allowance
    Route::resource('/salary/allowance', AllowanceController::class)->except('show');
    Route::post('/salary/allowance/add_input', [AllowanceController::class, 'add_input'])->name('salary.allowance.add_input');
    Route::post('/salary/allowance/remove_input', [AllowanceController::class, 'remove_input'])->name('salary.allowance.remove_input');
    Route::post('/salary/allowance/reset_input', [AllowanceController::class, 'reset_input'])->name('salary.allowance.reset_input');
    // Last Education
    Route::resource('/salary/last_education', LastEducationController::class)->except('show');
    // Position
    Route::resource('/salary/position', PositionController::class)->except('show');
    Route::delete('/salary/position/{position:slug}/{user}/destroy_user', [PositionController::class, 'destroy_user'])->name('position.destroy_user');

    // Student -> Transaction
    Route::resource('/transaction', StudentTransactionController::class)->except('show');
    Route::get('/transaction/choose_student', [StudentTransactionController::class, 'choose_student'])->name('transaction.choose_student');
    Route::get('/transaction/success_saved', [StudentTransactionController::class, 'success_saved'])->name('transaction.success_saved');
    Route::get('/transaction/maintenance', [StudentTransactionController::class, 'maintenance'])->name('transaction.maintenance');
    Route::get('/transaction/detail', [StudentTransactionController::class, 'detail'])->name('transaction.detail');
    Route::get('/transaction/create/{cost:slug}', [StudentTransactionController::class, 'create_step2'])->name('transaction.create.step2');
    Route::delete('/transaction/item/{transaction_item}/destroy', [StudentTransactionController::class, 'delete_item'])->name('transaction.delete_item');
    Route::post('/transaction/payment', [StudentTransactionController::class, 'payment'])->name('transaction.payment');

    // Finance -> Transaction
    Route::get('/finance/transaction', [TransactionController::class, 'index'])->name('finance.transaction.index');
    Route::get('/finance/transaction/create', [TransactionController::class, 'create'])->name('finance.transaction.create');
    Route::get('/finance/transaction/create/{user:username}', [TransactionController::class, 'create_detail'])->name('finance.transaction.create_detail');
    Route::get('/finance/transaction/{transaction:invoice_id}/detail', [TransactionController::class, 'show'])->name('finance.transaction.show');
    Route::post('/finance/transaction/store', [TransactionController::class, 'store'])->name('finance.transaction.store');
    Route::post('/finance/transaction/create/save_transaction', [TransactionController::class, 'save_transaction'])->name('finance.transaction.save_transaction');
    Route::put('/finance/transaction/create/{transaction}/update_transaction', [TransactionController::class, 'update_transaction'])->name('finance.transaction.update_transaction');
    // Route::get('/finance/transaction/create_detail/{transaction}', [TransactionController::class, 'create_detail'])->name('finance.transaction.create_detail');
    Route::delete('/finance/transaction/create_detail/{transaction_detail}/destroy', [TransactionController::class, 'detail_destroy'])->name('finance.transaction.detail.destroy');
    Route::post('/finance/transaction/get_user', [TransactionController::class, 'get_user'])->name('finance.transaction.get_user');
    Route::post('/finance/transaction/get_cost_schoolyear', [TransactionController::class, 'get_cost_schoolyear'])->name('finance.transaction.get_cost_schoolyear');
    Route::post('/finance/transaction/get_cost_detail', [TransactionController::class, 'get_cost_detail'])->name('finance.transaction.get_cost_detail');
    Route::post('/finance/transaction/get_cost_amount', [TransactionController::class, 'get_cost_amount'])->name('finance.transaction.get_cost_amount');
    Route::post('/finance/transaction/get_account_number', [TransactionController::class, 'get_account_number'])->name('finance.transaction.get_account_number');

    // Finance -> Transaction -> Export
    Route::get('/finance/transaction/{transaction}/print', [TransactionController::class, 'print'])->name('finance.transaction.print');

    // Finance -> Bill
    Route::get('/finance/bill', [BillController::class, 'index'])->name('finance.bill.index');
    Route::get('/finance/bill/uid/{user}', [BillController::class, 'show'])->name('finance.bill.show');

    // Finance -> Cost
    Route::get('/finance/cost', [CostController::class, 'index'])->name('finance.cost.index');
    Route::get('/finance/cost/ta/{schoolyear:slug}', [CostController::class, 'show'])->name('finance.cost.show');
    Route::get('/finance/cost/ta/{schoolyear:slug}/detail/{cost:slug}', [CostController::class, 'detail'])->name('finance.cost.detail');
    Route::get('/finance/cost/create/ta/{schoolyear:slug}/kategori/{cost_category}', [CostController::class, 'create'])->name('finance.cost.create');
    Route::post('/finance/cost/create/ta/{schoolyear:slug}/kategori/{cost_category}', [CostController::class, 'store'])->name('finance.cost.store');
    Route::get('/finance/cost/edit/ta/{schoolyear:slug}/biaya/{cost:slug}', [CostController::class, 'edit'])->name('finance.cost.edit');
    Route::put('/finance/cost/edit/ta/{schoolyear:slug}/biaya/{cost:slug}', [CostController::class, 'update'])->name('finance.cost.update');
    Route::delete('/finance/cost/ta/{schoolyear:slug}/biaya/{cost:slug}/destroy', [CostController::class, 'destroy'])->name('finance.cost.destroy');
    Route::post('/finance/cost/get_roles', [CostController::class, '_get_roles'])->name('finance.cost._get_roles');
    Route::post('/finance/cost/duplicate', [CostController::class, 'duplicate'])->name('finance.cost.duplicate');

    // Finance -> Report -> Transaction
    Route::get('/finance/report/{type}', [ReportController::class, 'index'])->name('finance.report.index');

    // Role
    Route::resource('/role', RoleController::class)->except('show');

    // Permission
    Route::resource('/permission', PermissionController::class)->except('show');

    // Sarpras
    // Facility
    Route::resource('/sarpras/facility', FacilityController::class)->except('show');
    // Building
    Route::resource('/sarpras/building', BuildingController::class)->except('show');
    // Room
    Route::resource('/sarpras/room', RoomController::class);
    Route::post('/sarpras/room/{room}/store_facility', [RoomController::class, 'store_facility'])->name('room.store_facility');
    Route::get('/sarpras/room/{room}/edit_facility/{facility}', [RoomController::class, 'edit_facility'])->name('room.edit_facility');
    Route::put('/sarpras/room/{room}/update_facility/{facility}', [RoomController::class, 'update_facility'])->name('room.update_facility');
    Route::delete('/sarpras/room/{room}/delete_facility/{facility}', [RoomController::class, 'delete_facility'])->name('room.delete_facility');
    Route::post('/sarpras/room/get_stage', [RoomController::class, '_get_stage'])->name('room._get_stage');
    // Submission
    Route::resource('/sarpras/submission', SubmissionController::class)->except('show');
    Route::get('/sarpras/submission/accept/{submission}', [SubmissionController::class, 'accept'])->name('submission.accept');
    Route::put('/sarpras/submission/reject/{submission}', [SubmissionController::class, 'reject'])->name('submission.reject');
    Route::post('/sarpras/submission/plus_input', [SubmissionController::class, 'plus_input'])->name('submission.plus_input');
    Route::post('/sarpras/submission/minus_input', [SubmissionController::class, 'minus_input'])->name('submission.minus_input');
    Route::get('/sarpras/submission/invoice/{submission}', [SubmissionController::class, 'invoice'])->name('submission.invoice');
    // Service
    Route::resource('/sarpras/service', ServiceController::class)->except('show');
    Route::post('/sarpras/service/get_facility', [ServiceController::class, '_get_facility'])->name('service._get_facility');

    // Penalty Point
    Route::resource('/point/penalty_point', PenaltyPointController::class);

    // Penalty Point Category
    Route::resource('/point/penalty_category', PenaltyCategoryController::class);

    // User Penalty
    Route::resource('/point/user_point', UserPointController::class)->except('show');
    Route::post('/user_point/bulk_delete', [UserPointController::class, 'bulk_delete'])->name('user_point.bulk_delete');

    // Point Report
    Route::resource('/point/report_point', ReportPointController::class)->only('index');
    Route::post('/point/export_point', [ReportPointController::class, 'export_point'])->name('point.export_point');
    Route::post('/point/export_total_point', [ReportPointController::class, 'export_total_point'])->name('point.export_total_point');

    // Osis
    // Absent
    Route::resource('/osis/absent', AbsentController::class)->only('index', 'create', 'store');

    // Picket
    // Schedule
    Route::resource('/picket_schedule', PicketScheduleController::class)->except('show');
    // Absent
    Route::resource('/picket_absent', PicketAbsentController::class)->except('show');
    // Teacher Absent
    Route::resource('/teacher_absent', TeacherAbsentController::class)->except('show');
    // Picket Report
    Route::resource('/picket_report', PicketReportController::class)->except('show');
    Route::post('/picket_report/export_monthly', [PicketReportController::class, 'export_monthly'])->name('picket_report.export_monthly');
    Route::post('/picket_report/export_custom', [PicketReportController::class, 'export_custom'])->name('picket_report.export_custom');
    // Student Apprenticeship
    Route::resource('/student_apprenticeship', StudentApprenticeshipController::class)->except('show');

    // Operator
    // Letter
    Route::resource('/operator/letter', LetterController::class)->except('show');
    // LetterCategory
    Route::resource('/operator/letter_category', LetterCategoryController::class)->except('show');

    // Lab Manage
    // Member
    Route::resource('/loan_member', LoanMemberController::class)->except('show');
    // Loan
    Route::resource('/loan', LoanController::class)->except('show');
    Route::post('/loan/find_members_by_scan', [LoanController::class, 'find_members_by_scan'])->name('loan.find_members_by_scan');
    Route::post('/loan/find_users_by_class', [LoanController::class, 'find_users_by_class'])->name('loan.find_users_by_class');
    Route::post('/loan/find_facilities_by_room', [LoanController::class, 'find_facilities_by_room'])->name('loan.find_facilities_by_room');
    Route::post('/loan/get_detail', [LoanController::class, 'get_detail'])->name('loan.get_detail');

    // Achievment
    Route::resource('achievement', AchievementController::class);
    Route::get('/achievement/attachment/{achievement_attachment}/destroy', [AchievementController::class, 'attachment_destroy'])->name('achievement.attachment.destroy');

    // Work Program (Program Kerja)
    Route::resource('work_program', WorkProgramController::class)->except('show');

    // Work Program Default (Program Kerja)
    Route::resource('work_program_default', WorkProgramDefaultController::class)->except('show');

    // Work Program Category (Program Kerja)
    Route::resource('work_program_category', WorkProgramCategoryController::class)->except('show');
    
    // Value Criteria
    Route::resource('value_criteria', ValueCriteriaController::class)->except('show');
    Route::post('value_criteria/status/update', [ValueCriteriaController::class, 'update_status'])->name('app.value_criteria.update_status');
});
// End Route

Route::post('/app/transaction/payment/confirm', [StudentTransactionController::class, 'confirm'])->name('app.transaction.payment.confirm');

// Route [auth]
Route::group(['middleware' => ['auth']], function () {
    // Json DataTables
    Route::get('/datatable.student_json', [DatatableController::class, 'student_json'])->name('datatable.student_json');
    Route::get('/datatable.student_bill_json', [DatatableController::class, 'student_bill_json'])->name('datatable.student_bill_json');
    Route::get('/datatable.student_absent_json/{classroom_id}/{expertise_id}', [DatatableController::class, 'student_absent_json'])->name('datatable.student_absent_json');
    Route::get('/datatable.teacher_json', [DatatableController::class, 'teacher_json'])->name('datatable.teacher_json');
    Route::get('/datatable.staff_json', [DatatableController::class, 'staff_json'])->name('datatable.staff_json');
    Route::get('/datatable.choose_student_json', [DatatableController::class, 'choose_student_json'])->name('datatable.choose_student_json');
});