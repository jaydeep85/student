<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use DataTables;

class AjaxStudentController extends Controller
{
    public function index(Request $request)
    {
        if(request()->ajax()) {
            return DataTables::of(Student::select('id','first_name','middle_name','last_name','email')->get())
            
            ->addColumn('action', function($row){
   
                $btn = '<a href="/admin/ajaxStudentView/'.$row->id.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View" class="view btn btn-success btn-sm viewStudent">View</a>';

                   $btn = $btn.' <a href="/admin/ajaxStudentEdit/'.$row->id.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editStudent">Edit</a>';

                   $btn = $btn.' <a onclick="return confirm(\'Are you sure?\')" href="/admin/ajaxStudentDelete/'.$row->id.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteStudent">Delete</a>';

                            return $btn;
                    })
            ->addColumn('checkbox', '<input type="checkbox" class= "student_checkbox" name="student_checkbox[]" value="{{$id}}">')
            ->rawColumns(['checkbox','action'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('admin.home');

    }

    public function edit(Request $request,$id)
    {
        if(isset($id))
        {
            if($getEditData = Student::where('id', $id)->first()->toArray())
            {                
                return view('student.edit', compact('getEditData'));
            }
        }

        return Redirect::back();
    }

    public function view(Request $request, $id)
    {
        if(isset($id))
        {
            if($getData = Student::where('id', $id)->first()->toArray())
            {                
                return view('student.view', compact('getData'));
            }
        }

        return Redirect::back();        

    }

    public function update(Request $request)
    {
        $request->validate([
        'fname' => 'required|string|max:255',
        'lname' => 'required|string|max:255',
        'mname' => 'required|string|max:255',
        'mobile' => 'required|numeric|digits:10',
        'gender' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'photo' => 'image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $profilePhoto = $request->profile;
        if($files = $request->file('photo'))
        {
            $destinationPath = 'photo/';
            $profilePhoto = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profilePhoto);
            $file_old = $destinationPath.$request->profile;
            unlink($file_old);
        }

        Student::whereId($request->editId)->update([
          'first_name' => $request->fname,
          'last_name' => $request->lname,
          'middle_name' => $request->mname,
          'gender' => $request->gender,
          'email' => $request->email,
          'mobile' => $request->mobile,
          'image' => $profilePhoto
        ]);

        return redirect()->route('admin.home')->with('message', 'Student Data Updated');

    }

    public function delete(Request $request, $id)
    {
        if(isset($id))
        {
            $delData = Student::find($id);
            
            if($delData == null)
            {
                return Redirect::back();                
            }
            else
            {
                $imgName = $delData->image;
                $imgPath = 'photo/'.$imgName;
                unlink($imgPath); 
                $delData->delete();
                return redirect()->route('admin.home')->with('message', 'Record deleted successfully');
            }

        }

        return Redirect::back();        
    }

    public function massDelete(Request $request)
    {
        $student_id_arr = $request->id;

        $studentImgs = Student::select('image')->whereIn('id', $student_id_arr)->get();

        foreach ($studentImgs as $img) {          
            $imgPath = 'photo/'.$img->image;
            unlink($imgPath);
        }

        $student = Student::whereIn('id', $student_id_arr);

        if($student->delete())
        {
            echo 'Data Deleted';
        }
    }

        
}
