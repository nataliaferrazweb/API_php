<?php

namespace App\DAO;

use App\Models\StockModel;

class StocksDAO extends Conection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertStock(StockModel $stock): void
    {
        try {
            $statement = $this->pdo
                ->prepare('INSERT INTO stocks
                (
                    users_id,
                    date,
                    name,
                    symbol,
                    open,
                    high,
                    low,
                    close
                )
                VALUES
                (
                    :users_id,
                    :date,
                    :name,
                    :symbol,
                    :open,
                    :high,
                    :low,
                    :close
                );
            ');
            $statement->execute([
                'users_id' => $stock->getUsersId(),
                'date' => $stock->getDate(),
                'name' => $stock->getName(),
                'symbol' => $stock->getSymbol(),
                'open' => $stock->getOpen(),
                'high' => $stock->getHigh(),
                'low' => $stock->getLow(),
                'close' => $stock->getClose()
            ]);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function getAllStocksByUser(int $limit): array
    {
        try {
            $statement = $this->pdo
                ->prepare('SELECT
                    *
                FROM stocks
                WHERE
                    users_id = :usersId
                ORDER BY id DESC
                LIMIT 0, :limit
            ;');
            $statement->bindParam(':usersId', $_SESSION['userId'], \PDO::PARAM_INT);
            $statement->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $statement->execute();
            $stocks = $statement->fetchAll(\PDO::FETCH_ASSOC);

            return $stocks;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }


}
