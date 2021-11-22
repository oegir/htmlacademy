<?php


namespace taskforce\models;

use taskforce\models\exceptions\FileNotExistException;
use taskforce\models\exceptions\CantWriteFileException;

require_once 'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

$output_file_name = 'data/data';

$converter = new CsvConverter('data/categories.csv', 'category', $output_file_name, true);

$converter->createInsertSql();

$converter = new CsvConverter('data/cities.csv', 'city', $output_file_name, false);
$converter->createInsertSql();

$converter = new CsvConverter('data/tasks.csv', 'task', $output_file_name, false);
$converter->createInsertSql();

$converter = new CsvConverter('data/profiles.csv', 'user', $output_file_name, false);
$converter->createInsertSql();

$converter = new CsvConverter('data/users.csv', 'user', $output_file_name, false);
$converter->createUpdateSql(1);

$converter = new CsvConverter('data/opinions.csv', 'review', $output_file_name, false);
$converter->createInsertSql();

$converter = new CsvConverter('data/replies.csv', 'response', $output_file_name, false);
$converter->createInsertSql();

$converter = new CsvConverter('data/user-category.csv', 'user_category', $output_file_name, false);
$converter->createInsertSql();

class CsvConverter
{
    private string $filename;
    private string $table_name;
    private string $output_filename;
    private int $flag;

    public function __construct(string $filename, string $table_name, string $output_filename = null, bool $overwrite = true)
    {
        if(!file_exists($filename)) {
            throw new FileNotExistException('Файл не существует');
        }

        $this->output_filename = is_null($output_filename) ? $filename : $output_filename;
        $this->flag = $overwrite ? 0 : FILE_APPEND;

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
                $sql .= ',' . PHP_EOL;
            }

            $i++;
        }

        $sql = rtrim($sql, "," . PHP_EOL);
        $sql .= ';';

        $sql .= PHP_EOL . PHP_EOL;

        if(file_put_contents($this->output_filename . '.sql', $sql, $this->flag) === false) {
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
                $sql .= ' WHERE id=' . $start_index . ";" . PHP_EOL;
                $start_index++;
            }

            $i++;
        }

        $sql .= PHP_EOL . PHP_EOL;

        if(file_put_contents($this->output_filename . '.sql', $sql, $this->flag) === false) {
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
