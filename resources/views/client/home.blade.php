<div class="row">
    <div class="col-md-8">
        <booking-component :user="{{$user}}" scope="today"></booking-component>
        <booking-component :user="{{$user}}" scope="future"></booking-component>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Your Pets</div>
            <div class="card-body">
                @foreach ( $user->pets as $pet)
                    <p>
                    {{ $pet->name}} <i class="fas fa-{{$pet->petType->pet_type}}"></i>
                    <br>
                    {{-- Special Instructions: {{ $pet->special_instructions}} --}}
                    </p>
                @endforeach
            </div>
        </div>
    </div>
</div>

