<div class="d-flex justify-content-center my-2">
    {{ $lowersByPaymentType->appends(request()->input())->links()}}
</div>
