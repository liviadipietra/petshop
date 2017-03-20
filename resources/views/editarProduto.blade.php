@extends('layouts.app')
@section('content')
<!-- Display Validation Errors -->
@include('common.errors')

<!-- New Task Form -->
<div class="row">
  <div class="Absolute-Center">
    <h1>Cadastro de Produto</h1>
    <br/>
    <br/>
    @if(!empty($produto->id) && Auth::user()->tipo == 2)
    <div class="row">
      {{ Form::open(['route' => ['removerProduto', $produto->id], 'method' => 'delete', 'onsubmit' => 'return confirm("Tem certeza de que deseja remover esse produto?");']) }}
        <button class="btn btn-primary" type="submit" <?php if(count($produto->compras) > 0) echo "disabled title='Produto presente em compras'" ?>>Remover Produto</button>
      {{ Form::close() }}
    </div>
    <br/>
    @endif
    <form id="formProduto" action="{{ route('atualizarProduto') }}" method="POST" class="form-signin" onsubmit="return $('#formProduto').valid();" enctype="multipart/form-data">
       {{ csrf_field() }}
       <input type="hidden" name="produtoId" id="produtoId" value="{{$produto->id}}" />
       @if(Auth::user()->tipo == 2)
      <div class="form-group row">
        <label for="nome" class="col-sm-2 col-form-label">Produto:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control required" id="nome" name="nome" value="{{ empty(old('nome')) ? $produto->nome : old('nome') }}">
        </div>
      </div>
      @else
      <div class="form-group row">
        <label for="nome" class="col-sm-2 col-form-label">Produto:</label>
        <div class="col-sm-10">
          <h4>{{ $produto->nome }}</h4>
        </div>
      </div>
      @endif
      <div class="form-group row">
        <label for="preco" class="col-sm-2 col-form-label">Preço</label>
        <div class="col-sm-10">
          <input type="text" class="form-control required number" id="preco" name="preco" value="{{ empty(old('preco')) ? $produto->preco : old('preco') }}">
        </div>
      </div>
      <div class="form-group row">
        <label for="imagem" class="col-sm-2 col-form-label">Imagem</label>
        <div class="col-sm-10">
          <input type="file" class="form-control <?php if(empty($produto->imagem)) echo "required"; ?>" id="imagem" name="imagem" />
        </div>
        @if(!empty($produto->imagem))
          <img src="data:image/jpeg;base64,{{$produto->imagem}}" width="150px" height="150px"/>
        @endif
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-def btn-block btn-lg btn-primary">Salvar</button>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">
$(function(){
  $("#formProduto").validate({
			rules: {
				nome: "required",
        <?php if(empty($produto->imagem)) : ?>
        imagem: "required",
        <?php endif; ?>
				preco: {
          required:true,
          number:true
        }
			}
    });
})
</script>
@endsection
