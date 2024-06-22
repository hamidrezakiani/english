<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\ResponseTemplate;
use App\Models\WordTest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WordTestController extends Controller
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

            $tests = $this->withDeleted();
        $this->setData($tests);
        $this->setVariable('currentUpdatingAt',$currentTime);
        return $this->response();
    }

    private function withoutDeleted()
    {
        return WordTest::with([
            'questions' => function ($query) {
                return $query->with(['answers']);
            }
        ])->orderBy('orderIndex', 'ASC')->get();
    }

    private function withDeleted()
    {
        $lastUpdate = $this->lastUpdatedAt;
        return WordTest::withTrashed()->where('updated_at','>=',$lastUpdate)->orWhereHas('questions',function($query)use($lastUpdate){
            return $query->withTrashed()->where('updated_at','>=',$lastUpdate)
            ->orWhereHas('answers',function($query)use($lastUpdate){
                return $query->withTrashed()->where('updated_at','>=',$lastUpdate);
            });
        })
        ->with([
            'questions' => function ($query)use ($lastUpdate) {
                return $query->withTrashed()->where('updated_at','>=',$lastUpdate)
                ->orWhereHas('answers',function($query)use($lastUpdate){
                    return $query->withTrashed()->where('updated_at','>=',$lastUpdate);
                })
                ->with(['answers' => function($query)use ($lastUpdate){
                    return $query->withTrashed()->where('updated_at','>=',$lastUpdate);
                }]);
            }
        ])->orderBy('orderIndex', 'ASC')->get();
    }
}
