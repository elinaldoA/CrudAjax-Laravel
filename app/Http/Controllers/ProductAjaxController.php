<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductAjaxController extends Controller
{
    public function index(Request $request)
    {
   
        if ($request->ajax()) {
            $data = Product::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Editar</a>';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Deletar</a>';
    
                    return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('productAjax');
    }
    public function store(Request $request)
    {
        Product::updateOrCreate(['id' => $request->product_id],
                ['name' => $request->name,'detail'=>$request->detail]);
        return response()->json(['success'=>'Produto salvo com sucesso!']);
    }
    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }
    public function destroy($id)
    {
        Product::find($id)->delete();
        return response()->json(['success'=>'Produto excluído com sucesso']);
    }

}
