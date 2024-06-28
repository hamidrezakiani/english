<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\ResponseTemplate;
use App\Models\ReadingTest;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ReadingTestController extends Controller
{
    use ResponseTemplate;
    private $lastUpdatedAt;
    public function index(Request $request)
    {
        $this->lastUpdatedAt = $request->lastUpdatedAt;
        $currentTime = Carbon::now();
        if (!$this->lastUpdatedAt)
            $tests = $this->withoutDeleted();
        else
            $tests = $this->withDeleted();

        $this->setData($tests);
        $this->setVariable('currentUpdatingAt',$currentTime);
        return $this->response();
    }

    private function withoutDeleted()
    {
        return ReadingTest::with(['readings' => function ($query) {
            return $query->with(['questions' => function($query){
                return $query->with(['answers']);
            }])->orderBy('orderIndex');
        }])->orderBy('orderIndex', 'ASC')->get();
    }

    private function withDeleted()
    {
        $lastUpdate = $this->lastUpdatedAt;
        \Log::debug($lastUpdate);
        return ReadingTest::where('updated_at','>=',$lastUpdate)->withTrashed()
        ->with([
            'readings' => function ($query)use ($lastUpdate) {
                return $query->where('updated_at','>=',$lastUpdate)->withTrashed()
                ->with([
                    'questions' => function ($query)use ($lastUpdate) {
                        return $query->where('updated_at','>=',$lastUpdate)->withTrashed()
                        ->with(['answers' => function($query)use ($lastUpdate){
                            return $query->where('updated_at','>=',$lastUpdate)->withTrashed();
                        }])->orderBy('orderIndex');
                    }
                ]);
            }
        ])->orderBy('orderIndex', 'ASC')->get();
    }
}
