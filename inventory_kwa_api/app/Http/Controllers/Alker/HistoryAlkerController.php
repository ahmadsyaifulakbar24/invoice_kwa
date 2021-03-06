<?php

namespace App\Http\Controllers\Alker;

use App\Helpers\FileHelpers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HistoryController;
use App\Http\Resources\HistoryResource;
use App\Models\HistoryAlker;
use Illuminate\Http\Request;

class HistoryAlkerController extends Controller
{
    public function __invoke(Request $request, $alker_id)
    {
        $history_alker = HistoryAlker::where('alker_id', $alker_id)->get();
        return HistoryResource::collection($history_alker);
    }
}