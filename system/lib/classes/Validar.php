<?php

/**
 * class for data validation
 * 
 * @package Helpgroup
 * @subpackage Classes
 *
 * @author Dimitri Lameri, Danilo Gomes <danilo@digirati.com.br>, Arnour Sabino <arnour@digirati.com.br>
 */
abstract class Validar {

    /**
     * center the validation
     *
     * @param string $StPattern
     * @param string $StData
     * @param mixed  $Exception
     * @return bool
     *
     * @author Dimitri Lameri <Dimitri@Digirati.com.br>
     */
    public static function doValidation($StPattern, $StData, $Exception = false) {
        if (preg_match($StPattern, $StData)) {
            return true;
        } elseif ($Exception) {
            throw new Exception($Exception);
        } else {
            return false;
        }
    }

    /**
     * validate email
     *
     * @param string $StEmail
     * @return bool
     *
     * @author Dimitri Lameri <Dimitri@Digirati.com.br>
     */
    public static function Email($StData, $Exception = false) {
        $ExpReg = '/^[\w\.\-]+[@][\w\.\-]+\.(?i)[a-z\_\-]{2,4}$/';
        return self::doValidation($ExpReg, $StData, $Exception);
    }

    /**
     * validate hex
     *
     * @param string $StData
     * @return bool;
     *
     * @author Dimitri Lameri <Dimitri@Digirati.com.br>
     */
    public static function Hex($StData, $Exception = false) {
        $ExpReg = '/^#?(((?i)[a-z]|[0-9]){3}(((?i)[a-z]|[0-9]){3})?)$/';
        return self::doValidation($ExpReg, $StData, $Exception);
    }

    /**
     * validate date
     *
     * @param string $StData
     * @param string $StFormat - Formato da data
     * @return bool;
     *
     * @author Dimitri Lameri <Dimitri@Digirati.com.br>
     */
    public static function Date($StData, $StFormat = 'd/m/y', $Exception = false) {
        $StSeparator = '(\/|\-)';
        $StDay = '([0-2][0-9]|3[0-1])';
        $StMonth = '(0[1-9]|1[0-2])';
        $StYear = '([0-9]{4})';

        $ExpReg = preg_replace('/\/|\-/', $StSeparator, $StFormat);
        $ExpReg = preg_replace('/[d]/i', $StDay, $ExpReg);
        $ExpReg = preg_replace('/[m]/i', $StMonth, $ExpReg);
        $ExpReg = preg_replace('/[y]/i', $StYear, $ExpReg);

        $ExpReg = '/^' . $ExpReg . '$/';

        return self::doValidation($ExpReg, $StData, $Exception);
    }

    /**
     * validate time
     *
     * @param string $StData
     * @return bool;
     *
     * @author Dimitri Lameri <Dimitri@Digirati.com.br>
     */
    public static function Time($StData, $Exception = false) {
        $StSeparator = '(\/|\-|\:)';
        $StHour = '([01][0-9]|2[0-3])';
        $StMinute = '([0-5][0-9])';
        $StSecond = '([0-5][0-9])';

        $ExpReg = preg_replace('/\/|\-|\:/', $StSeparator, DATE_FORMAT);
        $ExpReg = preg_replace('/[h]/i', $StHour, $ExpReg);
        $ExpReg = preg_replace('/[i]/i', $StMinute, $ExpReg);
        $ExpReg = preg_replace('/[s]/i', $StSecond, $ExpReg);

        $ExpReg = '/^' . $ExpReg . '$/';

        return self::doValidation($ExpReg, $StData, $Exception);
    }

    /**
     * validate domain
     *
     * @param string $StData
     * @return bool
     *
     * @author Dimitri Lameri <Dimitri@Digirati.com.br>
     */
    public static function Domain($StData, $Exception = false) {
        $ExpReg = '/^[\w\.\-]+\.(?i)[a-z\_\-]{2,4}$/';
        return self::doValidation($ExpReg, $StData, $Exception);
    }

