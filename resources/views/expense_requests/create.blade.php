
@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">ثبت درخواست هزینه</h1>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('expense_requests.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- نوع هزینه -->
            <div>
                <label class="block font-medium mb-1">نوع هزینه</label>
                <select name="category_id" class="w-full border rounded p-2" required>
                    <option value="">انتخاب کنید</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- شرح -->
            <div>
                <label class="block font-medium mb-1">شرح</label>
                <textarea name="description" rows="3" class="w-full border rounded p-2">{{ old('description') }}</textarea>
            </div>

            <!-- مبلغ -->
            <div>
                <label class="block font-medium mb-1">مبلغ</label>
                <input type="number" name="amount" class="w-full border rounded p-2" value="{{ old('amount') }}" min="0" step="1">
            </div>

            <!-- شماره شبا -->
            <div>
                <label class="block font-medium mb-1">شماره شبا</label>
                <input type="text" name="iban" class="w-full border rounded p-2" value="{{ old('iban') }}">
            </div>
            <!-- کد ملی -->
            <div>
                <label class="block font-medium mb-1">کد ملی</label>
                <input type="text" name="national_code" class="w-full border rounded p-2" value="{{ old('national_code') }}" required>
            </div>

            <!-- فایل آپلود -->
            <div>
                <label class="block font-medium mb-1">فایل ضمیمه</label>
                <input type="file" name="file" class="w-full border rounded p-2">
            </div>

            <!-- دکمه ثبت -->
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    ثبت درخواست
                </button>
            </div>
        </form>
    </div>
@endsection
