<?php

date_default_timezone_set('America/Sao_Paulo');

use Illuminate\Support\Facades\Route;

require_once("../public/funcoes.php");

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=";</script><?php
    }
    else{
        $apiRequest = "";
        $param = "index";
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            if ($param == $value->slug){
                $moduloE = $value;
            }
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = :id', ['id' => $value->id]);
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);
                
            }
        }
        $versoes = DB::select('select * from versions ORDER BY created_at DESC');
        $acao = "Visualizou a Página Inicial";
        $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
        return view('home', 
        [
            'apiRequest' => $apiRequest,
            'versoes' => $versoes,
            'modulePai' => $modulePai,
            'param' => $param,
            'moduloE' => $moduloE
        ]);
    }
});

Route::get('/index', function () {
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=";</script><?php
    }
    else{
        $apiRequest = "";
        $param = "index";
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            if ($param == $value->slug){
                $moduloE = $value;
            }
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = :id', ['id' => $value->id]);
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);
                
            }
        }
        $versoes = DB::select('select * from versions ORDER BY created_at DESC');
        $acao = "Visualizou a Página Inicial";
        $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
        return view('home', 
        [
            'apiRequest' => $apiRequest,
            'versoes' => $versoes,
            'modulePai' => $modulePai,
            'param' => $param,
            'moduloE' => $moduloE
        ]);
    }
});

