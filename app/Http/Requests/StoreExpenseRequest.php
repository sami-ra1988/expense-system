<?php

namespace App\Http\Requests;

use App\Payments\BankResolver;
use App\ValueObjects\Iban;
use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'national_code' => 'required|exists:users,national_code',
            'category_id'   => 'required|exists:expense_categories,id',
            'description'   => 'required|string',
            'amount'        => 'required|integer|min:1',
            'iban'          => 'required|string|min:2',
            'files.*'       => 'file|max:10240'
        ];
    }

    public function messages(): array
    {
        return [
            'national_code.required' => 'کد ملی الزامی است.',
            'national_code.exists'   => 'این کد ملی وجود ندارد.',
            'category_id.required'   => 'انتخاب نوع هزینه الزامی است.',
            'category_id.exists'     => 'نوع هزینه انتخاب شده معتبر نیست.',
            'description.required'   => 'شرح هزینه الزامی است.',
            'amount.required'        => 'مبلغ الزامی است.',
            'amount.integer'         => 'مبلغ باید عدد باشد.',
            'amount.min'             => 'مبلغ باید حداقل ۱ باشد.',
            'iban.required'          => 'شماره شبا الزامی است.',
            'iban.string'            => 'شماره شبا باید رشته باشد.',
            'iban.min'               => 'شماره شبا نامعتبر است.',
            'files.*.file'           => 'فایل ضمیمه معتبر نیست.',
            'files.*.max'            => 'حجم فایل ضمیمه نباید بیشتر از ۱۰ مگابایت باشد.'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $ibanValue = $this->input('iban');

            try {
                $iban = new Iban($ibanValue);
                $resolver = new BankResolver();
                $resolver->resolve($iban);
            } catch (\Exception $e) {
                $validator->errors()->add('iban', 'شماره شبا نامعتبر یا متعلق به بانک پشتیبانی نشده است.');
            }
        });
    }
}
