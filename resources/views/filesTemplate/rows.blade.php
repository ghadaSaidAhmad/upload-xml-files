<table id="example1" class="table table-bordered table-hover">
    <caption>{{$my_file->name}}</caption>
  <thead>
    <tr>
      <th>name</th>
      <th>job</th>
      <th>operation</th>

    </tr>
  </thead>
  <tbody>
    @foreach($my_file->rows as $row)
    <tr>
      <td>{{$row->name}}</td>
      <td>{{$row->job}}</td>
      <td>
        <button class="btn btn-info">edit</button>
          <button class="btn btn-danger"> delete</button>
      </td>

    </tr>
    @endforeach
  </tbody>
</table>
