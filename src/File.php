<?php

declare(strict_types = 1);

namespace GameOfLife;

use GameOfLife\Grid;
use GameOfLife\Cell;

/**
 * Description of File
 *
 * @author Darek Dawidowicz
 */
class File {

    /**
     * Filename
     *
     * @var string
     */
    private $filename;

    /**
     * 
     * @param string $filename
     */
    public function __construct(string $filename) {
        $this->filename = $filename;
    }

    /**
     * Load game grid from json file
     * 
     * @return Grid
     */
    public function loadGrid() {
        $this->fp = fopen($this->filename, 'r');
        $data = json_decode(fread($this->fp, filesize($this->filename)));
        fclose($this->fp);
        foreach ($data as $i => $row) {
            foreach ($row as $j => $item) {
                $data[$i][$j] = new Cell($item->posX, $item->posY, $item->status);
            }
        }

        return new Grid(count($data[0]), count($data), $data);
    }

    /**
     * Save game grid into json file
     * 
     * @param Grid $grid
     */
    public function saveGrid(Grid $grid) {
        $data = $grid->getCells();
        $this->fp = fopen($this->filename, 'w');
        fwrite($this->fp, json_encode($data));
        fclose($this->fp);
    }

}
