<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\uploadXmlRequest;
use Illuminate\Support\Facades\Input;
use App\Myfile;
use App\MyRow;

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

            Myfile::find($my_file->id)->delete();
              return redirect()->back()->with('error', 'corrupted file,please select xml file  ');
          }

          //redirect back with success message
          return redirect()->back()->with('message', 'file uploded Successfully');

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

        return[
            'response'=> 1,
           'data'=> view('filesTemplate.myrows',compact('my_file','id'))->render()
        ] ;
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Myfile::find($id)->delete();
    }

    /**
     * insert row the myrows resource.
     *
     * @param  int  $request
     * @return \Illuminate\Http\Response
     */

     public function insertRow(Request $request)
    {
      $result=MyRow::create(['name'=>$request->name,'job'=>$request->job,'myfile_id'=>$request->myfile_id]);
      if ($result) echo 'Data Inserted';
    }

    /**
     * update row the myrows resource.
     *
     * @param  int  $request
     * @return \Illuminate\Http\Response
     */
    public  function updateRow(Request $request)
   {
     $result=MyRow::where('id',$request->id)->update([$request->column_name=>$request->value]);
     if ($result)  echo 'Data Updated';
   }

   /**
    * delete row the myrows resource.
    *
    * @param  int  $request
    * @return \Illuminate\Http\Response
    */

   public function deleteRow(Request $request)
  {
    $result=MyRow::where('id',$request->id)->delete();
    if ($result)  echo 'Data Deleted';
  }

  /**
   * get all rows
   *
   * @param  int  $request
   * @return json
   */
  public function fetchRows(Request $request)
  {

      $query = MyRow::where('myfile_id',$request->file_id);
      if(isset($_POST["search"]["value"]))
      {
       $query = $query->where('name','like','%'.$_POST["search"]["value"].'%');
       $query = $query->where('job','like','%'.$_POST["search"]["value"].'%');

      }

      if(isset($_POST["order"]))
      {
        $query = $query->orderBy($columns[$_POST['order']['0']['column']]);

      }

      $result=$query->get();

     $data = array();
     foreach ($result as  $row)
     {
        $sub_array = array();
       $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="name">' . $row->name . '</div>';
       $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="job">' . $row->job. '</div>';
       $sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["id"].'">Delete</button>';
       $data[] = $sub_array;
     }
    $output = array(
                     "draw"    => intval($_POST["draw"]),
                     "recordsTotal"  =>  count($result),
                     "recordsFiltered" => count($result),
                     "data"    => $data
                    );

    echo json_encode($output);

  }


}
