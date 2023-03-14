<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\ResponseTemplate;
use App\Models\SimilarWord;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class SimilarWordController extends Controller
{
    use ResponseTemplate;
    public function index(Request $request)
    {
        if ($request->flag == 'search' && $request->q != "") {
            $words = SimilarWord::where('word', 'like', $request->q . '%')
                ->orWhere('translation', 'like', '%' . $request->q . '%')->paginate(100);
        } else {
            if ($request->flag == 'all') {
                $words =
                SimilarWord::orderBy('orderIndex', 'ASC')->get();
            } else {
                $words = SimilarWord::orderBy('orderIndex', 'ASC')->paginate($request->paginate);
            }
        }
        $this->setData($words);
        return $this->response();
    }

    public function store(Request $request)
    {
        SimilarWord::where('orderIndex','>=',$request->orderIndex ?? 0)->update(['orderIndex' => DB::raw('orderIndex + 1')]);
        $word = SimilarWord::create(['word' => $request->word,'translation' => $request->translation,'orderIndex' => $request->orderIndex ?? 1]);
        $this->setData($word);
        return $this->response();
    }

    public function update(Request $request,$id)
    {
        $word = SimilarWord::find($id);
        $word->update($request->all());
        $word = SimilarWord::find($id);
        $this->setData($word);
        return $this->response();
    }

    public function destroy($id)
    {
        $word = SimilarWord::find($id);
        SimilarWord::where('orderIndex', '>', $word->orderIndex)->update(['orderIndex' => DB::raw('orderIndex - 1')]);
        $word->delete();
        return $this->response();
    }

    public function moveUp($id)
    {
        $currentRow = SimilarWord::find($id);
        $targetRow = SimilarWord::where('orderIndex','<',$currentRow->orderIndex)->orderBy('orderIndex','DESC')->first();
        $currentOrderIndex = $currentRow->orderIndex;
        $currentRow->orderIndex = $targetRow->orderIndex;
        $currentRow->save();
        $targetRow->orderIndex = $currentOrderIndex;
        $targetRow->save();
        return $this->response();
    }

    public function moveDown($id)
    {
        $currentRow = SimilarWord::find($id);
        $targetRow = SimilarWord::where('orderIndex', '>', $currentRow->orderIndex)->orderBy('orderIndex', 'ASC')->first();
        $currentOrderIndex = $currentRow->orderIndex;
        $currentRow->orderIndex = $targetRow->orderIndex;
        $currentRow->save();
        $targetRow->orderIndex = $currentOrderIndex;
        $targetRow->save();
        return $this->response();
    }

    public function swap(Request $request)
    {
        $word = SimilarWord::find($request->id);
        $targetWord = SimilarWord::where('orderIndex',$request->targetIndex)->first();
        $wordIndex = $word->orderIndex;
        $word->orderIndex = $targetWord->orderIndex;
        $word->save();
        $targetWord->orderIndex = $wordIndex;
        $targetWord->save();
        return $this->response();
    }

    public function jump(Request $request)
    {
        $word = SimilarWord::find($request->id);
        $wordIndex = $word->orderIndex;
        $targetIndex = $request->targetIndex;
        $dif = $targetIndex - $wordIndex;
        if($dif > 0)
          SimilarWord::where('orderIndex', '>', $wordIndex)->where('orderIndex','<=',$targetIndex)->update(['orderIndex' => DB::raw('orderIndex - 1')]);
        else
          SimilarWord::where('orderIndex', '<', $wordIndex)->where('orderIndex', '>=', $targetIndex)->update(['orderIndex' => DB::raw('orderIndex + 1')]);
        $word->orderIndex = $targetIndex;
        $word->save();
        return $this->response();
    }
}
