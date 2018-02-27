@extends('layouts.master') @section('content')

<section class="content">
  <div class="row" style="padding:50px">
    <div class="col-xs-12">
      <div class="box" style="padding:40px">

        @if(!empty($errors->all()))
        <div class="alert alert-danger">
          {{ HTML::ul($errors->all()) }}
        </div>
        @endif

        @if(session()->has('message'))
        <div class="alert alert-success">
          {{ session()->get('message') }}
        </div>
        @endif

        @if(session()->has('error'))
        <div class="alert alert-danger">
          {{ session()->get('error') }}
        </div>
        @endif


        <div class="box-header">
          <div class="panel-heading"></div>

          {{ Form::open(array('url' => 'myfiles','files'=>true,'name'=>'myfiles')) }}
          <div class="form-group">
            <label for="attachment">upload xml File</label>
            <input type="file" name="attachment" class="form-control">
          </div>
          <button class="btn btn-info" type="submit"> upload</button>
          {{ Form::close() }}
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          @if(count($my_files)>0)
          <div class="row">
            <div class="col-md-6">
              <table id="example2" class="table table-bordered table-hover">
                <caption class="">All uploaded xml File</caption>
                <thead>
                  <tr>
                    <th>file</th>
                    <th>operation</th>

                  </tr>
                </thead>
                <tbody>
                  @foreach($my_files as $file)
                  <tr class="myfile" data-id="{{$file->id}}">
                    <td>{{$file->name}}</td>
                    <td>
                      <button type="button" data-toggle="tooltip" data-placement="left" title="delete" class="btn btn-danger  btn-xs delete_myfile" data-id="{{$file->id}}"> delete</button>
                    </td>

                  </tr>
                  @endforeach
                </tbody>

              </table>
            </div>
            <div class="col-md-6" id="filecontent">

            </div>
          </div>
          @else
          <div class="alert alert-success">no uploaded files.</div>
          @endif
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->


    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->

@endsection
