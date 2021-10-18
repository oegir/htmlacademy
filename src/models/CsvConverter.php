<?php


namespace taskforce\models;

use taskforce\models\exceptions\FileNotExistException;
use taskforce\models\exceptions\CantWriteFileException;

class CsvConverter
{
    private string $filename;
    private string $table_name;

    public function __construct(string $filename, string $table_name)
    {
        if(!file_exists($filename)) {
            throw new FileNotExistException('Файл не существует');
        }

        $this->filename = $filename;
        $this->table_name = $table_name;
    }

    public function createInsertSql(): bool
    {
        $spl_file_object = new \SplFileObject($this->filename);
        $sql = 'INSERT INTO ' . $this->table_name . ' ';

        $i = 0;
        while (!$spl_file_object->eof()) {
            $row = $spl_file_object->fgetcsv();

            if($row[0] === null) {
                $sql = rtrim($sql, ", ");
                $sql .= ';';
                break;
            }

            if($i === 0) {
                $sql .= $this->rowInSqlCreateString($row, false);
                $sql .= ' VALUES ';
            } else {
                $sql .= $this->rowInSqlCreateString($row);
                $sql .= ', ';
            }

            $i++;
        }

        if(file_put_contents($this->filename . '.sql', $sql) === false) {
            throw new CantWriteFileException('Ошибка при создании файла sql');
        }
        return true;
    }

    public function createUpdateSql(int $start_index): bool
    {
        $spl_file_object = new \SplFileObject($this->filename);
        $sql = '';
        $cols = [];
        $i = $start_index;

        while (!$spl_file_object->eof()) {
            $row = $spl_file_object->fgetcsv();

            if($row[0] === null) {
                break;
            }

            if($i === $start_index) {
                foreach($row as $col) {
                    $cols[] = $col;
                }
            } else {
                $sql .= 'UPDATE ' . $this->table_name . ' SET ';
                $sql .= $this->rowInSqlUpdateString($row, $cols);
                $sql .= ' WHERE id=' . $start_index . "; \n";
                $start_index++;
            }

            $i++;
        }

        if(file_put_contents($this->filename . '.sql', $sql) === false) {
            throw new CantWriteFileException('Ошибка при создании файла sql');
        }
        return true;
    }

    private function rowInSqlCreateString(array $row, bool $quote = true): string
    {
        $string = '(';
        foreach($row as $col) {
            $val = $col ? $col : 'NULL';
            $string .= $quote && $val !== 'NULL' ? "'" : "";
            $string .= $val;
            $string .= $quote && $val !== 'NULL' ? "'" : "";
            $string .= ', ';
        }
        $string = rtrim($string, ", ");
        $string .= ')';
        return $string;
    }

    private function rowInSqlUpdateString(array $row, array $cols): string
    {
        $string = '';
        for($i = 0; $i < count($cols); $i++) {
            $val = $row[$i] ? "'".$row[$i]."'" : 'NULL';
            $string .= $cols[$i] . "=" . $val . ", ";
        }
        $string = rtrim($string, ', ');
        return $string;
    }
}