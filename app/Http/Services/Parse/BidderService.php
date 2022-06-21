<?php

namespace App\Http\Services\Parse;

use App\Models\Bidder;
use App\Models\DebtorCategory;
use App\Models\Region;
use App\Models\SroAu;
use App\Models\Type;

class BidderService
{
    protected $bidder_type;
    protected $bidder;
    protected $type;

    public function __construct($bidder_type, $inn, $type)
    {

        $this->bidder_type = Type::where('title', $bidder_type)->first();
        $this->type = $type;
        $bidder = Bidder::where('inn', $inn)->first();
        if ($bidder) {
            $this->bidder = $bidder;
        } else {
            $this->bidder = new Bidder();
        }

    }

    public function saveBidder($person)
    {
        $region = null;
        if (array_key_exists( 'Region', $person)) {
            $region = Region::where('title', $person['Region'])->first();
            if (!$region) {
                $region = Region::create(['title' => $person['Region']]);
            }
            $region = $region->id;
        }
        if (array_key_exists('FullName', $person)) {
            $name = $person[ 'FullName'];
        } else {
            $name = $person[ 'FirstName'];
        }
        $address = null;
        if (array_key_exists('Address', $person)) {
            $address = $person[ 'Address'];
        } else if (array_key_exists('LegalAddress', $person)) {
            $address = $person[ 'LegalAddress'];
        }
        $sro = null;
        if (array_key_exists('SROName', $person)) {
            $sro = SroAu::where('name', $person['SROName'])->first();
            if (!$sro) {
                $sro = SroAu::create(['name' => $person['SROName']]);
            }
            $sro = $sro->id;
        }
        $category = null;
        if(array_key_exists('CategoryCode', $person)){
           $category = DebtorCategory::where('code', $person['CategoryCode'])->first()['id'];
        }

        $this->bidder->name = $name;
        $this->bidder->middle_name = array_key_exists('MiddleName', $person) ? $person['MiddleName' ] : NULL;
        $this->bidder->last_name = array_key_exists('LastName', $person) ? $person['LastName' ] : NULL;
        $this->bidder->inn = $person['INN'];
        $this->bidder->snils = array_key_exists('SNILS', $person) ? $person['SNILS'] : NULL;
        $this->bidder->short_name = array_key_exists('ShortName', $person) ? $person['ShortName'] : NULL;
        $this->bidder->ogrn = array_key_exists('OGRN', $person) ? $person['OGRN'] : NULL;
        $this->bidder->address = $address;
        $this->bidder->region_id = $region;
        $this->bidder->debtor_category_id = $category;
        $this->bidder->ogrnip = array_key_exists('OGRNIP', $person) ? $person['OGRNIP'] : NULL;
        $this->bidder->type = $this->type;
        $this->bidder->phone = array_key_exists('Phone', $person) ? $person['Phone'] : NULL;
        $this->bidder->email = array_key_exists('Email', $person) ? $person['Email'] : NULL;
        $this->bidder->reg_num =  array_key_exists('RegNum', $person) ? $person['RegNum'] : NULL;
        $this->bidder->sro_reg_num =  array_key_exists('SRORegNum', $person) ? $person['SRORegNum'] : NULL;
        $this->bidder->sro_au_id = $sro;
        $this->bidder->reg_date = array_key_exists('DateReg', $person) ? $person['DateReg'] : NULL;

        $this->bidder->save();
        if(!$this->bidder->types->contains($this->bidder_type)) {
            $this->bidder->types()->attach($this->bidder_type);
        }
        return $this->bidder;
    }

}
