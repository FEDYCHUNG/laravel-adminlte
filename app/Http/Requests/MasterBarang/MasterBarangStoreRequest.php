<?php

namespace App\Http\Requests\MasterBarang;

use Illuminate\Foundation\Http\FormRequest;

class MasterBarangStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'kode_barang' => ['required', 'string'],
            'nm_barang' => ['required', 'string'],
            'harga_jual' => ['required'],
            'harga_beli' => ['required'],
            'satuan' => ['required'],
            'kategori' => ['required'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'kode_barang' => 'Kode Barang',
            'nm_barang' => 'Nama Barang',
            'harga_jual' => 'Harga Jual',
            'harga_beli' => 'Harga Beli',
            'satuan' => 'Satuan',
            'kategori' => 'Kategori',
        ];
    }
}
