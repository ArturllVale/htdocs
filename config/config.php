<?php
define('DB_HOST', 'localhost');             // IP do Host ou localhost
define('DB_USER', 'ragnarok');              // Usuário do Banco de dados
define('DB_PASSWORD', 'ragnarok3229');          // Senha do Banco de dados
define('DB_NAME', 'ragnarok');              // Nome do Banco de dados

define('SITE_TITLE', 'Flex CP');            // Título do Site
define('ENVIO_DISCORD_ATIVADO', false);     // Defina como true para ativar ou false para desativar
                                            // o envio de Mensagem de nova conta no Servidor do Discord.
define('DISCORD_WEBHOOK_URL', 'https://discord.com/api/webhooks/SEU_WEBHOOK_ID/SEU_TOKEN');

// Configurações de e-mail
define('SMTP_HOST', 'smtp.seudominio.com');
define('SMTP_USERNAME', 'seu_email@seudominio.com');
define('SMTP_PASSWORD', 'sua_senha');
define('SMTP_SECURE', 'tls');
define('SMTP_PORT', 587);

// Informações do remetente
define('EMAIL_FROM', 'seu_email@seudominio.com');
define('SENDER_NAME', 'Seu Nome');
?>