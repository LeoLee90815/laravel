<?php

namespace Reliese\Blueprint;

/**
 * Class ColumnBlueprint
 */
class ColumnBlueprint
{
    /**
     * @var string
     */
    private string $columnName;

    /**
     * @var ColumnOwnerInterface
     */
    private ColumnOwnerInterface $columnOwner;

    /**
     * @var string
     */
    private string $dataType;

    /**
     * @var bool
     */
    private bool $hasDefault;

    /**
     * @var IndexBlueprint[]
     */
    private array $indexReferences = [];

    /**
     * @var bool
     */
    private bool $isAutoincrement;

    /**
     * @var bool
     */
    private bool $isNullable;

    /**
     * @var int
     */
    private int $maximumCharacters;

    /**
     * @var int
     */
    private int $numericPrecision;

    /**
     * @var int
     */
    private int $numericScale;

    /**
     * @var ForeignKeyBlueprint[]
     */
    private array $referencedForeignKeys = [];

    /**
     * @var ForeignKeyBlueprint[]
     */
    private array $referencingForeignKeys;

    /**
     * @var bool
     */
    private ?bool $isUnsigned = null;


    /**
     * ColumnBlueprint constructor.
     *
     * @param ColumnOwnerInterface $columnOwner The Table or View that owns the column
     * @param string $columnName
     * @param string $dataType
     * @param bool $isNullable
     * @param int $maximumCharacters
     * @param int $numericPrecision
     * @param int $numericScale
     * @param bool $isAutoincrement
     * @param bool $hasDefault
     */
    public function __construct(
        ColumnOwnerInterface $columnOwner,
        string $columnName,
        string $dataType,
        bool $isNullable,
        int $maximumCharacters,
        int $numericPrecision,
        int $numericScale,
        bool $isAutoincrement,
        bool $hasDefault
    )
    {
        $this->columnOwner = $columnOwner;
        $this->setColumnName($columnName);
        $this->setDataType($dataType);
        $this->setIsNullable($isNullable);
        $this->setMaximumCharacters($maximumCharacters);
        $this->setNumericPrecision($numericPrecision);
        $this->setNumericScale($numericScale);
        $this->setIsAutoincrement($isAutoincrement);
        $this->setHasDefault($hasDefault);
    }

    /**
     * Factory method to simplify initialization from a Doctrine Column
     *
     * @param ColumnOwnerInterface         $columnOwner
     * @param \Doctrine\DBAL\Schema\Column $columnDefinition
     *
     * @return static
     */
    public static function fromDoctrineColumnDefinition(
        ColumnOwnerInterface $columnOwner,
        \Doctrine\DBAL\Schema\Column $columnDefinition
    ) {
        $isNullable = !$columnDefinition->getNotnull();
        $hasDefault = null === $columnDefinition->getDefault();

        $columnBlueprint = new static(
            $columnOwner,
            $columnDefinition->getName(),
            $columnDefinition->getType()->getName(),
            $isNullable,
            $columnDefinition->getLength() ?? -1,
            $columnDefinition->getPrecision() ?? -1,
            $columnDefinition->getScale() ?? -1,
            $columnDefinition->getAutoincrement(),
            $hasDefault
        );

        $columnBlueprint
            ->setIsUnsigned($columnDefinition->getUnsigned())
        ;


        return $columnBlueprint;
    }

    /**
     * @param IndexBlueprint $indexBlueprint
     *
     * @return $this
     */
    public function addIndexReference(IndexBlueprint $indexBlueprint): static
    {
        $this->indexReferences[$indexBlueprint->getUniqueName()] = $indexBlueprint;
        return $this;
    }

    /**
     * @param ForeignKeyBlueprint $referencedForeignKey
     *
     * @return $this
     */
    public function addReferencedForeignKey(ForeignKeyBlueprint $referencedForeignKey): static
    {
        $this->referencedForeignKeys[$referencedForeignKey->getName()] = $referencedForeignKey;
        return $this;
    }

