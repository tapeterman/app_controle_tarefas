<?php

namespace App\Http\Controllers;

use Mail;
use App\Mail\NovaTarefaMail;
use App\Exports\TarefasExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

Use App\Models\Tarefa;

class TarefaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function rules(){

        return [
                    'tarefa' => 'min:3|max:200',
                    'data_limite_conclusao' => 'required|date',

        ];
    }

    protected function message(){

        return [
                    'max'       => 'O máximo de caracteres é 200',
                    'min'       => 'O mínimo de caracteres é 3',
                    'date'      => 'O campo :attribute deve ser um data valida!'
        ];
    }

    protected function security(Tarefa $tarefa){

        
        if(auth()->user()->id != $tarefa->user_id){
            return false;
        }
        return true;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user_id = auth()->user()->id;
        $tarefas = Tarefa::where('user_id',$user_id)->paginate(10);
        return view('tarefa.index',['tarefas' => $tarefas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tarefa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate($this->rules(),$this->message());
        
        $dados = $request->all();
        $dados['user_id'] = $this->user_id;

        $tarefa = Tarefa::create($dados);
        $destinatario = auth()->user()->email;
        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));
        return redirect()->route('tarefa.show',['tarefa' =>$tarefa]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function show(Tarefa $tarefa)
    {
        
        return view('tarefa.show',['tarefa' => $tarefa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function edit(Tarefa $tarefa)
    {
        if($this->security($tarefa)){
            return view('tarefa.edit',['tarefa'=>$tarefa]);
        }
        return view('acesso-negado');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tarefa $tarefa)
    {

        if($this->security($tarefa)){
            $request->validate($this->rules(),$this->message());
            $tarefa->update($request->all());
            return redirect()->route('tarefa.show',['tarefa' =>$tarefa]);
        };
        return view('acesso-negado');
       

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarefa $tarefa)
    {
        if($this->security($tarefa)){
            $tarefa->delete();            
            return redirect()->route('tarefa.index');
        };
        return view('acesso-negado');
    }

    public function export()
    {
        return Excel::download(new TarefasExport, 'Tarefas.xlsx');
    }
}
