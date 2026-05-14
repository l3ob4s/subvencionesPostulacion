<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'El campo debe ser aceptado.',
    'active_url'           => 'El campo no es una URL válida.',
    'after'                => 'El campo debe ser una fecha posterior a :date.',
    'after_or_equal'       => 'El campo debe ser una fecha posterior o igual a :date.',
    'alpha'                => 'El campo solo puede contener letras.',
    'alpha_dash'           => 'El campo solo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num'            => 'El campo solo puede contener letras y números.',
    'array'                => 'El campo debe ser un array.',
    'before'               => 'El campo debe ser una fecha anterior a :date.',
    'before_or_equal'      => 'El campo debe ser una fecha anterior o igual a :date.',
    'between'              => [
        'numeric' => 'El campo debe ser un valor entre :min y :max.',
        'file'    => 'El archivo debe pesar entre :min y :max kilobytes.',
        'string'  => 'El campo debe contener entre :min y :max caracteres.',
        'array'   => 'El campo debe contener entre :min y :max elementos.',
    ],
    'boolean'              => 'El campo debe ser verdadero o falso.',
    'confirmed'            => 'El campo confirmación de no coincide.',
    'date'                 => 'El campo no corresponde con una fecha válida.',
    'date_equals'          => 'El campo debe ser una fecha igual a :date.',
    'date_format'          => 'Formato de fecha incorrecto',
    'different'            => 'Los campos y :other deben ser diferentes.',
    'digits'               => 'El campo debe ser un número de :digits dígitos.',
    'digits_between'       => 'El campo debe contener entre :min y :max dígitos.',
    'dimensions'           => 'El campo tiene dimensiones de imagen inválidas.',
    'distinct'             => 'El campo tiene un valor duplicado.',
    'email'                => 'Debe ingresar un correo válido.',
    'ends_with'            => 'El campo debe finalizar con alguno de los siguientes valores: :values',
    'exists'               => 'El campo seleccionado no existe.',
    'file'                 => 'El campo debe ser un archivo.',
    'filled'               => 'El campo debe tener un valor.',
    'gt'                   => [
        'numeric' => 'El campo debe ser mayor a :value.',
        'file'    => 'El archivo debe pesar más de :value kilobytes.',
        'string'  => 'El campo debe contener más de :value caracteres.',
        'array'   => 'El campo debe contener más de :value elementos.',
    ],
    'gte'                  => [
        'numeric' => 'El campo debe ser mayor o igual a :value.',
        'file'    => 'El archivo debe pesar :value o más kilobytes.',
        'string'  => 'El campo debe contener :value o más caracteres.',
        'array'   => 'El campo debe contener :value o más elementos.',
    ],
    'image'                => 'El campo debe ser una imagen.',
    'in'                   => 'El campo es inválido.',
    'in_array'             => 'El campo no existe en :other.',
    'integer'              => 'El campo debe ser un número entero.',
    'ip'                   => 'El campo debe ser una dirección IP válida.',
    'ipv4'                 => 'El campo debe ser una dirección IPv4 válida.',
    'ipv6'                 => 'El campo debe ser una dirección IPv6 válida.',
    'json'                 => 'El campo debe ser una cadena de texto JSON válida.',
    'lt'                   => [
        'numeric' => 'El campo debe ser menor a :value.',
        'file'    => 'El archivo debe pesar menos de :value kilobytes.',
        'string'  => 'El campo debe contener menos de :value caracteres.',
        'array'   => 'El campo debe contener menos de :value elementos.',
    ],
    'lte'                  => [
        'numeric' => 'El campo debe ser menor o igual a :value.',
        'file'    => 'El archivo debe pesar :value o menos kilobytes.',
        'string'  => 'El campo debe contener :value o menos caracteres.',
        'array'   => 'El campo debe contener :value o menos elementos.',
    ],
    'max'                  => [
        'numeric' => 'El campo no debe ser mayor a :max.',
        'file'    => 'El archivo no debe pesar más de :max kilobytes.',
        'string'  => 'El campo no debe contener más de :max caracteres.',
        'array'   => 'El campo no debe contener más de :max elementos.',
    ],
    'mimes'                => 'El campo debe ser un archivo de tipo: :values.',
    'mimetypes'            => 'El campo debe ser un archivo de tipo: :values.',
    'min'                  => [
        'numeric' => 'El campo debe ser al menos :min.',
        'file'    => 'El archivo debe pesar al menos :min kilobytes.',
        'string'  => 'El campo debe contener al menos :min caracteres.',
        'array'   => 'El campo debe contener al menos :min elementos.',
    ],
    'not_in'               => 'El campo seleccionado es inválido.',
    'not_regex'            => 'El formato del campo es inválido.',
    'numeric'              => 'El campo debe ser un número.',
    'password'             => 'La contraseña es incorrecta.',
    'present'              => 'El campo debe estar presente.',
    'regex'                => 'El formato del campo es inválido.',
    'required'             => 'El campo es obligatorio.',
    'required_if'          => 'El campo es obligatorio cuando el campo :other es :value.',
    'required_unless'      => 'El campo es requerido a menos que :other se encuentre en :values.',
    'required_with'        => 'El campo es obligatorio cuando :values está presente.',
    'required_with_all'    => 'El campo es obligatorio cuando :values están presentes.',
    'required_without'     => 'El campo es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo es obligatorio cuando ninguno de los campos :values están presentes.',
    'same'                 => 'Los campos y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'El campo debe ser :size.',
        'file'    => 'El archivo debe pesar :size kilobytes.',
        'string'  => 'El campo debe contener :size caracteres.',
        'array'   => 'El campo debe contener :size elementos.',
    ],
    'starts_with'          => 'El campo debe comenzar con uno de los siguientes valores: :values',
    'string'               => 'El campo debe ser una cadena de caracteres.',
    'timezone'             => 'El campo debe ser una zona horaria válida.',
    'unique'               => 'El valor del campo ya está en uso.',
    'uploaded'             => 'El campo no se pudo subir.',
    'url'                  => 'El formato del campo es inválido.',
    'uuid'                 => 'El campo debe ser un UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        '*.*.idActividad' => [
            'gt' => 'Debe seleccionar una actividad',
        ],
        '*.*.canthora' => [
            'gt' => 'Debe ingresar cantidad de horas',
        ],
        '*.*.valorhora' => [
            'gt' => 'Debe ingresar valor hora',
        ],
        '*.*.montototal' => [
            'gt' => 'Debe ingresar monto total',
        ],
        '*.*.cantidad' => [
            'gt' => 'Debe ingresar cantidad',
        ],
        'runOrganizacion' => [
            'required' => 'Debe ingresar RUN de la organización',
            'integer' => 'El Run no debe contener caracteres, puntos ni guión',
            'digits_between' => 'Run debe contener entre 7 y 9 digitos',
        ],
        'dvR*' => [
            'required_with' => 'Debe ingresar dígito verificador',
            'max' => 'El largo máximo para el digito verificador es de un caracter',
        ],
        //Datos Organizacion
        'nombreOrganizacion' => [
            'required' => 'Debe ingresar el nombre de la organización',
            'string' => 'El nombre de la organización debe ser texto',
        ],
        'agnosExistencia' => [
            'required' => 'Debe ingresar años de existencia',
            'gte' => 'Existencia legal de la institución debe ser mínino de dos años',
            'required_with' => 'Usted ingresó fecha de vencimiento de la directiva por lo tanto debe ingresar años de existencia',
        ],
        'direccion*' => [
            'required' => 'Debe ingresar la dirección de la organización',
            'string' => 'La dirección de la organización debe ser texto',
        ],
        'codTipoVia' => [
            'required' => 'Debe seleccionar el tipo de vía',
            'gt' => 'Debe seleccionar el tipo de vía',
        ],
        'nombreVia' => [
            'required' => 'Debe ingresar el nombre de la calle',
            'string' => 'El nombre de la calle debe ser texto',
        ],
        'numDireccion' => [
            'required' => 'Debe ingresar el numero de la dirección',
            'integer'  => 'El campo debe ser un valor numerico',
            'digits_between' => 'El número de la dirección no debe sobrepasar los 5 dígitos',
        ],
        '*fono*' => [
            'required' => 'Debe ingresar teléfono',
            'regex' => 'El formato de teléfono no es válido',
        ],
        'correo*' => [
            'required' => 'Debe ingresar correo',
        ],
        '*Provincia*' => [
            'required' => 'Debe seleccionar provincia',
            'gt' => 'Debe seleccionar provincia',
        ],
        '*Comuna*' => [
            'required' => 'Debe seleccionar comuna',
            'gt' => 'Debe seleccionar comuna',
        ],
        'idTipocuenta' => [
            'required' => 'Debe seleccionar tipo de cuenta',
            'gt' => 'Debe seleccionar tipo de cuenta',
        ],
        'idBanco' => [
            'required' => 'Debe seleccionar banco',
            'gt' => 'Debe seleccionar banco',
        ],
        'numeroCuenta' => [
            'required' => 'Debe ingresar número de cuenta',
        ],


        //Datos Representante Legal
        'rutRepLegal' => [
            'required' => 'Debe ingresar rut del representante legal',
            'integer' => 'El Rut no debe contener caracteres, puntos ni guión',
            'digits_between' => 'Rut debe contener entre 7 y 9 digitos',
        ],
        'fecVencDirectiva' => [
            'required' => 'Debe ingresar fecha de vencimiento de la directiva',
            'max' => 'El largo máximo para el digito verificador es de un caracter',
            'required_with' => 'Usted ingresó años de existencia por lo tanto debe ingresar fecha de vencimiento de la directiva',
        ],
        //Datos Administrativos del proyecto
        'nombreProyecto' => [
            'required' => 'Debe ingresar nombre del proyecto',
        ],
        'idFondoConcursable' => [
            'required' => 'Debe seleccionar fondo concursable',
            'gt' => 'Debe seleccionar fondo concursable',
        ],
        'nomRepLegal' => [
            'required' => 'Debe ingresar nombre del representante legal',
        ],
        'montoProyecto' => [
            'required' => 'Debe ingresar el monto del proyecto',
            'gt' => 'El monto del proyecto debe ser mayor a cero',
            // 'min' => 'El monto minímo a financiar es de $:min para el fondo seleccionado',
            // 'max' => 'El monto máximo a financiar es de $:max para el fondo seleccionado',
        ],
        'duracionProyecto' => [
            'required' => 'Debe ingresar la duración del proyecto',
            'min' => 'La duración del proyecto debe ser mayor o igual a :min meses',
            'max' => 'La ejecución del proyecto para el fondo seleccionado máximo debe durar :max meses',
        ],
        'idTipoProyecto' => [
            'required' => 'Debe seleccionar el tipo de proyecto',
            'gt' => 'Debe seleccionar el tipo de proyecto',
        ],
        //Datos técnicos del proyecto
        'cantBenefHombreProy' => [
            'required' => 'Debe ingresar cantidad de beneficiarios, si no existen beneficiarios hombre ingrese 0',
        ],
        'cantBenefMujerProy' => [
            'required' => 'Debe ingresar cantidad de beneficiarios, si no existen beneficiarias mujer ingrese 0',
        ],
        'cantTotalBenef' => [
            'gt' => 'La suma de los beneficiarios: hombres y mujeres, debe ser mayor a cero',
        ],
        'resumenProyecto' => [
            'required' => 'Debe ingresar resumen del proyecto',
        ],
        'objetivoProyecto' => [
            'required' => 'Debe ingresar objetivo general del proyecto',
        ],
        'descripNecesidadACubrir' => [
            'required' => 'Debe ingresar ¿Que problema o necesidad busca resolver?',
        ],
        'descripTerritorioBenef' => [
            'required' => 'Debe ingresar descripción del territorio y beneficiarios',
        ],
        'descripDifusionProy' => [
            'required' => 'Debe ingresar difusión del proyecto',
        ],
        'descripResultadoProy' => [
            'required' => 'Debe ingresar resultados y/o productos esperados',
        ],
        'descripMedioVerifPostEjecuProy' => [
            'required' => 'Debe ingresar medios de verificación de actividades y/o productos a obtener post ejecución del proyecto',
        ],
        //Objetivos especificos del proyecto
        'inputsObjEspecifico.*.descripcionObjEspecifico' => [
            'required' => 'Debe ingresar objetivo específico',
        ],
        'inputsActividad.*.tituloActividad' => [
            'required' => 'Debe ingresar título de la actividad',
        ],
        'inputsActividad.*.descripcionActividad' => [
            'required' => 'Debe ingresar descripción de la actividad',
        ],
        'inputsActividad.*.mesesEjecuActividad' => [
            'required' => 'Debe seleccionar al menos un mes',
        ],
        'inputsActividad.*.descripBienesServRRHHActividad' => [
            'required' => 'Debe ingresar descricpión de los Bienes, Servicios Y/O RRHH ',
        ],
        'inputsDescripRRHH.*.descripCargo' => ['required' => 'Ingrese la descripción del cargo'],
        'inputsDescripRRHH.*.descripFuncActividades' => ['required' => 'Describa las funciones y/o actividades a realizar'],
        'inputsDescripRRHH.*.descripPerfilCargo' => ['required' => 'Describa el perfil del cargo'],
        'inputsDescripRRHH.*.totalHorasServicio' => [
            'required' => 'Ingrese la cantidad de horas del servicio',
            'gt' => 'La cantidad de horas del servicio debe ser mayor a cero',
        ],
        'inputsDescripRRHH.*.descripPeriocidadServicio' => ['required' => 'Describa la periocidad del servicio'],
        'inputsDescripRRHH.*.montoTotalServicio' => [
            'required'  => 'Ingrese el monto total del servicio',
            'gt'  => 'Monto total del servicio debe ser mayor a cero',
        ],
        'docProyecto' => [
            'required' => 'Debe adjuntar la documentación de su proyecto', 
             'mimes'                => 'El archivo debe ser de tipo PDF',
            'mimetypes'            => 'El archivo debe ser de tipo PDF.',
        ],
         'codTipoTerritoriosCheck' => [
            'required' => 'Debe seleccionar al menos una opción', 
        ],
         'codTipoDifusionCheck' => [
            'required' => 'Debe seleccionar al menos una opción', 
        ],
         'codTipoMedioVerificacionCheck' => [
            'required' => 'Debe seleccionar al menos una opción',
        ],
        'codTipoInstitucion' => [
            'required' => 'Seleccione el tipo de institución',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
