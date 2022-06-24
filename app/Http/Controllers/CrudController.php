<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\account_info;

class CrudController extends Controller
{
     public function account_manage(){
        $data = account_info::get();
        return view('account_manage', ['data'=>$data]);
    }

    public function insert_data(request $request){
    	$account = $request->account;
    	$name = $request->name;
    	$sex = $request->sex;
    	$birthday = $request->b_y.'-'.$request->b_m.'-'.$request->b_d;
    	$mail = $request->mail;
    	$remark = $request->remark;
    	$db = new account_info;
    	$db->account = $account;
    	$db->name = $name;
    	$db->sex = $sex;
    	$db->birthday = $birthday;
    	$db->mail = $mail;
    	$db->remark = $remark;
    	$db->save();
    	return redirect()->back();
    }

    public function update_data(request $request){
        $birthday = $request->b_y.'-'.$request->b_m.'-'.$request->b_d;
        account_info::where('sno', $request->sno)->update([
            'account' => $request->account,
            'name' => $request->name,
            'sex' => $request->sex,
            'birthday' => $birthday,
            'mail' => $request->mail,
            'remark' => $request->remark,
        ]);
        return redirect()->back();
    }

    public function delete_data($sno){
        account_info::where('sno', $sno)->delete();
        return redirect('/');
    }
}
