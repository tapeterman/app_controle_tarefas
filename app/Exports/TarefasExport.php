<?php

namespace App\Exports;

use App\Models\Tarefa;
use Maatwebsite\Excel\Concerns\{FromCollection,WithHeadings,WithMapping};

class TarefasExport implements FromCollection, WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return Tarefa::all();
        return auth()->user()->tarefas()->get();
    }

    public function headings():array{

        return [
                    'ID_tarefa', 
                    'Tarefa',
                    'Data_limite_conclusao',
        ];
    }

    public function map($linha):array{

        return [
                    $linha->id,
                    $linha->tarefa,
                    date('d/m/Y',strtotime($linha->data_limite_conclusao)),

        ];

    }



}
