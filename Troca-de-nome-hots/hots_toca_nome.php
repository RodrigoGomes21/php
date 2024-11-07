<?php
// Verifica se o script está sendo executado como root
if (posix_getuid() !== 0) {
    die("Você precisa ser root para mudar o nome do host.");
}

// Nome do novo host
$new_host = 'novo-nome-do-host';

// Comando para mudar o nome do host no Linux
$command = "hostnamectl set-hostname $new_host";

// Executa o comando
$output = shell_exec($command);

// Confirma se o nome foi alterado
if ($output === null) {
    echo "Nome do host alterado com sucesso para '$new_host'.";
} else {
    echo "Erro ao alterar o nome do host: $output";
}

// Opcional: Atualiza o arquivo /etc/hosts para refletir a mudança
$hosts_file = '/etc/hosts';
$hosts_content = file_get_contents($hosts_file);
$hosts_content = preg_replace('/127\.0\.1\.1\s+.*$/', "127.0.1.1 $new_host", $hosts_content);

// Salva as alterações no arquivo /etc/hosts
file_put_contents($hosts_file, $hosts_content);

echo "\nO nome do host foi alterado no arquivo /etc/hosts também.";
?>