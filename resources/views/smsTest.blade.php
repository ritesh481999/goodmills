<!DOCTYPE html>
<html>
    <head>
        <title>SMS Testing</title>
        <style>
            .error, .alert-danger {
                color: red;
            }
            .alert-success {
                color: green;
            }
        </style>
    </head>
    <body>
        @include('message')
        <div style="align-content: center;">
            <form action="{{ route('smsTest') }}" method="POST">
                @csrf
                <label for="to">SMS sending to</label>
                <input id="to" name='to' type='text' />
                <strong class="error">@error('to'){{ $message }}@enderror</strong>
                <br/>

                <label for="message">Message</label>
                <input id="message" name='message' type='text' />
                <strong class="error">@error('message'){{ $message }}@enderror</strong>
                <br/>

                <input type='submit' value='Send' />
            </form>
            
        </div>
    </body>
</html>