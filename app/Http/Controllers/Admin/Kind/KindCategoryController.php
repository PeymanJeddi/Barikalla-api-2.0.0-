<?php

namespace App\Http\Controllers\Admin\Kind;

use App\DataTables\KindCategoryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class KindCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KindCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.kindCategory.index', [
            'pageTitle' => 'مدیریت ثوابت سیستمی',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }
}
