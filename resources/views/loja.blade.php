@extends('layouts.app')

@section('content')

<?php
$tipoUser = 1;
if(Auth::check()){
  $tipoUser = Auth::user()->tipo;
}
?>
@if($tipoUser == 2)
<div class="row">
  <p><a href="{{route('inserirProduto')}}" class="btn btn-primary" role="button">Inserir Produto</a></p>
</div>
@endif
@if (count($produtos) > 0)
<div class="row">
@foreach ($produtos as $produto)
  <div class="col-6 col-lg-4">
    <h2>{{$produto->nome}}</h2>
    <img src="data:image/jpeg;base64,{{$produto->imagem}}" width="200px"/>
    <p>R${{$produto->preco}}</p>
    @if($tipoUser == 1)
      <?php echo Form::open(array('action' => 'HomeController@adicionarItem')); ?>
    @else
      <?php echo Form::open(array('action' => 'HomeController@editarProduto')); ?>
    @endif
    {{ csrf_field() }}
    <input type="hidden" name="produtoAdicionar" value="{{ $produto->id }}" />
    @if($tipoUser == 1)
      <p><input type="submit" class="btn btn-secondary" role="button" value="Comprar" /></p>
    @else
      <p><input type="submit" class="btn btn-secondary" role="button" value="Editar Produto" /></p>
    @endif
  </form>
  </div><!--/span-->
@endforeach
</div>
@endif
@endsection
