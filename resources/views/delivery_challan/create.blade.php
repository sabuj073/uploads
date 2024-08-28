@extends('layouts.app')
@section('title')
    {{ __('messages.invoice.new_invoice') }}
@endsection


@section('content')
<div class="container">
    <div class="card">

    <div class="card-body">
    <h1>Create Delivery Challan</h1>
    <form action="{{ route('delivery_challan.store') }}" method="POST" id="chalan_form">
        @csrf

        <div class="form-group">
            <div class="row">
                <div class="row">
                    <div class="col-md-4">
                         <label for="buyer">Buyer</label>
                         <select class="form-control" name="buyer" id="buyer" required onchange="fetchPONumbers(this.value)">
                             <option value="">--Select--</option>
                             @foreach(\App\Models\Client::with(['user'])->get() as $row)
                             <option value="{{ $row->id }}">{{ $row->user->first_name." ".$row->user->last_name }}</option>
                             @endforeach
                         </select>
            
                    </div>
                    <div class="col-md-4">
                         <label for="po_provider">PO Provider</label>
                         <input type="text" class="form-control mt-2" id="po_provider" name="po_provider" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="po_number">PO Number</label>
            <select class="form-control" name="po_number" id="po_number" required>
                <option value="">--Select PO Number--</option>
            </select>

            <input type="hidden" class="form-control" id="invoice_id" name="invoice_id" required>
        </div>
        
        <button type="button" id="search_invoice" class="btn btn-primary mt-3">Search Invoice</button>

        <div id="invoice_details" style="display:none;" class="mt-5">
            <div id="items" class="row"></div>
            <button type="button" class="btn btn-primary" id="submit_button">Create</button>
        </div>
    </form>
</div>
</div>
</div>

<script>

function fetchPONumbers(clientId) {
        if(clientId) {
            $.ajax({
                url: '/admin/get-po-numbers/' + clientId,
                type: 'GET',
                success: function(response) {
                    var poSelect = $('#po_number');
                    poSelect.empty(); // Clear existing options

                    if(response.length > 0) {
                         $('#po_number').empty().append('<option value="">--Select--</option>');
                        response.forEach(function(poNumber) {
                            poSelect.append('<option value="' + poNumber + '">' + poNumber + '</option>');
                        });
                    } else {
                        poSelect.append('<option value="">No PO numbers available</option>');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $('#po_number').empty().append('<option value="">--Select--</option>');
        }
    }


$(document).ready(function() {
    $('#submit_button').click(function() {
        $("#chalan_form").submit();
    });




    $('#search_invoice').click(function() {
        var poNumber = $('#po_number').val();
        $.ajax({
            url: '{{ route("delivery_challan.searchInvoice") }}',
            method: 'GET',
            data: { po_number: poNumber },
            success: function(data) {
                console.log(data);
                if (data && data.invoice_items) {
                    $('#invoice_details').show();
                    $('#items').empty();
                    $('#items').append('<h3>Items</h3>');
                    $("#invoice_id").val(data.id);
                    data.invoice_items.forEach(function(item, index) {
                        var itemHtml = `
                            <div class="col-md-4 item-group mb-5">
                                <div class="card card_new">
                                    <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>${item.product_name}</h5>
                                    <button type="button" class="btn btn-danger btn-sm remove-item">X</button>
                                </div>
                                <input type="hidden" name="items[${index}][invoice_item_id]" value="${item.id}">
                                <input type="hidden" name="items[${index}][product_name]" value="${item.product_name}">
                                <div class="variations row">
                        `;
                        if (item.variations) {
                            var variations = item.variations.split(',');
                            variations.forEach(function(variation, vIndex) {
                                console.log(item);
                                itemHtml += `
                                    <div class="col-md-12 form-group">
                                        <label ckass="mb-3">${variation}</label>
                                        <input type="hidden" name="items[${index}][variations][${vIndex}][name]" value="${variation}">
                                        <input type="number" value="${item.quantity}" class="form-control mt-3" name="items[${index}][variations][${vIndex}][quantity]" placeholder="Quantity" min="1">
                                        <input type="text" value="" class="form-control mt-3" name="items[${index}][variations][${vIndex}][packeging]" placeholder="Packeging" >
                                    </div>
                                `;
                            });
                        }
                        itemHtml += '</div></div></div></div>';
                        $('#items').append(itemHtml);
                    });

                    // Attach event listener for remove buttons
                    $('.remove-item').click(function() {
                        $(this).closest('.item-group').remove();
                    });
                } else {
                    alert('No invoice found');
                }
            },
            error: function() {
                alert('Error fetching invoice details');
            }
        });
    });
});
</script>

<style>
    .card_new{
        background-color: #cfcfcf !important;
    }
</style>
@endsection
