<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marque;
use Session;

class MarqueController extends Controller
{
    public function marques()
    {
       Session::put('page','marques');
       $marques = Marque::get()->toArray();
        //  dd($sections);
        return view('admin.marque.marques')->with(compact('marques'));
    }
    public function updateMarqueStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
        }if($data['status']=="Active"){
            $status = 0;
        }else{
            $status = 1;
        }
        Marque::where('id',$data['marque_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'marque_id'=>$data['marque_id']]);
    }
    public function deletemarques($id)
    {
           Marque::where('id',$id)->delete();
           $message = "Marque supprimer avec succes!";
           return redirect()->back()->with('success_message',$message);
    }

    public function addEditMarque(Request $request , $id=null)
    {
        Session::put('page','marques');
          if($id==""){
            $title = "Ajouter Marque";
            $marque = new Marque;
            $message = "Marque Ajouter avec succes";
          }else{
            $title = "Ajouter Marque";
            $marque = Marque::find($id);
            $message = "Marque Ajouter avec succes";
          }
          if ($request->isMethod('post')) {
            $data = $request->all();

             // echo "<pre>"; print_r($data); die;
             $rules = [
                'nom' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessage = [
                'nom.required' => 'Veillez entrer le nom de la marque',
                'nom.regex' => 'Le nom de la marque est invalide',
            ];

            $this->validate($request, $rules, $customMessage);
              
            $marque->nom = $data['nom'];
            $marque->status = 1;
            $marque->save();
            return redirect('admin/marques')->with('success_message',$message);
          }
           return view('admin.marque.add_edit_marque')->with(compact('title','marque'));
    }
}
