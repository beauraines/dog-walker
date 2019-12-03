<div class="card">
    <div class="card-header">Bookings</div>
    <div class="card-body">
        @foreach ( $user->bookings as $booking )
            <p>
                {{$booking->date}}
                {{-- <a href="{{route('booking.destroy',$booking->id}}"</a> --}}
                {!! Form::open(['route' => ['booking.destroy', $booking->id], 'method' => 'delete',"class"=>"float-right"]) !!}
                    <button class="delete">
                        <i class="far fa-trash-alt"></i>
                    </button>
                {!!Form::close() !!}
                {{-- <i class="far fa-trash-alt float-right"></i> --}}
                <a href="/booking/{{$booking->id}}/edit"><i class="far fa-edit float-right"></i></a><br>
                {{ $booking->service->name}}
            </p>
        @endforeach

        <a href="/booking/create" class='float-right'>New Booking</a>
    </div>
</div>
<div class="card">
    <div class="card-header">Your Pets</div>
    <div class="card-body">
        @foreach ( $user->pets as $pet)
            <p>
            {{ $pet->name}} - {{ $pet->petType->pet_type}}<br>
            Special Instructions: {{ $pet->special_instructions}}
            </p>
        @endforeach
    </div>
</div>
