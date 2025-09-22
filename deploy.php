<?php
$secret = '@WowE_(Cj7';
//$log_file = '/var/www/u3265633/data/www/10domov.ru/deploy-webhook.log';
$github_signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
//file_put_contents($log_file, "GitHub Signature: " . $github_signature . "\n", FILE_APPEND);

// Получаем данные от GitHub
$payload = file_get_contents('php://input');
if (!verifyGitHubSignature($payload, $github_signature, $secret)) {
    //file_put_contents($log_file, "❌ Signature verification failed\n", FILE_APPEND);
    http_response_code(403);
    exit('Forbidden');
}
$data = json_decode($payload, true);
//file_put_contents($log_file, date('Y-m-d H:i:s') . print_r($payload, true) . "\n", FILE_APPEND);

// Обрабатываем только пуши в master и мердж-реквесты
if ($_SERVER['HTTP_X_GITHUB_EVENT'] === 'pull_request') {
    $action = $data['action'];
    $merged = $data['pull_request']['merged'];
    $base_branch = $data['pull_request']['base']['ref'];
    
    if ($action === 'closed' && $merged && $base_branch === 'master') {
        shell_exec('/var/www/u3265633/data/opt/scripts/deploy.sh > /dev/null 2>&1 &');
        echo "Deploy started after merge to master";
    }
}

function verifyGitHubSignature($payload, $github_signature, $secret) {
    if (empty($github_signature)) {
        return false;
    }
    $expected_signature = 'sha256=' . hash_hmac('sha256', $payload, $secret);

    return hash_equals($expected_signature, $github_signature);
}
?>