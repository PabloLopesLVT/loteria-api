<?php

namespace App\Controllers;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../services/BilheteService.php';
require_once __DIR__ . '/../models/Bilhete.php';

use App\Models\Bilhete;
use App\Services\BilheteService;

class BilheteController
{

    private $bilheteService;

    public function __construct(BilheteService $bilheteService = null)
    {
        $this->bilheteService = $bilheteService ?? new BilheteService();
    }

    private function jsonResponse(int $statusCode, array $data)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }

    public function gerarBilhetes()
    {

        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input || !isset($input['qtdeBilhetes'], $input['qtdeDezenas'])) {
            return $this->jsonResponse(400, ["error" => ["Parâmetros inválidos.", "Informe a quantidade de bilhetes e a quantidade de dezenas por bilhete."]]);
        }

        $qtdeBilhetes = (int) $input['qtdeBilhetes'];
        $qtdeDezenas = (int) $input['qtdeDezenas'];

        $bilhetes = $this->bilheteService->gerarBilhetes($qtdeBilhetes, $qtdeDezenas);

        if (isset($bilhetes['error'])) {
            return $this->jsonResponse(400, $bilhetes);
        }

        $response = $this->bilheteService->salvarBilhetes($bilhetes['bilhetes']);

        if (isset($response['error'])) {
            return $this->jsonResponse(500, $response);
        }

        return $this->jsonResponse(201, ["message" => "Bilhetes gerados e salvos com sucesso!", "bilhetes" => $bilhetes]);
    }

    public function gerarBilhetePremiado()
    {

        $response = $this->bilheteService->gerarBilhetePremiado();

        if (isset($response['error'])) {
            return $this->jsonResponse(500, $response);
        }

        return $this->jsonResponse(201, ["message" => "Bilhete premiado gerado com sucesso!", "bilhete" => $response]);
    }

    public function listarBilhetes()
    {
        try {
            $html = $this->bilheteService->listarBilhetes();

            // Verifica se retornou um erro tratado
            if (strpos($html, "Nenhum bilhete encontrado") !== false) {
                return $this->jsonResponse(404, ["error" => "Nenhum bilhete encontrado."]);
            }

            return $html;
        } catch (Exception $e) {
            return $this->jsonResponse(500, ["error" => "Erro interno no servidor", "message" => $e->getMessage()]);
        }
    }
}
