<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Branch;
use App\User;

class BranchController extends Controller
{

    protected $administrators = [];

    public function __construct()
    {
        $this->administrators = User::ofRole(1)->pluck('name', 'id')->toArray();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches   = Branch::all();

        return view('branches.index', [
            'branches'          => $branches,
            'administrators'    => $this->administrators
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $administrators = $this->administrators;
        
        return view('branches.create', compact('administrators'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array_filter($request->all());

        if (empty($data['slug']))
            $data['slug'] = str_slug($data['slug']);

        try {
            $branch = Branch::create($data);
            return back()->with('message', 'Branch was created successfully!');
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
    public function show(Branch $branch)
    {
        return $this->edit($branch);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        $administrators = $this->administrators;

        return view('branches.update', compact('branch', 'administrators'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        $data = array_filter($request->all());


        if (empty($data['slug']))
            $data['slug'] = str_slug($data['slug']);
        
        try {
            $branch = $branch->update($data);
            return back()->with('message', 'Branch was created successfully!');
        } catch ( Exception $e ) {
            return back()->withInput()->with('message', 'Fooo!');
        }
    }

    public function switch($id, Request $request)
    {
        Branch::switch($id);

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
