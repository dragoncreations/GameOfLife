<?php

declare(strict_types = 1);

namespace GameOfLife;

use GameOfLife\Grid;
use GameOfLife\Cell;
use GameOfLife\File;

/**
 * Controller used for instantiating a new game
 *
 * @author Darek Dawidowicz
 */
class Game {

    /**
     * File stores state of game
     *
     * @var File
     */
    private $file;

    /**
     * Game grid
     *
     * @var Grid 
     */
    private $grid;

    /**
     * 
     * @param File $file
     * @param Grid $grid
     */
    public function __construct(File &$file, Grid &$grid = NULL) {
        $this->file = $file;

        if (!is_null($grid)) {
            $this->grid = $grid;
        } else {
            $this->grid = $this->file->loadGrid();
        }
    }

    /**
     * Seed action
     * 
     * @param string $template
     */
    public function seed(string $template) {
        $this->setTemplate(json_decode($template));
        $this->file->saveGrid($this->grid);
    }

    /**
     * Set template on game grid
     * 
     * @param array $template
     */
    private function setTemplate(array $template) {
        $centerX = (int) floor(floor($this->grid->getWidth() / 2) / 2);
        $centerY = (int) floor(floor($this->grid->getHeight() / 2) / 2);

        if (is_array($template) && !empty($template)) {
            $posY = $centerY;
            foreach ($template as $row) {
                if (is_array($row) && !empty($row)) {
                    $posX = $centerX;
                    foreach ($row as $status) {
                        $this->grid->getCell($posX, $posY)->setStatus($status);
                        $posX++;
                    }
                }
                $posY++;
            }
        }
    }

    /**
     * Tick action
     */
    public function tick() {
        $this->nextStep();
        $this->file->saveGrid($this->grid);
    }

    /**
     * Next step of game
     */
    private function nextStep() {
        for ($posY = 0; $posY < $this->grid->getHeight(); $posY++) {
            for ($posX = 0; $posX < $this->grid->getWidth(); $posX++) {
                $this->checkStatus($this->grid->getCell($posX, $posY));
            }
        }

        $this->changeStatus();
    }

    /**
     * Checks and, if necessary, changes the status of the cell
     * 
     * @param Cell $cell
     */
    private function checkStatus(Cell &$cell) {
        $neighbors = $this->getNumberOfAliveNeighbors($cell);

        if ($cell->getStatus() && ($neighbors < 2 || $neighbors > 3)) {
            $this->grid->addToKill($cell);
        }

        if (!$cell->getStatus() && $neighbors === 3) {
            $this->grid->addToBorn($cell);
        }
    }

    /**
     * Change cells status
     */
    private function changeStatus() {
        $toKill = $this->grid->getToKill();

        if (is_array($toKill) && !empty($toKill)) {
            foreach ($toKill as $cell) {
                $cell->setStatus(Cell::STATUS_DEAD);
            }
        }

        $toBorn = $this->grid->getToBorn();

        if (is_array($toBorn) && !empty($toBorn)) {
            foreach ($toBorn as $cell) {
                $cell->setStatus(Cell::STATUS_ALIVE);
            }
        }
    }

    /**
     * Gets number of living neighbors for a cell
     * 
     * @param Cell $cell
     * 
     * @return int Number of alive neighbors for cell.
     */
    private function getNumberOfAliveNeighbors(Cell &$cell) {
        $alive = 0;

        for ($y = $cell->getPosY() - 1; $y <= $cell->getPosY() + 1; $y++) {
            for ($x = $cell->getPosX() - 1; $x <= $cell->getPosX() + 1; $x++) {
                if (
                        $this->isValidCoordinates($x, $y) &&
                        $this->grid->getCell($x, $y)->getStatus() &&
                        ($x != $cell->getPosX() || $y != $cell->getPosY())
                ) {
                    $alive += 1;
                }
            }
        }

        return $alive;
    }

    /**
     * Checks whether the coordinates are correct
     * 
     * @param int $x
     * @param int $y
     * 
     * @return boolean
     */
    private function isValidCoordinates(int $x, int $y) {
        return (
                $x >= 0 &&
                $y >= 0 &&
                $x < $this->grid->getWidth() &&
                $y < $this->grid->getHeight()
                );
    }

    /**
     * Return rendered game grid
     * 
     * @return string Rendered grid
     */
    public function renderGrid() {
        $cells = $this->grid->getCells();

        if (is_array($cells) && !empty($cells)) {
            foreach ($cells as $i => $row) {
                if (is_array($row) && !empty($row)) {
                    foreach ($row as $j => $cell) {
                        switch ($cell->getStatus()) {
                            case Cell::STATUS_ALIVE:
                                $value = "O";
                                break;
                            default :
                                $value = " ";
                        }
                        $cells[$i][$j] = $value;
                    }
                    $cells[$i] = implode(' ', $cells[$i]);
                }
            }
        }

        return implode("\n", $cells);
    }

}
