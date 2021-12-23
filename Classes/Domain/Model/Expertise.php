<?php
namespace Slub\MahuPartners\Domain\Model;

/***
 *
 * This file is part of the "MaHu Frontend" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Carsten Radeck <carsten.radeck@slub-dresden.de>, SLUB Dresden
 *
 ***/

/**
 * Expertise
 */
class Expertise extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * type
     * 
     * @var int
     */
    protected $type = 0;

    /**
     * name
     * 
     * @var string
     */
    protected $name = '';

    /**
     * description
     * 
     * @var string
     */
    protected $description = '';

    /**
     * purpose
     * 
     * @var string
     */
    protected $purpose = '';

    /**
     * quantities
     * 
     * @var string
     */
    protected $quantities = '';

    /**
     * customization
     * 
     * @var bool
     */
    protected $customization = false;

    /**
     * materialClasses
     * 
     * @var string
     */
    protected $materialClasses = 0;

    /**
     * regulations
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\MahuPartners\Domain\Model\Regulation>
     */
    protected $regulations = null;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     * 
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->regulations = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the type
     * 
     * @return int $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     * 
     * @param int $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Returns the name
     * 
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     * 
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the description
     * 
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     * 
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the purpose
     * 
     * @return string $purpose
     */
    public function getPurpose()
    {
        return $this->purpose;
    }

    /**
     * Sets the purpose
     * 
     * @param string $purpose
     * @return void
     */
    public function setPurpose($purpose)
    {
        $this->purpose = $purpose;
    }

    /**
     * Returns the quantities
     * 
     * @return string $quantities
     */
    public function getQuantities()
    {
        return $this->quantities;
    }

    /**
     * Sets the quantities
     * 
     * @param string $quantities
     * @return void
     */
    public function setQuantities($quantities)
    {
        $this->quantities = $quantities;
    }

    /**
     * Returns the customization
     * 
     * @return bool $customization
     */
    public function getCustomization()
    {
        return $this->customization;
    }

    /**
     * Sets the customization
     * 
     * @param bool $customization
     * @return void
     */
    public function setCustomization($customization)
    {
        $this->customization = $customization;
    }

    /**
     * Returns the boolean state of customization
     * 
     * @return bool
     */
    public function isCustomization()
    {
        return $this->customization;
    }

    /**
     * Adds a Regulation
     * 
     * @param \Slub\MahuPartners\Domain\Model\Regulation $regulation
     * @return void
     */
    public function addRegulation(\Slub\MahuPartners\Domain\Model\Regulation $regulation)
    {
        $this->regulations->attach($regulation);
    }

    /**
     * Removes a Regulation
     * 
     * @param \Slub\MahuPartners\Domain\Model\Regulation $regulationToRemove The Regulation to be removed
     * @return void
     */
    public function removeRegulation(\Slub\MahuPartners\Domain\Model\Regulation $regulationToRemove)
    {
        $this->regulations->detach($regulationToRemove);
    }

    /**
     * Returns the regulations
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\MahuPartners\Domain\Model\Regulation> $regulations
     */
    public function getRegulations()
    {
        return $this->regulations;
    }

    /**
     * Sets the regulations
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\MahuPartners\Domain\Model\Regulation> $regulations
     * @return void
     */
    public function setRegulations(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $regulations)
    {
        $this->regulations = $regulations;
    }

    /**
     * Returns the materialClasses
     * 
     * @return string materialClasses
     */
    public function getMaterialClasses()
    {
        return $this->materialClasses;
    }

    /**
     * Sets the materialClasses
     * 
     * @param int $materialClasses
     * @return void
     */
    public function setMaterialClasses($materialClasses)
    {
        $this->materialClasses = $materialClasses;
    }
}
