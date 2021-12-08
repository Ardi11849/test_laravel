<?php

use App\Models\Pajak;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/pajak', function(Request $request){
    $data = DB::table('Pajaks')
            ->select(
                DB::raw("Items.id as ItemId, Items.nama as NamaItem,
                        CONCAT('[', GROUP_CONCAT(JSON_OBJECT('id',Pajaks.id, 'nama', Pajaks.nama, 'rate', Pajaks.rate)),']') as Pajak
                        ")
            )
            ->join('Items','Items.id','=','Pajaks.id_item')
            ->groupBy('ItemId', 'NamaItem')
            ->get();
    return $data;
});

Route::post('/pajak', function(Request $request){
    $pajak = new Pajak;
    $pajak->id_item = $request->id_item;
    $pajak->nama = $request->nama;
    $pajak->rate = $request->rate;
    $pajak->save();
    return "Data berhasil di tambahkan";
});

Route::put('/pajak', function(Request $request){
    $id = $request->id;
    $id_item = $id_item;
    $nama = $request->nama;
    $rate = $request->rate;

    $pajak = DB::table('Pajaks')
              ->where('id', $id)
              ->update(['id_item', $id_item, 'nama' => $nama, 'rate' => $rate]);
    return "Data berhasil di ubah";
});

Route::delete('/pajak', function (Request $request)
{
    $id = $request->id;
    $pajak = DB::table('Pajaks')->where('id', $id)->delete();
    return "Data berhasil di hapus";
});

Route::get('/item', function(){
    $data = Item::all();
    return $data;
});

Route::post('/item', function(Request $request){
    $item = new Item;
    $item->nama = $request->nama;
    $item->save();
    return "Data berhasil di tambahkan";
});

Route::put('/item', function(Request $request){
    $id = $request->id;
    $nama = $request->nama;

    $item = DB::table('Items')
              ->where('id', $id)
              ->update(['nama' => $nama]);
    return "Data berhasil di ubah";
});

Route::delete('/item', function (Request $request)
{
    $id = $request->id;
    $item = DB::table('Items')->where('id', $id)->delete();
    return "Data berhasil di hapus";
});
