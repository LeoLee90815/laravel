<?php

namespace Reliese\Configuration;

use Reliese\Configuration\Sections\DatabaseAnalyserConfiguration;
use Reliese\Configuration\Sections\DatabaseBlueprintConfiguration;
use Reliese\Configuration\Sections\DataAccessGeneratorConfiguration;
use Reliese\Configuration\Sections\DataTransportCollectionGeneratorConfiguration;
use Reliese\Configuration\Sections\DataTransportObjectGeneratorConfiguration;
use Reliese\Configuration\Sections\ModelDataMapGeneratorConfiguration;
use Reliese\Configuration\Sections\ModelGeneratorConfiguration;
use Reliese\Configuration\Sections\ValidatorGeneratorConfiguration;
use Reliese\Configuration\Sections\CodeFormattingConfiguration;
/**
 * Class ConfigurationProfile
 */
class ConfigurationProfile
{
    private string $name;

    private CodeFormattingConfiguration $codeFormattingConfiguration;

    private DatabaseBlueprintConfiguration $databaseBlueprintConfiguration;

    private DatabaseAnalyserConfiguration $databaseAnalyserConfiguration;

    private DataAccessGeneratorConfiguration $dataAccessGeneratorConfiguration;

    private DataTransportCollectionGeneratorConfiguration $dataTransportCollectionGeneratorConfiguration;

    private DataTransportObjectGeneratorConfiguration $dataTransportObjectGeneratorConfiguration;

    private ModelDataMapGeneratorConfiguration $modelDataMapGeneratorConfiguration;

    private ModelGeneratorConfiguration $modelGeneratorConfiguration;

    private ValidatorGeneratorConfiguration $validatorGeneratorConfiguration;

