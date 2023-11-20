<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Site;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    public function show($router){
        $view = 'page';
        $pages = Page::where(['active' => 1,'router'=>$router])->first();
        if(View::exists($router)) $view = $router;

        return view($view, array_merge($this->getDataLayout(),['pages'=> $pages]));
    }

    public function saveContact(Request $request){
        if($request->input('submit')){  
            $data = [
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'content' => $request->input('content')
            ];
            $validate = [
                'name'    => 'max:100', 
                'address' => 'max:225', 
                'email'   => 'nullable|email|max:225',
                'phone'   => 'max:25',
                'content' => 'required',
            ];
            
            $valid = Validator::make($data, $validate);
            if ($valid->fails()){
                return redirect('/lien-he')->with('errors', $valid->errors());
            }

            $data = Contact::insertGetId($data);  
            return redirect('/lien-he')->with('success', 'success');
        }
    }
}
