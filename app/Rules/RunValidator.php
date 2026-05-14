<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;

class RunValidator implements Rule, DataAwareRule, ValidatorAwareRule {
        
    private $data;

    private $validator;

    public function __construct() 
    {
        //
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function setValidator($validator)
    {
        $this->validator = $validator;

        return $this;
    }

    public function passes($attribute, $value) {

    if ($attribute == 'dvRunOrganizacion') {
       if ($this->validator->errors()->has('runOrganizacion')) {//Si rut tiene errores no se valida el DV
            return true;
       }
    }

    if ($attribute == 'dvRutRepLegal')  {
      if ($this->validator->errors()->has('rutRepLegal')) {//Si rut tiene errores no se valida el DV
        return true;
      }
    }

     if ($attribute == 'dvRunOrganizacion') {
        $rut = data_get($this->data, 'runOrganizacion');
     }
     else 
      if ($attribute == 'dvRutRepLegal')  {
         $rut = data_get($this->data, 'rutRepLegal');
      }
        $serie=2;
        $suma=0;
        $rut = strval($rut);
        $lenRut = strlen($rut)-1;
        //dd($rut, $lenRut);

        for ($i=$lenRut; $i>=0; $i--) {
            if ( $serie > 7 ) {
                $serie=2;
            }
            $suma += $rut[$i] * $serie;
            $serie++;
        }

        $dvCalc = 11-($suma % 11);
        if ( $dvCalc == 10 ) {
            $dvCalc='K';
        } else
        if ($dvCalc == 11) {
            $dvCalc='0';
        }       
            return $dvCalc == strtoupper($value);      
       //Si valor es true el rut es correcto 
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El rut ingresado no es válido, revisar dígito verificador.';
    }
}
