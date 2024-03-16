@extends('layouts.backend.app')
@section('title','Order List')
@push('css')
@endpush
@section('content')
<div class="row">
    {{-- <h4 class="fw-bold py-3 mb-4">Product List</h4>--}}
    <div class="card">
        <div class="col-12 ">
            <h5 class="card-header">Order List <a href="{{route('branch.sell-point.create')}}"
                    class="btn btn-outline-primary">Create New</a></h5>

        </div>
        <div class="table-responsive text-nowrap">
            <form action="{{route('branch.sell-point.index')}}" method="get">
                <div class="row border border-1 mb-3 p-2 d-flex">
                    <div class="col-auto">
                        <select name="per_page" class="form-control select2" required>
                            <option value="10" {{$searched_data['per_page']==='10' ?'selected':''}}>10</option>
                            <option value="15" {{$searched_data['per_page']==='15' ?'selected':''}}>15</option>
                            <option value="50" {{$searched_data['per_page']==='50' ?'selected':''}}>50</option>
                            <option value="100" {{$searched_data['per_page']==='100' ?'selected':''}}>100</option>
                            <option value="500" {{$searched_data['per_page']==='500' ?'selected':''}}>500</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <select name="sorting" class="form-control select2" required>
                            <option>Sorting</option>
                            <option value="latest" {{$searched_data['sorting']==='latest' ?'selected':''}}>Latest
                            </option>
                            <option value="oldest" {{$searched_data['sorting']==='oldest' ?'selected':''}}>Oldest
                            </option>

                        </select>
                    </div>
                    <div class="col-auto">
                        <select class="form-control select2" name="select_day">
                            <option>Select Day</option>
                            <option value="thisYear" {{$searched_data['select_day']=='thisYear' ?'selected':''}}>
                                {{ __('This Year') }}</option>
                            <option value="thisMonth" {{$searched_data['select_day']=='thisMonth' ?'selected':''}}>
                                {{ __('This Month') }}</option>
                            <option value="thisWeek" {{$searched_data['select_day']=='thisWeek' ?'selected':''}}>
                                {{ __('This Week') }}</option>
                            <option value="today" {{$searched_data['select_day']=='today' ?'selected':''}}>
                                {{ __('Today') }}</option>
                        </select>
                    </div>

                    <div class="col-auto">
                        <input type="text" name="search" placeholder="Invoice Id" class="form-control">
                    </div>
                    <div class="col-auto m-auto">
                        <button class="btn btn-sm btn-success">Submit</button>
                        <a href="{{route('branch.sell-point.index')}}" class="btn btn-sm btn-dark">reset</a>
                    </div>
                </div>
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Customer Info</th>
                        <th>Invoice No.</th>
                        <th>Grand Total</th>
                        <th>Item</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @php
                    $i = ($list->perPage() * ($list->currentPage() - 1)) + 1;
                    @endphp
                    @foreach ($list as $key =>$value)
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$i++}}</strong></td>
                        <td>
                            <p style="margin: 0px; padding: 0px"><b>Name:</b>{{$value->customer_name}}</p>
                            <p style="margin: 0px; padding: 0px;"><b>Phone:</b> {{$value->customer_phone}}</p>
                        </td>
                        <td>{{$value->invoice_id}}</td>
                        <td>{{$value->grand_total}}</td>
                        <td>{{$value->items->count('id')}}</td>
                        <td> {{$value->created_at->diffForHumans()}}</td>
                        <td><a class="btn btn-sm btn-outline-primary"
                                href="{{route('branch.sell-point.show',$value->id)}}">View</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $list->links() }}
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    /*-------------------------------
    Delete  Alert
  -----------------------------------*/
$(".deleteIndex").on("click", function (event) {
    const id = $(this).data("id");
    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete this Data!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.value) {
            event.preventDefault();
            document.getElementById("delete_datalist_form_" + id).submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire(
                "Cancelled",
                "Your Data is Save :)",
                "error"
            );
        }
    });
});
</script>
@endpush