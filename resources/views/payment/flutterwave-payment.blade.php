<form>
        <script src="https://checkout.flutterwave.com/v3.js"></script>
{{--        <button type="button" onClick="makePayment()">Pay Now</button>--}}
    </form>

    <script>
        function makePayment() {
            FlutterwaveCheckout({
                public_key: "{{$key}}",
                tx_ref: "{{$trx}}",
                amount: {{$total_amount}},
                currency: "NGN",
                country: "NG",
                payment_options: "card, mobilemoneyghana, ussd",
                customer: {
                    email: "{{$email}}",
                    phone_number: "{{$phone}}",
                    name: "{{$name}}",
                },
                callback: function (data) {
                    console.log(data);
                    window.location.replace("{{url('/flconfirmpayment/')}}/"+data.tx_ref+"/"+data.transaction_id);
                },
                onclose: function() {
                    // close modal
                    window.location.replace("{{url('/flconfirmpayment/')}}/{{$trx}}/2");
                },
                customizations: {
                    title: "{{$basic->sitename}}",
                    description: "{{$basic->sitename}} Wallet Funding",
                    logo: "{{url('/')}}assets/images/main.png",
                },
            });
        }
        makePayment();
    </script>
