<div class="d-flex justify-content-center my-2">
    {{ $serviceOrders->appends(request()->input())->links()}}
</div>
