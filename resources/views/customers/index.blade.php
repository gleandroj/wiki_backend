@extends('layout')
@section('content')
<br/>
<div class="row">
    <div class=" col-lg-9">
        <h2>Clientes</h2>                
    </div>
    <button type="button" class="btn btn-success pull-right">Novo</button>
</div>
<br/>
@component('bootstrap::table')
<thead>
    <tr>
        <td>#ID</td>
        <td>Nome</td>
        <td>RG</td>
        <td>CPF</td>
        <td>Dt. Nascimento</td>
        <td>Telefone</td>
        <td>Actions</td>
    </tr>
</thead>
<tbody>
@foreach ($customers as $customer)
    <tr>
        <td> <a href="{{url('/customers', [$customer->id])}}">{{ $customer->id }}</a></td>
        <td>{{ $customer->nome }}</td>
        <td>{{ $customer->rg }}</td>
        <td>{{ $customer->cpf }}</td>
        <td>{{ $customer->dt_nascimento->format('d/m/Y') }}</td>
        <td>{{ $customer->telefone }}</td>
        <td style="display: flex; flex-direction: row; justify-content: space-between;">
            <a style="margin-right: 4px;" href="{{url('/customers', [$customer->id, 'edit'])}}" class="btn btn-primary">Editar</a>
            <form method="post" action="{{ url('/customers', [$customer->id]) }}">
                @method('DELETE')
                @csrf
                <button type="subimit" class="btn btn-secondary">Deletar</button>
            </form>
        </td>
    </tr>
@endforeach
<tbody>
@endcomponent

<div class="row">{{ $customers->links() }}</div>
@endsection