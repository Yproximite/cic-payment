<?php

namespace CicPayment;

class CmcicHmac
{
    /**
     * La clé du TPE en format opérationnel / The usable TPE key
     *
     * @var string
     */
    private $_sUsableKey;

    /**
     * @param CmcicTpe $oTpe
     */
    function __construct($oTpe)
    {
        $this->_sUsableKey = $this->_getUsableKey($oTpe);
    }

    /**
     * Renvoie la clé dans un format utilisable par la certification hmac
     * Return the key to be used in the hmac function
     *
     * @param CmcicTpe $oTpe
     *
     * @return string
     */
    private function _getUsableKey($oTpe)
    {
        $hexStrKey = substr($oTpe->getCle(), 0, 38);
        $hexFinal  = "" . substr($oTpe->getCle(), 38, 2) . "00";

        $cca0 = ord($hexFinal);

        if ($cca0 > 70 && $cca0 < 97)
            $hexStrKey .= chr($cca0 - 23) . substr($hexFinal, 1, 1);
        else {
            if (substr($hexFinal, 1, 1) == "M")
                $hexStrKey .= substr($hexFinal, 0, 1) . "0";
            else
                $hexStrKey .= substr($hexFinal, 0, 2);
        }

        return pack("H*", $hexStrKey);
    }

    /**
     * Renvoie le sceau HMAC d'une chaine de données
     * Return the HMAC for a data string
     *
     * If you don't have PHP 5 >= 5.1.2 and PECL hash >= 1.1
     * you may use the hmac_sha1 function defined below
     * return strtolower($this->hmac_sha1($this->_sUsableKey, $sData));
     *
     * @param string $sData
     *
     * @return string
     */
    public function computeHmac($sData)
    {
        return strtolower(hash_hmac("sha1", $sData, $this->_sUsableKey));
    }

    /**
     *
     * RFC 2104 HMAC implementation for PHP >= 4.3.0 - Creates a SHA1 HMAC.
     * Eliminates the need to install mhash to compute a HMAC
     * Adjusted from the md5 version by Lance Rushing .
     *
     * Implémentation RFC 2104 HMAC pour PHP >= 4.3.0 - Création d'un SHA1 HMAC.
     * Elimine l'installation de mhash pour le calcul d'un HMAC
     * Adaptée de la version MD5 de Lance Rushing.
     *
     * @param string $key
     * @param string $data
     *
     * @return string
     */
    public function hmac_sha1($key, $data)
    {

        $length = 64; // block length for SHA1
        if (strlen($key) > $length) {
            $key = pack("H*", sha1($key));
        }
        $key    = str_pad($key, $length, chr(0x00));
        $ipad   = str_pad('', $length, chr(0x36));
        $opad   = str_pad('', $length, chr(0x5c));
        $k_ipad = $key ^ $ipad;
        $k_opad = $key ^ $opad;

        return sha1($k_opad . pack("H*", sha1($k_ipad . $data)));
    }
}