Route::get('/principal', function () {
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=";</script><?php
    }
    else{
        $apiRequest = "";
        $param = "index";
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            if ($param == $value->slug){
                $moduloE = $value;
            }
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = :id', ['id' => $value->id]);
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);
                
            }
        }
        $versoes = DB::select('select * from versions ORDER BY created_at DESC');
        $acao = "Visualizou a Página Inicial";
        $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
        return view('home', 
        [
            'apiRequest' => $apiRequest,
            'versoes' => $versoes,
            'modulePai' => $modulePai,
            'param' => $param,
            'moduloE' => $moduloE
        ]);
    }
});
Route::get('/usuario', function () {
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=usuario";</script><?php
    }
    else{
        $url = $_SERVER['REQUEST_URI'];
        $vet = explode('/', $url);
        array_shift($vet);
        array_shift($vet);
        array_shift($vet);
        $vet2 = explode('?', $vet[0]);
        $vet[0] = $vet2[0];
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = :id', ['id' => $value->id]);
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        $versoes = DB::select('select * from versions ORDER BY created_at DESC');
        $param = "usuario";
        if ($permissao[0]->view){
            $sql = "SELECT * FROM users";
            if (isset($_REQUEST['nomeFiltro']) && $_REQUEST['nomeFiltro']){
                $sql .= " WHERE name LIKE '%".$_REQUEST['nomeFiltro']."%'";
                $where = 1;
            }
            if (isset($_REQUEST['emailFiltro']) && $_REQUEST['emailFiltro']){
                $sql .= " WHERE email LIKE '%".$_REQUEST['emailFiltro']."%'";
                $where = 1;
            }
            $usuarios = DB::select($sql);
            $acao = "Visualizou os usuários do sistema!";
            $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
            return view('user', 
            [
                'versoes' => $versoes,
                'usuarios' => $usuarios,
                'modulePai' => $modulePai,
                'param' => $param,
                'moduloE' => $moduloE,
                'permissao' => $permissao
            ]);
        }
        else{
            return view('noPermission', 
            [
                'versoes' => $versoes,
                'modulePai' => $modulePai,
                'param' => $param,
                'moduloE' => $moduloE,
                'permissao' => $permissao
            ]);
        }
    }
});
Route::get('/fornecedores', function () {
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=fornecedores";</script><?php
    }
    else{
        $url = $_SERVER['REQUEST_URI'];
        $vet = explode('/', $url);
        array_shift($vet);
        array_shift($vet);
        array_shift($vet);
        $vet2 = explode('?', $vet[0]);
        $vet[0] = $vet2[0];
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = :id', ['id' => $value->id]);
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        $versoes = DB::select('select * from versions ORDER BY created_at DESC');
        $param = "fornecedores";
        if ($permissao[0]->view){
            $sql = "SELECT * FROM users";
            $usuarios = DB::select($sql);
            $_REQUEST['nomeFiltro'] = (isset($_REQUEST['nomeFiltro'])) ? $_REQUEST['nomeFiltro'] : "";
            $_REQUEST['documentoFiltro'] = (isset($_REQUEST['documentoFiltro'])) ? $_REQUEST['documentoFiltro'] : "";
            $sql = 'select a.*, b.name, b.surname, b.cpf, c.razao_social, c.nome_fantasia, c.cnpj from suppliers a LEFT JOIN suppliers_pf b ON (a.id = b.supplier) LEFT JOIN suppliers_pj c ON (a.id = c.supplier) ';
            if (isset($_REQUEST['nomeFiltro']) && $_REQUEST['nomeFiltro']){
                $sql .= "WHERE (b.name LIKE '%".$_REQUEST['nomeFiltro']."%' OR b.surname LIKE '%".$_REQUEST['nomeFiltro']."%' OR c.razao_social LIKE '%".$_REQUEST['nomeFiltro']."%' OR c.nome_fantasia LIKE '%".$_REQUEST['nomeFiltro']."%') ";
                $entrou = 1;
            }
            if (isset($_REQUEST['nomeFiltro']) && $_REQUEST['documentoFiltro']){
                if (isset($entrou) && $entrou == 1){
                    $sql .= "AND ";
                }
                else{
                    $sql .= "WHERE ";
                }
                $sql .= "(b.cpf LIKE '%".$_REQUEST['documentoFiltro']."%' OR b.rg LIKE '%".$_REQUEST['documentoFiltro']."%' OR c.cnpj LIKE '%".$_REQUEST['documentoFiltro']."%') ";
            }
            $sql .= 'ORDER BY a.created_at DESC ';
            $suppliers = DB::select($sql);
            if (!isset($_REQUEST['pagina'])){
                $_REQUEST['pagina'] = 1;
            }
            if (!isset($_REQUEST['totalPaginacao'])){
                $_REQUEST['totalPaginacao'] = 15;
            }
            $ini = ($_REQUEST['pagina'] == 1) ? 0 : 2;
            $totalRegistros = count($suppliers);
            $suppliersPaginas = ceil($totalRegistros / $_REQUEST['totalPaginacao']);
            if ($suppliersPaginas == 1){
                $proxima = 1;
                $anterior = 1;
            }
            else{
                $proxima = $_REQUEST['pagina'] + 1;
            }
            if ($_REQUEST['pagina'] < 2){
                $anterior = 1;
                $ini = 0;
            }
            else{
                $anterior = $_REQUEST['pagina'] - 1;
                $ini = ($_REQUEST['pagina'] * $_REQUEST['totalPaginacao']) - $_REQUEST['totalPaginacao'];
            }
            $sql .= "LIMIT ".$ini.", ".$_REQUEST['totalPaginacao'];
            $suppliers = DB::select($sql);
            $acao = "Visualizou os fornecedores do sistema!";
            $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
            return view('supplier', 
            [
                'totalRegistros' => $totalRegistros,
                'suppliersPaginas' => $suppliersPaginas,
                'proxima' => $proxima,
                'anterior' => $anterior,
                'versoes' => $versoes,
                'usuarios' => $usuarios,
                'suppliers' => $suppliers,
                'modulePai' => $modulePai,
                'param' => $param,
                'moduloE' => $moduloE,
                'permissao' => $permissao,
                'vet0' => $vet[0],
                'vet1' => ''
            ]);
        }
        else{
            return view('noPermission', 
            [
                'versoes' => $versoes,
                'modulePai' => $modulePai,
                'param' => $param,
                'moduloE' => $moduloE,
                'permissao' => $permissao,
                'vet0' => $vet[0],
                'vet1' => ''
            ]);
        }
    }
});
Route::get('/modulos', function () {
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=modulos";</script><?php
    }
    else{
        $url = $_SERVER['REQUEST_URI'];
        $vet = explode('/', $url);
        array_shift($vet);
        array_shift($vet);
        array_shift($vet);
        $vet2 = explode('?', $vet[0]);
        $vet[0] = $vet2[0];
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = :id', ['id' => $value->id]);
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        $versoes = DB::select('select * from versions ORDER BY created_at DESC');
        $param = "modulos";
        if ($permissao[0]->view){
            $sql = "SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id)";
            if (isset($_REQUEST['paiFiltro']) && $_REQUEST['paiFiltro']){
                $sql .= " WHERE a.module = '".$_REQUEST['paiFiltro']."'";
                $where = 1;
            }
            if (isset($_REQUEST['nomeFiltro']) && $_REQUEST['nomeFiltro']){
                if (isset($where)){
                    $sql .= " AND";
                }
                else{
                    $sql .= "WHERE";
                }
                $sql .= " a.name LIKE '%".$_REQUEST['nomeFiltro']."%'";
            }
            $modules = DB::select($sql);
            $acao = "Visualizou os módulos do sistema!";
            $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
            return view('module', 
            [
                'versoes' => $versoes,
                'modules' => $modules,
                'modulePai' => $modulePai,
                'param' => $param,
                'moduloE' => $moduloE,
                'permissao' => $permissao
            ]);
        }
        else{
            return view('noPermission', 
            [
                'versoes' => $versoes,
                'modulePai' => $modulePai,
                'param' => $param,
                'moduloE' => $moduloE,
                'permissao' => $permissao
            ]);
        }
    }
});
Route::get('/permissao', function () {
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=permissao";</script><?php
    }
    else{
        $url = $_SERVER['REQUEST_URI'];
        $vet = explode('/', $url);
        array_shift($vet);
        array_shift($vet);
        array_shift($vet);
        $vet2 = explode('?', $vet[0]);
        $vet[0] = $vet2[0];
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = :id', ['id' => $value->id]);
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        $versoes = DB::select('select * from versions ORDER BY created_at DESC');
        $param = "permissao";
        if ($permissao[0]->view){
            $sql = "SELECT * FROM users";
            $users = DB::select($sql);
            $acao = "Visualizou as permissões do sistema!";
            $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
            return view('permission', 
            [
                'versoes' => $versoes,
                'users' => $users,
                'modulePai' => $modulePai,
                'param' => $param,
                'moduloE' => $moduloE,
                'permissao' => $permissao
            ]);
        }
        else{
            return view('noPermission', 
            [
                'versoes' => $versoes,
                'modulePai' => $modulePai,
                'param' => $param,
                'moduloE' => $moduloE,
                'permissao' => $permissao
            ]);
        }
    }
});
Route::get('/logs', function () {
        if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
            ?><script>location.href="<?=env('APP_URL')?>login?pagina=logs";</script><?php
        }
        else{
            $url = $_SERVER['REQUEST_URI'];
            $vet = explode('/', $url);
            array_shift($vet);
            array_shift($vet);
            array_shift($vet);
            $vet2 = explode('?', $vet[0]);
            $vet[0] = $vet2[0];
            $modulePai = DB::select('select * from modules where module = 0');
            foreach ($modulePai as $key => $value){
                $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
                foreach ($modulePai[$key]->modules as $chave => $valor){
                    $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                    if ($vet[0] == $valor->slug){
                        $moduloE = $valor;
                        $permissao = $modulePai[$key]->modules[$chave]->permissao;
                    }
                }
            }
            $versoes = DB::select('select * from versions ORDER BY created_at DESC');
            $param = "logs";
            if ($permissao[0]->view){
                $sql = "SELECT * FROM users";
                $users = DB::select($sql);
                $acao = "Visualizou os logs de acesso ao sistema!";
                $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
                $logs =DB::select("SELECT * FROM logs WHERE user = '".$_SESSION['user']['id']."' ORDER BY created_at DESC");
                $param = "logs";
                return view('logs', 
                [
                    'versoes' => $versoes,
                    'users' => $users,
                    'modulePai' => $modulePai,
                    'param' => $param,
                    'logs' => $logs,
                    'moduloE' => $moduloE,
                    'permissao' => $permissao
                ]);
            }
            else{
                return view('noPermission', 
                [
                    'versoes' => $versoes,
                    'modulePai' => $modulePai,
                    'param' => $param,
                    'moduloE' => $moduloE,
                    'permissao' => $permissao
                ]);
            }
        }
});
Route::get('/versao', function () {
        if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
            ?><script>location.href="<?=env('APP_URL')?>login?pagina=versao";</script><?php
        }
        else{
            $url = $_SERVER['REQUEST_URI'];
            $vet = explode('/', $url);
            array_shift($vet);
            array_shift($vet);
            array_shift($vet);
            $vet2 = explode('?', $vet[0]);
            $vet[0] = $vet2[0];
            $modulePai = DB::select('select * from modules where module = 0');
            foreach ($modulePai as $key => $value){
                $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
                foreach ($modulePai[$key]->modules as $chave => $valor){
                    $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                    if ($vet[0] == $valor->slug){
                        $moduloE = $valor;
                        $permissao = $modulePai[$key]->modules[$chave]->permissao;
                    }
                }
            }
            $versoes = DB::select('select * from versions ORDER BY created_at DESC');
            $param = "versao";
            if ($permissao[0]->view){
                $sql = "SELECT * FROM users";
                $users = DB::select($sql);
                $acao = "Visualizou as versões do sistema!";
                $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
                $sql = "SELECT * FROM versions ";
                if (isset($_REQUEST['nomeFiltro']) && $_REQUEST['nomeFiltro']){
                    $sql .= "WHERE name LIKE '%".$_REQUEST['nomeFiltro']."%' ";
                }
                $sql .= "ORDER BY created_at DESC";
                $versions = DB::select($sql);
                return view('versions', 
                [
                    'versoes' => $versoes,
                    'users' => $users,
                    'modulePai' => $modulePai,
                    'param' => $param,
                    'versions' => $versions,
                    'moduloE' => $moduloE,
                    'permissao' => $permissao
                ]);
            }
            else{
                return view('noPermission', 
                [
                    'versoes' => $versoes,
                    'modulePai' => $modulePai,
                    'param' => $param,
                    'moduloE' => $moduloE,
                    'permissao' => $permissao
                ]);
            }
        }
});
Route::post('/usuario/cadastrar', function () {
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=usuario";</script><?php
    }
    else{
        if ($_REQUEST['nome'] && $_REQUEST['email'] && $_REQUEST['password']){
            $sql = "INSERT INTO users (name, email, password, created_at, updated_at) VALUES ('".$_REQUEST['nome']."', '".$_REQUEST['email']."', '".md5($_REQUEST['password'])."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
            $result = DB::select($sql);
            $sql = "SELECT * FROM users WHERE email = '".$_REQUEST['email']."'";
            $result = DB::select($sql);
            $acao = "Cadastrou o usuário do sistema ".$result[0]->id."!";
            $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
            if (count($_FILES) && $_FILES['img']['error'] == 0){     
                if (preg_match('/.jpg/', $_FILES['img']['name'])){
                    $extensao = "jpg";
                }
                elseif (preg_match('/.jpeg/', $_FILES['img']['name'])){
                    $extensao = "jpeg";
                }
                elseif (preg_match('/.gif/', $_FILES['img']['name'])){
                    $extensao = "gif";
                }
                elseif (preg_match('/.png/', $_FILES['img']['name'])){
                    $extensao = "png";
                }
                elseif (preg_match('/.bmp/', $_FILES['img']['name'])){
                    $extensao = "bmp";
                }
                elseif (preg_match('/.svg/', $_FILES['img']['name'])){
                    $extensao = "svg";
                }
                elseif (preg_match('/.webp/', $_FILES['img']['name'])){
                    $extensao = "webp";
                }
                if ($extensao){
                    copy($_FILES['img']['tmp_name'], env('APP_DIR')."storage/usuario".$result[0]->id.".".$extensao);
                    $sql = "UPDATE users SET img = 'usuario".$result[0]->id.".".$extensao."' WHERE id = '".$result[0]->id."'";
                    $result2 = DB::select($sql);
                }
            }
            ?>
            <script>
                alert('Registro inserido com sucesso! Aguarde o refresh da página!');
                location.href="<?=env('APP_URL')?>usuario";
            </script>
            <?php
        }
        else{
            ?>
            <script>
                alert('Todos os campos obrigatórios devem estar preenchidos!');
                history.go(-1);
            </script>
            <?php
        }
    }
});
Route::post('/fornecedores/cadastrar', function () {
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=fornecedores";</script><?php
    }
    else{
            if ($_REQUEST['tpForn'] == 'F'){
                $statusCad = $_REQUEST['active_pf'];
            }
            else{
                $statusCad = $_REQUEST['active'];
            }
            $_REQUEST['endereco'] = (isset($_REQUEST['endereco'])) ? $_REQUEST['endereco'] : "";
            $_REQUEST['numero'] = (isset($_REQUEST['numero'])) ? $_REQUEST['numero'] : "";
            $_REQUEST['inscrEst'] = (isset($_REQUEST['inscrEst'])) ? $_REQUEST['inscrEst'] : "";
            if ($_REQUEST['tpForn'] == 'F'){
                $result = DB::table('suppliers_pf')->where('cpf', '=', $_REQUEST['cpf'])->count();
                if($result){
                    ?>
                    <script>
                        alert('Já existe um fornecedor cadastrado com esse cpf. Tente novamente!');
                        location.href="<?=env('APP_URL')?>fornecedores/add";
                    </script>
                    <?php
                    die();
                }
            }
            else{
                $result = DB::table('suppliers_pj')->where('cnpj', '=', $_REQUEST['cnpj'])->count();
                if($result){
                    ?>
                    <script>
                        alert('Já existe um fornecedor cadastrado com esse cnpj. Tente novamente!');
                        location.href="<?=env('APP_URL')?>fornecedores/add";
                    </script>
                    <?php
                    die();
                }
            }
            $sql = "INSERT INTO suppliers (tp_supplier, status, zip, address, number, complement, neighborhood, city, state, referencia, obs, condominio, endereco, numero, created_at, updated_at) VALUES ('".$_REQUEST['tpForn']."', '".$statusCad."', '".$_REQUEST['cep']."', '".$_REQUEST['address']."', '".$_REQUEST['number']."', '".$_REQUEST['complement']."', '".$_REQUEST['neighborhood']."', '".$_REQUEST['city']."', '".$_REQUEST['state']."', '".$_REQUEST['referencia']."', '".$_REQUEST['observacao']."', '".$_REQUEST['condominio']."', '".$_REQUEST['endereco']."', '".$_REQUEST['numero']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
            $result = DB::select($sql);
            $id = DB::getPdo()->lastInsertId();
            if ($_REQUEST['tpForn'] == 'F'){
                $sql = "INSERT INTO suppliers_pf (supplier, name, surname, cpf, rg, created_at, updated_at) VALUES ('".$id."', '".$_REQUEST['nome']."', '".$_REQUEST['apelido']."', '".$_REQUEST['cpf']."', '".$_REQUEST['rg']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
                DB::select($sql);
            }
            else{
                $sql = "INSERT INTO suppliers_pj (supplier, cnpj, razao_social, nome_fantasia, ind_inscr_est, inscr_est, inscr_mun, situacao, recolhimento, created_at, updated_at) VALUES ('".$id."', '".$_REQUEST['cnpj']."', '".$_REQUEST['razaoSocial']."', '".$_REQUEST['nomeFantasia']."', '".$_REQUEST['indInscrEst']."', '".$_REQUEST['inscrEst']."', '".$_REQUEST['inscrMun']."', '".$_REQUEST['status']."', '".$_REQUEST['gathering']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
                DB::select($sql);
            }
            for ($i = 0; $i <= $_REQUEST['qualEsta']; $i++){
                if ($_REQUEST['telefone'.$i] && $_REQUEST['tipo'.$i]){
                    $sql = "INSERT INTO suppliers_phones (supplier, tel, type, created_at, updated_at) VALUES ('".$id."', '".$_REQUEST['telefone'.$i]."', '".$_REQUEST['tipo'.$i]."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
                    DB::select($sql);
                }
            }
            for ($i = 0; $i <= $_REQUEST['qualEstaEmail']; $i++){
                if ($_REQUEST['email'.$i] && $_REQUEST['tipoEmail'.$i]){
                    $sql = "INSERT INTO suppliers_emails (supplier, email, type, created_at, updated_at) VALUES ('".$id."', '".$_REQUEST['email'.$i]."', '".$_REQUEST['tipoEmail'.$i]."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
                    DB::select($sql);
                }
            }
            for ($i = 1; $i <= $_REQUEST['contatosAdicionais']; $i++){
                if (isset($_REQUEST['nomeContato'.$i]) && isset($_REQUEST['nomeEmpresa'.$i]) && $_REQUEST['nomeContato'.$i] && $_REQUEST['nomeEmpresa'.$i]){
                    $sql = "INSERT INTO suppliers_contacts (supplier, name, company, office, created_at, updated_at) VALUES ('".$id."', '".$_REQUEST['nomeContato'.$i]."', '".$_REQUEST['nomeEmpresa'.$i]."', '".$_REQUEST['nomeCargo'.$i]."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
                    DB::select($sql);
                    $idSuppliersContacts = DB::getPdo()->lastInsertId();
                    for ($j = 1; $j <= $_REQUEST['qualEstaTelefoneContato'.$i]; $j++){
                        if (isset($_REQUEST['telefoneContatoAdicional'.$i.$j]) && isset($_REQUEST['tipoTelefoneContato'.$i.$j]) && $_REQUEST['telefoneContatoAdicional'.$i.$j] && $_REQUEST['tipoTelefoneContato'.$i.$j]){
                            $sql = "INSERT INTO suppliers_contacts_phones (supplier_contact, tel, type, created_at, updated_at) VALUES ('".$idSuppliersContacts."', '".$_REQUEST['telefoneContatoAdicional'.$i.$j]."', '".$_REQUEST['tipoTelefoneContato'.$i.$j]."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
                            DB::select($sql);
                        }
                    }
                    for ($j = 1; $j <= $_REQUEST['qualEstaEmailContato'.$i]; $j++){
                        if (isset($_REQUEST['emailContatoAdicional'.$i.$j]) && isset($_REQUEST['tipoEmailContato'.$i.$j]) && $_REQUEST['emailContatoAdicional'.$i.$j] && $_REQUEST['tipoEmailContato'.$i.$j]){
                            $sql = "INSERT INTO suppliers_contacts_emails (supplier_contact, email, type, created_at, updated_at) VALUES ('".$idSuppliersContacts."', '".$_REQUEST['emailContatoAdicional'.$i.$j]."', '".$_REQUEST['tipoEmailContato'.$i.$j]."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
                            DB::select($sql);
                        }
                    }
                }
            }
            $acao = "Cadastrou o fornecedor ".$id."!";
            $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
            ?>
            <script>
                alert('Registro inserido com sucesso! Aguarde o refresh da página!');
                location.href="<?=env('APP_URL')?>fornecedores";
            </script>
            <?php
    }
});
Route::post('/modulos/cadastrar', function () {
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=modulos";</script><?php
    }
    else{
        if ($_REQUEST['nome']){
            $sql = "INSERT INTO modules (module, name, slug, created_at, updated_at) VALUES ('".$_REQUEST['moduloPai']."', '".$_REQUEST['nome']."', '".$_REQUEST['slug']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
            $result = DB::select($sql);
            $sql = "SELECT LAST_INSERT_ID() as last_insert_id;";
            $idModulo = DB::select($sql);
            $sql = "SELECT * FROM modules WHERE id = '".$idModulo[0]->last_insert_id."'";
            $result = DB::select($sql);
            $acao = "Cadastrou o módulo do sistema ".$result[0]->id."!";
            $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
            ?>
            <script>
                alert('Registro inserido com sucesso! Aguarde o refresh da página!');
                location.href="<?=env('APP_URL')?>modulos";
            </script>
            <?php
        }
        else{
            ?>
            <script>
                alert('Todos os campos obrigatórios devem estar preenchidos!');
                history.go(-1);
            </script>
            <?php
        }
    }
});
Route::post('/versao/cadastrar', function () {
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=versao";</script><?php
    }
    else{
        if ($_REQUEST['nome'] && $_REQUEST['descricao']){
            $sql = "INSERT INTO versions (name, description, img, created_at, updated_at) VALUES ('".$_REQUEST['nome']."', '".$_REQUEST['descricao']."', '', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
            $result = DB::select($sql);
            $sql = "SELECT LAST_INSERT_ID() as last_insert_id;";
            $idVersao = DB::select($sql);
            $sql = "SELECT * FROM versions WHERE id = '".$idVersao[0]->last_insert_id."'";
            $result = DB::select($sql);
            if (count($_FILES) && $_FILES['img']['error'] == 0){     
                if (preg_match('/.jpg/', $_FILES['img']['name'])){
                    $extensao = "jpg";
                }
                elseif (preg_match('/.jpeg/', $_FILES['img']['name'])){
                    $extensao = "jpeg";
                }
                elseif (preg_match('/.gif/', $_FILES['img']['name'])){
                    $extensao = "gif";
                }
                elseif (preg_match('/.png/', $_FILES['img']['name'])){
                    $extensao = "png";
                }
                elseif (preg_match('/.bmp/', $_FILES['img']['name'])){
                    $extensao = "bmp";
                }
                elseif (preg_match('/.svg/', $_FILES['img']['name'])){
                    $extensao = "svg";
                }
                elseif (preg_match('/.webp/', $_FILES['img']['name'])){
                    $extensao = "webp";
                }
                if ($extensao){
                    copy($_FILES['img']['tmp_name'], env('APP_DIR')."storage/versao".$result[0]->id.".".$extensao);
                    $sql = "UPDATE versions SET img = 'versao".$result[0]->id.".".$extensao."' WHERE id = '".$result[0]->id."'";
                    $result2 = DB::select($sql);
                }
            }
            $acao = "Cadastrou a versão do sistema ".$result[0]->id."!";
            $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
            ?>
            <script>
                alert('Registro inserido com sucesso! Aguarde o refresh da página!');
                location.href="<?=env('APP_URL')?>versao";
            </script>
            <?php
        }
        else{
            ?>
            <script>
                alert('Todos os campos obrigatórios devem estar preenchidos!');
                history.go(-1);
            </script>
            <?php
        }
    }
});
Route::get('/usuario/editar/{id}', function () {
    $url = $_SERVER['REQUEST_URI'];
    $vet = explode('/', $url);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=usuario/editar/<?=$vet[2]?>";</script><?php
    }
    else{
        $apiRequest = "";
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        if ($permissao[0]->edit){
            $versoes = DB::select('select * from versions ORDER BY created_at DESC');
            $sql = "SELECT * FROM users WHERE id = '".$vet[2]."'";
            $usuario = DB::select($sql);
            $param = "usuario";
            return view('editUser', 
            [
                'versoes' => $versoes,
                'apiRequest' => $apiRequest,
                'modulePai' => $modulePai,
                'param' => $param,
                'usuario' => $usuario,
                'moduloE' => $moduloE,
                'permissao' => $permissao
            ]);
        }
        else{
            ?>
            <script>
                alert('Sem permissão para acessar essa página!');
                location.href="<?=env('APP_URL')?>usuario";
            </script>
            <?php
        }
    }
});
Route::get('/fornecedores/editar/{id}', function () {
    $url = $_SERVER['REQUEST_URI'];
    $vet = explode('/', $url);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=fornecedores/editar/<?=$vet[2]?>";</script><?php
    }
    else{
        $apiRequest = "";
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        if ($permissao[0]->edit){
            $versoes = DB::select('select * from versions ORDER BY created_at DESC');
            $sql = "SELECT * FROM suppliers WHERE id = '".$vet[2]."'";
            $supplier = DB::select($sql);
            if (!count($supplier)){
                ?>
                <script>
                    alert('Não foi encontrado o ID pesquisado! Você será redirecionado para a página de fornecedores!');
                    location.href="<?=env('APP_URL')?>fornecedores";
                </script>
                <?php
                die();
            }
            $sql = "SELECT * FROM cities WHERE id = '".$supplier[0]->city."'";
            $city = DB::select($sql);
            $sql = "SELECT * FROM suppliers_pf WHERE supplier = '".$vet[2]."'";
            $supplier_pf = DB::select($sql);
            $sql = "SELECT * FROM suppliers_pj WHERE supplier = '".$vet[2]."'";
            $supplier_pj = DB::select($sql);
            $sql = "SELECT * FROM suppliers_phones WHERE supplier = '".$vet[2]."'";
            $supplier_phones = DB::select($sql);
            $sql = "SELECT * FROM suppliers_emails WHERE supplier = '".$vet[2]."'";
            $supplier_emails = DB::select($sql);
            $sql = "SELECT * FROM suppliers_contacts WHERE supplier = '".$vet[2]."'";
            $supplier_contacts = DB::select($sql);
            if (count($supplier_contacts)){
                foreach ($supplier_contacts as $key => $value){
                    $sql = "SELECT * FROM suppliers_contacts_phones WHERE supplier_contact = '".$value->id."'";
                    $supplier_contacts[$key]->phones = DB::select($sql);
                    $sql = "SELECT * FROM suppliers_contacts_emails WHERE supplier_contact = '".$value->id."'";
                    $supplier_contacts[$key]->emails = DB::select($sql);
                }
            }
            $sql = "SELECT * FROM states ORDER BY uf ASC";
            $states = DB::select($sql);
            $param = "fornecedores";
            return view('editSupplier', 
            [
                'versoes' => $versoes,
                'apiRequest' => $apiRequest,
                'modulePai' => $modulePai,
                'param' => $param,
                'supplier' => $supplier,
                'city' => $city,
                'supplier_pf' => $supplier_pf,
                'supplier_pj' => $supplier_pj,
                'supplier_phones' => $supplier_phones,
                'supplier_emails' => $supplier_emails,
                'supplier_contacts' => $supplier_contacts,
                'states' => $states,
                'moduloE' => $moduloE,
                'permissao' => $permissao,
                'vet0' => $vet[0],
                'vet1' => $vet[1]
            ]);
        }
        else{
            ?>
            <script>
                alert('Sem permissão para acessar essa página!');
                location.href="<?=env('APP_URL')?>fornecedores";
            </script>
            <?php
        }
    }
});
Route::get('/modulos/editar/{id}', function () {
    $url = $_SERVER['REQUEST_URI'];
    $vet = explode('/', $url);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=modulos/editar/<?=$vet[2]?>";</script><?php
    }
    else{
        $apiRequest = "";
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        if ($permissao[0]->edit){
            $versoes = DB::select('select * from versions ORDER BY created_at DESC');
            $sql = "SELECT * FROM modules WHERE id = '".$vet[2]."'";
            $modulo = DB::select($sql);
            $param = "modulos";
            return view('editModule', 
            [
                'versoes' => $versoes,
                'apiRequest' => $apiRequest,
                'modulePai' => $modulePai,
                'param' => $param,
                'modulo' => $modulo,
                'moduloE' => $moduloE
            ]);
        }
        else{
            ?>
            <script>
                alert('Sem permissão para acessar essa página!');
                location.href="<?=env('APP_URL')?>modulos";
            </script>
            <?php
        }
    }
});
Route::get('/versao/editar/{id}', function () {
    $url = $_SERVER['REQUEST_URI'];
    $vet = explode('/', $url);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=usuario/versao/<?=$vet[2]?>";</script><?php
    }
    else{
        $apiRequest = "";
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        $versoes = DB::select('select * from versions ORDER BY created_at DESC');
        $sql = "SELECT * FROM versions WHERE id = '".$vet[2]."'";
        $versao = DB::select($sql);
        $param = "versao";
        if ($permissao[0]->edit){
            return view('editVersions', 
            [
                'versoes' => $versoes,
                'apiRequest' => $apiRequest,
                'modulePai' => $modulePai,
                'param' => $param,
                'versao' => $versao,
                'moduloE' => $moduloE
            ]);
        }
        else{
            ?>
            <script>
                alert('Sem permissão para acessar essa página!');
                location.href="<?=env('APP_URL')?>versao";
            </script>
            <?php
        }
    }
});
Route::post('/usuario/edita', function () {
    $url = $_SERVER['REQUEST_URI'];
    $vet = explode('/', $url);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=<?=$vet[0]?>/<?=$vet[1]?>";</script><?php
    }
    else{
        if ($_REQUEST['nome'] && $_REQUEST['email'] && $_REQUEST['id']){
            $sql = "UPDATE users SET name = '".$_REQUEST['nome']."', email = '".$_REQUEST['email']."', ";
            if ($_REQUEST['password']){
                $sql .= "password = '".md5($_REQUEST['password'])."', ";
            }
            $sql .= "updated_at = '".date('Y-m-d H:i:s')."' WHERE id = '".$_REQUEST['id']."'";            
            $result = DB::select($sql);
            $sql = "SELECT * FROM users WHERE email = '".$_REQUEST['email']."'";
            $result = DB::select($sql);
            if (count($_FILES) && $_FILES['img']['error'] == 0){     
                if (preg_match('/.jpg/', $_FILES['img']['name'])){
                    $extensao = "jpg";
                }
                elseif (preg_match('/.jpeg/', $_FILES['img']['name'])){
                    $extensao = "jpeg";
                }
                elseif (preg_match('/.gif/', $_FILES['img']['name'])){
                    $extensao = "gif";
                }
                elseif (preg_match('/.png/', $_FILES['img']['name'])){
                    $extensao = "png";
                }
                elseif (preg_match('/.bmp/', $_FILES['img']['name'])){
                    $extensao = "bmp";
                }
                elseif (preg_match('/.svg/', $_FILES['img']['name'])){
                    $extensao = "svg";
                }
                elseif (preg_match('/.webp/', $_FILES['img']['name'])){
                    $extensao = "webp";
                }
                if (isset($extensao)){
                    copy($_FILES['img']['tmp_name'], env('APP_DIR')."storage/usuario".$_REQUEST['id'].".".$extensao);
                    $sql = "UPDATE users SET img = 'usuario".$_REQUEST['id'].".".$extensao."' WHERE id = '".$_REQUEST['id']."'";
                    $result2 = DB::select($sql);
                    if ($_REQUEST['id'] == $_SESSION['user']['id']){
                        $_SESSION['user']['img'] = "usuario".$_REQUEST['id'].".".$extensao;
                    }
                }
            }
            $acao = "Atualizou o usuário do sistema ".$result[0]->id."!";
            $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
            ?>
            <script>
                alert('Registro atualizado com sucesso! Aguarde o refresh da página!');
                location.href="<?=env('APP_URL')?>usuario";
            </script>
            <?php
        }
        else{
            ?>
            <script>
                alert('Todos os campos obrigatórios devem estar preenchidos!');
                history.go(-1);
            </script>
            <?php
        }
    }
});
Route::post('/fornecedores/edita', function () {
    $url = $_SERVER['REQUEST_URI'];
    $vet = explode('/', $url);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=<?=$vet[0]?>/<?=$vet[1]?>";</script><?php
    }
    else{
        if (isset($_REQUEST['nome']) && $_REQUEST['nome']){
            if (!validaCPF($_REQUEST['cpf'])){
                ?>
                <script>
                    alert('CPF inválido! Verifique e tente novamente!');
                    history.go(-1);
                </script>
                <?php
                die();
            }
            $statusCad = $_REQUEST['active_pf'];
            $sql = "SELECT * FROM suppliers_pf WHERE cpf = '".$_REQUEST['cpf']."' AND supplier != '".$_REQUEST['id']."'";
            $dados = DB::select($sql);
            if (count($dados)){
                ?>
                <script>
                    alert('Não é possível utilizar esse cpf, pois ele já está sendo utilizado por outro fornecedor! Confira!');
                    history.go(-1);
                </script>
                <?php
                die();   
            }
        }
        else{
            if (!validaCNPJ($_REQUEST['cnpj'])){
                ?>
                <script>
                    alert('CNPJ inválido! Verifique e tente novamente!');
                    history.go(-1);
                </script>
                <?php
                die();
            }
            $statusCad = $_REQUEST['active'];
            $sql = "SELECT * FROM suppliers_pj WHERE cnpj = '".$_REQUEST['cnpj']."' AND supplier != '".$_REQUEST['id']."'";
            $dados = DB::select($sql);
            if (count($dados)){
                ?>
                <script>
                    alert('Não é possível utilizar esse cnpj, pois ele já está sendo utilizado por outro fornecedor! Confira!');
                    history.go(-1);
                </script>
                <?php
                die();   
            }
        }
        $_REQUEST['endereco'] = (isset($_REQUEST['endereco'])) ? $_REQUEST['endereco'] : "";
        $_REQUEST['numero'] = (isset($_REQUEST['numero'])) ? $_REQUEST['numero'] : "";
        $_REQUEST['inscrEst'] = (isset($_REQUEST['inscrEst'])) ? $_REQUEST['inscrEst'] : "";
        $sql = "UPDATE suppliers SET status = '".$statusCad."', zip = '".$_REQUEST['cep']."', address = '".$_REQUEST['address']."', number = '".$_REQUEST['number']."', complement = '".$_REQUEST['complement']."', neighborhood = '".$_REQUEST['neighborhood']."', city = '".$_REQUEST['city']."', state = '".$_REQUEST['state']."', referencia = '".$_REQUEST['referencia']."', obs = '".str_replace("\r\n", "", addslashes($_REQUEST['observacao']))."', condominio = '".$_REQUEST['condominio']."', endereco = '".$_REQUEST['endereco']."', numero = '".$_REQUEST['numero']."', updated_at = '".date('Y-m-d H:i:s')."' WHERE id = '".$_REQUEST['id']."'";
        DB::select($sql);
        if (isset($_REQUEST['nome']) && $_REQUEST['nome']){
            $sql = "UPDATE suppliers_pf SET cpf = '".$_REQUEST['cpf']."', name = '".$_REQUEST['nome']."', surname = '".$_REQUEST['apelido']."', rg = '".$_REQUEST['rg']."', updated_at = '".date('Y-m-d H:i:s')."' WHERE supplier = '".$_REQUEST['id']."'";
        }
        else{
            $sql = "UPDATE suppliers_pj SET razao_social = '".$_REQUEST['razaoSocial']."', nome_fantasia = '".$_REQUEST['nomeFantasia']."', ind_inscr_est = '".$_REQUEST['indInscrEst']."', inscr_est = '".$_REQUEST['inscrEst']."', inscr_mun = '".$_REQUEST['inscrMun']."', situacao = '".$_REQUEST['status']."', recolhimento = '".$_REQUEST['gathering']."', updated_at = '".date('Y-m-d H:i:s')."' WHERE supplier = '".$_REQUEST['id']."'";
        }
        DB::select($sql);
        $sql = "DELETE FROM suppliers_phones WHERE supplier = '".$_REQUEST['id']."'";
        DB::select($sql);
        $sql = "DELETE FROM suppliers_emails WHERE supplier = '".$_REQUEST['id']."'";
        DB::select($sql);
        $sql = "SELECT * FROM suppliers_contacts WHERE supplier = '".$_REQUEST['id']."'";
        $contacts = DB::select($sql);
        foreach ($contacts as $key => $value){
            $sql = "DELETE FROM suppliers_contacts_phones WHERE supplier_contact = '".$value->id."'";
            DB::select($sql);
            $sql = "DELETE FROM suppliers_contacts_emails WHERE supplier_contact = '".$value->id."'";
            DB::select($sql);
        }
        $sql = "DELETE FROM suppliers_contacts WHERE supplier = '".$_REQUEST['id']."'";
        DB::select($sql);
        for ($i = 0; $i <= $_REQUEST['qualEsta']; $i++){
            if ($_REQUEST['telefone'.$i] && $_REQUEST['tipo'.$i]){
                $sql = "INSERT INTO suppliers_phones (supplier, tel, type, created_at, updated_at) VALUES ('".$_REQUEST['id']."', '".$_REQUEST['telefone'.$i]."', '".$_REQUEST['tipo'.$i]."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
                DB::select($sql);
            }
        }
        for ($i = 0; $i <= $_REQUEST['qualEstaEmail']; $i++){
            if ($_REQUEST['email'.$i] && $_REQUEST['tipoEmail'.$i]){
                $sql = "INSERT INTO suppliers_emails (supplier, email, type, created_at, updated_at) VALUES ('".$_REQUEST['id']."', '".$_REQUEST['email'.$i]."', '".$_REQUEST['tipoEmail'.$i]."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
                DB::select($sql);
            }
        }
        for ($i = 1; $i <= $_REQUEST['contatosAdicionais']; $i++){
            if (isset($_REQUEST['nomeContato'.$i]) && isset($_REQUEST['nomeEmpresa'.$i]) && $_REQUEST['nomeContato'.$i] && $_REQUEST['nomeEmpresa'.$i]){
                $sql = "INSERT INTO suppliers_contacts (supplier, name, company, office, created_at, updated_at) VALUES ('".$_REQUEST['id']."', '".$_REQUEST['nomeContato'.$i]."', '".$_REQUEST['nomeEmpresa'.$i]."', '".$_REQUEST['nomeCargo'.$i]."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
                DB::select($sql);
                $idSuppliersContacts = DB::getPdo()->lastInsertId();
                for ($j = 1; $j <= $_REQUEST['qualEstaTelefoneContato'.$i]; $j++){
                    if (isset($_REQUEST['telefoneContatoAdicional'.$i.$j]) && isset($_REQUEST['tipoTelefoneContato'.$i.$j]) && $_REQUEST['telefoneContatoAdicional'.$i.$j] && $_REQUEST['tipoTelefoneContato'.$i.$j]){
                        $sql = "INSERT INTO suppliers_contacts_phones (supplier_contact, tel, type, created_at, updated_at) VALUES ('".$idSuppliersContacts."', '".$_REQUEST['telefoneContatoAdicional'.$i.$j]."', '".$_REQUEST['tipoTelefoneContato'.$i.$j]."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
                        DB::select($sql);
                    }
                }
                for ($j = 1; $j <= $_REQUEST['qualEstaEmailContato'.$i]; $j++){
                    if (isset($_REQUEST['emailContatoAdicional'.$i.$j]) && isset($_REQUEST['tipoEmailContato'.$i.$j]) && $_REQUEST['emailContatoAdicional'.$i.$j] && $_REQUEST['tipoEmailContato'.$i.$j]){
                        $sql = "INSERT INTO suppliers_contacts_emails (supplier_contact, email, type, created_at, updated_at) VALUES ('".$idSuppliersContacts."', '".$_REQUEST['emailContatoAdicional'.$i.$j]."', '".$_REQUEST['tipoEmailContato'.$i.$j]."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
                        DB::select($sql);
                    }
                }
            }
        }
        $acao = "Atualizou o fornecedor ".$_REQUEST['id']."!";
        $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
        ?>
        <script>
            alert('Registro atualizado com sucesso! Aguarde o refresh da página!');
            location.href="<?=env('APP_URL')?>fornecedores";
        </script>
        <?php
    }
});
Route::post('/modulos/edita', function () {
    $url = $_SERVER['REQUEST_URI'];
    $vet = explode('/', $url);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=<?=$vet[0]?>/<?=$vet[1]?>";</script><?php
    }
    else{
        if ($_REQUEST['nome']){
            $sql = "UPDATE modules SET `module` = '".$_REQUEST['moduloPai']."', name = '".$_REQUEST['nome']."', slug = '".$_REQUEST['slug']."', ";
            $sql .= "updated_at = '".date('Y-m-d H:i:s')."' WHERE id = '".$_REQUEST['id']."'";            
            $result = DB::select($sql);
            $sql = "SELECT * FROM modules WHERE id = '".$_REQUEST['id']."'";
            $result = DB::select($sql);
            $acao = "Atualizou o módulo do sistema ".$result[0]->id."!";
            $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
            ?>
            <script>
                alert('Registro atualizado com sucesso! Aguarde o refresh da página!');
                location.href="<?=env('APP_URL')?>modulos";
            </script>
            <?php
        }
        else{
            ?>
            <script>
                alert('Todos os campos obrigatórios devem estar preenchidos!');
                history.go(-1);
            </script>
            <?php
        }
    }
});
Route::post('/versao/edita', function () {
    $url = $_SERVER['REQUEST_URI'];
    $vet = explode('/', $url);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=<?=$vet[0]?>/<?=$vet[1]?>";</script><?php
    }
    else{
        if ($_REQUEST['nome'] && $_REQUEST['descricao']){
            $sql = "UPDATE versions SET name = '".$_REQUEST['nome']."', description = '".$_REQUEST['descricao']."', ";
            $sql .= "updated_at = '".date('Y-m-d H:i:s')."' WHERE id = '".$_REQUEST['id']."'";            
            $result = DB::select($sql);
            if (count($_FILES) && $_FILES['img']['error'] == 0){     
                if (preg_match('/.jpg/', $_FILES['img']['name'])){
                    $extensao = "jpg";
                }
                elseif (preg_match('/.jpeg/', $_FILES['img']['name'])){
                    $extensao = "jpeg";
                }
                elseif (preg_match('/.gif/', $_FILES['img']['name'])){
                    $extensao = "gif";
                }
                elseif (preg_match('/.png/', $_FILES['img']['name'])){
                    $extensao = "png";
                }
                elseif (preg_match('/.bmp/', $_FILES['img']['name'])){
                    $extensao = "bmp";
                }
                elseif (preg_match('/.svg/', $_FILES['img']['name'])){
                    $extensao = "svg";
                }
                elseif (preg_match('/.webp/', $_FILES['img']['name'])){
                    $extensao = "webp";
                }
                if ($extensao){
                    copy($_FILES['img']['tmp_name'], env('APP_DIR')."storage/versao".$_REQUEST['id'].".".$extensao);
                    $sql = "UPDATE versions SET img = 'versao".$_REQUEST['id'].".".$extensao."' WHERE id = '".$_REQUEST['id']."'";
                    $result = DB::select($sql);
                }
            }
            $sql = "SELECT * FROM versions WHERE id = '".$_REQUEST['id']."'";
            $result = DB::select($sql);
            $acao = "Atualizou a versão do sistema ".$result[0]->id."!";
            $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
            ?>
            <script>
                alert('Registro atualizado com sucesso! Aguarde o refresh da página!');
                location.href="<?=env('APP_URL')?>versao";
            </script>
            <?php
        }
        else{
            ?>
            <script>
                alert('Todos os campos obrigatórios devem estar preenchidos!');
                history.go(-1);
            </script>
            <?php
        }
    }
});

