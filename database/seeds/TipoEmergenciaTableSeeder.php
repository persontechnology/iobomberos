<?php

use Illuminate\Database\Seeder;
use iobom\Models\Emergencia\Emergencia;
use iobom\Models\Emergencia\TipoEmergencia;
class TipoEmergenciaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            'ATENCION PREHOSPITALARIA',
            'CONTRA INCENDIO',
            'FALSA ALARMA',
            'RESCATE',
            'DESASTRES'
        );

        $dataAPrehos = array(
            'OVACE',
            'AHOGAMIENTOS',
            'AMPUTACIONES',
            'ANGINA DE PECHO',
            'AUSENCIA DE SIGNOS VITALES',
            'AVISERACIÓN',
            'BRADICARDIA',
            'CEFALEA',
            'COMA',
            'CRISIS CONVULSIVA',
            'CRISIS DE ASMA',
            'CRISIS HIPERTENSIVA',
            'DIFICULTAD RESPIRATORIA',
            'DOLOR ABDOMINAL',
            'FRACTURA CERRADA',
            'FRACTURA EXPUESTA',
            'HEMORRAGIAS PELVICAS',
            'HERIDA PENETRANTE',
            'HERIDA SOPLANTE',
            'HERIDA SUPERFICIAL',
            'HERIDAS EN TEJIDOS BLANDOS',
            'HIPERGLICEMIA',
            'HIPERTERMIA',
            'HIPOGLICEMIA',
            'HIPOTERMIA',
            'INFARTO AGUDO DEL MIOCARDIO',
            'INTOXICACION ALCOHOLICA',
            'INTOXICACION ALIMENTICIAS',
            'INTOXICACION MEDICAMENTOS',
            'INTOXICACION SUSTANCIAS TOXICAS',
            'MODEDURAS',
            'PARO RESPIRATORIO',
            'PARTOS',
            'PICADURAS',
            'POLITRAUMATIZADO',
            'QUEMADURAS',
            'SANGRADO DIGESTIVO',
            'SINDROME CONVERSIVO ',
            'SINDROME CONVERSIVO H',
            'TAQUICARDIA',
            'TCE GRAVE',
            'TCE LEVEL',
            'TCE MODERADO',
            'TRANSFERENCIAS',
            'TRASTORNOS MENTALES',
            'TRAUMA ABDOMINAL',
            'TRAUMA CERVICAL',
            'TRAUMA DE TORAX ABIERTO',
            'TRAUMA DE TORAX CERRADO',
            'TRAUMA EXTREMIDADES',
            'TRAUMA FACIAL',
            'TRAUMA PELVICO',
            'TRAUMA RAQUIMEDULAR',
        );
        $dataRescate = array(
            'ABRIR DEPARTAMENTOS',
            'ACUATICO',
            'ANIMAL',
            'AVEATORIO',
            'CAIDA DE ARBOLES',
            'COLISIÓN',
            'DERRAMES DE COMBUSTIBLES',
            'DERRUMBE',
            'DESBORDES DE RIOS',
            'DESLAVES',
            'ESPACIOS CONFINADOS',
            'ESTRELLAMIENTO',
            'ESTRUCTURAS COLAPSADAS',
            'IMPACTO ANGULAR',
            'IMPACTO FRONTAL',
            'IMPACTO LATERAL',
            'IMPACTO POR ALCANCE',
            'INUNDACIONES',
            'MATERIALES PELIGROSOS',
            'RESCATE EN MONTAÑA',
            'VERTICAL',
            'VOLCAMIENTO',
            'VOLCAMIENTO DE  1/4 DE CICLO',
            'VOLCAMIENTO DE 3/4 CICLO',
            'VOLCAMIENTO DE MEDIO CICLO',

        );

        $dataCIncendio = array(
            'AMAGO DE INCENDIO',
            'BALDEOS',
            'ESTRUCTURAL',
            'FORESTAL',
            'FUGA DE GAS',
            'VEHICULAR'
        );

        $dataDesastre = array(
            'ACCIDENTES VEHICULARES DE MAGNITUD',
            'INCENDIOS FORESTALES DE MAGNITUD',
            'INCENDIOS INDUSTRIALES',
            'INUNDACIONES DE MAGNITUD',
            'TERREMOTOS',
        );

        foreach (Emergencia::all() as $eme) {
            switch ($eme->nombre) {
                case 'ATENCION PREHOSPITALARIA':
                    foreach ($dataAPrehos as $ap) {
                        TipoEmergencia::firstOrCreate([
                            'nombre'=>$ap,
                            'emergencia_id'=>$eme->id
                        ]);
                    }
                    break;
                case 'CONTRA INCENDIO':
                    foreach ($dataCIncendio as $ci) {
                        TipoEmergencia::firstOrCreate([
                            'nombre'=>$ci,
                            'emergencia_id'=>$eme->id
                        ]);
                    }
                    break;
                case 'RESCATE':
                    foreach ($dataRescate as $re) {
                        TipoEmergencia::firstOrCreate([
                            'nombre'=>$re,
                            'emergencia_id'=>$eme->id
                        ]);
                    }
                    break;
                case 'DESASTRES':
                    foreach ($dataDesastre as $de) {
                        TipoEmergencia::firstOrCreate([
                            'nombre'=>$de,
                            'emergencia_id'=>$eme->id
                        ]);
                    }
                    break;
                
                default:
                    # code...
                    break;
            }
        }

    }
}
