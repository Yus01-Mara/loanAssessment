@extends('layouts.app')

@section('content')
<div class="container">

    <h4>Senarai Permohonan</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Perniagaan</th>
                <th>Jumlah</th>
                <th>Tindakan</th>
            </tr>
        </thead>

        <tbody>
            @foreach($apps as $a)
            <tr>
                <td>{{ $a->applicant_name }}</td>
                <td>{{ $a->business_name }}</td>
                <td>RM {{ number_format($a->amount,2) }}</td>
                <td>
                    <a href="/penilaian/{{ $a->id }}" class="btn btn-primary">
                        Nilai
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
