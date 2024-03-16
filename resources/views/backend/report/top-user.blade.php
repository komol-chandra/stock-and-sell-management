@extends('layouts.backend.app')
@section('title','Top User Report')
@push('css')
@endpush
@section('content')
<div class="row">
    {{-- <h4 class="fw-bold py-3 mb-4">Product List</h4>--}}
    <div class="card">
        <div class="table-responsive text-nowrap">

            <table class="table">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Total Purchase</th>
                        <th>Created At</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @php
                    $i = ($list->perPage() * ($list->currentPage() - 1)) + 1;
                    @endphp
                    @foreach ($list as $key =>$value)
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$i++}}</strong></td>
                        <td> {{$value->name}}</td>
                        <td> {{$value->email}}</td>
                        <td> {{$value->phone}}</td>
                        <td> {{$value->address}}</td>
                        <td> {{$value->total_amount}}</td>
                        <td> {{$value->created_at->diffForHumans()}}</td>
                        <td><span class="badge {{$value->is_active===1?" bg-label-primary":"bg-label-danger"}}
                                me-1">{{$value->is_active===1 ? "Active":"Inactive"}}</span></td>
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