    public function __construct(
        string $name,
        array $configuration
    ) {
        $this->setName($name)
            ->parseConfiguration($configuration);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return ConfigurationProfile
     */
    public function setName(string $name): ConfigurationProfile
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return CodeFormattingConfiguration
     */
    public function getCodeFormattingConfiguration(): CodeFormattingConfiguration
    {
        return $this->codeFormattingConfiguration;
    }

    /**
     * @param CodeFormattingConfiguration $codeFormattingConfiguration
     *
     * @return ConfigurationProfile
     */
    public function setCodeFormattingConfiguration(CodeFormattingConfiguration $codeFormattingConfiguration): ConfigurationProfile
    {
        $this->codeFormattingConfiguration = $codeFormattingConfiguration;
        return $this;
    }

    /**
     * @return DatabaseBlueprintConfiguration
     */
    public function getDatabaseBlueprintConfiguration(): DatabaseBlueprintConfiguration
    {
        return $this->databaseBlueprintConfiguration;
    }

    /**
     * @param DatabaseBlueprintConfiguration $databaseBlueprintConfiguration
     *
     * @return ConfigurationProfile
     */
    public function setDatabaseBlueprintConfiguration(DatabaseBlueprintConfiguration $databaseBlueprintConfiguration): ConfigurationProfile
    {
        $this->databaseBlueprintConfiguration = $databaseBlueprintConfiguration;
        return $this;
    }

    /**
     * @return DatabaseAnalyserConfiguration
     */
    public function getDatabaseAnalyserConfiguration(): DatabaseAnalyserConfiguration
    {
        return $this->databaseAnalyserConfiguration;
    }

    /**
     * @param DatabaseAnalyserConfiguration $databaseAnalyserConfiguration
     *
     * @return ConfigurationProfile
     */
    public function setDatabaseAnalyserConfiguration(DatabaseAnalyserConfiguration $databaseAnalyserConfiguration): ConfigurationProfile
    {
        $this->databaseAnalyserConfiguration = $databaseAnalyserConfiguration;
        return $this;
    }

    /**
     * @return DataAccessGeneratorConfiguration
     */
    public function getDataAccessGeneratorConfiguration(): DataAccessGeneratorConfiguration
    {
        return $this->dataAccessGeneratorConfiguration;
    }

    /**
     * @param DataAccessGeneratorConfiguration $dataAccessGeneratorConfiguration
     *
     * @return ConfigurationProfile
     */
    public function setDataAccessGeneratorConfiguration(DataAccessGeneratorConfiguration $dataAccessGeneratorConfiguration): ConfigurationProfile
    {
        $this->dataAccessGeneratorConfiguration = $dataAccessGeneratorConfiguration;
        return $this;
    }

    /**
     * @return DataTransportCollectionGeneratorConfiguration
     */
    public function getDataTransportCollectionGeneratorConfiguration(): DataTransportCollectionGeneratorConfiguration
    {
        return $this->dataTransportCollectionGeneratorConfiguration;
    }

    /**
     * @param DataTransportCollectionGeneratorConfiguration $dataTransportCollectionGeneratorConfiguration
     *
     * @return ConfigurationProfile
     */
    public function setDataTransportCollectionGeneratorConfiguration(DataTransportCollectionGeneratorConfiguration $dataTransportCollectionGeneratorConfiguration): ConfigurationProfile
    {
        $this->dataTransportCollectionGeneratorConfiguration = $dataTransportCollectionGeneratorConfiguration;
        return $this;
    }

    /**
     * @return DataTransportObjectGeneratorConfiguration
     */
    public function getDataTransportObjectGeneratorConfiguration(): DataTransportObjectGeneratorConfiguration
    {
        return $this->dataTransportObjectGeneratorConfiguration;
    }

    /**
     * @param DataTransportObjectGeneratorConfiguration $dataTransportObjectGeneratorConfiguration
     *
     * @return ConfigurationProfile
     */
    public function setDataTransportObjectGeneratorConfiguration(DataTransportObjectGeneratorConfiguration $dataTransportObjectGeneratorConfiguration): ConfigurationProfile
    {
        $this->dataTransportObjectGeneratorConfiguration = $dataTransportObjectGeneratorConfiguration;
        return $this;
    }

    /**
     * @return ModelDataMapGeneratorConfiguration
     */
    public function getModelDataMapGeneratorConfiguration(): ModelDataMapGeneratorConfiguration
    {
        return $this->modelDataMapGeneratorConfiguration;
    }

    /**
     * @param ModelDataMapGeneratorConfiguration $modelDataMapGeneratorConfiguration
     *
     * @return ConfigurationProfile
     */
    public function setModelDataMapGeneratorConfiguration(ModelDataMapGeneratorConfiguration $modelDataMapGeneratorConfiguration): ConfigurationProfile
    {
        $this->modelDataMapGeneratorConfiguration = $modelDataMapGeneratorConfiguration;
        return $this;
    }

    /**
     * @return ModelGeneratorConfiguration
     */
    public function getModelGeneratorConfiguration(): ModelGeneratorConfiguration
    {
        return $this->modelGeneratorConfiguration;
    }

    /**
     * @param ModelGeneratorConfiguration $modelGeneratorConfiguration
     *
     * @return ConfigurationProfile
     */
    public function setModelGeneratorConfiguration(ModelGeneratorConfiguration $modelGeneratorConfiguration): ConfigurationProfile
    {
        $this->modelGeneratorConfiguration = $modelGeneratorConfiguration;
        return $this;
    }

    /**
     * @return ValidatorGeneratorConfiguration
     */
    public function getValidatorGeneratorConfiguration(): ValidatorGeneratorConfiguration
    {
        return $this->validatorGeneratorConfiguration;
    }

    /**
     * @param ValidatorGeneratorConfiguration $validatorGeneratorConfiguration
     *
     * @return ConfigurationProfile
     */
    public function setValidatorGeneratorConfiguration(ValidatorGeneratorConfiguration $validatorGeneratorConfiguration): ConfigurationProfile
    {
        $this->validatorGeneratorConfiguration = $validatorGeneratorConfiguration;
        return $this;
    }

    /**
     * @param array $configuration
     *
     * @return $this
     */
    public function parseConfiguration(array $configuration): static
    {
        return $this
            ->setCodeFormattingConfiguration(
                new CodeFormattingConfiguration($configuration(CodeFormattingConfiguration::class)))
            ->setDatabaseBlueprintConfiguration(
                new DatabaseBlueprintConfiguration($configuration(DatabaseBlueprintConfiguration::class)))
            ->setDatabaseAnalyserConfiguration(
                new DatabaseAnalyserConfiguration($configuration(DatabaseAnalyserConfiguration::class)))
            ->setDataAccessGeneratorConfiguration(
                new DataAccessGeneratorConfiguration($configuration(DataAccessGeneratorConfiguration::class)))
            ->setDataTransportCollectionGeneratorConfiguration(
                new DataTransportCollectionGeneratorConfiguration($configuration(DataTransportCollectionGeneratorConfiguration::class)))
            ->setDataTransportObjectGeneratorConfiguration(
                new DataTransportObjectGeneratorConfiguration($configuration(DataTransportObjectGeneratorConfiguration::class)))
            ->setModelDataMapGeneratorConfiguration(
                new ModelDataMapGeneratorConfiguration($configuration(ModelDataMapGeneratorConfiguration::class)))
            ->setModelGeneratorConfiguration(
                new ModelGeneratorConfiguration($configuration(ModelGeneratorConfiguration::class)))
            ->setValidatorGeneratorConfiguration(
                new ValidatorGeneratorConfiguration($configuration(ValidatorGeneratorConfiguration::class)))
        ;
    }
}