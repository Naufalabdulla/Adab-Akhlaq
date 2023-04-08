<?php

namespace App\Http\Controllers;

use App\Models\CA;
use App\Models\RaporAdab;
use App\Http\Controllers\RaporAdabController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Brian2694\Toastr\Facades\Toastr;
use PDF;

class CatatanAdabDanIbadahSantriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $pencatatanadabdanibadah = CA::all();

        return view('pencatatanadabdanibadah.index',compact('pencatatanadabdanibadah'));
    }

    public function create()
    {
        return view('pencatatanadabdanibadah.create');
    }

    public function store(Request $request)
    {
        $name = RaporAdab::where('nama', $request->nama)->first();
        if($name){
            $hadir = CA::where('nama', $name->nama)->where('kualitas', 'Berjamaah')->count();
            $alpha = CA::where('nama', $name->nama)->where('kualitas', 'Tidak Berjamaah')->count();
            $terlambat = CA::where('nama', $name->nama)->where('kualitas', 'Masbuq')->count();
        }else{
            $hadir = null;
            $alpha = null;
            $terlambat = null;
        }

        if($hadir && $alpha && $terlambat){
            if($hadir > $terlambat){
                if($hadir > $alpha){
                    $hasil = 'Berjamaah';
                }else{
                    $hasil = 'kesalaha';
                }
            }if($alpha > $terlambat){
                $hasil = 'keanehan';
            }else{
                $hasil = 'Masbuq';
            }

        }else{
            if($request->kualitas == 'Berjamaah'){
                $hasil = 'Berjamaah';
            }if($request->kualitas == 'Masbuq'){
                $hasil = 'Masbuq';
            }else{
                $hasil = 'gk tau';
            }
        }

        if($name){
            $name->update([
                'rataratakualitas' => $hasil,
            ]);
        }else{
            RaporAdab::create([
                'nama' => $request->nama,
                'tahunajaran' => 4,
                'rataratakualitas' => $hasil,
                'catatan' => $request->catatan
            ]);
        }
        CA::create($request->except(['_token','submit']));
        Toastr::success('Data berhasil di simpan','Berhasil');
        return redirect('/pencatatanadabdanibadah');
        // return Route::post('rapor/post', [RaporAdabController::class, 'post'])->name('rapor.post');;
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $pencatatanadabdanibadah = CA::find($id);
        return view('pencatatanadabdanibadah.edit',compact(['pencatatanadabdanibadah']));
    }

    public function update(Request $request, $id)
    {
        $pencatatanadabdanibadah = CA::find($id);
        $pencatatanadabdanibadah->update($request->except(['_token','submit']));
        Toastr::success('Data berhasil diubah','Berhasil');
        return redirect('/pencatatanadabdanibadah');
    }

    public function destroy($id)
    {
        $pencatatanadabdanibadah = CA::find($id);
        $pencatatanadabdanibadah->delete();
        Toastr::success('Data berhasil di hapus','Berhasil');
        return redirect('/pencatatanadabdanibadah');
    }
}
