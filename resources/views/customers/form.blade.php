@extends('layout')
@section('content')
<br/>
<form method="POST" action="{{ url('/customers', [ !empty($customer) ? $customer->id : '']) }}">
  @method($method ?? 'POST')
  @csrf

  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

  <div class="row">
      <div class=" col-lg-9">
          <h2>{{ !empty($title) ? $title : 'Formulario'}}</h2>                
      </div>
  </div>
  <br/>
  <div class="row">
  <div class="form-group col-md-4">
    <label for="nome">Nome</label>
    <input {{$disabled ? 'disabled' : ''}} type="text" class="form-control" id="nome" value="{{ !empty($customer) ? $customer->nome : old('nome') }}" name="nome">
  </div>
  
  <div class="form-group col-md-4">
    <label for="rg">RG</label>
    <input {{$disabled ? 'disabled' : ''}} type="text" class="rg form-control" id="rg" value="{{ !empty($customer) ? $customer->rg : old('rg') }}" name="rg">
  </div>
  
  <div class="form-group col-md-4">
    <label for="cpf">CPF</label>
    <input {{$disabled ? 'disabled' : ''}} type="text" class="cpf form-control" id="cpf" value="{{ !empty($customer) ? $customer->cpf : old('cpf') }}" name="cpf">
  </div>
  </div>

  <div class="row">
  <div class="form-group col-md-4">
    <label for="telefone">Telefone</label>
    <input {{$disabled ? 'disabled' : ''}} type="text" class="phone_with_ddd form-control" id="telefone" value="{{ !empty($customer) ? $customer->telefone : old('telefone') }}" name="telefone">
  </div>
  
  <div class="form-group col-md-4">
    <label for="dt_nascimento">Data de Nascimento</label>
    <input {{$disabled ? 'disabled' : ''}} type="text" class="date form-control" id="dt_nascimento" value="{{ !empty($customer) ? $customer->dt_nascimento->format('d/m/Y') : old('dt_nascimento') }}" name="dt_nascimento">
  </div>
  
  <div class="col-md-12">
        <button class="{{ $disabled ? 'hidden' : 'btn btn-primary'}}" type="submit">Salvar</button>
        <a href="{{ url('customers') }}" class="btn btn-default">{{ $disabled ? 'Voltar' : 'Cancelar' }}</a>
      </div>
  </div>
</form>
@endsection

@section('scripts')

<script>
$(document).ready(function(){
  $('.date').mask('00/00/0000');
  $('.phone_with_ddd').mask('(00) 0000-0000');
  $('.cpf').mask('000.000.000-00', {reverse: true});
  $('.rg').mask('000000', {reverse: true});
});

</script>

@endsection