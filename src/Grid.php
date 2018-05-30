<?php

declare(strict_types = 1);

namespace GameOfLife;

use GameOfLife\Cell;

/**
 * Game grid
 *
 * @author Darek Dawidowicz
 */
class Grid {

    /**
     * Grid width
     * 
     * @var int
     */
    private $width;

    /**
     * Grid height
     * 
     * @var int
     */
    private $height;

    /**
     * Grid cells
     * 
     * @var Cell[]
     */
    private $cells = [];

    /**
     * Cells to kill in next generation
     *
     * @var Cell[]
     */
    private $toKill = [];

    /**
     * Cells to born in next generation
     *
     * @var Cell[]
     */
    private $toBorn = [];

    /**
     * 
     * @param int $width
     * @param int $height
     * @param Cell[] $cells
     */
    public function __construct(int $width, int $height, array $cells = []) {
        $this->width = $width;
        $this->height = $height;
        $this->setCells($cells);
    }

    /**
     * Get grid width
     * 
     * @return int
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * Set grid width
     * 
     * @param int $width
     */
    public function setWidth(int $width) {
        $this->width = $width;
    }

    /**
     * Get grid height
     * 
     * @return int
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * Set grid height
     * 
     * @param int $height
     */
    public function setHeight(int $height) {
        $this->height = $height;
    }

    /**
     * Get cell at given coordinates
     * 
     * @param int $x
     * @param int $y
     * 
     * @return Cell
     */
    public function getCell(int $x, int $y) {
        return $this->cells[$y][$x];
    }

    /**
     * Get cells
     * 
     * @return Cell[]
     */
    public function getCells() {
        return $this->cells;
    }

    /**
     * Set cells
     * 
     * @param Cell[] $cells
     */
    public function setCells(array $cells) {
        if (!empty($cells)) {
            $this->cells = $cells;
        } else {
            for ($x = 0; $x < $this->width; $x++) {
                for ($y = 0; $y < $this->height; $y++) {
                    $this->cells[$y][$x] = new Cell($x, $y);
                }
            }
        }
    }

    /**
     * Add cell to kill in next generation
     * 
     * @param Cell $cell
     */
    public function addToKill(Cell &$cell) {
        $this->toKill[] = $cell;
    }

    /**
     * Get cells to kill in next generation
     * 
     * @return Cell[]
     */
    public function getToKill() {
        return $this->toKill;
    }

    /**
     * Add cell to born in next generation
     * 
     * @param Cell $cell
     */
    public function addToBorn(Cell &$cell) {
        $this->toBorn[] = $cell;
    }

    /**
     * Get cells to born in next generation
     * 
     * @return Cell[]
     */
    public function getToBorn() {
        return $this->toBorn;
    }

}
