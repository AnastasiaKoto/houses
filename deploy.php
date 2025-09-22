<?php
$log_file = '/var/www/u3265633/data/www/deploy-webhook.log';
/*
file_put_contents($log_file, date('Y-m-d H:i:s') . " Test \n", FILE_APPEND);
if ($_POST['secret'] !== $secret) {
    http_response_code(403);
    exit('Forbidden');
}
*/
// Получаем данные от GitHub
$payload = json_decode(file_get_contents('php://input'), true);
file_put_contents($log_file, date('Y-m-d H:i:s') . print_r($payload, true) . "\n", FILE_APPEND);
file_put_contents($log_file, date('Y-m-d H:i:s') . " - Event: " . $_SERVER['HTTP_X_GITHUB_EVENT'] . "\n", FILE_APPEND);

// Обрабатываем только пуши в master и мердж-реквесты
if ($_SERVER['HTTP_X_GITHUB_EVENT'] === 'push') {
    $ref = $payload['ref'];
    $branch = str_replace('refs/heads/', '', $ref);
    
    if ($branch === 'master') {
        shell_exec('/var/www/u3265633/data/opt/scripts/deploy.sh > /dev/null 2>&1 &');
        echo "Deploy started for master branch";
    }
}
elseif ($_SERVER['HTTP_X_GITHUB_EVENT'] === 'pull_request') {
    $action = $payload['action'];
    $merged = $payload['pull_request']['merged'];
    $base_branch = $payload['pull_request']['base']['ref'];
    
    if ($action === 'closed' && $merged && $base_branch === 'master') {
        shell_exec('/var/www/u3265633/data/opt/scripts/deploy.sh > /dev/null 2>&1 &');
        echo "Deploy started after merge to master";
    }
}
?>