<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;
use Auth;
use Validator;

use App\Produto;
use App\Compra;
use App\User;

class HomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('auth', ['except' => 'index']);
    }

    public function index(){
      $produtos = Produto::orderBy('created_at', 'desc')->get();

      return view('loja', [
          'produtos' => $produtos
      ]);
    }

    public function adicionarItem(Request $request){
      $produtoAdicionar = $request->produtoAdicionar;
      $carrinho = Session::get('carrinho',[]);
      if(isset($carrinho[$produtoAdicionar])){
        $carrinho[$produtoAdicionar]['quantidade']++;
      } else {
        $carrinho[$produtoAdicionar] = [ 'quantidade' => 1 ];
      }
      Session::put('carrinho',$carrinho);

      $produtos = [];
      foreach($carrinho as $id => $item){
        array_push($produtos, Produto::find($id));
      }

      return view('carrinho', [
        'produtos' => $produtos,
        'carrinho' => $carrinho
      ]);
    }

    public function carrinho(){
      $carrinho = Session::get('carrinho',[]);
      $produtos = [];
      foreach($carrinho as $id => $item){
        array_push($produtos, Produto::find($id));
      }

      return view('carrinho', [
        'produtos' => $produtos,
        'carrinho' => $carrinho
      ]);
    }

    public function finalizarCompra(Request $request){
      $carrinho = Session::get('carrinho',[]);
      foreach($carrinho as $id => $item){
        $fieldname = "qtde_".$id;
        if(isset($request->$fieldname)){
          $carrinho[$id]['quantidade'] = $request->$fieldname;
        }
        if($carrinho[$id]['quantidade'] > 0){
          $compra = new Compra;
          $compra->user_id = Auth::user()->id;
          $compra->produto_id = $id;
          $compra->quantidade = $carrinho[$id]['quantidade'];
          $compra->datacompra = date('Y-m-d H:i:s');
          $compra->situacao = 1;
          $compra->created_at = date('Y-m-d H:i:s');
          $compra->updated_at = date('Y-m-d H:i:s');
          $compra->save();
        }
      }

      Session::put('carrinho',[]);

      Session::flash('status_success', 'Obrigado por comprar!');

      return redirect('/');
    }

    public function compras(){
      $compras = Compra::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

      return view('compras', [
        'compras' => $compras
      ]);
    }

    public function cliente(){
      return view('cliente', [
        'user' => Auth::user()
        ]);
    }

    public function atualizarCliente(Request $request){
      $validator = Validator::make($request->all(), [
            'nome' => 'required|max:255',
            'email' => 'required|email|max:255',
            'senha' => 'confirmed',
        ], [
          'required' => 'O campo :attribute é obrigatório.',
          'max' => 'O campo :attribute deve possuir no máximo :max caracteres.',
          'min' => 'O campo :attribute deve possuir no mínimo :min caracteres.',
          'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
        ]);

      if ($validator->fails()) {
        return redirect('/cliente')
            ->withInput()
            ->withErrors($validator);
      }

      $usersEmail = User::where('email', $request->email)->get();

      foreach($usersEmail as $usuario){
        if($usuario->id != Auth::user()->id){
          Session::flash('status_error', 'O e-mail informado já pertence à outro usuário!');
          return redirect('/cliente')
            ->withInput();;
        }
      }

      $user = User::find(Auth::user()->id);

      $user->nome = $request->nome;

      $user->email = $request->email;

      if(!empty($request->senha)){
        $user->senha = bcrypt($request->senha);
      }

      $user->save();

      Session::flash('status_success', 'Dados alterados com sucesso!');

      return redirect('/cliente');
    }

    public function editarProduto(Request $request){
      if((Auth::user()->tipo != 2) && (Auth::user()->tipo != 3)) return redirect('/');
      $produto = Produto::find($request->produtoAdicionar);
      return view('editarProduto',[
          'produto'=>$produto
        ]);
    }

    public function atualizarProduto(Request $request){
      if((Auth::user()->tipo != 2) && (Auth::user()->tipo != 3)) return redirect('/');
      $produto = Produto::find($request->produtoId);
      if($produto == null) $produto = new Produto;
        $fields = [
            'preco' => 'required|numeric'
        ];

        if(Auth::user()->tipo == 2){
          $fields['nome'] = 'required|max:255';
        }

        if(empty($produto->imagem)){
          $fields['imagem'] = 'required|image';
        }

        $validator = Validator::make($request->all(), $fields, [
          'required' => 'O campo :attribute é obrigatório.',
          'max' => 'O campo :attribute deve possuir no máximo :max caracteres.',
          'min' => 'O campo :attribute deve possuir no mínimo :min caracteres.',
          'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
          'image' => 'Selecione uma imagem válida.',
        ]);

      if ($validator->fails()) {
        return redirect('/inserirProduto')
            ->withInput()
            ->withErrors($validator);
      }

      if(isset($request->nome))
        $produto->nome = $request->nome;

      $produto->preco = $request->preco;

      if($request->imagem != null){
        $maxHeight = 500;
        $maxWidth = 500;
        list($width, $height) = getimagesize($request->imagem->path());
        if(($width <= $maxWidth) && ($height <= $maxHeight))
          $produto->imagem = base64_encode(file_get_contents($request->imagem->path()));
        else {
          Session::flash('status_error', 'Seelcione uma imagem de no máximo 500x500');
          return redirect('/inserirProduto')
            ->withInput();
        }

      }

      $produto->save();

      Session::flash('status_success', 'Dados alterados com sucesso!');

      return redirect('/');
    }

    public function inserirProduto(){
      if(Auth::user()->tipo != 2) return redirect('/');
      return view('editarProduto',[
          'produto'=> new Produto
        ]);
    }

    public function removerProduto($idProduto){
      if(Auth::user()->tipo != 2) return redirect('/');
      Produto::destroy($idProduto);
      Session::flash('status_success', 'Produto removido com sucesso!');
      return redirect('/');
    }
}
