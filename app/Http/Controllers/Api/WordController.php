<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\ResponseTemplate;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class WordController extends Controller
{
    use ResponseTemplate;
    public function index(Request $request)
    {
        if($request->flag == 'search'&& $request->q != "")
        {
            $words = Word::where('word','like',$request->q.'%')
                           ->orWhere('translation','like','%'.$request->q.'%')->paginate(100);
        }
        else
        {
            $words = Word::orderBy('orderIndex', 'ASC')->paginate($request->per_page);
        }
        $this->setData($words);
        return $this->response();
    }

    public function store(Request $request)
    {
        Word::where('orderIndex','>=',$request->orderIndex ?? 0)->update(['orderIndex' => DB::raw('orderIndex + 1')]);
        $word = Word::create(['word' => $request->word,'translation' => $request->translation,'orderIndex' => $request->orderIndex ?? 1]);
        $this->setData($word);
        return $this->response();
    }

    public function update(Request $request,$id)
    {
        $word = Word::find($id);
        $word->update($request->all());
        $word = Word::find($id);
        $this->setData($word);
        return $this->response();
    }

    public function destroy($id)
    {
        $word = Word::find($id);
        Word::where('orderIndex', '>', $word->orderIndex)->update(['orderIndex' => DB::raw('orderIndex - 1')]);
        $word->delete();
        return $this->response();
    }

    public function moveUp($id)
    {
        $currentRow = Word::find($id);
        $targetRow = Word::where('orderIndex','<',$currentRow->orderIndex)->orderBy('orderIndex','DESC')->first();
        $currentOrderIndex = $currentRow->orderIndex;
        $currentRow->orderIndex = $targetRow->orderIndex;
        $currentRow->save();
        $targetRow->orderIndex = $currentOrderIndex;
        $targetRow->save();
        return $this->response();
    }

    public function moveDown($id)
    {
        $currentRow = Word::find($id);
        $targetRow = Word::where('orderIndex', '>', $currentRow->orderIndex)->orderBy('orderIndex', 'ASC')->first();
        $currentOrderIndex = $currentRow->orderIndex;
        $currentRow->orderIndex = $targetRow->orderIndex;
        $currentRow->save();
        $targetRow->orderIndex = $currentOrderIndex;
        $targetRow->save();
        return $this->response();
    }

    public function swap(Request $request)
    {
        $word = Word::find($request->wordId);
        $targetWord = Word::find($request->targetWordId);
        $wordIndex = $word->orderIndex;
        $word->orderIndex = $targetWord->orderIndex;
        $word->save();
        $targetWord->orderIndex = $wordIndex;
        $targetWord->save();
        return $this->response();
    }

    public function jump(Request $request)
    {
        $word = Word::find($request->id);
        $wordIndex = $word->index;
        $targetIndex = $request->targetIndex;
        $dif = $targetIndex - $wordIndex;
        if($dif > 0)
          Word::where('orderIndex', '>', $wordIndex)->where('orderIndex','<=',$targetIndex)->update(['orderIndex' => DB::raw('orderIndex - 1')]);
        else
          Word::where('orderIndex', '<', $wordIndex)->where('orderIndex', '>=', $targetIndex)->update(['orderIndex' => DB::raw('orderIndex + 1')]);
        $word->orderIndex = $targetIndex;
        $word->save();
        return $this->response();
    }
}
