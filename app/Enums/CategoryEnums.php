<?php

namespace App\Enums;

enum CategoryEnums: string
{
    case A_FAZER = 'A Fazer';
    case EM_PROGRESSO = 'Em Progresso';
    case CONCLUIDO = 'Concluído';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
