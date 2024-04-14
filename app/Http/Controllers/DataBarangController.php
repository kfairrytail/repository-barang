<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("barang",[
            "title" => "Data Barang",
            "data" => Barang::all()
        ]);
    }

    public function modifyIndex($id_barang)
    {

        $barang = Barang::all()->find($id_barang);
        if(is_null($barang)){
            return redirect("/barang");
        }
        return view("barang_edit",[
            "title" => "Edit Data ".$barang->nama_barang,
            "id_barang" => $id_barang
        ]);
    }

    public function addIndex()
    {
        return view("barang_add",[
            "title" => "Tambah Data",
        ]);
    }

    public function modify($id_barang,Request $request)
    {
        $barang = Barang::all()->find($id_barang);
        $validData = $request->validate([
            "nama_barang" => "required",
            "spesifikasi" => "required",
            "lokasi" => "required",
            "kondisi" => "required",
            "jumlah_barang" => "required|numeric",
            "sumber_dana" => "required",
        ]);
        $barang->update($validData);
        return redirect("/barang");
    }

    public function add(Request $request)
    {
        $validData = $request->validate([
            "nama_barang" => "required|min:3",
            "spesifikasi" => "required|min:3",
            "lokasi" => "required",
            "kondisi" => "required|min:4",
            "jumlah_barang" => "required|numeric|min:1",
            "sumber_dana" => "required",
        ]);
        Barang::query()->create($validData);
        return redirect("/barang");
    }

    public function delete(Request $request){
        $request->validate([
           "id_barang" => "required|numeric"
        ]);
        Barang::destroy($request->id_barang);
        return redirect("/barang");
    }


}
