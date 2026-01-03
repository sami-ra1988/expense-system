@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">کارتابل تایید درخواست‌ها</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border-collapse border border-gray-300 table">
            <thead>
            <tr class="bg-gray-100">
                <th><input type="checkbox" id="selectAll"></th>
                <th>نوع هزینه</th>
                <th>شرح</th>
                <th>مبلغ</th>
                <th>کاربر</th>
                <th>فایل ضمیمه</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($requests as $request)
                <tr class="hover:bg-gray-50">
                    <td class="text-center">
                        <input type="checkbox" class="request-checkbox" value="{{ $request->id }}">
                    </td>
                    <td>{{ $request->category->title }}</td>
                    <td>{{ $request->description }}</td>
                    <td>{{ number_format($request->amount) }}</td>
                    <td>{{ $request->user->name }}</td>
                    <td class="text-center">
                        @if($request->media->isNotEmpty())
                            <a href="{{ route('expense_requests.download', $request) }}" class="text-blue-600 hover:underline">دانلود</a>
                        @else
                            -
                        @endif
                    </td>
                    <td class="space-x-2">
                        <!-- تایید تکی -->
                        <form method="POST" action="{{ route('expense_requests.approve', $request->id) }}" class="inline-block">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700">تایید</button>
                        </form>

                        <!-- رد تکی -->
                        <button type="button"
                                class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700"
                                onclick="showRejectModal({{ $request->id }}, '{{ route("expense_requests.reject", $request->id) }}')">رد</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- دکمه‌های دسته جمعی -->
        <div class="mt-4 flex space-x-2">
            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700" onclick="bulkApprove()">تایید انتخاب شده</button>
            <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" onclick="showBulkReject()">رد انتخاب شده</button>
        </div>
    </div>

    <!-- مودال رد تکی -->
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded p-6 w-96">
            <h2 class="text-xl font-bold mb-4">علت رد درخواست</h2>
            <textarea id="rejectReason" class="w-full border rounded p-2 mb-4" rows="3" placeholder="علت رد را وارد کنید..."></textarea>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeRejectModal()" class="bg-gray-300 px-3 py-1 rounded">انصراف</button>
                <button type="button" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700" onclick="submitReject()">رد</button>
            </div>
        </div>
    </div>

    <script>

        // انتخاب همه چک‌باکس‌ها
        document.getElementById('selectAll').addEventListener('change', function() {
            document.querySelectorAll('.request-checkbox').forEach(cb => cb.checked = this.checked);
        });


        let rejectId = '';
        let rejectUrl = '';

        function showRejectModal(id, url) {
            rejectId = id;
            rejectUrl = url;  // مسیر دقیق لاراول
            document.getElementById('rejectReason').value = '';
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function submitReject() {
            const reason = document.getElementById('rejectReason').value.trim();
            if(!reason){ alert('لطفا علت رد را وارد کنید.'); return; }

            fetch(rejectUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ reason: reason})
            })
                .then(res => res.json())
                .then(data => {
                    closeRejectModal();
                    if(data.success){
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('خطا در رد درخواست.');
                    }
                });
        }
        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
        // تایید دسته جمعی
        function bulkApprove() {
            const selected = Array.from(document.querySelectorAll('.request-checkbox:checked')).map(cb => cb.value);
            if(selected.length === 0) { alert('لطفا حداقل یک درخواست را انتخاب کنید.'); return; }

            if(!confirm('آیا مطمئن هستید می‌خواهید این درخواست‌ها را تایید کنید؟')) return;

            fetch('{{ route("expense_requests.bulk_approve") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },

                body: JSON.stringify({
                    request_ids: selected,
                    action: 'approve'
                })
            })
                .then(res => res.json())
                .then(data => {
                    if(data.success){
                        alert('تایید دسته جمعی با موفقیت انجام شد.');
                        location.reload();
                    } else {
                        alert('خطا در انجام عملیات.');
                    }
                });
        }

        // رد دسته جمعی
        function showBulkReject() {
            const selected = Array.from(document.querySelectorAll('.request-checkbox:checked')).map(cb => cb.value);
            if(selected.length === 0){ alert('لطفا حداقل یک درخواست را انتخاب کنید.'); return; }

            const reason = prompt('علت رد دسته‌جمعی را وارد کنید:');
            if(!reason) return;

            fetch('{{ route("expense_requests.bulk_reject") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    request_ids: selected,   // حتما آرایه باشد
                    action: 'reject',        // اضافه کردن action
                    reason: reason           // علت رد
                })
            })
                .then(res => res.json())
                .then(data => {
                    if(data.success){
                        alert('رد دسته‌جمعی با موفقیت انجام شد.');
                        location.reload();
                    } else {
                        alert('خطا در انجام عملیات.');
                    }
                });
        }
    </script>
@endsection
