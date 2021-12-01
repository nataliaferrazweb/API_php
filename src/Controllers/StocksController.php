<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\DAO\StocksDAO;
use App\Models\StockModel;
use Swift_Mailer;
use Swift_Message;

class StocksController extends ValidateController
{
    /**
     * @var Swift_Mailer
     */
    protected $mailer;

    /**
     * @param Swift_Mailer $mailer
     */
    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function requestStock(Request $request, Response $response, array $args): Response
    {

        $queryParams = $request->getQueryParams();

        if (!isset($queryParams['code']) || $this->validateVars($queryParams['code'])) {
            $payload = json_encode([
                'error' => \Exception::class,
                'status' => 400,
                'code' => '003',
                'userMessage' => 'Invalid null argument.']);

            $response->getBody()->write($payload);
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }

        try {
            // require stock
            $stocksApi = file_get_contents("https://stooq.com/q/l/?s=" . $queryParams['code'] . "&f=sd2t2ohlcvn&h&e=csv");
            $lines = explode(PHP_EOL, $stocksApi);

            $arrayValues = str_getcsv($lines[1]);

            $stocks = array(
                'symbol' => $arrayValues[0],
                'datetime' => $arrayValues[1] . ' ' . $arrayValues[2],
                'open' => $arrayValues[3],
                'high' => $arrayValues[4],
                'low' => $arrayValues[5],
                'close' => $arrayValues[6],
                'volume' => $arrayValues[7],
                'name' => $arrayValues[8]
            );

            if ($stocks['open'] == "N/D") {
                $payload = json_encode(['error' => \Exception::class,
                    'status' => 400,
                    'code' => '004',
                    'userMessage' => "Invalid stock code."]);

                $response->getBody()->write($payload);
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(400);
            }

            // save in DB


            $stocksDAO = new StocksDAO();
            $stock = new StockModel();
            $stock->setUsersId($_SESSION['userId'])
                ->setDate($stocks['datetime'])
                ->setName($stocks['name'])
                ->setSymbol($stocks['symbol'])
                ->setOpen($stocks['open'])
                ->setHigh($stocks['high'])
                ->setLow($stocks['low'])
                ->setClose($stocks['close']);

            $stocksDAO->insertStock($stock);

            // send Email

            $message = (new Swift_Message($stocks['name'] . ' stocks from PHP Challenge'))
                ->setFrom(['phpchallenge@jobsity.io' => 'PHP Challenge'])
                ->setTo([$_SESSION['userEmail']])
                ->setBody('<h4>Hello, ' . $_SESSION["userName"] . '!</h4>
                        <p>You request the stocks for <strong>' . $stocks["name"] . '</strong>:</p>
                        <p><strong>Symbol:</strong> ' . $stocks["symbol"] . '</p>
                        <p><strong>Date:</strong> ' . date("d/m/Y H:i:s", strtotime($stocks["datetime"])) . '</p>
                        <p><strong>Open:</strong> ' . $stocks["open"] . '</p>
                        <p><strong>High:</strong> ' . $stocks["high"] . '</p>
                        <p><strong>Low:</strong> ' . $stocks["low"] . '</p>
                        <p><strong>Close:</strong> ' . $stocks["close"] . '</p>', 'text/html')
                ->addPart('Hello, ' . $_SESSION["userName"] . '!
                You request the stocks for ' . $stocks["name"] . ':
                    Symbol: ' . $stocks["symbol"] . '
                    Date: ' . date("d/m/Y H:i:s", strtotime($stocks["datetime"])) . '
                    Open: ' . $stocks["open"] . '
                    High: ' . $stocks["high"] . '
                    Low: ' . $stocks["low"] . '
                    Close: ' . $stocks["close"], 'text/plain');

            // Later just do the actual email sending.
            $this->mailer->send($message);


            // show user

            $payload = json_encode(['message' => 'success',
                'name' => $stocks['name'],
                'symbol' => $stocks['symbol'],
                'date' => date("d/m/Y H:i:s", strtotime($stocks["datetime"])),
                'open' => $stocks['open'],
                'high' => $stocks['high'],
                'low' => $stocks['low'],
                'close' => $stocks['close']]);

            $response->getBody()->write($payload);
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);

        } catch (\InvalidArgumentException $ex) {

            $payload = json_encode(['error' => \InvalidArgumentException::class,
                'status' => 400,
                'code' => '002',
                'userMessage' => "Invalid Argument.",
                'developerMessage' => $ex->getMessage()]);

            $response->getBody()->write($payload);
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);


        } catch (\Exception | \Throwable $ex) {
            $payload = json_encode(['error' => \Exception::class,
                'status' => 500,
                'code' => '001',
                'userMessage' => "Application error.",
                'developerMessage' => $ex->getMessage()]);

            $response->getBody()->write($payload);
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);

        }

    }

    public function getHistory(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();

        $limit = (int)$queryParams['limit'] ?? 10;

        $stocksDAO = new StocksDAO();
        $history = $stocksDAO->getAllStocksByUser($limit);

        $response->getBody()->write(
            json_encode($history)
        );

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
