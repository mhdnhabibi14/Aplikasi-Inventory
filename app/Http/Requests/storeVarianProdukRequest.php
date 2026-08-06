<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class storeVarianProdukRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'produk_id' => 'required|exists:produks,id',
            'nama_varian' => 'required',
            'harga_varian' => 'required|numeric|min:0',
            'stok_varian' => 'required|numeric|min:0',
            'gambar_varian' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'produk_id.required' => 'Produk harus diisi',
            'produk_id.exists' => 'produk tidak ditemukan',
            'nama_varian.required' => 'Nama varian harus diisi',
            'harga_varian.required' => 'Harga varian harus diisi',
            'harga_varian.numeric' => 'Harga varian berupa angka',
            'harga_varian.min' => 'Harga varian tidak boleh minus',
            'stok_varian.required' => 'Stok varian harus diisi',
            'stok_varian.numeric' => 'Stok Harus berupa angka',
            'stok_varian.min' => 'Stok varian tidak boleh minus',
            'gambar_varian.required' => 'Gambar varian wajin diupload',
            'gambar_varian.image' => 'Gambar varian tidak sesuai',
            'gambar_varian.mimes' => 'Format gambar varian tidak sesuai',
            'gambar_varian.max' => 'Ukuran gambar varian terlalu besar',
        ];
    }
}
