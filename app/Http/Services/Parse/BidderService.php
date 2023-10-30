<?php

namespace App\Http\Services\Parse;

use App\Models\Bidder;
use App\Models\DebtorCategory;
use App\Models\Region;
use App\Models\SroAu;
use App\Models\Type;
use Artisaninweb\SoapWrapper\SoapWrapper;

class BidderService
{
    protected $bidder_type;
    protected $bidder;
    protected $type;
    protected $inn;

    public function __construct($bidder_type, $inn, $type)
    {

        $this->bidder_type = Type::where('title', $bidder_type)->first();
        $this->type = $type;
        $this->inn = $inn;
        $bidder = Bidder::where('inn', $inn)->first();
        if ($bidder) {
            $this->bidder = $bidder;
        } else {
            $this->bidder = new Bidder();
        }

    }

    public function saveBidder($person)
    {
        $region = $this->bidder->region_id;
        if (array_key_exists('Region', $person)) {
            $tmp = $person['Region'];
            $region = Region::where('title', 'LIKE', '%' . $tmp . '%')->first();
            if ($region) {
                $region = $region['id'];
            }
        }

        if (array_key_exists('FullName', $person)) {
            $name = $person['FullName'];
        } else {
            $name = $person['FirstName'];
        }
        $address = $this->bidder->address;
        if (array_key_exists('Address', $person)) {
            $address = $person['Address'];
        } else if (array_key_exists('LegalAddress', $person)) {
            $address = $person['LegalAddress'];
        }
        $sro = $this->bidder->sro_au_id;
        if (array_key_exists('SROName', $person)) {
            $sro = SroAu::where('name', $person['SROName'])->first();
            if (!$sro) {
                $sro = SroAu::create(['name' => $person['SROName']]);
            }
            $sro = $sro->id;
        }
        $category = $this->bidder->debtor_category_id;
        if (array_key_exists('CategoryCode', $person)) {
            $category = DebtorCategory::where('code', $person['CategoryCode'])->first()['id'];
        }

        $this->bidder->name = $name;
        $this->bidder->middle_name = array_key_exists('MiddleName', $person) ? $person['MiddleName'] : $this->bidder->middle_name;
        $this->bidder->last_name = array_key_exists('LastName', $person) ? $person['LastName'] : $this->bidder->last_name;
        $this->bidder->inn = $person['INN'];
        $this->bidder->snils = array_key_exists('SNILS', $person) ? $person['SNILS'] : $this->bidder->snils;
        $this->bidder->short_name = array_key_exists('ShortName', $person) ? $person['ShortName'] : $this->bidder->short_name;
        $this->bidder->ogrn = array_key_exists('OGRN', $person) ? $person['OGRN'] : $this->bidder->ogrn;
        $this->bidder->bankrupt_id = array_key_exists('BankruptId', $person) ? $person['BankruptId'] : $this->bidder->bankrupt_id;
        $this->bidder->address = $address;
        $this->bidder->region_id = $region;
        $this->bidder->debtor_category_id = $category;
        $this->bidder->ogrnip = array_key_exists('OGRNIP', $person) ? $person['OGRNIP'] : $this->bidder->ogrnip;
        $this->bidder->type = $this->type;
        $this->bidder->phone = array_key_exists('Phone', $person) ? $person['Phone'] : $this->bidder->phone;
        $this->bidder->email = array_key_exists('Email', $person) ? $person['Email'] : $this->bidder->email;
        $this->bidder->reg_num = array_key_exists('RegNum', $person) ? $person['RegNum'] : $this->bidder->reg_num;
        $this->bidder->sro_au_id = $sro;
        $this->bidder->reg_date = array_key_exists('DateReg', $person) ? $person['DateReg'] : $this->bidder->reg_date;

        $this->bidder->save();
        if (!$this->bidder->types->contains($this->bidder_type)) {
            $this->bidder->types()->attach($this->bidder_type);
        }
        return $this->bidder;
    }

    public function parseDebtor($codeType, $debtorMessageData = null)
    {
        $soapWrapper = new SoapWrapper();
        $service = new SoapWrapperService($soapWrapper);
        $debtor_data = get_object_vars($service->searchDebtorByCode($codeType, $this->inn));
        if (array_key_exists('DebtorPerson', $debtor_data)) {
            if (gettype($debtor_data['DebtorPerson']) == 'array') {
                $debtor = $debtor_data['DebtorPerson'];
                if (gettype($debtor) == 'array') {
                    $debtor = $debtor[count($debtor) - 1];
                }
            } else {
                $debtor = get_object_vars($debtor_data['DebtorPerson']);
            }
        } elseif (array_key_exists('DebtorCompany', $debtor_data)) {
            if (gettype($debtor_data['DebtorCompany']) == 'array') {
                $debtor = $debtor_data['DebtorCompany'];
                if (gettype($debtor) == 'array') {
                    $debtor = $debtor[count($debtor) - 1];
                }
            } else {
                $debtor = get_object_vars($debtor_data['DebtorCompany']);
            }
        }else{
            if(is_null($debtorMessageData)){
                return null;
            }
            $debtor = $debtorMessageData;
        }
        if (gettype($debtor) == 'object') {
            $debtor = get_object_vars($debtor);
        }
        return $this->saveBidder($debtor);
    }

}