    /**
     * validate IP
     *
     * @param string $StData
     * @return bool
     *
     * @author Dimitri Lameri <Dimitri@Digirati.com.br>
     */
    public static function IP($StData, $Exception = false) {
        $ExpReg = '/^(([0-9]{1,3})\.){3}([0-9]{1,3})$/';
        if (!self::doValidation($ExpReg, $StData)) {
            $StData = strtoupper($StData);
            $ExpReg = '/^(^(([0-9A-F]{1,4}(((:[0-9A-F]{1,4}){5}::[0-9A-F]{1,4})|((:[0-9A-F]{1,4}){4}::[0-9A-F]{1,4}(:[0-9A-F]{1,4}){0,1})|((:[0-9A-F]{1,4}){3}::[0-9A-F]{1,4}(:[0-9A-F]{1,4}){0,2})|((:[0-9A-F]{1,4}){2}::[0-9A-F]{1,4}(:[0-9A-F]{1,4}){0,3})|(:[0-9A-F]{1,4}::[0-9A-F]{1,4}(:[0-9A-F]{1,4}){0,4})|(::[0-9A-F]{1,4}(:[0-9A-F]{1,4}){0,5})|(:[0-9A-F]{1,4}){7}))$|^(::[0-9A-F]{1,4}(:[0-9A-F]{1,4}){0,6})$)|^::$)|^((([0-9A-F]{1,4}(((:[0-9A-F]{1,4}){3}::([0-9A-F]{1,4}){1})|((:[0-9A-F]{1,4}){2}::[0-9A-F]{1,4}(:[0-9A-F]{1,4}){0,1})|((:[0-9A-F]{1,4}){1}::[0-9A-F]{1,4}(:[0-9A-F]{1,4}){0,2})|(::[0-9A-F]{1,4}(:[0-9A-F]{1,4}){0,3})|((:[0-9A-F]{1,4}){0,5})))|([:]{2}[0-9A-F]{1,4}(:[0-9A-F]{1,4}){0,4})):|::)((25[0-5]|2[0-4][0-9]|[0-1]?[0-9]{0,2})\.){3}(25[0-5]|2[0-4][0-9]|[0-1]?[0-9]{0,2})$/';
            if (self::doValidation($ExpReg, $StData)) {
                return 'V6';
            } else {
                return false;
            }
        } else {
            return 'V4';
        }
    }

    /**
     * validate ID
     *
     * @param string $StData
     * @return bool
     *
     * @author Dimitri Lameri <Dimitri@Digirati.com.br>
     */
    public static function IDRegistro($StData, $Exception = false) {
        $ExpReg = '/^[A-Z0-9]+$/';
        return self::doValidation($ExpReg, $StData, $Exception);
    }

    /**
     * Valida ID
     * @param $StData
     * @param $Exception
     * @return bool
     */
    public static function ID($StData, $Exception = false) {
        if (empty($StData)) {
            if ($Exception) {
                throw new Exception($Exception);
            }
            return false;
        }
        return self::Integer($StData, $Exception);
    }

    /**
     * validate any integer field
     *
     * @param string $StData
     * @return bool
     *
     * @author Dimitri Lameri <Dimitri@Digirati.com.br>
     */
    public static function Integer($StData, $Exception = false) {
        $ExpReg = '/^[0-9]+$/';
        return self::doValidation($ExpReg, $StData, $Exception);
    }

    /**
     * validate any string field
     *
     * @param string $StData
     * @return bool
     *
     * @author Dimitri Lameri <Dimitri@Digirati.com.br>
     */
    public static function String($StData, $Exception = false) {
        if (!empty($StData) && is_string($StData)) {
            return true;
        } elseif ($Exception) {
            throw new Exception($Exception);
        } else {
            return false;
        }
    }

    /**
     * valida login dos sistemas da hostnet, como webtodo, webmail
     * @param $StData
     * @param $ItTamanho
     * @param $Exception
     * @return bool
     * 
     * @author Arnour Sabino <arnour@digirati.com.br>
     */
    public static function Login($StData, $ItTamanho = 32, $Exception = false) {
        $ExpReg = '/^[a-z][_a-z0-9-]*(\.[_a-z0-9-]+)?$/';
        return self::doValidation($ExpReg, $StData, $Exception) && (strlen($StData) <= $ItTamanho);
    }

    /**
     * valida contas webtodo
     * @param $StData
     * @param $Exception
     * @return bool
     */
    public static function Account($StData, $Exception = false) {
        return self::Login($StData, 16, $Exception);
    }

