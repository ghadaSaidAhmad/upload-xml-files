<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\uploadXmlRequest;
use Illuminate\Support\Facades\Input;
use App\Myfile;

class MyFileController extends Controller
{

  protected $uploadDestination = 'uploads/myfiles/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $my_files=Myfile::paginate(5);
      return view('index',compact('my_files'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(uploadXmlRequest $request)
    {


      if (Input::hasFile('attachment'))
      {

          $destination = storage_path($this->uploadDestination);
          $file_name = time() . '.xml';
          $request->file('attachment')->move($destination, $file_name);

         //insert uploaded file name in my_files table
          $my_file = new Myfile();
          $my_file->name = $file_name;
          $my_file->save();

          //parse xml
          try {
            $xml = simplexml_load_file($destination.'/'.$file_name);

            foreach ($xml->employee as $row)
            {
           //insert parsed xml in to my_rows table
            $my_file->rows()->create([
                                      'name' => $row->name,
                                      'job' => $row->job,
                                  ]);
            }

          } catch (\Exception $e)
          {
              return redirect()->back()->with('message', 'corrupted file,please select xml file  ');
          }

          //redirect back
          return redirect()->back()->with('message', 'file Saved Successfully');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $my_file=Myfile::find($id);
        // dd($my_rows);
        return[
            'response'=> 1,
           'data'=> view('filesTemplate.rows',compact('my_file'))->render()
        ] ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
