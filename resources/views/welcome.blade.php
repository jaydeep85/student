
@extends('layouts.app')
@section('content')
<div class="container">
	@if(session()->has('message'))
                   <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
  
     <div class="row justify-content-center">
         <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                    <div class="card-body">
                       
                    </div>
               </div>
        </div>
    </div>
</div>

@endsection