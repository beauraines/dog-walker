<booking-component :user="{{$user}}" scope="today"></booking-component>
<booking-component :user="{{$user}}" scope="future"></booking-component>


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
