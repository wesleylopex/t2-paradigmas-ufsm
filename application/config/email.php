<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Configurações referente ao envio de e-mail
| from - E-mail que vai enviar os e-mails, tem que ser um email do servidor de hospedagem
| contact - E-mail que receberá os contatos da aba Contato do site
| register - E-mail que receberá o aviso de um novo registro de usuário
| upload - E-mail que receberá o arquivo enviado pelo usuário
|--------------------------------------------------------------------------
|
*/
$config['smtp_host'] = 'email-ssl.com.br';
$config['smtp_port'] = 465;
$config['protocol'] = 'smtp';
$config['smtp_user'] = 'noreply@noreply.com.br';
$config['smtp_pass'] = 'noreply';
$config['smtp_crypto'] = 'ssl';
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
$config['wordwrap'] = TRUE;