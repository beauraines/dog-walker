<div class="card">
    <div class="card-header">Bookings</div>
    <div class="card-body">
        @foreach ( $user->bookings as $booking )
            <p>
                {{$booking->date}}<br>
                {{ $booking->service->name}}
            </p>
        @endforeach
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
