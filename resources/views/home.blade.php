@extends('layouts.app')

@section('content')

@if (\Session::has('status'))
    <div class="container">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ \Session::get('status')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
    </div>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @includeWhen($user->type=='App\\Staff', 'staff.home')
            @includeWhen($user->type=='App\\Client', 'client.home')
        </div>
    </div>
</div>
@endsection
