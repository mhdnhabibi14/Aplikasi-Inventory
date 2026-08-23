<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class PengaturanApkRequest extends FormRequest
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
            'nama_aplikasi'             => 'required',
            'tanggal_analisa_awal'      => 'required|date',
            'tanggal_analisa_akhir'     => 'required|date|after_or_equal:tanggal_analisa_awal',
            'minimal_stok'              => 'required|min:10'
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'nama_aplikasi.required'                => 'Nama Aplikasi wajib diisi',
            'tanggal_analisa_awal.required'         => 'Tanggal analisa awal wajib diisi',
            'tanggal_analisa_awal.date'             => 'Tanggal analisa awal harus berupa tanggal yang valid',
            'tanggal_analisa_akhir.required'        => 'Tanggal analisa akhir wajib diisi',
            'tamggal_analisa_akhir.date'            => 'tanggal analisa akhir harus berupa tanggal yang valid',
            'tanggal_analisa_akhir.after_or_equal'  => 'Tanggal analisa akhir harus sama dengan atau setelah tanggal analisa awal',
            'minimal_stok.required'                 => 'Minimal stok wajib diisi',
            'minimal_stok.min'                      => 'Minimal stok tidak boleh kurang dari 10'
        ];
    }
}
