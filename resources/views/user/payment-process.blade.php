@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-indigo-500 text-white"> @lang('One Time Payment') </div>    
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12 mb-2">
                            <label for="card-holder-name"> @lang('Card Holder Name') </label>
                            <input class="form-control" id="card-holder-name" type="text">
                        </div>
                        <div class="form-group col-md-12 mb-2">
                            <label for="amount"> @lang('Amount') </label>
                            <input class="form-control" id="amount" type="number" step="any">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="form-group col-md-12">
                            <h3 class="mb-3"> @lang('Card Information') </h3>
                            <div id="card-element"></div>
                        </div>
                    </div>   
                </div>
                <div class="card-footer">
                    <button class="btn w-100 bg-indigo-500 hover:bg-indigo-700 text-white" id="card-button" data-secret="{{ $intent->client_secret }}">
                        @lang('Pay')
                    </button>  
                </div>
            </div>  
        </div>
    </div>
</div>
<div class="d-flex justify-content-center spin d-none">
    <div class="spinner-border text-indigo-500" role="status">
      <span class="visually-hidden"> @lang('Loading') ... </span>
    </div>
</div>
@endsection
@push('script-head-lib')
<script src="https://js.stripe.com/v3/"></script>
@endpush
@push('script')
<script>
    const stripe = Stripe("{{$method->credentials->stripe_key}}");
    
    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');
</script>
<script>
const cardHolderName = document.getElementById('card-holder-name');
const amount = document.getElementById('amount');
const cardButton = document.getElementById('card-button');
const clientSecret = cardButton.dataset.secret;

cardButton.addEventListener('click', async (e) => {
    $(".spin").removeClass("d-none")
    const { paymentMethod, error } = await stripe.createPaymentMethod(
        'card', cardElement, {
            billing_details: { name: cardHolderName.value }
        }
    );

    if (error) {
        window.location.href = "{{url()->previous()}}"
    } else {
        var url = "{{route('user.deposit.money')}}"
        $.ajax({
            url,
            method:"POST",
            data:{
                _token:"{{csrf_token()}}",
                paymentMethod:paymentMethod.id,
                amount:amount.value
            }
        }).done(function(data){
            $(".spin").addClass("d-none")
            if (data.status==1) {
                toastr.success('Deposit Successfull')
                setTimeout(function(){
                    window.location.href = data.url
                },2000)
            }     
        }).fail(function(res){
            toastr.error('Something went wrong')
        })
    }
});
</script>
@endpush

@push('style')
<style>
    input,
.StripeElement {
  height: 40px;

  color: #32325d;
  background-color: white;
  border: 1px solid transparent;
  border-radius: 4px;

  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

input {
  padding: 10px 12px;
}

input:focus,
.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}
</style>
@endpush