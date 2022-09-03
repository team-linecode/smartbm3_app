<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Manage\BillController;
use App\Http\Controllers\Manage\CostController;
use App\Http\Controllers\Manage\RoleController;
use App\Http\Controllers\Manage\UserController;
use App\Http\Controllers\Manage\DashboardController;
use App\Http\Controllers\Manage\DatatableController;
use App\Http\Controllers\Manage\FormTeacherController;
use App\Http\Controllers\Manage\PermissionController;
use App\Http\Controllers\Manage\ReportController;
use App\Http\Controllers\Manage\TransactionController;
use App\Http\Controllers\Manage\User\StaffController;
use App\Http\Controllers\Manage\User\StudentController;
use App\Http\Controllers\Manage\User\TeacherController;

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

Route::get('/', [AuthController::class, 'login'])->name('auth.login');
Route::post('/', [AuthController::class, 'post_login'])->name('auth.post_login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/forgot', [AuthController::class, 'forgot'])->name('auth.forgot');
Route::get('/reset/{email}/{token}', [AuthController::class, 'reset'])->name('auth.reset');

// Route [auth, master]
Route::middleware(['auth'])->prefix('app')->name('app.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    // Form Teacher
    Route::resource('/form_teacher', FormTeacherController::class)->except('show');

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
    Route::resource('/user/student', StudentController::class);
    Route::get('/user/student/{student}/change_password', [StudentController::class, 'change_password'])->name('student.change_password');
    Route::put('/user/student/{student}/save_password', [StudentController::class, 'save_password'])->name('student.save_password');
    Route::get('/user/student/{student}/destroy_image', [StudentController::class, 'destroy_image'])->name('student.destroy_image');

    Route::resource('/user/staff', StaffController::class);

    // Finance -> Transaction
    Route::get('/finance/transaction', [TransactionController::class, 'index'])->name('finance.transaction.index');
    Route::get('/finance/transaction/create', [TransactionController::class, 'create'])->name('finance.transaction.create');
    Route::post('/finance/transaction/create', [TransactionController::class, 'store'])->name('finance.transaction.store');
    Route::post('/finance/transaction/create/save_transaction', [TransactionController::class, 'save_transaction'])->name('finance.transaction.save_transaction');
    Route::put('/finance/transaction/create/{transaction}/update_transaction', [TransactionController::class, 'update_transaction'])->name('finance.transaction.update_transaction');
    Route::get('/finance/transaction/create_detail/{transaction}', [TransactionController::class, 'create_detail'])->name('finance.transaction.create_detail');
    Route::delete('/finance/transaction/create_detail/{transaction_detail}/destroy', [TransactionController::class, 'detail_destroy'])->name('finance.transaction.detail.destroy');
    Route::post('/finance/transaction/get_user', [TransactionController::class, 'get_user'])->name('finance.transaction.get_user');
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

    // Finance -> Report -> Transaction
    Route::get('/finance/report/{type}', [ReportController::class, 'index'])->name('finance.report.index');

    // Role
    Route::resource('/role', RoleController::class)->except('show');

    // Permission
    Route::resource('/permission', PermissionController::class)->except('show');
});
// End Route

// Route [auth]
Route::group(['middleware' => ['auth']], function () {
    // Json DataTables
    Route::get('/datatable.student_json', [DatatableController::class, 'student_json'])->name('datatable.student_json');
    Route::get('/datatable.student_bill_json', [DatatableController::class, 'student_bill_json'])->name('datatable.student_bill_json');
    Route::get('/datatable.teacher_json', [DatatableController::class, 'teacher_json'])->name('datatable.teacher_json');
    Route::get('/datatable.staff_json', [DatatableController::class, 'staff_json'])->name('datatable.staff_json');
});
