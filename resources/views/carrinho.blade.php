@extends('layouts.app')

@section('content')
<?php $total = 0; ?>
<h3>Meu Carrinho</h3><br/><br/>
@if (count($produtos) > 0)
<?php echo Form::open(array('action' => 'HomeController@finalizarCompra')); ?>
<table style="width:70%">
  <thead>
    <tr>
    <th colspan="2">
	  Produto
  </th>
	<th>
	  Preço
		</th>
	<th>
	  Quantidade
		</th>
	<th>
	  Subtotal
		</th>
  </tr>
</thead>
<tbody>
@foreach ($produtos as $produto)
<?php $total += ($produto->preco * $carrinho[$produto->id]['quantidade']); ?>
<tr>
<td>
        <img src="data:image/jpeg;base64,{{$produto->imagem}}"  width="150px" alt="{{$produto->nome}}" class="img-thumbnail"/>
      </td>
    <td>
      {{$produto->nome}}
    </td>

    <td>
    R$ {{$produto->preco}}
  </td>
    <td>
        <input type="text" id="qtde_{{$produto->id}}" name="qtde_{{$produto->id}}" size="6" style="text-align:center" class="qtde" value="{{$carrinho[$produto->id]['quantidade']}}" />
      </td>
    <td class="subtotal" preco="{{($produto->preco * $carrinho[$produto->id]['quantidade'])}}">
      R$ <?php echo $produto->preco * $carrinho[$produto->id]['quantidade'];  ?>
    </td>
</tr>
@endforeach
</tbody>
<tfoot>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td><strong>Total:</strong></td>
    <td class="total"><strong>R$ {{ $total }}</strong></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><p><input type="submit" class="btn btn-primary" style="margin-top:20px" role="button" value="Fechar Compra" /></p></td>
  </tr>
</tfoot>
</table>
</form>

<script type="text/javascript">
  $('input.qtde').change(function(){
    qtde = parseInt($(this).val());
    if(isNaN(qtde)) { qtde = 0; $(this).val(0); }
    preco = parseFloat($(this).parent().prev().text().replace('R$ ', ''));
    if(isNaN(preco)) { preco = 0; }
    $(this).parent().next().text('R$ '+(qtde * preco).toFixed(2));
    $(this).parent().next().attr('preco',(qtde * preco).toFixed(2));

    calcularTotal();
  });

  function calcularTotal(){
    total = 0;
    $('td.subtotal').each(function(){
      preco = $(this).attr('preco');
      preco = parseFloat(preco);
      if(isNaN(preco)) preco = 0;
      total += preco;
    })
    $('td.total').html('<strong>R$ '+total.toFixed(2)+'</strong>')
  }
</script>
@else
<br/><br/><br/>
<h4>O seu carrinho está vazio.</h4>
@endif
@endsection
