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
 * Company
 */
class Company extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * name
     * 
     * @var string
     */
    protected $name = '';

    /**
     * www
     * 
     * @var string
     */
    protected $www = '';

    /**
     * logo
     * 
     * @var string
     */
    protected $logo = '';

    /**
     * facet
     * 
     * @var string
     */
    protected $facet = '';

    /**
     * facetValue
     * 
     * @var string
     */
    protected $facetValue = '';

    /**
     * description
     * 
     * @var string
     */
    protected $description = '';
    
    /**
     * disclaimer
     *
     * @var string
     */
    protected $disclaimer = '';

    /**
     * since
     * 
     * @var \DateTime
     */
    protected $since = null;

    /**
     * services
     * 
     * @var string
     */
    protected $services = '';

    /**
     * street
     * 
     * @var string
     */
    protected $street = '';

    /**
     * zip
     * 
     * @var string
     */
    protected $zip = '';

    /**
     * city
     * 
     * @var string
     */
    protected $city = '';

    /**
     * country
     * 
     * @var string
     */
    protected $country = '';

    /**
     * businessArea
     * 
     * @var string
     */
    protected $businessArea = '';

    /**
     * numberOfEmployees
     * 
     * @var int
     */
    protected $numberOfEmployees = 0;

    /**
     * formOfCompany
     * 
     * @var string
     */
    protected $formOfCompany = '';
    
    /**
     * superordinate
     *
     * @var string
     */
    protected $superordinate = '';

    /**
     * superordinate
     *
     * @var string
     */
    protected $editors = '';

    /**
     * contacts
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\MahuPartners\Domain\Model\Contact>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $contacts = null;

    /**
     * expertises
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\MahuPartners\Domain\Model\Expertise>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $expertises = null;

    /**
     * divisions
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\MahuPartners\Domain\Model\Division>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $divisions = null;

    /**
     * id
     * 
     * @var string
     */
    protected $id = '';
    
    /**
     * type
     *
     * @var int
     */
    protected $type = 0;
    
    /**
     * @var boolean
     */
    protected $hidden;
    
    /**
     * ID of the corresponding User record
     *
     * @var int
     */
    protected $userid = 0;

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
     * Returns the logo
     * 
     * @return string $logo
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Sets the logo
     * 
     * @param string $logo
     * @return void
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * Returns the facet
     * 
     * @return string $facet
     */
    public function getFacet()
    {
        return $this->facet;
    }

    /**
     * Sets the facet
     * 
     * @param string $facet
     * @return void
     */
    public function setFacet($facet)
    {
        $this->facet = $facet;
    }

    /**
     * Returns the www
     * 
     * @return string $www
     */
    public function getWww()
    {
        return $this->www;
    }

    /**
     * Sets the www
     * 
     * @param string $www
     * @return void
     */
    public function setWww($www)
    {
        $this->www = $www;
    }

    /**
     * Returns the facetValue
     * 
     * @return string $facetValue
     */
    public function getFacetValue()
    {
        return $this->facetValue;
    }

    /**
     * Sets the facetValue
     * 
     * @param string $facetValue
     * @return void
     */
    public function setFacetValue($facetValue)
    {
        $this->facetValue = $facetValue;
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
     * Returns the disclaimer
     *
     * @return string $disclaimer
     */
    public function getDisclaimer()
    {
        return $this->disclaimer;
    }
    
    /**
     * Sets the disclaimer
     *
     * @param string $disclaimer
     * @return void
     */
    public function setDisclaimer($disclaimer)
    {
        $this->disclaimer = $disclaimer;
    }

    /**
     * Returns the since
     * 
     * @return \DateTime $since
     */
    public function getSince()
    {
        return $this->since;
    }

    /**
     * Sets the since
     * 
     * @param \DateTime $since
     * @return void
     */
    public function setSince(\DateTime $since)
    {
        $this->since = $since;
    }

    /**
     * Returns the services
     * 
     * @return string $services
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Sets the services
     * 
     * @param string $services
     * @return void
     */
    public function setServices($services)
    {
        $this->services = $services;
    }

    /**
     * Returns the street
     * 
     * @return string $street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Sets the street
     * 
     * @param string $street
     * @return void
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Returns the zip
     * 
     * @return string $zip
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Sets the zip
     * 
     * @param string $zip
     * @return void
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * Returns the city
     * 
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the city
     * 
     * @param string $city
     * @return void
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Returns the country
     * 
     * @return string $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets the country
     * 
     * @param string $country
     * @return void
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Returns the businessArea
     * 
     * @return string $businessArea
     */
    public function getBusinessArea()
    {
        return $this->businessArea;
    }

    /**
     * Sets the businessArea
     * 
     * @param string $businessArea
     * @return void
     */
    public function setBusinessArea($businessArea)
    {
        $this->businessArea = $businessArea;
    }

    /**
     * Returns the numberOfEmployees
     * 
     * @return int $numberOfEmployees
     */
    public function getNumberOfEmployees()
    {
        return $this->numberOfEmployees;
    }

    /**
     * Sets the numberOfEmployees
     * 
     * @param int $numberOfEmployees
     * @return void
     */
    public function setNumberOfEmployees($numberOfEmployees)
    {
        $this->numberOfEmployees = $numberOfEmployees;
    }

    /**
     * Returns the formOfCompany
     * 
     * @return string $formOfCompany
     */
    public function getFormOfCompany()
    {
        return $this->formOfCompany;
    }

    /**
     * Sets the formOfCompany
     * 
     * @param string $formOfCompany
     * @return void
     */
    public function setFormOfCompany($formOfCompany)
    {
        $this->formOfCompany = $formOfCompany;
    }
    
    /**
     * Returns the superordinate
     *
     * @return string $superordinate
     */
    public function getSuperordinate()
    {
        return $this->superordinate;
    }
    
    /**
     * Sets the superordinate
     *
     * @param string $superordinate
     * @return void
     */
    public function setSuperordinate($superordinate)
    {
        $this->superordinate = $superordinate;
    }
    
    /**
     * Returns the editors
     *
     * @return string $editors
     */
    public function getEditors()
    {
        return $this->editors;
    }
    
    /**
     * Sets the editors
     *
     * @param string $editors
     * @return void
     */
    public function setEditors($editors)
    {
        $this->editors = $editors;
    }
    
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
        $this->contacts = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->expertises = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->divisions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a Contact
     * 
     * @param \Slub\MahuPartners\Domain\Model\Contact $contact
     * @return void
     */
    public function addContact(\Slub\MahuPartners\Domain\Model\Contact $contact)
    {
        $this->contacts->attach($contact);
    }

    /**
     * Removes a Contact
     * 
     * @param \Slub\MahuPartners\Domain\Model\Contact $contactToRemove The Contact to be removed
     * @return void
     */
    public function removeContact(\Slub\MahuPartners\Domain\Model\Contact $contactToRemove)
    {
        $this->contacts->detach($contactToRemove);
    }

    /**
     * Returns the contacts
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\MahuPartners\Domain\Model\Contact> $contacts
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Sets the contacts
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\MahuPartners\Domain\Model\Contact> $contacts
     * @return void
     */
    public function setContacts(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * Adds a Expertise
     * 
     * @param \Slub\MahuPartners\Domain\Model\Expertise $expertise
     * @return void
     */
    public function addExpertise(\Slub\MahuPartners\Domain\Model\Expertise $expertise)
    {
        $this->expertises->attach($expertise);
    }

    /**
     * Removes a Expertise
     * 
     * @param \Slub\MahuPartners\Domain\Model\Expertise $expertiseToRemove The Expertise to be removed
     * @return void
     */
    public function removeExpertise(\Slub\MahuPartners\Domain\Model\Expertise $expertiseToRemove)
    {
        $this->expertises->detach($expertiseToRemove);
    }

    /**
     * Returns the expertises
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\MahuPartners\Domain\Model\Expertise> $expertises
     */
    public function getExpertises()
    {
        return $this->expertises;
    }

    /**
     * Sets the expertises
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\MahuPartners\Domain\Model\Expertise> $expertises
     * @return void
     */
    public function setExpertises(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $expertises)
    {
        $this->expertises = $expertises;
    }

    /**
     * Adds a Division
     * 
     * @param \Slub\MahuPartners\Domain\Model\Division $division
     * @return void
     */
    public function addDivision(\Slub\MahuPartners\Domain\Model\Division $division)
    {
        $this->divisions->attach($division);
    }

    /**
     * Removes a Division
     * 
     * @param \Slub\MahuPartners\Domain\Model\Division $divisionToRemove The Division to be removed
     * @return void
     */
    public function removeDivision(\Slub\MahuPartners\Domain\Model\Division $divisionToRemove)
    {
        $this->divisions->detach($divisionToRemove);
    }

    /**
     * Returns the divisions
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\MahuPartners\Domain\Model\Division> $divisions
     */
    public function getDivisions()
    {
        return $this->divisions;
    }

    /**
     * Sets the divisions
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\MahuPartners\Domain\Model\Division> $divisions
     * @return void
     */
    public function setDivisions(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $divisions)
    {
        $this->divisions = $divisions;
    }

    /**
     * Returns the id
     * 
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the id
     * 
     * @param string $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Returns the userid
     *
     * @return string $userid
     */
    public function getUserid()
    {
        return $this->userid;
    }
    
    /**
     * Sets the userid
     *
     * @param string $userid
     * @return void
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
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
     * @return boolean $hidden
     */
    public function getHidden() {
        return $this->hidden;
    }
    
    /**
     * @return boolean $hidden
     */
    public function isHidden() {
        return $this->getHidden();
    }
    
    /**
     * @param boolean $hidden
     * @return void
     */
    public function setHidden($hidden) {
        $this->hidden = $hidden;
    }
}