    /**
     * Verifique se a 'String' informada esta no padrao AlfaNumerico(Letras e Numeros)
     * @param $StData
     * @param $Exception
     * @return bool
     */
    public static function AlphaNumeric($StData, $Exception = false) {
        $StPattern = '/^[A-Za-z0-9]+$/';
        return self::doValidation($StPattern, $StData, $Exception);
    }

    /**
     * Valida o formato de senhas [WebTodo]
     * @param $StData
     * @param $Exception
     * @return bool
     */
    public static function PassWord($StData, $Exception = false) {
        $StPattern = '/^[0-9a-zA-Z-{}\[\]:;<>.!@#$%&*()_+=?\/|\\, ]{4,30}$/';
        return self::doValidation($StPattern, $StData, $Exception);
    }

    /**
     * valida Banco de dados
     * @param $StData
     * @param $Exception
     * @return bool
     */
    public static function DataBase($StData, $Exception = false) {
        $StPattern = '/^[a-z0-9][a-z0-9_-]{2,60}$/';
        return self::doValidation($StPattern, $StData, $Exception);
    }

    /**
     * valida um usuario de banco de dados
     * @param $StData
     * @param $Exception
     * @return bool
     */
    public static function DataBaseAccount($StData, $Exception = false) {
        $StPattern = '/^[a-z0-9][_a-z0-9-]*(\.[_a-z0-9-]+)?$/';
        return self::doValidation($StPattern, $StData, $Exception) && strlen($StData) <= 16;
    }

    /**
     * valida Database Host [IP Valido, Dominio valido, '%', '%' + Dominio, IP + '%']
     * @param $StData
     * @param $Exception
     * @return bool
     */
    public static function DataBaseHost($StData, $Exception = false) {

        if (self::IP($StData)) {
            return true;
        } else {

            if (self::Domain($StData)) {

                if (checkdnsrr($StData, 'A')) {
                    return true;
                } else {
                    return false;
                }
            } else {

                if ($StData == '%') {
                    return true;
                } else {

                    # parte de um IP ex.: 10.1.2.% ou 10.3.%
                    $StPattern = '/(((\d{1,2})|(1\d{2})|(2[0-4]\d)|(25[0-5]))\.){1,3}%$/';
                    if (!self::doValidation($StPattern, $StData)) {

                        $StPattern = '/^%\.([A-Za-z0-9%-]+\.)+[A-Za-z]{2,4}$/';
                        if (!self::doValidation($StPattern, $StData)) {
                            return false;
                        } else {
                            return true;
                        }
                    } else {
                        return true;
                    }
                }
            }
        }
    }

    /**
     * Valida Tabela de Banco de dados
     * 
     * @param $StData
     * @param $Exception
     * @return bool
     */
    public static function DatabaseTable($StData, $Exception = false) {
        $StPattern = '/^[A-Za-z][A-Za-z0-9_-]{1,60}$/';
        return self::doValidation($StPattern, $StData, $Exception);
    }

    /**
     * validate CPF
     *
     * @param string $StData
     * @return bool
     *
     * @author Dimitri Lameri <Dimitri@Digirati.com.br>
     */
    public static function CPF($StData, $Exception = false) {
        $ArNulos = array('12345678909');

        for ($i = 0; $i <= 9; $i++) {
            $ArNulos[] = str_repeat($i, 11);
        }

        $StCPF = ereg_replace('[^0-9]', '', $StData);

        if (strlen($StCPF) != 11) {
            if ($Exception) {
                throw new Exception($Exception);
            }
            return false;
        }

        if (in_array($StCPF, $ArNulos)) {
            if ($Exception) {
                throw new Exception($Exception);
            }
            return false;
        }

        $ItSumPenultDV = 0;
        for ($i = 0; $i < 9; $i++) {
            $ItSumPenultDV += substr($StCPF, $i, 1) * (10 - $i);
        }

        $ItPenultDV = $ItSumPenultDV % 11;
        $ItPenultDV = ($ItPenultDV > 1) ? (11 - $ItPenultDV) : 0;

        if ($ItPenultDV != $StCPF[9]) {
            if ($Exception) {
                throw new Exception($Exception);
            }
            return false;
        }

        $ItSumLastDV = 0;
        for ($i = 0; $i < 10; $i++) {
            $ItSumLastDV += substr($StCPF, $i, 1) * (11 - $i);
        }

        $ItLastDV = $ItSumLastDV % 11;
        $ItLastDV = ($ItLastDV > 1) ? (11 - $ItLastDV) : 0;
        if ($ItLastDV != $StCPF[10]) {
            if ($Exception) {
                throw new Exception($Exception);
            }
            return false;
        }

        $StData = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", $StData);
        return $StData;
    }

