<?php

namespace App\Http\Controllers\Admin\User;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserStoreRequest;
use App\Http\Requests\Admin\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(UserDataTable $datatable)
    {
        return $datatable->render('admin.pages.user.index');
    }

    public function create()
    {
        $statusOptions = [
            [
                'id' => 'incomplete',
                'label' => 'ناقص',
            ],
            [
                'id' => 'pending',
                'label' => 'درحال بررسی',
            ],
            [
                'id' => 'rejected',
                'label' => 'رد شده',
            ],
            [
                'id' => 'verified',
                'label' => 'تایید شده',
            ],
        ];
        return view('admin.pages.user.form', [
            'pageTitle' => 'ایجاد کاربر',
            'statusOptions' => $statusOptions,
            'routes' => [
                'store' => route('admin.users.store'),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create([...$request->validated()]);
        $user->status = $request->status;
        $user->is_admin = $request->is_admin ?? 0;
        $user->save();
        return redirect()->route('admin.users.index')->with('toast', ['message' => '.کاربر جدید با موفقیت ساخته شد', 'status' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $statusOptions = [
            [
                'id' => 'incomplete',
                'label' => 'ناقص',
            ],
            [
                'id' => 'pending',
                'label' => 'درحال بررسی',
            ],
            [
                'id' => 'rejected',
                'label' => 'رد شده',
            ],
            [
                'id' => 'verified',
                'label' => 'تایید شده',
            ],
        ];
        return view('admin.pages.user.form', [
            'pageTitle' => 'ویرایش کاربر',
            'statusOptions' => $statusOptions,
            'user' => $user,
            'routes' => [
                'store' => route('admin.users.update', $user),
                'method' => 'patch',
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update([...$request->validated()]);
        $user->status = $request->status;
        $user->is_admin = $request->is_admin ?? 0;
        $user->save();
        return redirect()->route('admin.users.index')->with('toast', ['message' => "کاربر $user->first_name با موفقیت ویرایش شد", 'status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
