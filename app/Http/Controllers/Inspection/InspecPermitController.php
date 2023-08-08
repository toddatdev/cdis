<?php

namespace App\Http\Controllers\Inspection;

use App\Http\Controllers\Controller;
use App\Models\Inspection\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InspecPermitController extends Controller
{

    public function store(Request $request)
    {
        try {

            $inspecPermitData = $request->except(['_token', 'inspection_id']);

            $inspection_id = $request->inspection_id;

            Inspection::find($inspection_id)->permitPlan()
                ->updateOrInsert(['inspection_id' => $inspection_id], $inspecPermitData);

            return response()
                ->json(['error' => false,
                    'title' => 'Inspection permit Info',
                    'message' => 'Inspection permit Information saved.']);

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
        }
    }
}
