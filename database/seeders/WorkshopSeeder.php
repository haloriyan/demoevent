<?php

namespace Database\Seeders;

use App\Models\WsCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pagi = WsCategory::where('name', 'LIKE', '%pagi%')->first();
        $siang = WsCategory::where('name', 'LIKE', '%siang%')->first();

        $pagis = ['Liver workshop', 'Pelvic workshop', 'Pancreatobiliary', 'Problematic cases in abdomen'];
        $siangs = ['Renal ultrasound', 'Pitfall and mimicking in GU and GI imaging', 'Bowel dan peritoneum', 'Imaging of abdominal and pelvic pain'];
        
        $pagiDatas = [];
        $siangDatas = [];
        
        foreach ($pagis as $pag) {
            array_push($pagiDatas, [
                'category_id' => $pagi->id,
                'title' => $pag,
                'count' => 0,
            ]);
        }
        foreach ($siangs as $sia) {
            array_push($siangDatas, [
                'category_id' => $siang->id,
                'title' => $sia,
                'count' => 0,
            ]);
        }

        DB::table('workshops')->insert($pagiDatas);
        DB::table('workshops')->insert($siangDatas);
    }
}
