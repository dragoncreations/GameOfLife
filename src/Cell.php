<?php

declare(strict_types = 1);

namespace GameOfLife;

/**
 * Grid cell
 *
 * @author Darek Dawidowicz
 */
class Cell implements \JsonSerializable {

    /**
     * Cell is dead
     */
    const STATUS_DEAD = 0;

    /**
     * Cell is alive
     */
    const STATUS_ALIVE = 1;

    /**
     * Cell x coordinate
     *
     * @var int
     */
    private $posX;

    /**
     * Cell y coordinate
     *
     * @var int
     */
    private $posY;

    /**
     * Cell status 
     *
     * @var int
     */
    private $status;

    /**
     * 
     * @param int $x
     * @param int $y
     * @param int $status
     */
    public function __construct(int $x, int $y, int $status = self::STATUS_DEAD) {
        $this->posX = $x;
        $this->posY = $y;
        $this->status = $status;
    }

    /**
     * Get x coordinate
     * 
     * @return int
     */
    public function getPosX() {
        return $this->posX;
    }

    /**
     * Get y coordinate
     * 
     * @return int
     */
    public function getPosY() {
        return $this->posY;
    }

    /**
     * Get cell status
     * 
     * @return int
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set cell status
     * 
     * @param int $status
     */
    public function setStatus(int $status) {
        $this->status = $status;
    }

    /**
     * 
     */
    public function jsonSerialize() {
        return
                [
                    'posX' => $this->getPosX(),
                    'posY' => $this->getPosY(),
                    'status'=> $this->getStatus()
        ];
    }

}
