@extends('layouts.app')

@section('content')

<?php $total = 0; ?>
<h3>Minhas Compras</h3><br/><br/>
@if (count($compras) > 0)
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
    <th>
    Data da Compra
    </th>
  </tr>
</thead>
<tbody>
@foreach ($compras as $compra)
<?php $total += ($compra->produto->preco * $compra->quantidade); ?>
<tr>
<td>
        <img src="data:image/jpeg;base64,{{$compra->produto->imagem}}"  width="150px" alt="{{$compra->produto->nome}}" class="img-thumbnail"/>
      </td>
    <td>
      {{$compra->produto->nome}}
    </td>

    <td>
    R$ {{$compra->produto->preco}}
  </td>
    <td>
        {{$compra->quantidade}}
      </td>
    <td>
      R$ <?php echo $compra->produto->preco * $compra->quantidade;  ?>
    </td>
    <td>
      {{ date('d/m/Y H:i:s', strtotime($compra->created_at))}}
    </td>
</tr>
@endforeach
</tbody>
<tfoot>
  <tr>
    <td></td>
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
    <td></td>
    <td><p><input type="submit" class="btn btn-primary" style="margin-top:20px" role="button" value="Fechar Compra" /></p></td>
  </tr>
</tfoot>
</table>
</form>
@else
<br/><br/><br/>
<h4>Você ainda não efetuou nenhuma compra.</h4>
@endif

@endsection
