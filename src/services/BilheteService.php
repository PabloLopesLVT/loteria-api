<?php

namespace App\Services;

require_once __DIR__ . '/../models/Bilhete.php';

use App\Models\Bilhete;

class BilheteService
{
    public function gerarBilhetes(int $qtdeBilhetes, int $qtdeDezenas): array
    {
        // Valida os parâmetros antes de gerar os bilhetes
        try {
            $this->validarParametros($qtdeBilhetes, $qtdeDezenas);
        } catch (\InvalidArgumentException $e) {
            return ["error" => $e->getMessage()];
        }

        $bilhetes = [];

        for ($i = 0; $i < $qtdeBilhetes; $i++) {
            $bilhetes[] = [
                "id" => $i + 1,
                "numeros" => $this->gerarNumerosAleatorios($qtdeDezenas)
            ];
        }

        return ["bilhetes" => $bilhetes];
    }

    public function salvarBilhetes(array $bilhetes): void
    {
        foreach ($bilhetes as $bilhete) {
            Bilhete::create([
                'numeros' => json_encode($bilhete['numeros'])
            ]);
        }
    }

    private function validarParametros(int $qtdeBilhetes, int $qtdeDezenas): void
    {
        if ($qtdeBilhetes < 1 || $qtdeBilhetes > 50) {
            throw new \InvalidArgumentException("A quantidade de bilhetes deve ser entre 1 e 50.");
        }

        if ($qtdeDezenas < 6 || $qtdeDezenas > 10) {
            throw new \InvalidArgumentException("A quantidade de dezenas deve ser entre 6 e 10.");
        }
    }

    private function gerarNumerosAleatorios(int $qtdeDezenas): array
    {
        $numeros = range(1, 60);
        shuffle($numeros);
    
        $response = array_slice($numeros, 0, $qtdeDezenas);   
        sort($response);     
        return $response;
    }

    public function gerarBilhetePremiado(): array
    {
        $bilhetePremiado = Bilhete::where('premiado', true)->where('status', true)->first();

        if ($bilhetePremiado) {
            $bilhetePremiado->update([
                'status' => false
            ]);
        }

        $bilhetePremiado = [
            "numeros" => $this->gerarNumerosAleatorios(6)
        ];

        Bilhete::create([
            'numeros' => json_encode($bilhetePremiado['numeros']),
            'premiado' => true,
            'status' => true
        ]);

        return ["bilhete_premiado" => $bilhetePremiado];
    }

    public function listarBilhetes(): string
    {
        $bilhetes = Bilhete::all()->where('premiado', false);

        $bilhetePremiado = Bilhete::where('premiado', true)->where('status', true)->first();

        if ($bilhetes->isEmpty()) {
            return ["error" => "Nenhum bilhete encontrado."];
        }

        $numerosPremiados = $bilhetePremiado ? json_decode($bilhetePremiado->numeros, true) : [];

        return $this->gerarTabelaHTML($bilhetes, $numerosPremiados);
    }

    private function gerarTabelaHTML($bilhetes, $numerosPremiados)
    {
        $html = '<h1>Bilhetes</h1><p>Números sorteados: ' . implode(', ', $numerosPremiados) . '</p>
        <table border="1" cellspacing="0" cellpadding="10">';
        $html .= '<tr><th>ID</th><th>Números</th></tr>';

        foreach ($bilhetes as $bilhete) {
            $numeros = json_decode($bilhete->numeros, true);
            $numerosDestacados = array_map(function ($num) use ($numerosPremiados) {
                return in_array($num, $numerosPremiados) ? "<strong>$num</strong>" : $num;
            }, $numeros);

            $html .= "<tr>";
            $html .= "<td>{$bilhete->id}</td>";
            $html .= "<td>" . implode(', ', $numerosDestacados) . "</td>";
            $html .= "</tr>";
        }

        $html .= '</table>';
        return $html;
    }    
}
