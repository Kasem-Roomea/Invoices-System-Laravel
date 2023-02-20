<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Session;

class SectionController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:الاقسام', ['only' => ['index','store']]);
        $this->middleware('permission:اضافة قسم', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل قسم', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = section::all();
        return view('sections.section' , compact("sections"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'section_name.required' => 'أسم القسم مطلوب',
            'section_name.unique' => 'أسم القسم مسجل مسبقا',
            'section_name.max' => 'أسم القسم يحتوي على أحرف اكتر من المطلوب',
            'description.max' => 'الملاحظات تحتوي على عدد أحرف اكتر من المطلوب',
        ];
        $rule =[
            'section_name'=>'required|unique:sections,section_name|max:255',
            'description'=>'max:255'
        ];
        $validated = $request->validate($rule , $messages);


        section::create([
            'section_name'=> $request->section_name,
            'description'=> $request->description,
            'created_by'=> (Auth::user()->name),
        ]);

        session()->flash("add" , "تم أضافة القسم بنجاح");
        return redirect('/section');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $messages = [
            'section_name.required' => 'أسم القسم مطلوب',
            'section_name.unique' => 'أسم القسم مسجل مسبقا',
            'section_name.max' => 'أسم القسم يحتوي على أحرف اكتر من المطلوب',
            'description.max' => 'الملاحظات تحتوي على عدد أحرف اكتر من المطلوب',
        ];
        $rule =[
            'section_name'=>'required|unique:sections,section_name|max:255'.$id,
            'description'=>'max:255'
        ];
        $validated = $request->validate($rule , $messages);

        $section = section::find($id);
        $section->update([
            "section_name"=> $request -> section_name ,
            "description"=> $request -> description,
        ]);
        session()->flash('edit' , "تم التعديل بنجاح");
    return redirect('/section');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        section::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/section');
    }
}
