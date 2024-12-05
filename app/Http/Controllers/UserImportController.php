<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessUserBatch;
use Maatwebsite\Excel\Facades\Excel;

class UserImportController extends Controller
{
    public function import()
    {
        $filePath = public_path('users.csv');

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File does not exist!'], 404);
        }

        // Load data from CSV
        $data = Excel::toArray([], $filePath)[0];

        

        if (empty($data) || count($data) < 2) {
            return response()->json(['error' => 'No data found in the file!'], 400);
        }  

        // Chunk data for batch processing
        $chunkSize = 100; // Process 100 rows per batch
        $chunks = array_chunk($data, $chunkSize);
        $header = [];

        

        foreach ($chunks as $chunk) {
            // Dispatch job to process the batch
            dispatch(new ProcessUserBatch($chunk, $header));
        }

        return response()->json(['message' => 'File uploaded. Processing in progress!']);
    }
}
