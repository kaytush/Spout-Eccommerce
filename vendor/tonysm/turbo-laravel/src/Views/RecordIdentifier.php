<?php

namespace Tonysm\TurboLaravel\Views;

use Illuminate\Database\Eloquent\Model;
use Tonysm\TurboLaravel\Models\Naming\Name;

class RecordIdentifier
{
    const NEW_PREFIX = "create";
    const DELIMITER = "_";

    /** @var Model */
    private $record;

    public function __construct(object $record)
    {
        throw_if(
            ! method_exists($record, 'getKey'),
            UnidentifiableRecordException::missingGetKeyMethod($record),
        );

        $this->record = $record;
    }

    public function domId(?string $prefix = null): string
    {
        if ($recordId = $this->record->getKey()) {
            return sprintf('%s%s%s', $this->domClass($prefix), self::DELIMITER, $recordId);
        }

        return $this->domClass($prefix ?: static::NEW_PREFIX);
    }

    public function domClass(?string $prefix = null): string
    {
        $singular = Name::forModel($this->record)->singular;
        $delimiter = static::DELIMITER;

        return trim("{$prefix}{$delimiter}{$singular}", $delimiter);
    }
}
