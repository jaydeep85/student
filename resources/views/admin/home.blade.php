@extends('admin.layout')

@section('content')
<div class="container">
  @if(session()->has('message'))
                   <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
    <div class="row justify-content-center">
        <div class="col-lx-8">
          <button style="margin: 5px;" class="btn btn-danger btn-xs delete-all" id="delete_all" data-url="">Delete All</button>
          <table class="table table-bordered table-striped" id="student_datatable">
   <thead>
      <tr>
         <th></th>
         <th>ID</th>
         <th>First Name</th>
         <th>Middle Name</th>
         <th>Last Name</th>
         <th>Email</th>
         <th>Action</th>
      </tr>
   </thead>
</table>
          
        </div>
    </div>
</div>

<script type="text/javascript">
	
	$(document).ready( function () {

		$.ajaxSetup({
	      headers: {
	          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	      }
  		});
    
    var table = $('#student_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('student.list') }}",
        columns: [
            {data: 'checkbox', name: 'checkbox'},
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'first_name', name: 'first_name'},
            {data: 'middle_name', name: 'middle_name'},
            {data: 'last_name', name: 'last_name'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

	});

  $(document).on('click','#delete_all', function(){
    var id = [];
    if(confirm('Are you sure you want to Delete this data ?'))
    {
      $('.student_checkbox:checked').each(function(){

        id.push($(this).val());

      });

      if(id.length > 0)
      {
        $.ajax({
          url:"{{ route('student.deleteall') }}",
          method:"get",
          data:{id:id},
          success:function(data)
          {
              alert(data);
            $('#student_datatable').DataTable().ajax.reload();
          }

        });

      }
      else
      {
        alert('Please select atleast one checkbox');
      }
    }

  });
</script>
@endsection

