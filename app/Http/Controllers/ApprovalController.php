<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApprovalRequest;
use App\Http\Requests\RejectRequest;
use App\Services\ApprovalService;
use Illuminate\Http\JsonResponse;

class ApprovalController extends Controller
{
    public function bulkApprove(ApprovalRequest $request, ApprovalService $service): JsonResponse
    {
        $service->process($request->request_ids, 'approve', null);
        return response()->json([
            'success' => true,
            'message' => 'درخواست‌ها با موفقیت تایید شدند.'
        ]);
    }

    public function bulkReject(ApprovalRequest $request, ApprovalService $service): JsonResponse
    {
        $service->process($request->request_ids, 'reject', $request->reason);
        return response()->json([
            'success' => true,
            'message' => 'درخواست‌ها با موفقیت رد شدند.'
        ]);
    }

    public function approve(int $expenseRequestId, ApprovalService $service)
    {
        $service->process([$expenseRequestId], 'approve', null);
        return redirect()->back()->with('success', 'درخواست تایید شد.');
    }

    public function reject(int $expenseRequestId, RejectRequest  $request, ApprovalService $service): JsonResponse
    {
        $service->process([$expenseRequestId], 'reject', $request->reason);
        return response()->json([
            'success' => true,
            'message' => 'درخواست با موفقیت رد شد.'
        ]);
    }
}

