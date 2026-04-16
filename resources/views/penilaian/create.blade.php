@extends('layouts.app')

@section('content')
<div class="container">

<h4>Penilaian 5C</h4>

<form method="POST" action="/penilaian/store">
@csrf
<input type="hidden" name="application_id" value="{{ $id }}">

@foreach($elements as $element)
<div class="card mb-3">
    <div class="card-header bg-dark text-white">
        {{ $element->name }} ({{ $element->weight }}%)
    </div>

    <div class="card-body">

        @foreach($element->subElements as $sub)
        <div class="mb-3">
            <label>{{ $sub->name }} ({{ $sub->weight }}%)</label>

            <select name="rating_{{ $sub->id }}"
                class="form-control rating"
                data-sub="{{ $sub->weight }}"
                data-element="{{ $element->weight }}">

                <option value="">-- pilih --</option>

                @foreach($sub->ratings as $r)
                <option value="{{ $r->score }}">
                    {{ $r->label }} ({{ $r->score }})
                </option>
                @endforeach

            </select>
        </div>
        @endforeach

    </div>
</div>
@endforeach

<div class="card p-3 mb-3">
    <h5>Score: <span id="score">0</span></h5>
    <h5>Status: <span id="status">-</span></h5>
</div>

<button class="btn btn-success">Submit</button>

</form>

</div>
@endsection
@section('scripts')
<script>

$('.rating').change(function(){

    let total = 0;

    $('.rating').each(function(){

        let score = parseFloat($(this).val()) || 0;
        let sub = parseFloat($(this).data('sub'));
        let element = parseFloat($(this).data('element'));

        total += score * (sub/100) * (element/100);
    });

    total = total.toFixed(2);

    $('#score').text(total);

    let status = '';
    if(total >= 80) status = 'SOKONG';
    else if(total >= 60) status = 'KIV';
    else status = 'TOLAK';

    $('#status').text(status);

});

</script>
@endsection
