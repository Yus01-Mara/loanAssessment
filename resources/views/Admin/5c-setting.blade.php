@extends('layouts.app')

@section('content')
<div class="container">

    <h4 class="mb-3">Setting 5C (Accordion UI)</h4>

    <div class="accordion" id="accordion5c">

        @foreach($elements as $element)
        <div class="accordion-item mb-2 shadow-sm">

            <!-- ===================== -->
            <!-- ELEMENT HEADER -->
            <!-- ===================== -->
            <h2 class="accordion-header">

                <button class="accordion-button collapsed d-flex justify-content-between"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse{{ $element->id }}">

                    <div class="w-100 d-flex justify-content-between">
                        <div>
                            <strong>{{ $element->name }}</strong>
                            <span class="badge bg-dark ms-2">{{ $element->code }}</span>
                        </div>

                        <div>
                            <span class="badge element-weight 
                                {{ $element->weight == 100 ? 'bg-success' : 'bg-danger' }}"
                                data-id="{{ $element->id }}">
                                {{ $element->weight }}%
                            </span>
                        </div>
                    </div>

                </button>
            </h2>

            <!-- ===================== -->
            <!-- SUB ELEMENT -->
            <!-- ===================== -->
            <div id="collapse{{ $element->id }}"
                class="accordion-collapse collapse"
                data-bs-parent="#accordion5c">

                <div class="accordion-body">

                    <table class="table table-bordered table-sm align-middle">

                        <thead class="table-light">
                            <tr>
                                <th width="25%">Sub Element</th>
                                <th width="10%">Weight</th>
                                <th width="55%">Rating</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                        @foreach($element->subElements as $sub)
                        <tr>

                            <!-- SUB NAME -->
                            <td>
                                <input type="text"
                                    class="form-control sub-name"
                                    data-id="{{ $sub->id }}"
                                    value="{{ $sub->name }}">
                            </td>

                            <!-- SUB WEIGHT -->
                            <td>
                                <input type="number"
                                    class="form-control sub-weight"
                                    data-element="{{ $element->id }}"
                                    data-id="{{ $sub->id }}"
                                    value="{{ $sub->weight }}">
                            </td>

                            <!-- RATING -->
                            <td>
                                <div class="rating-wrapper">

                                    @foreach($sub->ratings as $r)
                                    <div class="d-flex mb-1 rating-row">

                                        <input type="text"
                                            class="form-control me-1 rating-label"
                                            data-id="{{ $r->id }}"
                                            value="{{ $r->label }}">

                                        <input type="number"
                                            class="form-control me-1 rating-score"
                                            data-id="{{ $r->id }}"
                                            value="{{ $r->score }}">

                                        <button class="btn btn-sm btn-danger delete-rating"
                                            data-id="{{ $r->id }}">
                                            ✕
                                        </button>

                                    </div>
                                    @endforeach

                                </div>

                                <button class="btn btn-sm btn-outline-primary mt-1 add-rating"
                                    data-sub="{{ $sub->id }}">
                                    + Rating
                                </button>
                            </td>

                            <!-- ACTION -->
                            <td>
                                <button class="btn btn-success btn-sm save-sub"
                                    data-id="{{ $sub->id }}">
                                    💾
                                </button>
                            </td>

                        </tr>
                        @endforeach

                        </tbody>

                    </table>

                    <button class="btn btn-primary btn-sm add-sub"
                        data-element="{{ $element->id }}">
                        + Sub Element
                    </button>

                </div>
            </div>

        </div>
        @endforeach

    </div>

</div>
@endsection
@section('scripts')
<script>

$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
});

// ==========================
// SAVE SUB ELEMENT
// ==========================
$('.save-sub').click(function(){

    let row = $(this).closest('tr');
    let id = $(this).data('id');

    let name = row.find('.sub-name').val();
    let weight = row.find('.sub-weight').val();

    $.post('/admin/sub-elements/update-inline', {
        id, name, weight
    }, function(){

        showToast('Sub Element saved');
        validateSubTotal(row.find('.sub-weight').data('element'));
    });

});

// ==========================
// AUTO SAVE RATING
// ==========================
$(document).on('change','.rating-label, .rating-score',function(){

    let row = $(this).closest('.rating-row');

    let id = row.find('.rating-label').data('id');
    let label = row.find('.rating-label').val();
    let score = row.find('.rating-score').val();

    $.post('/admin/ratings/update-inline',{
        id, label, score
    });

});

// ==========================
// ADD SUB ELEMENT
// ==========================
$('.add-sub').click(function(){

    let element_id = $(this).data('element');

    $.post('/admin/sub-elements/add-inline',{ element_id }, function(){
        location.reload();
    });

});

// ==========================
// ADD RATING
// ==========================
$('.add-rating').click(function(){

    let sub_id = $(this).data('sub');

    $.post('/admin/ratings/add-inline',{ sub_element_id: sub_id }, function(){
        location.reload();
    });

});

// ==========================
// DELETE RATING
// ==========================
$(document).on('click','.delete-rating',function(){

    if(!confirm('Padam rating?')) return;

    let id = $(this).data('id');

    $.ajax({
        url: '/admin/ratings/'+id,
        type: 'DELETE',
        success: () => location.reload()
    });

});

// ==========================
// VALIDATION SUB = 100%
// ==========================
function validateSubTotal(elementId){

    let total = 0;

    $('.sub-weight[data-element="'+elementId+'"]').each(function(){
        total += parseFloat($(this).val()) || 0;
    });

    let badge = $('.element-weight[data-id="'+elementId+'"]');

    if(total == 100){
        badge.removeClass('bg-danger').addClass('bg-success');
    }else{
        badge.removeClass('bg-success').addClass('bg-danger');
        alert('Jumlah sub-element mesti 100%. Current: ' + total);
    }
}

// ==========================
// VALIDATION ELEMENT TOTAL
// ==========================
function validateElementTotal(){

    let total = 0;

    $('.element-weight').each(function(){
        total += parseFloat($(this).text()) || 0;
    });

    if(total != 100){
        alert('Total element weight mesti 100%. Current: ' + total);
    }
}

validateElementTotal();

// ==========================
// TOAST
// ==========================
function showToast(msg){
    console.log(msg);
}

</script>
@endsection
