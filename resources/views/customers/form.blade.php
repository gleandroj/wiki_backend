@extends('layout')
@section('content')
<br/>
<div class="row">
    <div class=" col-lg-9">
        <h2>{{ !empty($title) ? $title : 'Formulario'}}</h2>                
    </div>
</div>
<br/>
<div class="row">
 <div class="form-group col-md-4">
   <label for="nome">Nome</label>
   <input type="text" class="form-control" id="nome" name="nome">
 </div>
 
 <div class="form-group col-md-4">
   <label for="rg">RG</label>
   <input type="text" class="rg form-control" id="rg" name="rg">
 </div>
 
 <div class="form-group col-md-4">
   <label for="cpf">CPF</label>
   <input type="text" class="cpf form-control" id="cpf" name="cpf">
 </div>
</div>
<div class="row">
 <div class="form-group col-md-4">
   <label for="telefone">Telefone</label>
   <input type="text" class="phone_with_ddd form-control" id="telefone" name="telefone">
 </div>
 
 <div class="form-group col-md-4">
   <label for="dt_nascimento">Data de Nascimento</label>
   <input type="text" class="date form-control" id="dt_nascimento" name="dt_nascimento">
 </div>
 
 <div class="col-md-12">
      <button type="submit" class="btn btn-primary">Salvar</button>
      <a href="{{ url('customers') }}" class="btn btn-default">Cancelar</a>
    </div>
</div>
@endsection

@section('scripts')

<script>
$(document).ready(function(){
  $('.date').mask('11/11/1111');
  $('.phone_with_ddd').mask('(00) 0000-0000');
  $('.cpf').mask('000.000.000-00', {reverse: true});
  $('.rg').mask('000000', {reverse: true});
});

</script>

@endsection