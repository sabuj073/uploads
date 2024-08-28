@extends('layouts.app')
@section('title')
    {{ __('Performa Invoice') }}
@endsection


@section('content')
<div class="container">
    <div class="card">
    <div class="card-body">
    <h1>Create Performa Invoice</h1>
    <form action="{{ route('performa-invoice.store') }}" method="POST" id="chalan_form">
        @csrf

        <div class="form-group">
            <div class="row">
                <div class="row">
                    <div class="col-md-4">
                         <label for="po_provider" class="mb-2">PO Provider</label>
                         <select class="form-select productId product  fw-bold select2 mt-3"  name="po_provider"  required onchange="fetchPONumbers(this.value)">
                            <option value="">--Select--</option>
                            @foreach($client as $row)
                                <option value="{{ $row->id }}">{{ $row->user->first_name." ".$row->user->last_name }}</option>
                            @endforeach
                         </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="po_number" class="mb-2">PO Number</label>
            <select class="form-select productId product variations  fw-bold select2 mt-3" id="invoice_id"  name="invoice_id[]"  multiple required>
                <option value="">--Select--</option>
                @foreach($data as $key)
                    <option value="{{ $key->id }}">{{ $key->po_number }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" id="search_invoice" class="btn btn-primary mt-3">Create</button>


    </form>
</div>
</div>
</div>



<script>
        
function fetchPONumbers(clientId) {
        if(clientId) {
            $.ajax({
                url: '/admin/get-po-invoices/' + clientId,
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    var poSelect = $('#invoice_id');
                    poSelect.empty(); // Clear existing options

                    if(response.length > 0) {
                         $('#invoice_id').empty().append('<option value="">--Select--</option>');
                        response.forEach(function(poNumber) {
                            poSelect.append('<option value="' + poNumber.id + '">' + poNumber.po_number + '</option>');
                        });
                    } else {
                        poSelect.append('<option value="">No PO numbers available</option>');
                    }

                    poSelect.trigger('change');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $('#invoice_id').empty().append('<option value="">--Select--</option>');
        }
    }
</script>

@endsection