    public static function CNPJ($StData, $Exception = false) {

        $StCNPJ = ereg_replace('[^0-9]', '', $StData);

        # Registro BR
        if (strlen($StCNPJ) == 15 && substr($StCNPJ, 0, 1) == '0') {
            $StCNPJ = substr($StCNPJ, 1);
        }

        if (strlen($StCNPJ) != 14 || $StCNPJ == "00000000000000") {
            if ($Exception) {
                throw new Exception($Exception);
            }
            return false;
        }

        $Numero = array();
        $ItFator = 5;
        $ItSum = 0;
        for ($i = 1; $i <= 14; $i++) {
            $Numero[$i] = intval(substr($StCNPJ, $i - 1, 1));
            if ($i <= 12) {
                $ItSum += $Numero[$i] * $ItFator;
                if ($ItFator == 2) {
                    $ItFator = 9;
                } else {
                    $ItFator--;
                }
            }
        }

        $ItSum = $ItSum - (11 * ( intval($ItSum / 11) ));


        if ($ItSum == 0 || $ItSum == 1) {
            $ItPenultDV = 0;
        } else {
            $ItPenultDV = 11 - $ItSum;
        }

        if ($ItPenultDV == $Numero[13]) {
            $ItFator = 6;
            $ItSum = 0;
            for ($i = 1; $i <= 13; $i++) {
                $ItSum += $Numero[$i] * $ItFator;
                if ($ItFator == 2) {
                    $ItFator = 9;
                } else {
                    $ItFator--;
                }
            }
            $ItSum = $ItSum - (11 * ( intval($ItSum / 11) ));

            if ($ItSum == 0 || $ItSum == 1) {
                $ItLastDV = 0;
            } else {
                $ItLastDV = 11 - $ItSum;
            }

            if ($ItLastDV == $Numero[14]) {
                $StData = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{4})(\d{2})/", "$1.$2.$3/$4-$5", $StData);
                if (strlen($StData) == 18) {
                    $StData = '0' . $StData;
                }
                return $StData;
            }
        }

        if ($Exception) {
            throw new Exception($Exception);
        }
        return false;
    }

    /**
     * validate CEP
     *
     * @param string $StData
     * @param mixed $Exception
     * @return mixed
     */
    public static function CEP($StData, $Exception = false) {
        $StCEP = ereg_replace('[^0-9]', '', $StData);
        if (!in_array(strlen($StCEP), array('7', '8'))) {
            if ($Exception) {
                throw new Exception($Exception);
            }
            return false;
        } else {
            return preg_replace("/^(.*)(\d{3})/", "$1-$2", $StCEP);
        }
    }

    public static function isArray($ArData, $Exception = false) {
        if (!empty($ArData) && is_array($ArData)) {
            return true;
        }

        if ($Exception) {
            throw new Exception($Exception);
        }

        return false;
    }

    /**
     * validade Money (Real)
     * 
     * @param string $StData
     * @param mixed $Exception
     * @return mixed
     */
    public static function Money($StData, $Exception = false) {
        $StPattern = "/^([1-9]{1}[\d]{0,2}(\.[\d]{3})*(\,[\d]{0,2})?|[1-9]{1}[\d]{0,}(\,[\d]{0,2})?|0(\,[\d]{0,2})?|(\,[\d]{1,2})?)$/";
        return self::doValidation($StPattern, $StData, $Exception);
    }

    public static function Number($StData, $Exception = false) {
        if (!empty($StData) && is_numeric($StData)) {
            return true;
        }

        if ($Exception) {
            throw new Exception($Exception);
        }
        return false;
    }

}

?>
