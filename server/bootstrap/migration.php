<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Connect;

try {
    $sqlFilePath = __DIR__ . '/database.sql';

    $allowedExtensions = ['sql'];
    $pathInfo = pathinfo($sqlFilePath);

    if (!isset($pathInfo['extension']) || !in_array($pathInfo['extension'], $allowedExtensions)) {
        throw new Exception("Arquivo SQL inválido.");
    }

    if (!file_exists($sqlFilePath) || !is_readable($sqlFilePath)) {
        throw new Exception("Arquivo SQL não encontrado ou não acessível.");
    }

    $stmt = Connect::getInstance()->prepare(file_get_contents($sqlFilePath));
    $stmt->execute();

    echo "Script SQL executado com sucesso.\n";
} catch (PDOException $e) {
    echo "Erro ao executar o script SQL: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
