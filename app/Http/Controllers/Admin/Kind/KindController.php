<?php

namespace App\Http\Controllers\Admin\Kind;

use App\DataTables\KindDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Kind\KindStoreRequest;
use App\Http\Requests\Admin\Kind\KindUpdateRequest;
use App\Models\Kind;
use App\Models\KindCategory;

class KindController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KindCategory $kindcategory, KindDataTable $datatable)
    {
        return $datatable->render('admin.pages.kind.index', [
            'pageTitle' => "مدیریت ثابت‌های $kindcategory->title",
            'kindCategory' => $kindcategory,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(KindCategory $kindcategory)
    {
        if ($kindcategory->parent_id != null) {
            $parent = true;
            $kinds = Kind::where('kind_category_id', $kindcategory->parent_id)->get();
        }
        return view('admin.pages.kind.form', [
            'pageTitle' => 'ایجاد ثابت',
            'kindCategory' => $kindcategory,
            'parent' => $parent ?? false,
            'parents' => $kinds ?? '',
            'routes' => [
                'method' => 'post',
                'index' => route('admin.kindcategory.kind.index', $kindcategory),
                'store' => route('admin.kindcategory.kind.store', $kindcategory),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KindCategory $kindcategory, KindStoreRequest $request)
    {
        $kindcategory->kinds()->create([
            'key' => $request->key,
            'value_1' => $request->value_1,
            'value_2' => $request->value_2 ?? '',
            'parent_id' => $request->parent_id ?? null,
            'is_active' => $request->is_active ?? 1,
        ]);
        return redirect(route('admin.kindcategory.kind.index', $kindcategory))->with('toast', ['message' => 'ثابت جدید با موفقیت افزوده شد']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KindCategory $kindcategory, Kind $kind)
    {
        if ($kindcategory->parent_id != null) {
            $parent = true;
            $kinds = Kind::where('kind_category_id', $kindcategory->parent_id)->get();
        }
        return view('admin.pages.kind.form', [
            'pageTitle' => 'ویرایش ثابت',
            'kindCategory' => $kindcategory,
            'kind' => $kind,
            'parent' => $parent ?? false,
            'parents' => $kinds ?? '',
            'routes' => [
                'method' => 'patch',
                'index' => route('admin.kindcategory.kind.index', $kindcategory),
                'store' => route('admin.kindcategory.kind.update', [$kindcategory, $kind]),
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KindUpdateRequest $request, KindCategory $kindcategory, Kind $kind)
    {
        $kind->update([
            'key' => $request->key,
            'value_1' => $request->value_1,
            'value_2' => $request->value_2 ?? '',
            'parent_id' => $request->parent_id ?? null,
            'is_active' => $request->is_active ?? 1,
        ]);
        return redirect(route('admin.kindcategory.kind.index', $kindcategory))->with('toast', ['message' => 'ثابت جدید با موفقیت آپدیت شد']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KindCategory $kindcategory, Kind $kind)
    {
        $kind->delete();
    }
}
