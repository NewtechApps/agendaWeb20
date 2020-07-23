<?php

namespace App\Http\Controllers;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Session;
use Validator;

use App\Models\empresa;    
class empresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }



    public function index(Request $request)
    {

        $search = $request->get('search');
        $field  = $request->get('field')  != '' ? $request->get('field') : 'razao_social';
        $sort   = $request->get('sort')   != '' ? $request->get('sort')  : 'asc';
        
        $empresas = DB::table('empresa')
                    ->where('razao_social', 'like' , '%' . $search . '%')
                    ->orderBy($field, $sort)
                    ->get();
                    
        return view("cadastros.empresas.index")->with('empresas', $empresas);
    }


    public function create(Request $request)
    {

        session::put('id_modal','insert');
        $validator = Validator::make($request->all(), [
                    'i_razao_social'     => ['required'],
                    'i_nome_fantasia'    => ['required'],
                    'i_tipo_pessoa'      => ['required'],
                    'i_cpf_cnpj'         => ['required'],
                    'i_estado'           => ['required','not_in:null'],
                    'i_municipio'        => ['required'],
                    'i_endereco'         => ['required'],
                    'i_cep'              => ['required'],
                    'i_telefone_fixo'    => ['required'],
                    ], [], [
                    'i_razao_social'     => 'Razão Social',
                    'i_nome_fantasia'    => 'Nome Fantasia',
                    'i_tipo_pessoa'      => 'Tipo de Empresa',
                    'i_cpf_cnpj'         => 'CPF/CNPJ',
                    'i_estado'           => 'Estado/UF',
                    'i_municipio'        => 'Município',
                    'i_endereco'         => 'Endereço',
                    'i_cep'              => 'CEP',
                    'i_telefone_fixo'    => 'Tel. Fixo',
                    ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());
        } else {  

            try {

                $empresas = new empresa();
                $empresas->id_empresa    = empresa::getId();
                $empresas->razao_social  = $request->i_razao_social;
                $empresas->nome_fantasia = $request->i_nome_fantasia;
                $empresas->tipo_pessoa   = $request->i_tipo_pessoa;
                $empresas->cpf_cnpj      = $request->i_cpf_cnpj;
                $empresas->endereco      = $request->i_endereco;
                $empresas->complemento   = $request->i_complemento;
                $empresas->cep           = $request->i_cep;
                $empresas->estado        = $request->i_estado;
                $empresas->municipio     = $request->i_municipio;
                $empresas->telefone_fixo    = $request->i_telefone_fixo;
                $empresas->telefone_celular = $request->i_telefone_celular;
                $empresas->save();

            } catch (\Exception $e) {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            }
            return redirect($request->header('referer'));
        }
    }
  

    public function update(Request $request) 
    {
        session::put('id_modal','update');
        $validator = Validator::make($request->all(), [
                    'u_razao_social'     => ['required'],
                    'u_nome_fantasia'    => ['required'],
                    'u_tipo_pessoa'      => ['required'],
                    'u_cpf_cnpj'         => ['required'],
                    'u_estado'           => ['required','not_in:null'],
                    'u_municipio'        => ['required'],
                    'u_endereco'         => ['required'],
                    'u_cep'              => ['required'],
                    'u_telefone_fixo'    => ['required'],
                    ], [], [
                    'u_razao_social'     => 'Razão Social',
                    'u_nome_fantasia'    => 'Nome Fantasia',
                    'u_tipo_pessoa'      => 'Tipo de Empresa',
                    'u_cpf_cnpj'         => 'CPF/CNPJ',
                    'u_estado'           => 'Estado/UF',
                    'u_municipio'        => 'Município',
                    'u_endereco'         => 'Endereço',
                    'u_cep'              => 'CEP',
                    'u_telefone_fixo'    => 'Tel. Fixo',
                    ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());
        } else {  

            try {

                DB::table('empresa')
                ->where('id_empresa', '=', $request->u_id_empresa)
                ->update([
                    'razao_social'  => $request->u_razao_social,
                    'nome_fantasia' => $request->u_nome_fantasia,
                    'tipo_pessoa'   => $request->u_tipo_pessoa,
                    'cpf_cnpj'      => $request->u_cpf_cnpj,
                    'endereco'      => $request->u_endereco,
                    'complemento'   => $request->u_bairro,
                    'cep'           => $request->u_cep,
                    'estado'        => $request->u_estado,
                    'municipio'     => $request->u_municipio,
                    'telefone_fixo'    => $request->u_telefone_fixo,
                    'telefone_celular' => $request->u_telefone_celular,
                ]);

            } catch (\Exception $e) {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            }
            return redirect($request->header('referer'));
        }
    }



    public function delete(Request $request)
    {
        try {
            DB::table('empresa')->where('id_empresa', '=', $request->id_empresa)->delete();
        } catch (\Exception $e) {

            if(strpos($e->getMessage(), 'Cannot delete or update a parent row')>0){
                session::put('erros', 'Não é possível excluir esse registro. - ERRO: Essa Empresa já está sendo usada por outro cadastro'); 
            } else {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            }
        }
        return redirect($request->header('referer'));
    }    
    
}