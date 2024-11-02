@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Basic implementation for the 2Pay.js client</h5>

                        <form type="post" id="payment-form">
                            <div class="form-group">
                                <label for="name" class="label control-label">Name</label>
                                <input type="text" id="name" class="field form-control">
                            </div>

                            <div id="card-element">
                                <!-- A TCO IFRAME will be inserted here. -->
                            </div>

                            <button class="btn btn-primary" type="submit">Pay oi! </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        window.addEventListener('load', function() {
            // Initialize the JS Payments SDK client.
            let jsPaymentClient = new TwoPayClient('{{ config('twocheckout.seller_id') }}');

            // Create the component that will hold the card fields.
            let component = jsPaymentClient.components.create('card');

            // Mount the card fields component in the desired HTML tag. This is where the iframe will be located.
            component.mount('#card-element');

            var doAjaxRequest = function(fparams) {
                $.ajax({
                    type: 'POST',
                    url: fparams.formAction,
                    data: {
                        ess_token: fparams.token,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    xhrFields: {
                        withCredentials: true
                    }
                }).done(function(result) {
                    console.log('Ajax done result: ', result);
                    if (result.redirect) {
                        window.location.href = result.redirect;
                    } else if (result.success) {
                        alert(result.msg);
                    } else {
                        console.log(result.error);
                    }
                }).fail(function(response) {
                    alert(
                    'Your payment could not be processed. Please refresh the page and try again!');
                    console.log(response);
                });
            };

            // Handle form submission.
            document.getElementById('payment-form').addEventListener('submit', (event) => {
                event.preventDefault();

                // Extract the Name field value
                const billingDetails = {
                    name: document.querySelector('#name').value
                };

                // Call the generate method using the component as the first parameter
                // and the billing details as the second one
                jsPaymentClient.tokens.generate(component, billingDetails).then((response) => {
                    console.log(response.token);
                    var params = {
                        token: response.token,
                        formAction: "{{ route('twocheckout.handle-payment') }}"
                    }

                    doAjaxRequest(params)

                }).catch((error) => {
                    console.error(error);
                });
            });
        });
    </script>
@endsection