Route::get('/usuario/add', function () {
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=usuario";</script><?php
    }
    else{
        $apiRequest = "";
        $url = $_SERVER['REQUEST_URI'];
        $vet = explode('/', $url);
        array_shift($vet);
        array_shift($vet);
        array_shift($vet);
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        if ($permissao[0]->edit){
            $versoes = DB::select('select * from versions ORDER BY created_at DESC');
            $param = "usuario";
            return view('newUser', 
            [
                'versoes' => $versoes,
                'apiRequest' => $apiRequest,
                'modulePai' => $modulePai,
                'param' => $param,
                'moduloE' => $moduloE,
                'permissao' => $permissao
            ]);
        }
        else{
            ?>
            <script>
                alert('Sem permissão para ver essa página!');
                location.href="<?=env('APP_URL')?>usuario";
            </script>
            <?php
        }
    }
});

Route::get('/fornecedores/add', function () {
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=usuario";</script><?php
    }
    else{
        $apiRequest = "";
        $url = $_SERVER['REQUEST_URI'];
        $vet = explode('/', $url);
        array_shift($vet);
        array_shift($vet);
        array_shift($vet);
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        if ($permissao[0]->edit){
            $states = DB::select('select * from states ORDER BY uf ASC');
            $versoes = DB::select('select * from versions ORDER BY created_at DESC');
            $param = "fornecedores";
            return view('newSupplier', 
            [
                'versoes' => $versoes,
                'states' => $states,
                'apiRequest' => $apiRequest,
                'modulePai' => $modulePai,
                'param' => $param,
                'moduloE' => $moduloE,
                'permissao' => $permissao,
                'vet0' => $vet[0],
                'vet1' => $vet[1]
            ]);
        }
        else{
            ?>
            <script>
                alert('Sem permissão para ver essa página!');
                location.href="<?=env('APP_URL')?>usuario";
            </script>
            <?php
        }
    }
});

