<?php

namespace App\Http\Controllers;
use App\Models\ControllerVendedor;

use Illuminate\Http\Request;


class VendedorController extends Controller
{
    public function __construct(ControllerVendedor $vendedor)
    {
        $this->vendedor = $vendedor;
    }
    
    public function index()
    {        
        return view('admin.pages.vendedor.index');
    }

    public function create()
    {       
        return view('admin.pages.vendedor.create');
    }

    public function vendedorUpdate($id){
        if (!$data = $this->vendedor->find($id)){
            return view('admin.pages.vendedor.update', compact('data')); 
        } else {
            return view('admin.pages.vendedor.update', compact('data'));
        }
    }
    
    public function updateVendedor(Request $request)
    {                        
        if (!$data = $this->vendedor->find($request->id)){
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            $this->validate($request, $this->vendedor->rules());
        
            $dataForm =  $request->all();

            $data->update($dataForm);
            
            return view('admin.pages.vendedor.index');
        }
    }
}
