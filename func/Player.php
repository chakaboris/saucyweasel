<?php
class Player {
    protected string $playerName;
    private $playerCurrency;
    private $playerBlessing;
    private $playerLocation;

    public function __construct(string $playerName)
    {
        $this->playerName = $playerName;
    }

    public function GetName()
    {
        return $this->playerName;
    }
}
?>