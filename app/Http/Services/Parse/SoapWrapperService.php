<?php

namespace App\Http\Services\Parse;

use Artisaninweb\SoapWrapper\SoapWrapper;

class SoapWrapperService
{
    /**
     * @var SoapWrapper
     */
    protected $soapWrapper;

    /**
     * SoapController constructor.
     *
     * @param SoapWrapper $soapWrapper
     */
    public function __construct(SoapWrapper $soapWrapper)
    {
        //ini_set('memory_limit', '-1');

        $soapWrapper->add('Fedresurs', function ($service) {
            $service
                ->wsdl(\Config::get('values.WSDL'))
                ->trace(true)
                ->cache(WSDL_CACHE_NONE)
                ->options([
                    'login' => \Config::get('values.FEDRESURS_LOGIN'),
                    'password' => \Config::get('values.FEDRESURS_PASSWORD'),
                    'stream' => stream_context_create(array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    ))
                ]);
        });
        $this->soapWrapper = $soapWrapper;
    }

    /**
     * GetMessageIds. Список идентификаторов сообщений за период
     */
    public function getMessageIds($startDate, $endDate=null)
    {
        //$startDate = Carbon::now()->subDays(100)->format('Y-m-d\TH:i:s');
        //$endDate = Carbon::now()->format('Y-m-d\TH:i:s');

        $response = $this->soapWrapper->call('Fedresurs.GetMessageIds',
            [
                [
                    'startDate' => $startDate,
                    'endDate' => $endDate
                ]
            ]
        );
        return $response->GetMessageIdsResult;
    }

    /**
     * GetMessageContent. Сообщение по идентификатору сообщения
     */
    public function getMessageContent($id)
    {
        $response = $this->soapWrapper->call('Fedresurs.GetMessageContent',
            [
                [
                    'id' => $id
                ]
            ]
        );
        return $response->GetMessageContentResult;
    }

    /**
     * GetTradeMessages. Список идентификаторов торгов и сообщений ЭТП за период
     */
    public function getTradeMessages($startFrom, $endTo=null)
    {

        $response = $this->soapWrapper->call('Fedresurs.GetTradeMessages',
            [
                [
                    'startFrom' => $startFrom,
                    'endTo' => $endTo
                ]
            ]
        );
        return $response->GetTradeMessagesResult;
    }

    /**
     * GetTradeMessagesByTrade. Список сообщений по идентификатору торгов на ЭТП
     */
    public function getTradeMessagesByTrade($id, $tradePlaceInn, $startFrom, $endTo=null)
    {
        //$startFrom = Carbon::now()->subDays(100)->format('Y-m-d\TH:i:s');
        //$endTo = Carbon::now()->format('Y-m-d\TH:i:s');

        $response = $this->soapWrapper->call('Fedresurs.GetTradeMessagesByTrade',
            [
                [
                    'id'=>$id,
                    'startFrom' => $startFrom,
                    'endTo' => $endTo,
                    'tradePlaceInn' => $tradePlaceInn
                ]
            ]
        );
        return $response->GetTradeMessagesByTradeResult;
    }

    /**
     * GetTradeMessageContent. Сообщение по идентификатору от ЭТП
     */
    public function getTradeMessageContent($idTradeMessage)
    {
        $response = $this->soapWrapper->call('Fedresurs.GetTradeMessageContent',
            [
                [
                    'idTradeMessage' => $idTradeMessage
                ]
            ]
        );
        return $response->GetTradeMessageContentResult;
    }

    /**
     * GetArbitrManagerRegister. Список арбитражных управляющих
     */
    public function getArbitrManagerRegister($date=null)
    {
        //$date = Carbon::now()->subDays(100)->format('Y-m-d\TH:i:s');
        $response = $this->soapWrapper->call('Fedresurs.GetArbitrManagerRegister',
            [
                [
                    'date' => $date
                ]
            ]
        );
        return $response->GetArbitrManagerRegisterResult->AMList;
    }

    /**
     * GetDebtorRegister. Список должников
     */
    public function getDebtorRegister($date=null)
    {
        //$date = Carbon::now()->subDays(100)->format('Y-m-d\TH:i:s');
        $response = $this->soapWrapper->call('Fedresurs.GetDebtorRegister',
            [
                [
                    'date' => $date
                ]
            ]
        );
        return $response->GetDebtorRegisterResult->DebtorList;
    }

    /**
     * GetCompanyTradeOrganizerRegister. Список организаторов торгов
     */
    public function getCompanyTradeOrganizerRegister($date=null)
    {
        //$date = Carbon::now()->subDays(100)->format('Y-m-d\TH:i:s');
        $response = $this->soapWrapper->call('Fedresurs.GetCompanyTradeOrganizerRegister',
            [
                [
                    'date' => $date
                ]
            ]
        );
        return $response->GetCompanyTradeOrganizerRegisterResult->TradeOrganizerList;
    }

    /**
     * GetSroRegister. Список СРО АУ
     */
    public function getSroRegister($date=null)
    {
        //$date = Carbon::now()->subDays(100)->format('Y-m-d\TH:i:s');
        $response = $this->soapWrapper->call('Fedresurs.GetSroRegister',
            [
                [
                    'date' => $date
                ]
            ]
        );
        return $response->GetSroRegisterResult->SROList;
    }

    /**
     * GetDebtorsByLastPublicationPeriod. Список должников с последней публикацией в указанный период
     */
    public function getDebtorsByLastPublicationPeriod($startDate, $endDate)
    {
        //$startDate = Carbon::now()->subDays(31)->format('Y-m-d\TH:i:s');
        //$endDate = Carbon::now()->format('Y-m-d\TH:i:s');

        $response = $this->soapWrapper->call('Fedresurs.GetDebtorsByLastPublicationPeriod',
            [
                [
                    'startDate' => $startDate,
                    'endDate' => $endDate
                ]
            ]
        );
        return $response->GetDebtorsByLastPublicationPeriodResult->DebtorList;
    }

    /**
     * GetDebtorByIdBankrupt. Данные по должнику по его идентификатору
     */
    public function getDebtorByIdBankrupt($idBankrupt)
    {
        $response = $this->soapWrapper->call('Fedresurs.GetDebtorByIdBankrupt',
            [
                [
                    'idBankrupt' => $idBankrupt
                ]
            ]
        );
        return $response->GetDebtorByIdBankruptResult;
    }

    /**
     * GetDebtorMessagesContentForPeriodByIdBankrupt. Список сообщений по должнику за период
     */
    public function getDebtorMessagesContentForPeriodByIdBankrupt($idBankrupt, $startDate=null)
    {
        //$startDate = Carbon::now()->format('Y-m-d\TH:i:s');

        $response = $this->soapWrapper->call('Fedresurs.GetDebtorMessagesContentForPeriodByIdBankrupt',
            [
                [
                    'idBankrupt' => $idBankrupt,
                    'startDate' => $startDate
                ]
            ]
        );
        return $response->GetDebtorMessagesContentForPeriodByIdBankruptResult;
    }


    /**
     * GetDebtorReportsContentForPeriodByIdBankrupt. Список отчетов по должнику за период
     */
    public function getDebtorReportsContentForPeriodByIdBankrupt($idBankrupt, $startDate=null)
    {
        //$startDate = Carbon::now()->format('Y-m-d\TH:i:s');

        $response = $this->soapWrapper->call('Fedresurs.GetDebtorReportsContentForPeriodByIdBankrupt',
            [
                [
                    'idBankrupt' => $idBankrupt,
                    'startDate' => $startDate
                ]
            ]
        );
        return $response->GetDebtorReportsContentForPeriodByIdBankruptResult;
    }

    /**
     * SearchDebtorByCode. Данные по должнику по коду (ИНН, ОГРН, ОГРНИП, СНИЛС)
     */
    public function searchDebtorByCode($codeType, $codeValue)
    {
        $response = $this->soapWrapper->call('Fedresurs.SearchDebtorByCode',
            [
                [
                    'codeType' => $codeType,
                    'codeValue' => $codeValue
                ]
            ]
        );
        return $response->SearchDebtorByCodeResult->DebtorList;
    }
}
