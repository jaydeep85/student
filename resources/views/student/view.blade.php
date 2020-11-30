@extends('admin.layout')

@section('content')

	
	 

<div class="container">
	<table class="table table-striped">
	  <tr>
	    <th>First Name:</th>
	    <td>{{$getData['first_name']}}</td>
	  </tr>
	  <tr>
	    <th>Middle Name:</th>
	    <td>{{$getData['middle_name']}}</td>
	  </tr>
	  <tr>
	    <th>Last Name:</th>
	    <td>{{$getData['last_name']}}</td>
	  </tr>
	  <tr>
	    <th>Email:</th>
	    <td>{{$getData['email']}}</td>
	  </tr>
	  <tr>
	    <th>Mobile:</th>
	    <td>{{$getData['mobile']}}</td>
	  </tr>
	  <tr>
	    <th>Gender:</th>
	    <td>{{$getData['gender']}}</td>
	  </tr>
	  <tr>
	    <th>Photo:</th>
	    <td><img src="{{ asset('photo/'.$getData['image']) }}" width="50px;"></td>
	  </tr>
	</table>
	<a href="{{ URL::previous() }}">Go Back</a>
</div>

	
@endsection