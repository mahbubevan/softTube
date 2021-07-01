@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-indigo-500 text-white"> 
                    @lang('Update Your Payment Information')    
                </div>    
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="card-holder-name"> @lang('Card Holder Name') </label>
                            <input class="form-control" id="card-holder-name" type="text">
                        </div>
                    </div>
                    <div class="row mt-5 mb-5">
                        <div class="form-group col-md-12">
                            <div id="card-element"></div>
                        </div>
                    </div>    
                </div>
                <div class="card-footer">
                    <button class="btn bg-indigo-500 hover:bg-indigo-700 text-white" id="card-button" data-secret="{{ $intent->client_secret }}">
                        @lang('Update Payment Method')
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
const cardButton = document.getElementById('card-button');
const clientSecret = cardButton.dataset.secret;

cardButton.addEventListener('click', async (e) => {
    $(".spin").removeClass("d-none")
    const { setupIntent, error } = await stripe.confirmCardSetup(
        clientSecret, {
            payment_method: {
                card: cardElement,
                billing_details: { name: cardHolderName.value }
            }
        }
    );

    if (error) {
        window.location.href = "{{url()->previous()}}"
    } else {
        var url = "{{route('user.deposit.save.payment.info')}}"
        $.ajax({
            url,
            method:"POST",
            data:{
                _token:"{{csrf_token()}}",
                paymentMethod:setupIntent.payment_method
            }
        }).done(function(data){
            $(".spin").addClass("d-none")
            if (data.status==1) {
                toastr.success('Payment information saved successfully')
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

 .spin{
    z-index: 9999;
    position: fixed;
    background: rgba(0, 0, 0, 0.1);
    width: 100%;
    height: 100%;
    top: 0; left: 0; right: 0; bottom: 0;
 }
</style>
@endpush