
@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">جزئیات درخواست هزینه</h1>

        <div class="bg-white shadow rounded p-4 space-y-3">
            <p><strong>نوع هزینه:</strong> {{ $expense->type }}</p>
            <p><strong>شرح:</strong> {{ $expense->description }}</p>
            <p><strong>مبلغ:</strong> {{ number_format($expense->amount) }}</p>
            <p><strong>شماره شبا:</strong> {{ $expense->iban }}</p>
            <p><strong>کد ملی:</strong> {{ $expense->national_code }}</p>
            <p><strong>وضعیت:</strong> {{ $expense->status }}</p>

            <div>
                <strong>فایل‌های ضمیمه:</strong>
                <ul class="list-disc pl-5">
                    @foreach($expense->media as $file)
                        <li>
                            <a href="{{ route('expense_requests.download', $expense->id) }}" class="text-blue-600 hover:underline">
                                {{ $file->file_name ?? 'فایل ضمیمه' }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('expense_requests.index') }}" class="text-blue-600 hover:underline">بازگشت به لیست درخواست‌ها</a>
        </div>
    </div>
@endsection
