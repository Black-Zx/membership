<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
    return redirect()->route('members.index');
});

// Member List
Route::get('/members', [MemberController::class, 'index'])->name('members.index'); 
Route::get('/members/create', [MemberController::class, 'create'])->name('members.create'); // Registration Form
Route::get('/members/{member}', [MemberController::class, 'show'])->name('members.show'); // Member Details
Route::post('/members', [MemberController::class, 'store'])->name('members.store'); // Store Member
Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit'); // Edit Member
Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update'); // Update Member
Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy'); // Delete Member
Route::get('/export', [MemberController::class, 'export'])->name('export');

// Route::resource('members', MemberController::class);
