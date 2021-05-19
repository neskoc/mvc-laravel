<?php

/**
 * ShowYatzyTable trait.
 */

declare(strict_types=1);

namespace App\Models\Yatzy;

trait ShowYatzyTable
{
    private YatzyTable $yatzyTable;

    public function showYatzyTable(YatzyTable $yatzyTable, YatzyGame $yatzyGame, bool $addRadioButtons = false): string
    {
        $this->yatzyTable = $yatzyTable;
        $anySlotAAE = $yatzyTable->isAnySlotAvailableAllowedAndEnabled();
        $htmlTableBlock = "";
        $htmlTableBlock .= '<table class="table table-bordered">';
        $tableHeader = '<thead>';
        $tableHeader .= "<tr>";
        $tableHeader .= '<th></th>';
        for ($i = 1; $i <= $yatzyTable->nrYazyColumns; $i += 1) {
            $tableHeader .= '<th class="center">' . "{$yatzyGame->yatzyPlayers[$i]->name}</th>";
        }
        if ($addRadioButtons) {
            $tableHeader .= '<th class="center">Val</th>';
        }
        $tableHeader .= "</tr>";
        $tableHeader .= '</thead>';
        $tableBody = "<tbody>";
        for ($i = 0; $i < 6; $i += 1) {
            $tableBody .= $this->addTableRow($i, $anySlotAAE, $addRadioButtons);
        }
        $tableBody .= $this->addRow("SUMMA:", $this->yatzyTable->yatzyColumns, "sum");
        $tableBody .= $this->addRow("BONUS(50)", $this->yatzyTable->yatzyColumns, "bonus");
        for ($i = 6; $i < $yatzyTable::ROWS; $i += 1) {
            $tableBody .= $this->addTableRow($i, $anySlotAAE, $addRadioButtons);
        }
        $tableBody .= $this->addRow("Yatzy(50)", $this->yatzyTable->yatzyColumns, "yatzy");
        $tableBody .= $this->addRow("TOTAL:", $this->yatzyTable->yatzyColumns, "total");
        $tableBody .= "</tbody>";
        $htmlTableBlock .= $tableHeader;
        $htmlTableBlock .= $tableBody;
        $htmlTableBlock .= '</table>';
        return $htmlTableBlock;
    }

    private function addRow(string $rowName, array $handlers, string $value): string
    {
        $tableRow = "<tr>";
        $tableRow .= '<td class="left">' . $rowName . '</td>';
        for ($i = 0; $i < $this->yatzyTable->nrYazyColumns; $i += 1) {
            $tableRow .= '<td class="right">' . $handlers[$i]->$value . '</td>';
        }
        $tableRow .= "</tr>";

        return $tableRow;
    }

    private function addTableRow(int $rowNr, bool $anySlotAAE, bool $addRadioButtons = false): string
    {
        $showRadioButton = false;
        $tableRow = '<tr class="yatzy-row">';
        $tableRow .= '<td class="left">' . "{$this->yatzyTable::ROW_NAMES[$rowNr]}";
        for ($j = 0; $j < $this->yatzyTable->nrYazyColumns; $j += 1) {
            $rowValue = $this->yatzyTable->yatzyColumns[$j]->yatzyColumn[$rowNr] ?? "";
            $tableRow .= '<td class="right">' . "{$rowValue}</td>";
        }
        $slotAAE = $this->yatzyTable->isSlotAvailableAllowedAndEnabled($rowNr);
        $isChanceAavailable = $this->yatzyTable->isChanceAvailableAndEnabled();
        $slotEnabled = $this->yatzyTable->isSlotEnabled($rowNr);
        if ($addRadioButtons) {
            if ($anySlotAAE) { // anySlot excludes chance
                if ($slotAAE && $rowNr != $this->yatzyTable::ROWS - 1) { // exclude chance
                    $showRadioButton = true;
                }
            } elseif ($rowNr === $this->yatzyTable::ROWS - 1 && $isChanceAavailable) {
                $showRadioButton = true;
            } elseif ($slotEnabled && !$isChanceAavailable) {
                $showRadioButton = true;
                $this->yatzyTable->currentColumn->strike = true;
            }
        }
        if ($showRadioButton) {
            $radioButton = '<input class="select input" type="radio" id="' . $rowNr .
            '" name="choice" value="' . $rowNr . '" required>';
            $tableRow .= '<td class="center">' . "{$radioButton}</td>";
        }
        $tableRow .= '</tr>';

        return $tableRow;
    }
}
