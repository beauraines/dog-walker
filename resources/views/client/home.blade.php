<div class="card">
    <div class="card-header">Bookings</div>
    <div class="card-body">
        @foreach ( $user->bookings as $booking )
            <p>
                {{$booking->date}} <i class="far fa-trash-alt float-right"></i><i class="far fa-edit float-right"></i><br>
                {{ $booking->service->name}}
            </p>
        @endforeach

        <span class='float-right'>New Booking</span>
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
