<?php

namespace App\Http\Controllers\PengadaanRequest;

use App\Http\Controllers\Controller;
use App\Http\Resources\PengadaanRequest\PengadaanRequestResource;
use App\Models\PengadaanRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CreatePengadaanRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request)
    {
        if($request->jenis_pengadaan_id == 33) {
            $main_alker_id = ['required', 'numeric', 'exists:main_alker,id'];
            $item_id = ['nullable', 'numeric', 'exists:items,id'];
        } else {
            $main_alker_id = ['nullable', 'numeric', 'exists:main_alker,id'];
            $item_id = ['required', 'numeric', 'exists:items,id'];
        }
        $this->validate($request, [
            'jenis_pengadaan_id' => [
                'required', 
                Rule::exists('params', 'id')->where(function ($query) {
                    return $query->where('category_param', 'jenis_pengadaan');
                }),
            ],
            'pengadaan_request_item' => ['required', 'array'],
            'pengadaan_request_item.*.main_alker_id' => $main_alker_id,
            'pengadaan_request_item.*.item_id' => $item_id,
            'pengadaan_request_item.*.total' => ['required', 'numeric'],
            'pengadaan_request_item.*.description' => ['nullable', 'string']
        ]);

        $last = PengadaanRequest::latest()->first();
        $code = !empty($last['code']) ? $last['code'] : 0;
        $inputPengadaanRequest['code'] = $code + 1;
        $inputPengadaanRequest['user_id'] = $request->user()->id;
        $inputPengadaanRequest['jenis_pengadaan_id'] = $request->jenis_pengadaan_id;
        $PengadaanRequest = PengadaanRequest::create($inputPengadaanRequest);

        $pengadaan_request_item = $request->pengadaan_request_item;
        $PengadaanRequest->pengadaan_request_item()->createMany($pengadaan_request_item);

        return new PengadaanRequestResource($PengadaanRequest);
    }
}
