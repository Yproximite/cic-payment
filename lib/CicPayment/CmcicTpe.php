<?php

namespace CicPayment;

/**
 * Class CmcicTpe
 */
class CmcicTpe
{
    const CMCIC_SERVEUR_TEST = "https://ssl.paiement.cic-banques.fr/test/";
    const CMCIC_SERVEUR      = "https://paiement.creditmutuel.fr/";
    const CMCIC_URLPAIEMENT  = "paiement.cgi";

    const CMCIC_CGI1_FIELDS = "%s*%s*%s%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s";
    const CMCIC_CGI2_FIELDS = "%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*";
    const CMCIC_CTLHMAC     = "V1.04.sha1.php--[CtlHmac%s%s]-%s";
    const CMCIC_CTLHMACSTR  = "CtlHmac%s%s";

    /**
     * Version du TPE - TPE Version (Ex : 3.0)
     *
     * @var string
     */
    public $sVersion;
    /**
     * Numero du TPE - TPE Number (Ex : 1234567)
     *
     * @var string
     */
    public $sNumero;

    /**
     * Code Societe - Company code (Ex : companyname)
     *
     * @var string
     */
    public $sCodeSociete;

    /**
     * Langue - Language (Ex : FR, DE, EN, ..)
     *
     * @var string
     */
    public $sLangue;

    /**
     * Url de retour OK - Return URL OK
     *
     * @var string
     */
    public $sUrlOK;

    /**
     * Url du serveur de paiement - Payment Server URL (Ex : https://paiement.creditmutuel.fr/paiement.cgi)
     *
     * @var string
     */
    public $sUrlPaiement;

    /**
     * // La clé - The Key
     *
     * @var string
     */
    private $_sCle;

    /**
     * @param string $sCle
     * @param string $sVersion
     * @param string $sNumero
     * @param string $sCodeSociete
     * @param string $sUrlOK
     * @param string $sUrlKO
     * @param string $sLangue
     * @param bool   $isTest
     */
    function __construct($sCle, $sVersion, $sNumero, $sCodeSociete, $sUrlOK, $sUrlKO, $sLangue, $isTest = false)
    {
        $this->sVersion = $sVersion;
        $this->_sCle    = $sCle;
        $this->sNumero  = $sNumero;

        if ($isTest) {
            $this->sUrlPaiement = self::CMCIC_SERVEUR_TEST . self::CMCIC_URLPAIEMENT;
        } else {
            $this->sUrlPaiement = self::CMCIC_SERVEUR . self::CMCIC_URLPAIEMENT;
        }

        $this->sCodeSociete = $sCodeSociete;
        $this->sLangue      = $sLangue;

        $this->sUrlOK = $sUrlOK;
        $this->sUrlKO = $sUrlKO;
    }

    /**
     * Renvoie la clé du TPE / return the TPE Key
     *
     * @return string
     */
    public function getCle()
    {
        return $this->_sCle;
    }
}