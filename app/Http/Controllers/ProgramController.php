<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Program;
use App\Subject;
use App\Branch;

class ProgramController extends Controller
{
    protected $branches = [];
    protected $subjects = [];
    
    public function __construct()
    {
        $this->branches = Branch::lists('name', 'id')->toArray();
        array_unshift($this->branches, 'Please select');
        
        $this->subjects = Subject::lists('name', 'id')->toArray();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs = Program::all();

        return view('programs/index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = $this->subjects;

        return view('programs/create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data = array_filter($data);
        dd($data);
        try {
            $program = Program::create($data);
            return redirect('programs/' . $program->id )->with('message', 'Program was created successfully!');
        } catch ( Exception $e ) {
            return back()->withInput()->with('message', 'Fooo!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        $subjects   = $this->subjects;
        // Remove exists subject from all subject above

        return view('programs/update', compact('program', 'subjects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        return $this->show($program);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Program $program)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        $program->delete();

        return back();
    }
}
