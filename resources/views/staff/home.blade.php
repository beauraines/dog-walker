<div class="row">
    <div class="col-md-8">
        <booking-component :user="{{$user}}" scope="today"></booking-component>
        <booking-component :user="{{$user}}" scope="future"></booking-component>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Clients</div>
            <div class="card-body">
                <ol>
                    @foreach ( $clients ?? [] as $client)
                        <li>{{$client->name}}</li>
                @endforeach
            </ol>
        </div>
        </div>
    </div>
</div>

