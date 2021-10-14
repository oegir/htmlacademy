<?php

namespace TaskForce\processing;

use TaskForce\exception\FileFormatException;
use TaskForce\exception\SourceFileException;

/**
 * Класс для импорта данных из таблицы в формате CSV
 */
class CsvDataImporter
{
    private $fileName;
    private $columnsList;
    private $fileObject;

    private $result = [];
    private $error = null;

    /**
     * Импорт данных из файлов в формате CSV
     * @param $fileName имя файла
     * @param $columnsList перечень столбцов данных
     */
    public function import(string $fileName, array $columnsList): void
    {
        $this->fileName = $fileName;
        $this->columnsList = $columnsList;
        $this->result = [];
        if (!$this->validateColumns()) {
            throw new FileFormatException(
                "CsvDataImporter::import: Заданы неверные заголовки столбцов :" .
                $columnsList
            );
        }

        if (!file_exists($this->fileName)) {
            throw new SourceFileException(
                "CsvDataImporter::import: Файл не существует: " .
                $this->fileName
            );
        }

        try {
            $this->fileObject = new \SplFileObject($this->fileName);
        } catch (\RuntimeException $exception) {
            throw new SourceFileException(
                "CsvDataImporter::import: Не удалось открыть файл на чтение: " .
                $this->fileName
            );
        }

        $header_data = $this->getHeaderData();

        if (count($header_data) !== count($this->columnsList)) {
            throw new FileFormatException(
                "CsvDataImporter::import: Количество столбцов не совпадает: " .
                $this->fileName
            );
        }

        $map = array_map(function ($header, $column) {
            return strstr($header, $column) !== false;
        }, $header_data, $this->columnsList);
        $res = array_reduce($map, function ($out, $value) {
            $out &= $value;
            return $out;
        }, true);
        if (!$res) {
            throw new FileFormatException(
                "CsvDataImporter::import: нет необходимых столбцов: " .
                $this->fileName
            );
        }

        foreach ($this->getNextLine() as $line) {
            if ($line[0] !== null) {
                $this->result[] = $line;
            }
        }
    }

    /**
     * Получаем результат чтения файла
     */
    public function getData(): array
    {
        return $this->result;
    }

    /**
     * Первая строка файла - список имен столбцов данных
     */
    private function getHeaderData(): ?array
    {
        $this->fileObject->rewind();

        $data = $this->fileObject->fgetcsv();

        return $data;
    }

    /**
     * Читаем очередную строку из файла
     */
    private function getNextLine(): ?iterable
    {
        $result = null;

        while (!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }

        return $result;
    }

    /**
     * Проверка: имена столбцов д.б. строковыми константами
     */
    private function validateColumns(): bool
    {
        if (count($this->columnsList) == 0) {
            return false;
        }
        foreach ($this->columnsList as $column) {
            if (!is_string($column)) {
                return false;
            }
        }
        return true;
    }
}
