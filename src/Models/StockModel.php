<?php

namespace App\Models;

final class StockModel
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $usersId;
    /**
     * @var string
     */
    private $date;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $symbol;
    /**
     * @var string
     */
    private $open;
    /**
     * @var string
     */
    private $high;
    /**
     * @var string
     */
    private $low;
    /**
     * @var string
     */
    private $close;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getUsersId(): int
    {
        return $this->usersId;
    }

    /**
     * @param int $usersId
     * @return self
     */
    public function setUsersId(int $usersId): self
    {
        $this->usersId = $usersId;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     * @return self
     */
    public function setDate(string $date): self
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * @param string $symbol
     * @return self
     */
    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;
        return $this;
    }

    /**
     * @return string
     */
    public function getOpen(): string
    {
        return $this->open;
    }

    /**
     * @param string $open
     * @return self
     */
    public function setOpen(string $open): self
    {
        $this->open = $open;
        return $this;
    }

    /**
     * @return string
     */
    public function getHigh(): string
    {
        return $this->high;
    }

    /**
     * @param string $high
     * @return self
     */
    public function setHigh(string $high): self
    {
        $this->high = $high;
        return $this;
    }

    /**
     * @return string
     */
    public function getLow(): string
    {
        return $this->low;
    }

    /**
     * @param string $low
     * @return self
     */
    public function setLow(string $low): self
    {
        $this->low = $low;
        return $this;
    }

    /**
     * @return string
     */
    public function getClose(): string
    {
        return $this->close;
    }

    /**
     * @param string $close
     * @return self
     */
    public function setClose(string $close): self
    {
        $this->close = $close;
        return $this;
    }
}
