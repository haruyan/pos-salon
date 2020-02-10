<?php

namespace App\Http\Controllers;
use Request;
use App\Produk;
use App\MemberCategory;

class ProdukController extends Controller
{
	function KodeProduk(){
		$tgl	=date('Y-m-d');
		$number	=Produk::where("created_at","like","%".$tgl."%")->count();
		$angka	=$number +1;
		$code	='PDK'.date('ymd').$angka;
		return $code;
	}
	public function getProduk(){
		$data['page_titel']	=	'Produk';
		$data['data'] 		=	Produk::all();
		return view('pages.crud.produk',$data);
	}
	public function getAdd(){
		$data['page_titel']		='Tambah Produk';
		$data['kode']		=self::KodeProduk();
		return view('pages.crud.p_tambah',$data);
	}

	public function postAdd(){
		$new	= new Produk;
		$new->nama_deskripsi 	=Request::get('nama_deskripsi');
		$new->nama_category	=Request::get('nama_category');
		$new->foto 	=Request::get('foto');
		$new->harga	=Request::get('harga');
		$new->kode_produk	=Request::get('kode_produk');
        $act 	=$new->save();
        if ($act) {
			return redirect('produk')->with([
				'message' => 'Data Berhasil Di Simpan','message_type'=>'success']);
		}else{
			return redirect()->back()->with([
				'message' => 'Gagal Menyimpan Data','message_type'=>'warning']);
		}
		
	}
	public function getEdit($id){
		$data['data']		=produk::findOrFail($id);
		$data['page_titel']	='Edit Produk';
		$data['id']			=$id;
		return view('pages.crud.p_tambah',$data);
	}
	public function postEdit($id){
		$new	=Produk::findOrFail($id);
		$new->nama_deskripsi 	=Request::get('nama_deskripsi');
		$new->nama_category	=Request::get('nama_category');
		$new->foto 	=Request::get('foto');
		$new->harga	=Request::get('harga');
		$new->kode_produk	=Request::get('kode_produk');
		$act 	=$new->save();
		if ($act) {
			return redirect('/produk')->with([
				'message' => 'Data Berhasil Di Ubah','message_type'=>'success']);
		}else{
			return redirect()->back()->with([
				'message' => 'Gagal Mengedit Data','message_type'=>'warning']);
		}
	}
	public function getDelete($id){
		$act['data']=Produk::findOrFail($id)->delete();
		if ($act) {
			return redirect()->back()->with([
				'message' => 'Data Berhasil Di Hapus','message_type'=>'success']);
		}else{
			return redirect()->back()->with([
				'message' => 'Gagal Menghapus Data','message_type'=>'warning']);
		}

	}
}	