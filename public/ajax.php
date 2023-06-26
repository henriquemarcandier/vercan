<?php
require_once('connect.php');
require_once('funcoes.php');
ini_set('display_erros', 'off');
header('Content-type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');
switch ($_REQUEST['acao']) {
    case "verificaCNPJ":
        $_REQUEST['cnpj'] = str_replace('.', '', str_replace('/', '', str_replace('-', '', $_REQUEST['cnpj'])));
        $url = "https://receitaws.com.br/v1/cnpj/".$_REQUEST['cnpj'];
        $consulta = file_get_contents($url);
        $json = json_decode($consulta, true);
        echo "1|-|".$json['nome']."|-|".$json['fantasia']."|-|".$json['situacao']."|-|".str_replace(".", "", $json['cep'])."|-|".$json['logradouro']."|-|".$json['numero']."|-|".$json['complemento']."|-|".$json['bairro']."|-|".$json['uf']."|-|".$json['municipio'];
        break;
    case "selecionaEstado":
        $sql = "SELECT * FROM states WHERE uf = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql) or die(mysqli_error($con));
        if (mysqli_num_rows($query)){
            $row = mysqli_fetch_array($query);
            $sql = "SELECT * FROM cities WHERE state = '".$row['id']."' ORDER BY name ASC";
            $query = mysqli_query($con, $sql) or die(mysqli_error($con));
            if (mysqli_num_rows($query)){
                $html = "<select name='city' id='city' class='form-control'>
                <option value=''>SELECIONE A CIDADE ABAIXO CORRETAMENTE...</option>";
                while ($row = mysqli_fetch_array($query)){
                    $html .= "<option value='".$row['id']."' ";
                    if (strtoupper(retiraAcentos($_REQUEST['cidade'])) == $row['name']){
                        $html .= "selected";
                    }
                    $html .= ">".$row['name']."</option>";
                }
                $html .= "</select>";
                echo "1|-|".$html;
            }
        }
        break;
    case "alteraPermissoes":
        $sql = "SELECT * FROM permissions WHERE user = '".$_REQUEST['user']."' AND module = '".$_REQUEST['module']."'";
        $query = mysqli_query($con, $sql);
        if (!mysqli_num_rows($query)){
            $sql = "INSERT INTO permissions (user, module, ".$_REQUEST['tipo'].", created_at, updated_at) VALUES ('".$_REQUEST['user']."', '".$_REQUEST['module']."', '1', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
            mysqli_query($con, $sql);
            $img = "sucesso.png";
        }
        else{
            $row = mysqli_fetch_array($query);
            if ($row[$_REQUEST['tipo']] == 1){
                $img = "erro.ico";
                $valor = "0";
            }
            else{
                $img = "sucesso.png";
                $valor = "1";
            }
            $sql = "UPDATE permissions SET `".$_REQUEST['tipo']."` = '".$valor."' WHERE id = '".$row['id']."'";
            mysqli_query($con, $sql);
        }
        $img = "<img src='".URL."storage/images/".$img."' width='18' style='cursor:pointer' onclick=alteraPermissoes('".$_REQUEST['user']."','".$_REQUEST['module']."','".$_REQUEST['tipo']."','".URL."')>";
        echo "1|-|".$img;
        break;
    case "pegaPermissoes":
        $sql = "SELECT a.* FROM modules a WHERE a.module = '0'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            $html = '<table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <td>Módulo</td>
                    <td>Visualizar</td>
                    <td>Editar</td>
                    <td>Excluir</td>
                </tr>
            </thead>
            <tbody>';
            while ($row = mysqli_fetch_array($query)){
                $html .= "<tr>
                <td>".$row['name']."</td>
                <td></td>
                <td></td>
                <td></td>
                </tr>";
                $sql = "SELECT * FROM modules WHERE module = '".$row['id']."'";
                $query2 = mysqli_query($con, $sql);
                if (mysqli_num_rows($query2)){
                    while ($row2 = mysqli_fetch_array($query2)){
                        $sql = "SELECT * FROM permissions WHERE user = '".$_REQUEST['usuario']."' AND module = '".$row2['id']."'";
                        $query3 = mysqli_query($con, $sql);
                        if (mysqli_num_rows($query3)){
                            $row3 = mysqli_fetch_array($query3);
                        }
                        else{
                            unset($row3);
                        }
                        $html .= "<tr>
                            <td>".$row['name']." => ".$row2['name']."</td>
                            <td id='view".$row2['id']."_".$_REQUEST['usuario']."'>";
                        if (isset($row3) && $row3['view'] == 1){
                            $html .= '<img src="'.URL.'storage/images/sucesso.png" width="18" style="cursor:pointer" onclick=alteraPermissoes("'.$_REQUEST['usuario'].'","'.$row2['id'].'","view","'.URL.'")>';
                        }
                        else{
                            $html .= '<img src="'.URL.'storage/images/erro.ico" width="18" style="cursor:pointer" onclick=alteraPermissoes("'.$_REQUEST['usuario'].'","'.$row2['id'].'","view","'.URL.'")>';
                        }
                        $html .= "</td>
                            <td id='edit".$row2['id']."_".$_REQUEST['usuario']."'>";
                            if (isset($row3) && $row3['edit'] == 1){
                                $html .= '<img src="'.URL.'storage/images/sucesso.png" width="18" style="cursor:pointer" onclick=alteraPermissoes("'.$_REQUEST['usuario'].'","'.$row2['id'].'","edit","'.URL.'")>';
                            }
                            else{
                                $html .= '<img src="'.URL.'storage/images/erro.ico" width="18" style="cursor:pointer" onclick=alteraPermissoes("'.$_REQUEST['usuario'].'","'.$row2['id'].'","edit","'.URL.'")>';
                            }
                            $html .= "</td>
                            <td id='delete".$row2['id']."_".$_REQUEST['usuario']."'>";
                            if (isset($row3) && $row3['delete'] == 1){
                                $html .= '<img src="'.URL.'storage/images/sucesso.png" width="18" style="cursor:pointer" onclick=alteraPermissoes("'.$_REQUEST['usuario'].'","'.$row2['id'].'","delete","'.URL.'")>';
                            }
                            else{
                                $html .= '<img src="'.URL.'storage/images/erro.ico" width="18" style="cursor:pointer" onclick=alteraPermissoes("'.$_REQUEST['usuario'].'","'.$row2['id'].'","delete","'.URL.'")>';
                            }
                            $html .= "</td>
                        </tr>";
                    }
                }
            }
            $html .= '</tbody></table>';
        }
        echo "1|-|".$html;
        break;
    case "formLogin":
        $sql = "SELECT * FROM users WHERE email = '".$_REQUEST['emailLogin']."' AND password = '".md5($_REQUEST['senhaLogin'])."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            $row = mysqli_fetch_array($query);
            $_SESSION['user'] = $row;
            $action = "Se logou no sistema";
            $idUser = $_SESSION['user']['id'];
            $sql = "INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$idUser."', '".$action."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
            mysqli_query($con, $sql);
            echo "1";
        }
        else{
            echo "0|-|Login e/ou senha inválidos! Confira!";
        }
        break;
    case "formAlterarSenha":
        if ($_REQUEST['password'] != $_REQUEST['password2']){
            echo "0|-|Informe senhhas iguais!";
        }
        else {
            $sql = "UPDATE users SET password = '".md5($_REQUEST['password'])."', remember_token = '', updated_at = '".date('Y-m-d H:i:s')."' WHERE id = '".$_REQUEST['idUsuario']."'";
            mysqli_query($con, $sql);
            echo "1";
        }
        break;
    case "formEsqueceuSuaSenha":
        $sql = "SELECT * FROM users WHERE email = '".$_REQUEST['email']."'";
        $query = mysqli_query ($con, $sql);
        if (mysqli_num_rows($query)){
            $row = mysqli_fetch_array($query);
            $digitos = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
            $sql = "UPDATE users SET remember_token = '".$digitos."' WHERE id = '".$row['id']."'";
            mysqli_query($con,  $sql);
            $html = "<html>
                    <head>
                        <title>Sistema de Teste - Esqueceu sua senha</title>
<                   </head>
                    <body>
                        <table width='100%' cellspacing='0' cellpadding='0' border='0'>
                            <tr>
                                <td width='100' style='text-align:center' valign='top'><img src='".URL."images/logo.png' width='90'></td>
                                <td>Olá <b>".$row['name']."</b>,<br><br>
                                Este email é porque você solicitou em nosso site um lembrete da sua senha!<br><br>
                                Para alterar a sua senha, <a href='".URL."alterar-senha/".$digitos."'>clique aqui</a>.<br><br>
                                Atenciosamente,<br><br>
                                Equipe <a href='".URL."'>Sistema de Teste Gosat</a></td>
<                           </tr>
                        </table><hr noshade><center>Email desenvolvido por <a href='https://www.bhcommerce.com.br'>Henrique Marcandier</a></center><hr noshade>
                   </body>
                   </html>";
				   $assunto = "Sistema de Teste Gosat - Esqueceu Sua Senha?";
            $cabecalhoEmail = "Content-Type: text/html; charset=iso-8859-1\n";
            $cabecalhoEmail .= "From: Sistema de Teste Gosat<testegosat@bhcommerce.com.br>\nReply-To: Sistema de Teste Gosat<testegosat@bhcommerce.com.br>";
            enviarEmail("testegosat@bhcommerce.com.br", "Sistema de Teste Gosat", $row['email'], utf8_decode($row['name']), utf8_decode($assunto), utf8_decode($html));
			//mail(utf8_decode($row['name']."<".$row['email'].">"), utf8_decode($parametrosSite['title']." - Esqueceu sua senha?"), utf8_decode($html), utf8_decode($cabecalhoEmail));
            echo "1|-|".$html;
        }
        else{
            echo "0|-|Esse email não está cadastrado em nossa base de dados!";
        }
        break;
    case 'aprovarUsuario':
        $sql = "SELECT * FROM user_pres WHERE id = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);
        $sql = "DELETE FROM user_pres WHERE id = '".$_REQUEST['id']."'";
        mysqli_query($con, $sql);
        $sql = ("INSERT INTO users (name, email, password, created_at, updated_at) VALUES ('".$row['name']."', '".$row['email']."', '".$row['password']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
        mysqli_query($con, $sql);
        $html = "<html>
                    <head>
                        <title>Sistema de Teste Gosat - Cadastro Liberado no Admin com Sucesso!</title>
<                   </head>
                    <body>
                        <table width='100%' cellspacing='0' cellpadding='0' border='0'>
                            <tr>
                                <td width='100' style='text-align:center' valign='top'><img src='".URL."img/logo.png' width='90'></td>
                                <td>Olá <b>".$row['name']."</b>,<br><br>
                                Este email é para informar que o seu cadastro foi liberado com sucesso no admin de nosso site!<br><br>
                                Para acessar nosso admin, <a href='".URL."admin'>clique aqui</a>.<br><br>
                                Seu email: ".$row['email']."<br><br>
                                Atenciosamente,<br><br>
                                Equipe <a href='".URL."'>Sistema de Teste Gosat</a></td>
<                           </tr>
                        </table><hr noshade><center>Email desenvolvido pela <a href='https://www.bhcommerce.com.br'>BH Commerce</a></center><hr noshade>
                   </body>
                   </html>";
        $cabecalhoEmail = "Content-Type: text/html; charset=iso-8859-1\n";
        $cabecalhoEmail .= "From: Sistema de Teste Gosat<testegosat@bhcommerce.com.br>\nReply-To: Sistema de Teste Gosat<testegosat@bhcommerce.com.br>";
        enviarEmail($parametrosSite['email'], utf8_decode($parametrosSite['title']), $row['email'], utf8_decode($row['name']), utf8_decode($parametrosSite['title']." - Cadastro Liberado no Admin com Sucesso!"), utf8_decode($html));
        //mail(utf8_decode($row['name']."<".$row['email'].">"), utf8_decode($parametrosSite['title']." - Cadastro Liberado no Admin com Sucesso!"), utf8_decode($html), utf8_decode($cabecalhoEmail));
        echo "1";
    break;        
    case "logout":
        $sql = "INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_SESSION['user']['id']."', 'Efetuou logout no site!', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
        mysqli_query($con, $sql) or die(mysqli_error($con));
        $_SESSION['user'] = "";
        echo "1";
        break;
    default:
        echo "0|-|Não foi encontrada a ação pesquisada!";
        break;
}
?>