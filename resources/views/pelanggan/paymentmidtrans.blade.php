<!DOCTYPE html>
<html>
<head>
    <title>Payment Page</title>
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
    <style>
        .button {
            background-color: blue;
            color: white;
            padding: 4px;
            width: 100%;
        }
    </style>
</head>
<body>
    <button id="pay-button" class="button">Pay!</button>
    <form action="{{ url('/payment/callback') }}" method="POST" id="submit_form">
        @csrf
        <input type="hidden" name="json" id="json_callback">
    </form>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    document.getElementById('json_callback').value = JSON.stringify(result);
                    document.getElementById('submit_form').submit();
                    window.location.href = "{{ url('/pelanggan/tablemonitoring') }}"; // Redirect to index page
                },
                onPending: function (result) {
                    document.getElementById('json_callback').value = JSON.stringify(result);
                    document.getElementById('submit_form').submit();
                    window.location.href = "{{ url('/pelanggan/tablemonitoring') }}"; // Redirect to index page
                },
                onError: function (result) {
                    console.log(result);
                }
            });
        };
    </script>
</body>
</html>