Route::get('/versao/add', function () {
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=versao";</script><?php
    }
    else{
        $url = $_SERVER['REQUEST_URI'];
        $vet = explode('/', $url);
        array_shift($vet);
        array_shift($vet);
        array_shift($vet);
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        if ($permissao[0]->edit){
            $apiRequest = "";
            $versoes = DB::select('select * from versions ORDER BY created_at DESC');
            $param = "versao";
            return view('newVersions', 
            [
                'versoes' => $versoes,
                'apiRequest' => $apiRequest,
                'modulePai' => $modulePai,
                'param' => $param,
                'moduloE' => $moduloE
            ]);
        }
        else{
            ?>
            <script>
                alert('Sem permissão para ver essa página!');
                location.href="<?=env('APP_URL')?>versao";
            </script>
            <?php
        }
    }
});

Route::get('/modulos/add', function () {
    $url = $_SERVER['REQUEST_URI'];
    $vet = explode('/', $url);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=modulos";</script><?php
    }
    else{
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        $apiRequest = "";
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        if ($permissao[0]->edit){
            $versoes = DB::select('select * from versions ORDER BY created_at DESC');
            $param = "modules";
            return view('newModule', 
            [
                'versoes' => $versoes,
                'apiRequest' => $apiRequest,
                'modulePai' => $modulePai,
                'param' => $param,
                'moduloE' => $moduloE
            ]);
        }
        else{
            ?>
            <script>
                alert('Sem permissão para ver essa página!');
                location.href="<?=env('APP_URL')?>modulos";
            </script>
            <?php
        }
    }
});
Route::get('/usuario/visualizar/{id}', function () {
    $url = $_SERVER['REQUEST_URI'];
    $vet = explode('/', $url);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    if (!isset($_SESSION) || !$_SESSION['user']){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=usuario/visualizar/<?=$vet[2]?>";</script><?php
    }
    else{
        $apiRequest = "";
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        $versoes = DB::select('select * from versions ORDER BY created_at DESC');
        $sql = "SELECT * FROM users WHERE id = '".$vet[2]."'";
        $result = DB::select($sql);
        $acao = "Visualizou o usuário do sistema ".$result[0]->id."!";
        $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
        $param = "usuario";
        return view('viewUser', 
        [
            'versoes' => $versoes,
            'apiRequest' => $apiRequest,
            'result' => $result,
            'modulePai' => $modulePai,
            'param' => $param,
            'moduloE' => $moduloE,
            'permissao' => $permissao
        ]);
    }
});
Route::get('/fornecedores/visualizar/{id}', function () {
    $url = $_SERVER['REQUEST_URI'];
    $vet = explode('/', $url);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    if (!isset($_SESSION) || !$_SESSION['user']){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=usuario/fornecedores/<?=$vet[2]?>";</script><?php
    }
    else{
        $apiRequest = "";
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        $versoes = DB::select('select * from versions ORDER BY created_at DESC');
        $sql = "SELECT * FROM suppliers WHERE id = '".$vet[2]."'";
        $supplier = DB::select($sql);
        if (!count($supplier)){
            ?>
            <script>
                alert('ID não encontrado em nossa base de dados! Você será redirecionado para a página de fornecedores agora!');
                location.href="<?=env('APP_URL')?>fornecedores";
            </script>
            <?php
            die();
        }
        $sql = "SELECT * FROM cities WHERE id = '".$supplier[0]->city."'";
        $city = DB::select($sql);
        $sql = "SELECT * FROM suppliers_pf WHERE supplier = '".$vet[2]."'";
        $supplier_pf = DB::select($sql);
        $sql = "SELECT * FROM suppliers_pj WHERE supplier = '".$vet[2]."'";
        $supplier_pj = DB::select($sql);
        $sql = "SELECT * FROM suppliers_phones WHERE supplier = '".$vet[2]."'";
        $supplier_phones = DB::select($sql);
        $sql = "SELECT * FROM suppliers_emails WHERE supplier = '".$vet[2]."'";
        $supplier_emails = DB::select($sql);
        $sql = "SELECT * FROM suppliers_contacts WHERE supplier = '".$vet[2]."'";
        $supplier_contacts = DB::select($sql);
        if (count($supplier_contacts)){
            foreach ($supplier_contacts as $key => $value){
                $sql = "SELECT * FROM suppliers_contacts_phones WHERE supplier_contact = '".$value->id."'";
                $supplier_contacts[$key]->phones = DB::select($sql);
                $sql = "SELECT * FROM suppliers_contacts_emails WHERE supplier_contact = '".$value->id."'";
                $supplier_contacts[$key]->emails = DB::select($sql);
            }
        }
        $sql = "SELECT * FROM states ORDER BY uf ASC";
        $states = DB::select($sql);
        $acao = "Visualizou o fornecedor ".$supplier[0]->id."!";
        $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
        $param = "fornecedores";
        return view('viewSupplier', 
        [
            'versoes' => $versoes,
            'apiRequest' => $apiRequest,
            'supplier' => $supplier,
            'supplier_pj' => $supplier_pj,
            'supplier_pf' => $supplier_pf,
            'supplier_phones' => $supplier_phones,
            'supplier_emails' => $supplier_emails,
            'supplier_contacts' => $supplier_contacts,
            'city' => $city,
            'states' => $states,
            'modulePai' => $modulePai,
            'param' => $param,
            'moduloE' => $moduloE,
            'permissao' => $permissao
        ]);
    }
});
Route::get('/modulos/visualizar/{id}', function () {
    $url = $_SERVER['REQUEST_URI'];
    $vet = explode('/', $url);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    if (!isset($_SESSION) || !$_SESSION['user']){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=modulos/visualizar/<?=$vet[2]?>";</script><?php
    }
    else{
        $apiRequest = "";
        
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        $versoes = DB::select('select * from versions ORDER BY created_at DESC');
        $sql = "SELECT a.*, b.name AS nomeTipoModulo FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.id = '".$vet[2]."'";
        $result = DB::select($sql);
        $acao = "Visualizou o usuário do sistema ".$result[0]->id."!";
        $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
        $param = "modulos";
        return view('viewModule', 
        [
            'versoes' => $versoes,
            'apiRequest' => $apiRequest,
            'result' => $result,
            'modulePai' => $modulePai,
            'param' => $param,
            'moduloE' => $moduloE
        ]);
    }
});

