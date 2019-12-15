@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @includeWhen($user->type=='App\\Staff', 'staff.home')
            @includeWhen($user->type=='App\\Client', 'client.home')
        </div>
    </div>
</div>
@endsection