    /**
     * @param ForeignKeyBlueprint $referencingForeignKey
     *
     * @return $this
     */
    public function addReferencingForeignKey(ForeignKeyBlueprint $referencingForeignKey): static
    {
        $this->referencingForeignKeys[$referencingForeignKey->getName()] = $referencingForeignKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getColumnName(): string
    {
        return $this->columnName;
    }

    /**
     * @return string
     */
    public function getDataType(): string
    {
        return $this->dataType;
    }

    /**
     * @return bool
     */
    public function getHasDefault(): bool
    {
        return $this->hasDefault;
    }

    /**
     * @return IndexBlueprint[]
     */
    public function getIndexReferences(): array
    {
        return $this->indexReferences;
    }

    /**
     * @return bool
     */
    public function getIsAutoincrement(): bool
    {
        return $this->isAutoincrement;
    }

    /**
     * @return bool
     */
    public function getIsNullable(): bool
    {
        return $this->isNullable;
    }

    /**
     * @return int
     */
    public function getMaximumCharacters(): int
    {
        return $this->maximumCharacters;
    }

    /**
     * @return int
     */
    public function getNumericPrecision(): int
    {
        return $this->numericPrecision;
    }

    /**
     * @return int
     */
    public function getNumericScale(): int
    {
        return $this->numericScale;
    }

    /**
     * @return ColumnOwnerInterface
     */
    public function getOwner(): ColumnOwnerInterface
    {
        return $this->columnOwner;
    }

    /**
     * @return ForeignKeyBlueprint[]
     */
    public function getReferencedForeignKeys(): array
    {
        return $this->getReferencedForeignKeys();
    }

    /**
     * @return ForeignKeyBlueprint[]
     */
    public function getReferencingForeignKeys(): array
    {
        return $this->getReferencingForeignKeys();
    }

    /**
     * @return string
     */
    public function getUniqueName(): string
    {
        return sprintf('%s.%s',
            $this->getOwner()->getUniqueName(),
            $this->getColumnName());
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setColumnName(string $value): self
    {
        $this->columnName = $value;
        return $this;
    }

    /**
     * The normalized data type which was derived from the raw data type in the database.
     * For example... 'unsigned bigint' should be 'float'
     *
     * @param string $value
     *
     * @return $this
     */
    public function setDataType(string $value): self
    {
        /**
         * TODO: Validate that $value matches a valid Laravel Model Field data type.
         */

        $this->dataType = $value;
        return $this;
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setHasDefault(bool $value): self
    {
        $this->hasDefault = $value;
        return $this;
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setIsAutoincrement(bool $value): self
    {
        $this->isAutoincrement = $value;
        return $this;
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setIsNullable(bool $value): self
    {
        $this->isNullable = $value;
        return $this;
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setMaximumCharacters(int $value): self
    {
        $this->maximumCharacters = $value;
        return $this;
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setNumericPrecision(int $value): self
    {
        $this->numericPrecision = $value;
        return $this;
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setNumericScale(int $value): self
    {
        $this->numericScale = $value;
        return $this;
    }

    public function isIncludedInUniqueIndex():bool
    {
        $indexReferences = $this->getIndexReferences();
        if (empty($indexReference)) {
            return false;
        }

        foreach ($indexReferences as $indexReference) {
            if ($indexReference->isUnique()) {
                return true;
            }
        }

        return false;
    }

    public function isIncludedInIndex():bool
    {
        return !empty($this->getIndexReferences());
    }

    public function referencesAnotherTable(?string $optionalTableNameFilter = null): bool
    {
        if (empty($this->referencedForeignKeys)) {
            return false;
        }

        if (null === $optionalTableNameFilter) {
            return true;
        }

        foreach ($this->referencedForeignKeys as $referencedForeignKey) {
            if ($optionalTableNameFilter === $referencedForeignKey->getReferencedTableName()) {
                return true;
            }
        }

        return false;
    }

    public function referencedByAnotherTable(?string $optionalTableNameFilter = null): bool
    {
        if (empty($this->referencingForeignKeys)) {
            return false;
        }

        if (null === $optionalTableNameFilter) {
            return true;
        }

        foreach ($this->referencingForeignKeys as $referencingForeignKey) {
            if ($optionalTableNameFilter === $referencingForeignKey->getReferencingObjectName()) {
                return true;
            }
        }

        return false;
    }

    public function hasCharacterLimit()
    {
        return $this->maximumCharacters > -1;
    }

    public function hasIsUnsigned():bool
    {
        return !is_null($this->isUnsigned);
    }

    /**
     * @param bool $isUnsigned
     *
     * @return ColumnBlueprint
     */
    public function setIsUnsigned(bool $isUnsigned): ColumnBlueprint
    {
        $this->isUnsigned = $isUnsigned;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsUnsigned(): bool
    {
        return $this->isUnsigned;
    }

    /**
     * @return ColumnOwnerInterface
     */
    public function getColumnOwner(): ColumnOwnerInterface
    {
        return $this->columnOwner;
    }
}
