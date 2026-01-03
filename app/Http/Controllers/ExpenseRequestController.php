<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Models\ExpenseCategory;
use App\Models\ExpenseRequest;
use App\Services\ExpenseService;
use App\Http\Resources\ExpenseRequestResource;
use Illuminate\Support\Facades\Storage;

class ExpenseRequestController extends Controller
{
    public function index()
    {
        $requests = ExpenseRequest::with('user', 'media')->latest()->get();
        return view('expense_requests.approvals', compact('requests'));
    }

    public function approvals()
    {
        $requests = ExpenseRequest::with('user', 'media')
            ->where('status', 'pending')
            ->latest()->get();
        return view('expense_requests.approvals', compact('requests'));
    }

    public function create()
    {
        $categories = ExpenseCategory::all();
        return view('expense_requests.create', compact('categories'));
    }

    public function store(StoreExpenseRequest $request, ExpenseService $service)
    {
        $validated = $request->validated();

        $expense = $service->create($validated);

        if ($request->hasFile('file')) {
            $expense->uploadMedia($request->file('file'));
        }

        return redirect()->route('expense_requests.create')
            ->with('success', 'درخواست با موفقیت ثبت شد.');

        // if request is api
        //return new ExpenseRequestResource($expense);
    }

    public function download(ExpenseRequest $expenseRequest)
    {
        if ($expenseRequest->media->isEmpty()) {
            abort(404);
        }

        $file = $expenseRequest->media->first();
        return Storage::download($file->getPath());
    }

    public function show(ExpenseRequest $expenseRequest)
    {
        $expenseRequest->load('user', 'media', 'category');

        return view('expense_requests.show', compact('expenseRequest'));
    }

}
