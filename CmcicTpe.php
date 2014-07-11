<?php

namespace yProxSite\cic-payment;

/**
 * Class CmcicTpe
 */
class CmcicTpe
{
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
    public $sUrlPaiement; //

    /**
     * // La clé - The Key
     *
     * @var string
     */
    private $_sCle; // La cl� - The Key

    /**
     * @param string $sLangue
     */
    function __construct($sLangue = "FR")
    {
        $aRequiredConstants = array('CMCIC_CLE', 'CMCIC_VERSION', 'CMCIC_TPE', 'CMCIC_CODESOCIETE');
        $this->_checkTpeParams($aRequiredConstants);

        $this->sVersion     = CMCIC_VERSION;
        $this->_sCle        = CMCIC_CLE;
        $this->sNumero      = CMCIC_TPE;
        $this->sUrlPaiement = CMCIC_SERVEUR . CMCIC_URLPAIEMENT;

        $this->sCodeSociete = CMCIC_CODESOCIETE;
        $this->sLangue      = $sLangue;

        $this->sUrlOK = CMCIC_URLOK;
        $this->sUrlKO = CMCIC_URLKO;
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

    /**
     * Contrôle l'existence des constantes d'initialisation du TPE
     * Check for the initialising constants of the TPE
     *
     * @param array $aConstants
     */
    private function _checkTpeParams($aConstants)
    {

        for ($i = 0; $i < count($aConstants); $i++)
            if (!defined($aConstants[$i]))
                die ("Erreur paramètre " . $aConstants[$i] . " indéfini");
    }
}