Route::get('/versao/visualizar/{id}', function () {
    $url = $_SERVER['REQUEST_URI'];
    $vet = explode('/', $url);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    if (!isset($_SESSION) || !$_SESSION['user']){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=versao/visualizar/<?=$vet[2]?>";</script><?php
    }
    else{
        $apiRequest = "";
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        $versoes = DB::select('select * from versions ORDER BY created_at DESC');
        $sql = "SELECT * FROM versions WHERE id = '".$vet[2]."'";
        $result = DB::select($sql);
        $acao = "Visualizou a versão do sistema ".$result[0]->id."!";
        $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
        $param = "versao";
        return view('viewVersions', 
        [
            'versoes' => $versoes,
            'apiRequest' => $apiRequest,
            'result' => $result,
            'modulePai' => $modulePai,
            'param' => $param,
            'moduloE' => $moduloE,
            'permissao' => $permissao
        ]);
    }
});
Route::get('/usuario/excluir/{id}', function () {
    if (!isset($_SESSION) || !$_SESSION['user']){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=usuario";</script><?php
    }
    else{
        $apiRequest = "";
        $url = $_SERVER['REQUEST_URI'];
        $vet = explode('/', $url);
        array_shift($vet);
        array_shift($vet);
        array_shift($vet);
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        if ($permissao[0]->delete){
            $dados = DB::select("SELECT * FROM users WHERE id = '".$vet[2]."'");
            if ($dados[0]->img){
                unlink(env('APP_DIR').'storage/'.$dados[0]->img);
            }
            $usuarioDeleta = DB::select("DELETE FROM users WHERE id = :id", ['id' => $vet[2]]);
            $logs = DB::select('INSERT INTO logs (user, action, created_at, updated_at) VALUES ("'.$_SESSION['user']['id'].'", "Deletou o usuário '.$vet[1].'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'")');
            ?>
            <script>
                alert('Registro excluído com sucesso!');
                location.href="<?=env('APP_URL')?>usuario";
            </script>
            <?php
        }
        else{
            ?>
            <script>
                alert('Sem permissão para visualizar essa página!');
                location.href="<?=env('APP_URL')?>usuario";
            </script>
            <?php
        }
    }
});
Route::get('/fornecedores/excluir/{id}', function () {
    if (!isset($_SESSION) || !$_SESSION['user']){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=fornecedores";</script><?php
    }
    else{
        $apiRequest = "";
        $url = $_SERVER['REQUEST_URI'];
        $vet = explode('/', $url);
        array_shift($vet);
        array_shift($vet);
        array_shift($vet);
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        if ($permissao[0]->delete){
            $dados = DB::select("SELECT * FROM suppliers WHERE id = '".$vet[2]."'");
            DB::select("DELETE FROM suppliers WHERE id = :id", ['id' => $vet[2]]);
            DB::select("DELETE FROM suppliers_pf WHERE supplier = :id", ['id' => $vet[2]]);
            DB::select("DELETE FROM suppliers_pj WHERE supplier = :id", ['id' => $vet[2]]);
            DB::select("DELETE FROM suppliers_phones WHERE supplier = :id", ['id' => $vet[2]]);
            DB::select("DELETE FROM suppliers_emails WHERE supplier = :id", ['id' => $vet[2]]);
            $contacts = DB::select("SELECT * FROM suppliers_contacts WHERE supplier = :id", ['id' => $vet[2]]);
            foreach ($contacts as $key => $value){
                DB::select("DELETE FROM suppliers_contacts_phones WHERE supplier_contact = :id", ['id' => $value->id]);
                DB::select("DELETE FROM suppliers_contacts_emails WHERE supplier_contact = :id", ['id' => $value->id]);
            }
            DB::select("DELETE FROM suppliers_contacts WHERE supplier = :id", ['id' => $vet[2]]);
            $logs = DB::select('INSERT INTO logs (user, action, created_at, updated_at) VALUES ("'.$_SESSION['user']['id'].'", "Deletou o fornecedor '.$vet[1].'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'")');
            ?>
            <script>
                alert('Registro excluído com sucesso!');
                location.href="<?=env('APP_URL')?>fornecedores";
            </script>
            <?php
        }
        else{
            ?>
            <script>
                alert('Sem permissão para visualizar essa página!');
                location.href="<?=env('APP_URL')?>usuario";
            </script>
            <?php
        }
    }
});
Route::get('/modulos/excluir/{id}', function () {
    if (!isset($_SESSION) || !$_SESSION['user']){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=modulos";</script><?php
    }
    else{
        $apiRequest = "";
        $url = $_SERVER['REQUEST_URI'];
        $vet = explode('/', $url);
        array_shift($vet);
        array_shift($vet);
        array_shift($vet);
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        if ($permissao[0]->delete){
            $usuarioDeleta = DB::select("DELETE FROM modules WHERE id = :id", ['id' => $vet[2]]);
            $logs = DB::select('INSERT INTO logs (user, action, created_at, updated_at) VALUES ("'.$_SESSION['user']['id'].'", "Deletou o módulo '.$vet[1].'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'")');
            ?>
            <script>
                alert('Registro excluído com sucesso!');
                location.href="<?=env('APP_URL')?>modulos";
            </script>
            <?php
        }
        else{
            ?>
            <script>
                alert('Sem permissão para visualizar essa página!');
                location.href="<?=env('APP_URL')?>modulos";
            </script>
            <?php 
        }
    }
});

Route::get('/versao/excluir/{id}', function () {
    if (!isset($_SESSION) || !$_SESSION['user']){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=versao";</script><?php
    }
    else{
        $apiRequest = "";
        $url = $_SERVER['REQUEST_URI'];
        $vet = explode('/', $url);
        array_shift($vet);
        array_shift($vet);
        array_shift($vet);
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        if ($permissao[0]->delete){
            $dados = DB::select("SELECT * FROM versions WHERE id = '".$vet[2]."'");
            if ($dados[0]->img){
                unlink(env('APP_DIR').'storage/'.$dados[0]->img);
            }
            $usuarioDeleta = DB::select("DELETE FROM versions WHERE id = :id", ['id' => $vet[2]]);
            $logs = DB::select('INSERT INTO logs (user, action, created_at, updated_at) VALUES ("'.$_SESSION['user']['id'].'", "Deletou o usuário '.$vet[2].'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'")');
            ?>
            <script>
                alert('Registro excluído com sucesso!');
                location.href="<?=env('APP_URL')?>versao";
            </script>
            <?php
        }
        else{
            ?>
            <script>
                alert('Sem permissão para visualizar essa página!');
                location.href="<?=env('APP_URL')?>versao";
            </script>
            <?php 
        }
    }
});
Route::get('/usuario/excluirImg/{id}', function () {
    if (!isset($_SESSION) || !$_SESSION['user']){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=usuario";</script><?php
    }
    else{
        $apiRequest = "";
        $url = $_SERVER['REQUEST_URI'];
        $vet = explode('/', $url);
        array_shift($vet);
        array_shift($vet);
        array_shift($vet);
        array_shift($vet);
        $dados = DB::select("SELECT * FROM users WHERE id = '".$vet[1]."'");
        if ($dados[0]->img){
            @unlink(env('APP_DIR').'storage/'.$dados[0]->img);
        }
        
        if ($vet[1] == $_SESSION['user']['id']){
            $_SESSION['user']['img'] = "";
        }
        DB::select("UPDATE users SET img = '' WHERE id = '".$vet[1]."'"); 
        $logs = DB::select('INSERT INTO logs (user, action, created_at, updated_at) VALUES ("'.$_SESSION['user']['id'].'", "Excluiu a imagem do usuário '.$vet[1].'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'")');
        ?>
        <script>
            alert('Imagem excluída com sucesso!');
            location.href="<?=env('APP_URL')?>usuario";
        </script>
        <?php
    }
});
Route::get('/versao/excluirImg/{id}', function () {
    if (!isset($_SESSION) || !$_SESSION['user']){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=versao";</script><?php
    }
    else{
        $apiRequest = "";
        $url = $_SERVER['REQUEST_URI'];
        $vet = explode('/', $url);
        array_shift($vet);
        array_shift($vet);
        array_shift($vet);
        array_shift($vet);
        $dados = DB::select("SELECT * FROM versions WHERE id = '".$vet[1]."'");
        if ($dados[0]->img){
            @unlink(env('APP_DIR').'storage/'.$dados[0]->img);
        }
        DB::select("UPDATE versions SET img = '' WHERE id = '".$vet[1]."'"); 
        $logs = DB::select('INSERT INTO logs (user, action, created_at, updated_at) VALUES ("'.$_SESSION['user']['id'].'", "Excluiu a imagem da versão '.$vet[1].'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'")');
        ?>
        <script>
            alert('Imagem excluída com sucesso!');
            location.href="<?=env('APP_URL')?>versao";
        </script>
        <?php
    }
});

Route::get('graficos', function () {
    if (!isset($_SESSION) || !isset($_SESSION['user']['name'])){
        ?><script>location.href="<?=env('APP_URL')?>login?pagina=";</script><?php
    }
    else{
        if (isset($_REQUEST['cpf'])){
            $api = Http::post('https://dev.gosat.org/api/v1/simulacao/credito?cpf='.$_REQUEST['cpf']);
            $apiRequest = $api->json();
        }
        else{
            $apiRequest = "";
        }
        $url = $_SERVER['REQUEST_URI'];
        $vet = explode('/', $url);
        array_shift($vet);
        array_shift($vet);
        array_shift($vet);  
        $versoes = DB::select('select * from versions ORDER BY created_at DESC');
        $param = "graficos";
        $modulePai = DB::select('select * from modules where module = 0');
        foreach ($modulePai as $key => $value){
            $modulePai[$key]->modules = DB::select('SELECT a.*, b.name AS nomePai FROM modules a LEFT JOIN modules b ON (a.module = b.id) WHERE a.module = "'.$value->id.'"');
            foreach ($modulePai[$key]->modules as $chave => $valor){
                $modulePai[$key]->modules[$chave]->permissao = DB::select('select * from permissions where module = :id AND user = :user LIMIT 1', ['id' => $valor->id, 'user' => $_SESSION['user']['id']]);        
                if ($vet[0] == $valor->slug){
                    $moduloE = $valor;
                    $permissao = $modulePai[$key]->modules[$chave]->permissao;
                }
            }
        }
        if ($permissao[0]->view){
            $acao = "Visualizou a Página de Gráficos do Sistema";
            $logs = DB::select("INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', '".$acao."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
            $param = "graficos";
            return view('graficos', 
            [
                'apiRequest' => $apiRequest,
                'versoes' => $versoes,
                'modulePai' => $modulePai,
                'param' => $param,
                'moduloE' => $moduloE,
                'permissao' => $permissao
            ]);
        }
        else{
            return view('noPermission', 
            [
                'versoes' => $versoes,
                'modulePai' => $modulePai,
                'param' => $param,
                'moduloE' => $moduloE,
                'permissao' => $permissao
            ]);
        }
    }
});
Route::get('login', function () {
    return view('login');
});

Route::get('esqueci-minha-senha', function () {
    return view('esqueciMinhaSenha');
});

Route::get('alterar-senha/{codigo}', function () {
    $url = $_SERVER['REQUEST_URI'];
    $vet = explode('/', $url);
    array_shift($vet);
    array_shift($vet);
    array_shift($vet);
    $usuario = DB::select("SELECT * FROM users WHERE remember_token = :codigo", ['codigo' => $vet[1]]);
    if (!count($usuario)){
        ?>
        <script>
            alert('Não foi encontrado o código pesquisado em nossa lista de usuários!');
            location.href="<?=env('APP_URL')?>";
        </script>
        <?php
    }
    else{
        return view('alterarSenha', ['usuario' => $usuario]);
    }
});