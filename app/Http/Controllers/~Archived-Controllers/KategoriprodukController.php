<?php

namespace App\Http\Controllers;
use Request;
use Illuminate\Support\Facades\DB;
use App\Kategoriproduk;
Use Alert;



class KategoriprodukController extends Controller
{
    public function index(){
		$kategori = DB::table('kategoriproduk')->get();

        return view('pages.crud.kategoriproduk',['kategoriproduk' => $kategori]);
    }
    public function add(){
        return view('pages.crud.tambah_kategoriproduk');
    }
    public function postAdd(){
		$new						= new Kategoriproduk;
		$new->nama 		= Request::get('nama');
		$act 						= $new->save();

		if ($act){
			return redirect('kategoriproduk')->with([	
				alert()->success('BERHASIL','Data Berhasil Disimpan')
			]);
		}else{
			return redirect()->back()->with([
				Alert::error('GAGAL', 'Data Gagal Disimpan')

			]);
		}
	}
	public function getDelete($id){
		$act['data']= kategoriproduk::findOrFail($id)->delete();
		if ($act){
			return redirect('kategoriproduk')->with([
				alert()->success('BERHASIL','Data Berhasil Dihapus')

			]);
		}else{
			return redirect()->back()->with([
				Alert::error('GAGAL', 'Data Gagal Dihapus')

			]);
		}
	}
	public function getEdit($id){
		$data['data']			= kategoriproduk::findOrFail($id);
		$data['id']				= $id;

		return view('pages.crud.tambah_kategoriproduk',$data);
	}
	public function postEdit($id){
		$new					= kategoriproduk::findOrFail($id);

		$act 					= $new->save();

		if ($act){
			return redirect('kategoriproduk')->with([
				alert()->success('BERHASIL','Data Berhasil Diedit')

			]);
		}else{
			return redirect()->back()->with([
				Alert::error('GAGAL', 'Data Gagal Diedit')
			]);
		}
	}   
}
?>  

