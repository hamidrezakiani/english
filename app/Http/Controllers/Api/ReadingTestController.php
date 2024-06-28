<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\ResponseTemplate;
use App\Models\Reading;
use App\Models\ReadingTest;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ReadingTestController extends Controller
{
    use ResponseTemplate;
    private $lastUpdatedAt;
    public function index(Request $request)
    {
        $this->lastUpdatedAt = Carbon::createFromTimestamp($request->lastUpdatedAt);
        $currentTime = Carbon::now()->timestamp;
        if (!$request->lastUpdatedAt){
            \Log::debug($request->lastUpdatedAt);
            $tests = $this->withoutDeleted();
        }
        else{
            \Log::debug($request->lastUpdatedAt."deleted");
            $tests = $this->withDeleted();
        }
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
        return ReadingTest::where(function($query)use($lastUpdate){
             return $query->withTrashed()->where('updated_at','>=',$lastUpdate)
             ->orWhereHas('readings',function($query)use($lastUpdate){
                return $query->withTrashed()->where('updated_at','>=',$lastUpdate)->orWhereHas('questions',function($query)use($lastUpdate){
                    return $query->withTrashed()->where('updated_at','>=',$lastUpdate)
                    ->orWhereHas('answers',function($query)use($lastUpdate){
                        return $query->withTrashed()->where('updated_at','>=',$lastUpdate);
                    });
                });
             });
        })->withTrashed()
        ->with([
            'readings' => function ($query)use ($lastUpdate) {
                return $query->withTrashed()->where(function($query)use($lastUpdate){
                    return $query->withTrashed()->where('updated_at','>=',$lastUpdate)
                    ->orWhereHas('questions',function($query)use($lastUpdate){
                        return $query->withTrashed()->where('updated_at','>=',$lastUpdate)
                        ->orWhereHas('answers',function($query)use($lastUpdate){
                            return $query->withTrashed()->where('updated_at','>=',$lastUpdate);
                        });
                });
            })->with([
                    'questions' => function ($query)use ($lastUpdate) {
                        return $query->where(function($query)use($lastUpdate){
                            return $query->withTrashed()->where('updated_at','>=',$lastUpdate)
                            ->orWhereHas('answers',function($query)use($lastUpdate){
                                return $query->withTrashed()->where('updated_at','>=',$lastUpdate);
                            });
                        })->withTrashed()
                        ->with(['answers' => function($query)use ($lastUpdate){
                            return $query->withTrashed()->where('updated_at','>=',$lastUpdate);
                        }])->orderBy('orderIndex');
                    }
                ]);
            }
        ])->orderBy('orderIndex', 'ASC')->get();
    }
}
