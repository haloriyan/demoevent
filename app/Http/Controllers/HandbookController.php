<?php

namespace App\Http\Controllers;

use App\Models\Handbook;
use App\Models\HandbookCategory;
use App\Models\HandbookCategoryPivot;
use Illuminate\Http\Request;

class HandbookController extends Controller
{
    public function store(Request $request) {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $categoryIDs = json_decode($request->category_ids);

        $handbook = Handbook::create([
            'title' => $request->title,
            'filename' => $fileName,
            'size' => $file->getSize(),
            'kiosk' => true,
        ]);

        $file->move(
            public_path('storage/handbooks'), $fileName
        );

        foreach ($categoryIDs as $cat) {
            HandbookCategoryPivot::create([
                'handbook_id' => $handbook->id,
                'category_id' => $cat,
            ]);
        }

        return redirect()->back()->with([
            'message' => "Berhasil menambahkan " . $handbook->title,
        ]);
    }
    public function delete(Request $request, $id) {
        $book = Handbook::where('id', $id);
        $handbook = $book->first();

        $book->delete();
        
        return redirect()->back()->with([
            'message' => "Berhasil menghapus " . $handbook->title,
        ]);
    }

    public function storeCategory(Request $request) {
        $cat = HandbookCategory::create([
            'name' => $request->name,
            'priority' => 0,
        ]);

        return redirect()->back()->with([
            'message' => "Berhasil menambahkan kategori " . $request->name,
        ]);
    }
    public function deleteCategory(Request $request, $id) {
        $cat = HandbookCategory::where('id', $id);
        $category = $cat->first();

        $cat->delete();
        
        return redirect()->back()->with([
            'message' => "Berhasil menghapus kategori " . $category->name,
        ]);
    }
}
