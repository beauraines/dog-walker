<div class="card">
    <div class="card-header">Today's Bookings - {{ today()->toFormattedDateString() }}</div>
    <div class="card-body">
        <ol>
        @foreach ($todays_bookings as $booking )
            <li>{{ $booking->client->name }} - {{ $booking->service->name}} ${{number_format($booking->computedPrice(),2) }}</li>
        @endforeach
        </ol>
    </div>
</div>
<div class="card">
    <div class="card-header">Future Bookings</div>
    <div class="card-body">
            @foreach ($future_bookings as $booking_by_day )
                {{$booking_by_day[0]->date}}
                <ol>
                @foreach ($booking_by_day as $booking)
                    <li>{{ $booking->client->name }} - {{ $booking->service->name}}</li>
                @endforeach
                </ol>
            @endforeach
    </div>
</div>
