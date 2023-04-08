<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RaporAdab;

class CA extends Model
{
    use HasFactory;
    protected $table = 'pencatatanadabdanibadah';
    protected $primaryKey = 'id';
    protected $fillable = ['nama', 'tanggalpencatatan', 'sholatlimawaktu', 'kualitas', 'catatan'];

    
        

    public function median(){
            $hadir = CA::where('kualitas', 'Hadir')->count();
            $alpha = CA::where('kualitas', 'Tidak Hadir')->count();
            $terlambat = CA::wher('kualitas', 'Terlambat')->count();

            if($hadir > $terlambat){
                if($hadir > $alpha){
                    return 'Hadir';
                }else{
                    return 'Alpha';
                }
            }if($alpha > $terlambat){
                return 'Alpha';
            }else{
                return 'Terlambat';
            }
        }

    public function average(){
        $iya = CA::where('sholatlimawaktu', 'Iya')->count();
        $tidak = CA::where('sholatlimawaktu', 'Tidak')->count();

        if($iya > $tidak){
            return 'Bagus';
        }else{
            return 'Buruk';
        }
    }

    public function make($query){
        $name =  CA::where('nama', '=', $query)->get();

            create::RaporAdab([
                'nama' => $query->name,
                'tahunajaran' => $query->id,
                'presentasikehadiran' => $query->average(),
                'rataratakualitas' => $query->median(),
                'catatan' => $query->catatan,
            ]);

    }
}