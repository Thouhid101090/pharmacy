@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>New Purchase</h2>

        <form action="{{ route('purchases.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Supplier Name</label>
                <input type="text" name="supplier_name" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Medicine</label>
                {{-- <input type="text" id="medicine_name" class="form-control" list="medicineList"
                        placeholder="Type medicine name" autocomplete="off" required> --}}
                <input type="text" id="medicine_name" name="medicine_name" class="form-control" list="medicineList"
                    placeholder="Type medicine name" autocomplete="off" required>


                <datalist id="medicineList">
                    @foreach ($medicines as $medicine)
                        <option data-id="{{ $medicine->id }}" value="{{ $medicine->name }}"></option>
                    @endforeach
                </datalist>

                <!-- Hidden input to store ID -->
                <input type="hidden" name="medicine_id" id="medicine_id" required>
            </div>


            <div class="mb-3">
                <label>Quantity</label>
                <input type="number" name="quantity" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Total Price</label>
                <input type="number" step="0.01" id="total_amount" name="total_amount" class="form-control" required>
            </div>

            {{-- <div class="mb-3">
                <label>Price</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div> --}}


            <div class="mb-3">
                <label>Expiry Date</label>
                <input type="date" name="expiry_date" class="form-control">
            </div>

            <button type="submit" class="btn btn-success mt-3">Save</button>
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>

    {{-- <script>
        $(document).ready(function() {
            $("#medicine_search").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('medicines.search') }}",
                        data: { term: request.term },
                        dataType: "json",
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.name + " (Stock: " + item.stock + ")", // show this in list
                                    value: item.name,  // fill input box
                                    id: item.id        // hidden ID
                                };
                            }));
                        }
                    });
                },
                minLength: 1,
                select: function(event, ui) {
                    $('#medicine_id').val(ui.item.id); // save medicine_id in hidden field
                }
            });
        });
    </script> --}}






    <script>
        document.getElementById('medicine_name').addEventListener('change', function() {
            var input = this.value;
            var list = document.getElementById('medicineList').childNodes;

            for (var i = 0; i < list.length; i++) {
                if (list[i].value === input) {
                    document.getElementById('medicine_id').value = list[i].dataset.id;
                    break;
                }
            }
        });
    </script>
@endsection
