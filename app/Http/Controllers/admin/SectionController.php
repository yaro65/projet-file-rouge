<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use Session;

class SectionController extends Controller
{
    public function sections()
    {
       Session::put('page','sections');
       $sections = Section::get()->toArray();
        //  dd($sections);
        return view('admin.sections.sections')->with(compact('sections'));
    }
    public function updateSectionStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
        }if($data['status']=="Active"){
            $status = 0;
        }else{
            $status = 1;
        }
        Section::where('id',$data['section_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'section_id'=>$data['section_id']]);
    }
    public function deletesections($id)
    {
           Section::where('id',$id)->delete();
           $message = "Section supprimer avec succes!";
           return redirect()->back()->with('success_message',$message);
    }

    public function addEditSection(Request $request , $id=null)
    {
        Session::put('page','sections');
          if($id==""){
            $title = "Ajouter Section";
            $section = new Section;
            $message = "Section Ajouter avec succes";
          }else{
            $title = "Ajouter Section";
            $section = Section::find($id);
            $message = "Section Ajouter avec succes";
          }
          if ($request->isMethod('post')) {
            $data = $request->all();

             // echo "<pre>"; print_r($data); die;
             $rules = [
                'nom' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessage = [
                'nom.required' => 'Veillez entrer le nom de la section',
                'nom.regex' => 'Le nom de la section est invalide',
            ];

            $this->validate($request, $rules, $customMessage);
              
            $section->nom = $data['nom'];
            $section->status = 1;
            $section->save();
            return redirect('admin/sections')->with('success_message',$message);
          }
           return view('admin.sections.add_edit_section')->with(compact('title','section'));
    }

}
