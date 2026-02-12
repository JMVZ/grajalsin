<?php

namespace Database\Seeders;

use App\Models\LineaCarga;
use Illuminate\Database\Seeder;

class LineasTransporteSeeder extends Seeder
{
    /**
     * Líneas de transporte: nombre, coordinador, telefono, base_operacion, notas.
     */
    public function run(): void
    {
        $lineas = [
            ['nombre' => 'T. FEUER', 'contacto' => 'C. MIGUEL ÁNGEL SANTOS', 'telefono' => '2221390702', 'base_operacion' => 'PUEBLA, PUEBLA', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. POLOK', 'contacto' => 'C.LIZ EVANGELISTA', 'telefono' => '3121445390', 'base_operacion' => 'COLIMA, COLIMA', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. GARIBAY', 'contacto' => 'C. BRENDA GARIBAY', 'telefono' => '3131087577', 'base_operacion' => 'MANZANILLO, COLIMA', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. GM', 'contacto' => 'C. LUZ', 'telefono' => '3131130198', 'base_operacion' => 'MANZANILLO, COLIMA', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. MONTELONGO', 'contacto' => 'C. SANTIAGO', 'telefono' => '3131413490', 'base_operacion' => 'MANZANILLO, COLIMA', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. ORTEGA', 'contacto' => 'C. JUAN DE LA CRUZ ORTEGA', 'telefono' => '3171097219', 'base_operacion' => 'COLIMA, COLIMA', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. SOLUCION EN TRANSPORTE TERRESTRE', 'contacto' => 'C. MANUEL CALDERA', 'telefono' => '3314250049', 'base_operacion' => 'GUADALAJARA, JALISCO', 'notas' => null],
            ['nombre' => 'T. GAONZALEZ GARCIA', 'contacto' => 'C. GONZALO GARCIA', 'telefono' => '3314644402', 'base_operacion' => 'GUADALAJARA, JALISCO', 'notas' => null],
            ['nombre' => 'T. SOLVER', 'contacto' => 'C. RICARDO SOLORZANO', 'telefono' => '3314778511', 'base_operacion' => 'GUADALAJARA, JALISCO', 'notas' => 'JAULAS'],
            ['nombre' => 'T. FLETES SAN LUIS POTOSÍ', 'contacto' => 'C. RAMÍREZ JACOB', 'telefono' => '3318100790', 'base_operacion' => 'GUADALAJARA, JALISCO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. MORENO', 'contacto' => 'C. KARINA TORRES M', 'telefono' => '3320319873', 'base_operacion' => 'GUADALAJARA, JALISCO', 'notas' => 'CAJA SECA Y THERMOS'],
            ['nombre' => 'T. TRANSPOMAS', 'contacto' => 'C. DANIEL BRISIO', 'telefono' => '3320418245', 'base_operacion' => 'GUADALAJARA, JALISCO', 'notas' => 'JAULAS'],
            ['nombre' => 'T. COFRAN', 'contacto' => 'C. ALEJANDRO PINEDA', 'telefono' => '3324933625', 'base_operacion' => 'GUADALAJARA, JALISCO', 'notas' => null],
            ['nombre' => 'T. AUTOEXPRESS YAFERAL Y CGI', 'contacto' => 'C. CARLOS GUTIÉRREZ IÍ', 'telefono' => '3331718049', 'base_operacion' => 'GUADALAJARA, JALISCO', 'notas' => null],
            ['nombre' => 'T. ODAL', 'contacto' => 'C. ADRIÁN VILLASEÑOR', 'telefono' => '3335597878', 'base_operacion' => 'GUADALAJARA, JALISCO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. FLETES TAPATÍOS SA', 'contacto' => 'C. JESÚS ALCANTAR', 'telefono' => '3335775753', 'base_operacion' => 'GUADALAJARA, JALISCO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. LARES SÁNCHEZ', 'contacto' => 'C. RAMON LARES SANCHEZ', 'telefono' => '3411009283', 'base_operacion' => 'JALISCO', 'notas' => 'PLATAFORMA'],
            ['nombre' => 'T. HERRERA', 'contacto' => 'C. JUAN SALCEDO', 'telefono' => '3411071864', 'base_operacion' => 'JALISCO', 'notas' => 'PLATAFORMA'],
            ['nombre' => 'T. DIAZ', 'contacto' => 'C. RENE DIAZ', 'telefono' => '3418860986', 'base_operacion' => 'JALISCO', 'notas' => 'JAULAS'],
            ['nombre' => 'T. JESUS GONZALEZ', 'contacto' => 'C. JESUS GONZALEZ', 'telefono' => '3511210236', 'base_operacion' => 'MICHOACÁN', 'notas' => null],
            ['nombre' => 'T. DEL CENTRO', 'contacto' => 'C. ROBERTO RAMIREZ CLO', 'telefono' => '3512812287', 'base_operacion' => 'MICHOACÁN', 'notas' => null],
            ['nombre' => 'T. REFRIGERADOS RUBIO', 'contacto' => 'C. HECTOR NOVOA', 'telefono' => '3751056446', 'base_operacion' => 'JALISCO', 'notas' => 'THERMOS'],
            ['nombre' => 'T. SGR', 'contacto' => 'C. JUAN LERMA', 'telefono' => '3861186961', 'base_operacion' => 'JALISCO', 'notas' => null],
            ['nombre' => 'T. FLORES DE OCCIDENTE', 'contacto' => 'C. MARCO ANTONIO VIVAS', 'telefono' => '3921079449', 'base_operacion' => 'JALISCO', 'notas' => null],
            ['nombre' => 'T. OHL TRANSPORTES', 'contacto' => 'C. YADIRA GUERRA', 'telefono' => '3951190737', 'base_operacion' => 'GUANAJUATO', 'notas' => 'JAULA'],
            ['nombre' => 'T. TRAVIESOS DE NUEVA ITALIA', 'contacto' => 'C. DANIEL BARBAN CISNEROS', 'telefono' => '4251142687', 'base_operacion' => 'NVA ITALIA, MICH.', 'notas' => null],
            ['nombre' => 'T. TRANSFLOSA', 'contacto' => 'C. OMAR', 'telefono' => '4271080503', 'base_operacion' => 'GUANAJUATO, QUERÉTARO', 'notas' => 'CAJA SECA Y JAULA'],
            ['nombre' => 'T. 3 DE JULIO', 'contacto' => 'C. JESÚS PAREDES', 'telefono' => '4271216551', 'base_operacion' => 'GUANAJUATO, QUERÉTARO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'COORDINADOR BACO', 'contacto' => 'C. REFUGIO SALAZAR', 'telefono' => '4422870607', 'base_operacion' => 'QUERÉTARO', 'notas' => null],
            ['nombre' => 'T. RANGEL', 'contacto' => 'C. AARON RANGEL', 'telefono' => '4443102945', 'base_operacion' => 'SAN LUIS POTOSÍ', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. CHEMA', 'contacto' => 'C. JAVIER LEIJA GONZÁL', 'telefono' => '4444451589', 'base_operacion' => 'SAN LUIS POTOSÍ', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. MAKIBU', 'contacto' => 'C. CITLALI SANDOVAL', 'telefono' => '4521142601', 'base_operacion' => 'DURANGO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. CHÁVEZ', 'contacto' => 'C. BELLANIRA CHÁVEZ MA', 'telefono' => '4531013491', 'base_operacion' => 'DURANGO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. LOGÍSTICA TERRESTRE', 'contacto' => 'C. BENITO', 'telefono' => '4771145808', 'base_operacion' => 'LEÓN, GUANAJUATO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. CARDOSO', 'contacto' => 'C. OSVALDO CARDOSO GONZ', 'telefono' => '5512957081', 'base_operacion' => 'CIUDAD DE MÉXICO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. PORTILLA', 'contacto' => 'C. RUTH PORTILLA', 'telefono' => '5518777603', 'base_operacion' => 'CIUDAD DE MÉXICO', 'notas' => 'JAULAS'],
            ['nombre' => 'T. SERVICIOS LOGÍSTICOS MARAL', 'contacto' => 'C. SELENE ALMARAZ', 'telefono' => '5519880727', 'base_operacion' => 'CIUDAD DE MÉXICO', 'notas' => 'CAJA SECA Y THERMOS'],
            ['nombre' => 'T. TMS', 'contacto' => 'C. AARON', 'telefono' => '5524335883', 'base_operacion' => 'CIUDAD DE MÉXICO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. ESPAÑA', 'contacto' => 'C. SIMON', 'telefono' => '5534573807', 'base_operacion' => 'CIUDAD DE MÉXICO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. TRASMISA', 'contacto' => 'C. URIEL ESPINOZA', 'telefono' => '5543840291', 'base_operacion' => 'CIUDAD DE MÉXICO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. ADM', 'contacto' => 'C. LUZ ESTRELLA', 'telefono' => '5544849868', 'base_operacion' => 'CIUDAD DE MÉXICO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. FRIKAMEXT', 'contacto' => 'C. MIGUEL', 'telefono' => '5546102651', 'base_operacion' => 'CIUDAD DE MÉXICO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. DANY', 'contacto' => 'C. DANIELA ARREAGA MARIN', 'telefono' => '5549207188', 'base_operacion' => 'CIUDAD DE MÉXICO', 'notas' => null],
            ['nombre' => 'T. NATURASOL', 'contacto' => 'C. JONATHAN RENTERIA', 'telefono' => '5568023412', 'base_operacion' => 'CIUDAD DE MÉXICO', 'notas' => null],
            ['nombre' => 'T. HERVI', 'contacto' => 'C. HIGINIO HERNÁNDEZ V', 'telefono' => '5573778105', 'base_operacion' => 'CIUDAD DE MÉXICO', 'notas' => 'JAULAS'],
            ['nombre' => 'T. ZONTE', 'contacto' => 'C. EDGAR FRANCO', 'telefono' => '5591989994', 'base_operacion' => 'CIUDAD DE MÉXICO', 'notas' => null],
            ['nombre' => 'T. DANIA VALERIA', 'contacto' => 'C. KARLA LÓPEZ', 'telefono' => '6181454541', 'base_operacion' => 'DURANGO', 'notas' => 'JAULAS'],
            ['nombre' => 'T. ATMX', 'contacto' => 'C. JAVIER OCHOA JR', 'telefono' => '6421414408', 'base_operacion' => 'DURANGO', 'notas' => 'THERMOS'],
            ['nombre' => 'T. ZEPEDA', 'contacto' => 'C. ADRIAN ZEPEDA OLIVARES', 'telefono' => '6463880618', 'base_operacion' => 'BAJA CALIFORNIA', 'notas' => 'THERMOS'],
            ['nombre' => 'T. REFRIGERADOS LEGORRETA', 'contacto' => 'C. LEONEL LEGORRETA', 'telefono' => '6531602441', 'base_operacion' => 'BAJA CALIFORNIA', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. GRUPO GLS ASOCIADOS', 'contacto' => 'C. DEYSI LÓPEZ', 'telefono' => '6671056969', 'base_operacion' => 'CULIACÁN, SINALOA', 'notas' => 'JAULAS'],
            ['nombre' => 'T. RENOVA', 'contacto' => 'FELIPE DE JESUS RENOVA PINEDA', 'telefono' => '6671430882', 'base_operacion' => 'CULIACÁN, SINALOA', 'notas' => 'THERMOS'],
            ['nombre' => 'T. LOGÍSTICA FBR', 'contacto' => 'C. NOE BATIZ', 'telefono' => '6671950718', 'base_operacion' => 'CULIACÁN, SINALOA', 'notas' => null],
            ['nombre' => 'T. GANDARILLA', 'contacto' => 'C. HÉCTOR GANDARILLA', 'telefono' => '6671969327', 'base_operacion' => 'CULIACÁN, SINALOA', 'notas' => 'JAULAS'],
            ['nombre' => 'T. BAGA', 'contacto' => 'C. MARISOL BAGA', 'telefono' => '6672298766', 'base_operacion' => 'CULIACÁN, SINALOA', 'notas' => null],
            ['nombre' => 'T. IDEAL', 'contacto' => 'C. SANDRA IDEAL', 'telefono' => '6681484136', 'base_operacion' => 'MAZATLÁN, SINALOA', 'notas' => null],
            ['nombre' => 'T. TRANAPAC', 'contacto' => 'C. URIEL FÉLIX', 'telefono' => '6682224310', 'base_operacion' => 'MAZATLÁN, SINALOA', 'notas' => null],
            ['nombre' => 'T. ANAPAU', 'contacto' => 'C. ANDRES AQUINO SALAZAR', 'telefono' => '6682531969', 'base_operacion' => 'MAZATLÁN, SINALOA', 'notas' => null],
            ['nombre' => 'T. NAFARRETE', 'contacto' => 'C. JOSE LUIS NAFARRETE', 'telefono' => '6688614023', 'base_operacion' => 'MAZATLÁN, SINALOA', 'notas' => 'JAULAS'],
            ['nombre' => 'T. ESPERANZA', 'contacto' => 'C. LUIS ENRIQUE', 'telefono' => '6878579915', 'base_operacion' => 'MEXICALI, BAJA CALIFORNIA', 'notas' => 'JAULAS'],
            ['nombre' => 'T. TRAMESA MEJIA', 'contacto' => 'C. EDGAR MEJIA CASTILLO', 'telefono' => '7121517007', 'base_operacion' => 'MICHOACÁN', 'notas' => null],
            ['nombre' => 'T. LOGISTICA NUEVA DEL TRANSPORTE', 'contacto' => 'C. OMAR GARCÉS VEGA', 'telefono' => '7131294567', 'base_operacion' => 'MICHOACÁN', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. VIGU', 'contacto' => 'C. AMEYALLI', 'telefono' => '7221594071', 'base_operacion' => 'TOLUCA, ESTADO DE MÉXICO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. VALDEZ', 'contacto' => 'C. ERNESTO VALDEZ', 'telefono' => '7222030896', 'base_operacion' => 'TOLUCA, ESTADO DE MÉXICO', 'notas' => null],
            ['nombre' => 'T. GONZÁLEZ', 'contacto' => 'C. JAIME GONZÁLEZ', 'telefono' => '7222095261', 'base_operacion' => 'TOLUCA, ESTADO DE MÉXICO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. V ARREOLA', 'contacto' => 'C. VICTOR ARREOLA', 'telefono' => '7222408939', 'base_operacion' => 'TOLUCA, ESTADO DE MÉXICO', 'notas' => null],
            ['nombre' => 'T. BUXMYR', 'contacto' => 'C. AXEL LÓPEZ', 'telefono' => '7222948723', 'base_operacion' => 'TOLUCA, ESTADO DE MÉXICO', 'notas' => null],
            ['nombre' => 'T. GONZÁLEZ DE XALATLA', 'contacto' => 'C. JESÚS GONZÁLEZ', 'telefono' => '7225222464', 'base_operacion' => 'TOLUCA, ESTADO DE MÉXICO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. ORTEGA', 'contacto' => 'C. DANIEL ORTEGA', 'telefono' => '7226024296', 'base_operacion' => 'TOLUCA, ESTADO DE MÉXICO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. XIME', 'contacto' => 'C. KAREN VILLEGAS', 'telefono' => '7226746316', 'base_operacion' => 'TOLUCA, ESTADO DE MÉXICO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. MOR', 'contacto' => 'C. MARCO OVANDO', 'telefono' => '7227680034', 'base_operacion' => 'TOLUCA, ESTADO DE MÉXICO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. ETN', 'contacto' => 'C. JAZMÍN GONZÁLES', 'telefono' => '7228398118', 'base_operacion' => 'TOLUCA, ESTADO DE MÉXICO', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. FGM GPO ZONTE', 'contacto' => 'C. FABIOLA', 'telefono' => '7711436769', 'base_operacion' => 'PACHUCA, HIDALGO', 'notas' => null],
            ['nombre' => 'T. ILHUILCAMINA', 'contacto' => 'C. JOEL GARCIA ZONTE', 'telefono' => '7712149554', 'base_operacion' => 'PACHUCA, HIDALGO', 'notas' => null],
            ['nombre' => 'T. SALAZAR HERMANOS', 'contacto' => 'C. RAFAEL FLORES COORDINADOR', 'telefono' => '8117543526', 'base_operacion' => 'MONTERREY, NUEVO LEÓN', 'notas' => null],
            ['nombre' => 'T. MILLENNIUM', 'contacto' => 'C. LUIS GARZA', 'telefono' => '8781175252', 'base_operacion' => 'TORREÓN, COAHUILA', 'notas' => null],
            ['nombre' => 'T. M&B REFRIGERADOS', 'contacto' => 'C. SAGUI VERGARA', 'telefono' => '3131129485', 'base_operacion' => 'TAMAZULA, JALISCO', 'notas' => 'THERMOS'],
            ['nombre' => 'T. CHEMA´S', 'contacto' => 'C. JAVIER LEIJA GONZALEZ', 'telefono' => '4444451598', 'base_operacion' => 'SAN LUIS POTOSI', 'notas' => 'CAJA SECA'],
            ['nombre' => 'T. MAKIBU', 'contacto' => 'C. ALEXIS GALINDO', 'telefono' => '4523080937', 'base_operacion' => 'URUAPAN, MICHOACAN', 'notas' => 'THERMOS'],
            ['nombre' => 'T. ZUÑIGA', 'contacto' => 'C. ARMANDO ZÚÑIGA', 'telefono' => '4771434660', 'base_operacion' => 'LEON GUANAJUATO', 'notas' => 'CAJA SECA, JAULA'],
        ];

        foreach ($lineas as $linea) {
            LineaCarga::updateOrCreate(
                [
                    'nombre' => $linea['nombre'],
                    'base_operacion' => $linea['base_operacion'] ?? '',
                ],
                array_merge($linea, ['estatus' => true])
            );
        }

        $this->command->info('✅ ' . count($lineas) . ' líneas de transporte insertadas/actualizadas.');
    }
}
