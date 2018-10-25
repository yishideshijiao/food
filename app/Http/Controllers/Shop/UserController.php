<?php

namespace App\Http\Controllers\Shop;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users=User::paginate(2);
//        dd($users);
        return view("shop.user.index",compact("users"));
    }

    public function add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate($request,[
                "name"=>"required",
                "email"=>"required",
                "password"=>"required",

            ]);

            $data=$request->post();

//            dd($data);
            User::create($data);
            return redirect()->route("shop.user.index")->with("success","添加成功");
        }else{
            $shops=Shop::all();
//            dd($shops);
            return view("shop.user.add",compact("shops"));
        }
    }

    public function del($id)
    {
        $user=User::find($id);
        if($user->delete()){
            return redirect()->route("shop.user.index");
        }

    }

    public function edit(Request $request,$id)
    {
        $user=User::find($id);
        if($request->isMethod('post')){
            //验证
            $this->validate($request,[
                "name"=>"required",
                "email"=>"required",
                "password"=>"required",
            ]);
            $data=$request->post();
//            dd($data);
            if($user->update($data)){
                return redirect()->route("shop.user.index");
            }
        }else{
            $shops=Shop::all();
            return view('shop.user.edit',compact('user','shops'));
        }
    }
}
