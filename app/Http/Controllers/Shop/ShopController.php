<?php

namespace App\Http\Controllers\Shop;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{

    public function index()
    {
       $shops=Shop::paginate(4);
       return view("shop.shop.index",compact("shops"));
    }

    public function add(Request $request){
        if($request->isMethod('post')){
            //验证
//            $this->validate($request,[
//                "name"=>"required",
//                "status"=>"required",
//                "sort"=>"required",
//                'img'=>"required"
//            ]);

            $data=$request->post();
            $data['shop_img']=$request->file("img")->store("images","image");
//            dd($data);
           Shop::create($data);
            return redirect()->route("shop.shop.index")->with("success","添加成功");
        }else{
            return view("shop.shop.add");
        }
    }

    public function del($id)
    {
        $shop=Shop::find($id);
        if($shop->delete()){
            return redirect()->route("shop.shop.index");
        }

    }

    public function edit(Request $request,$id)
    {
        $shop=Shop::find($id);
        if($request->isMethod('post')){
            //验证
//            $this->validate($request,[
//                "name"=>"required",
//                "status"=>"required",
//                "sort"=>"required",
//                'img'=>"required"
//            ]);
            $data=$request->post();
//            dd($data);
            $data['shop_img']=$request->file("img")->store("images","image");
            if($shop->update($data)){
                return redirect()->route("shop.shop.index");
            }
        }else{
            return view('shop.shop.edit',compact('shop'));
        }
    }



}
