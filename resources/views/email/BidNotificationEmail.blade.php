@component('mail::layout')
@slot('header')
    @component('mail::header', ['url' => config('app.url')])
        {{ config('app.name') }}
    @endcomponent
@endslot
                @component('mail::table')
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Bid Id</th>
                                <th scope="col">Bid Name</th>
                                <th scope="col">Commodity</th>
                                <th scope="col">Valid For</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($bids->count() > 0)
                                @foreach ($bids as $key => $bid)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td>{{ $bid->bid_code }}</td>
                                        <td>{{ $bid->bid_name }}</td>
                                        <td>{{ $bid->commodity->name }}</td>
                                        <td>{{ displayDateTime($bid->valid_till) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                @endcomponent

                @slot('footer')
                @component('mail::footer')
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                @endcomponent
            @endslot
@endcomponent
