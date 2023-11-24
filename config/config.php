<?php
define('DB_HOST',               	'localhost');           // IP do Host ou localhost
define('DB_USER',               	'ragnarok');            // Usuário do Banco de dados
define('DB_PASSWORD',           	'ragnarok3229');		// Senha do Banco de dados
define('DB_NAME',               	'ragnarok');			// Nome do Banco de dados
	
define('SITE_TITLE',            	'Flex CP');				// Título do Site
define('SITE_URL',              	'https://lseyvwh2.srv-108-181-92-76.webserverhost.top'); // Url do site
	
// Webhooks do Discord	
define('DISCORD_WEBHOOK_URL',   	'https://discord.com/api/webhooks/SEU_WEBHOOK_ID/SEU_TOKEN');
define('ENVIO_DISCORD_ATIVADO', 	false);					// Defina como true para ativar ou false para desativar
															// o envio de Mensagem de nova conta no Servidor do Discord.
// Configuração do hCaptcha	
define('DATA_SITEKEY',          	'd599cdb7-dc4c-43da-b266-bcf11ff1a5c2');	// Site Key gerado no hCaptcha
define('SECRET_KEY',            	'ES_35106de31fe04cd59b71adec1ddfc139');		// Chave secreta gerada no site hCaptcha
	
// Configurações de e-mail para 	recuperação de senha
define('SMTP_HOST',             	'sandbox.smtp.mailtrap.io');
define('SMTP_USERNAME',         	'10027ae8e3d6b0');
define('SMTP_PASSWORD',         	'9a0bd86ebfb996');
define('SMTP_SECURE',           	'tls');
define('SMTP_PORT',             	465);
	
// Informações do remetente do e	-mail de recuperação de senha
define('EMAIL_FROM',            	'noreply@mundorag.com.br');
define('SENDER_NAME',           	'MeuRO');
?>